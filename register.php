<?php
require_once ('Models/Register.php');
require_once ('Models/User.php');
require_once ('Models/ReCaptcha.php');

$view = new stdClass();
$view->pageTitle = 'Sign up';
$view->user = new User();
$view->reCaptcha = new ReCaptcha();
$view->reCaptcha = $view->reCaptcha->generateReCaptcha();

require_once ('logout.php');
unset($_SESSION['viewItem']);

// Checks if Sign up button is pressed
if (isset($_POST['register']))
{
    if (empty($_POST['registerEmail'])) {
        // Checks if username field is not empty
        if (!empty(trim($_POST['registerUsername']))) {
            var_dump(preg_match('/\d/', $_POST['registerUsername']));
            $view->newUser = $_POST['registerUsername'];
            // Check that password is between 8 to 16 characters
            if (strlen($_POST['registerPassword']) >= 8 && strlen($_POST['registerPassword']) <= 16) {
                if ($_POST['registerPassword'] == $_POST['confirmPassword'])
                {
                    if ($_POST['code'] == $_POST['finalCode']) {
                            $view->user->setUsername($_POST['registerUsername']);
                            $view->user->setPassword($_POST['registerPassword']);

                            // Call checkUser method to check if username doesn't already exist
                            $userCheck = $view->user->checkUser();
                            // var_dump($register);
                            // var_dump($userCheck);


                            // If username doesn't exist
                            if ($userCheck) {
                                // Create a new account
                                $view->user->registerAccount();
                                // On successful registration, redirect user to login page
                                header('location: login.php');
                                $view->error = null;
                                echo 'You have successfully registered';
                            } else {
                                $view->error = "This username is already taken
                  , please use different username...";
                            }
                    }
                    else
                    {
                        $view->error = 'Incorrect code';
                    }
                }
                else {
                    $view->error = 'Password not matched';
                }

            }
            else {
                $view->error = 'Password length should be between 8 to 16 characters';
            }
        }
        else {
            $view->error = 'Please type your username/password to register';
        }
        require_once ('Views/register.phtml');
    }
    else
    {
        echo 'Sorry, failed to establish the connection. Please try again later.';
    }
}
else
{
    require_once ('Views/register.phtml');
}