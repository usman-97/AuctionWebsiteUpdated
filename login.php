<?php
require_once ('Models/User.php');
require_once ('Models/Login.php');
require_once ('Models/ReCaptcha.php');

$view = new stdClass();
$view->pageTitle = 'Log in';

// User instance to check user credentials
$view->user = new User();

// Login instance to check user failed attempts and verify user
$view->login = new Login();

$view->reCaptcha = new ReCaptcha();
$view->reCaptcha = $view->reCaptcha->generateReCaptcha();
// var_dump($view->reCaptcha);

// If login button is pressed
if (isset($_POST['login'])) {
    // var_dump($_POST['finalCode']);
    // A trap for spam bots, email is a hidden field
    // in login view file, so if it is filled then consider it
    // a spam bot
    if (empty($_POST['email'])) {
        // Check if username field is empty
        if (empty(trim($_POST['username']))) {
            $view->error = 'Please enter username';
            // require_once('Views/login.phtml');
        }
        else {
            $view->username = $_POST['username'];
            // Check if password field is empty
            if (empty(trim($_POST['pwd']))) {
                $view->error = 'Please enter your password';
                // require_once('Views/login.phtml');
            }
            else {
                // var_dump($_POST['code']);
                // Check if user typed code is same as given code
                if ($_POST['finalCode'] === $_POST['code']) {
                    //var_dump($view->user->verifyUser());
                    if (!isset($_SESSION['coolDown'])) {
                        $view->user->setUsername($_POST['username']);
                        $view->user->setPassword($_POST['pwd']);
                        // var_dump($view->user->getUsername());
                        // var_dump($view->user->getPassword());

                        // Check if user exist in users database
                        if (!$view->user->checkUser()) {
                            // Verify user
                            if ($view->user->verifyUser()) {

                                // Start session
                                session_start();
                                unset($_SESSION['viewItem']);
                                unset($_SESSION['searchMode']);

                                // Session variables
                                $_SESSION['loggedIn'] = true; // If true then user has been successfully logged in
                                $_SESSION['username'] = $view->username; // Get username
                                $_SESSION['userID'] = $view->user->getUserID(); // Get user id from users table
                                $_SESSION['timeout'] = time(); // User last activity session
                                $_SESSION['expire'] = 3600; // Session expiry time in seconds

                                // Set error to null on user successful login
                                $view->error = null;

                                // Reset login failed login attempts by user
                                $view->login->resetAttempts($view->username);

                                // require_once('Views/login.phtml');
                                // var_dump($view->login->checkLoginAttempts());

                                echo $_POST['username'] . ' has successfully logged in!';
                                header("Location: index.php");
                                // require_once('Views/index.phtml');
                                var_dump($_SESSION['username']);
                            }
                            else {
                                $view->error = 'Invalid Password';
                                // require_once('Views/login.phtml');
                            }
                        }
                        else {
                            $view->error = "Invalid Username";
                            // require_once('Views/login.phtml');
                        }
                    }
                    else
                    {
                        $view->error =  'Too many failed login attempts, your account has been temporarily locked
                        , please try again and reload page after 1 minute. ';
                        $view->login->resetAttempts($_POST['username']);
                    }
                }
                else
                {
                    $view->error = "Incorrect code";
                }
            }
        }

        session_start();
        unset($_SESSION['searchMode']);
        unset($_SESSION['viewItem']);

        $attempts = $view->login->checkLoginAttempts($_POST['username']);
        if ($attempts >= 8)
        {
            if (!isset($_SESSION['coolDown'])) {
                // session_start();
                $_SESSION['coolDown'] = time();
                $_SESSION['coolDownExpiry'] = 60;
            }
            else
            {
                $view->error =  'Too many failed login attempts, your account has been temporarily locked
                        , please try again and reload page after 1 minute. ';
                $view->login->resetAttempts($_POST['username']);
            }
        }

        if (isset($_SESSION['coolDown']) && isset($_SESSION['coolDownExpiry']))
        {
            if ($_SESSION['coolDown'] < time() - $_SESSION['coolDownExpiry'])
            {
                // $view->login->resetAttempts($_POST['username']);
                unset($_SESSION['coolDown']);
            }
        }
        // var_dump($attempts);
        // var_dump($_SESSION['coolDown']);

        // If error is not set
        if ($view->error == null) {
            // require_once('index.php');
            // If error is not set then bring user to home page
            header("Location: index.php");
        }
        else {
            // If user failed to login then increase failed attempt
            $view->login->increaseAttempts($_POST['username']);
            require_once('Views/login.phtml');
        }

        // var_dump($view->error);
        // var_dump($view->login->checkLoginAttempts($_POST['username']));
    }
    else
    {
        echo 'Sorry, failed to establish the connection. Please try again later.';
    }
}
else
{
    require_once ('Views/login.phtml');
}

