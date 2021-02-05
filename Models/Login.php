<?php

/*
 * Login class extends User class
 * Subclass of User class
 */
class Login extends User {

    /*
     * Login class constructor
     */
    public function __construct()
    {
        // Parent class constructor is called
        parent::__construct();
    }

    /*
     * Checks failed login attempts for user
     * @param $username The user with failed login attempt
     */
    public function checkLoginAttempts($username)
    {
        // SQL query to get user's failed login attempt using :username parameter
        $sqlQuery = 'SELECT failed_login_attempt FROM users WHERE username = :username';

        $statement = $this->_dbHandle->prepare($sqlQuery);
        // Assign :username parameter to method paramter $username
        $statement->bindParam(":username", $username, PDO::PARAM_STR);

        $statement->execute();

        // Get users failed login attempts
        if ($statement->rowCount() == 1)
        {
            $dbRow = $statement->fetch();
            return $dbRow['failed_login_attempt'];
        }
    }

    /*
     * Increase the failed login attempts
     * @param $username The user which failed attempts to increment
     */
    public function increaseAttempts($username)
    {
        // Increment total failed attempt by 1
        $totalAttempts = $this->checkLoginAttempts($username) + 1;

        // SQL query to update failed_login_attempt for user who failed to login
        $sqlQuery = 'UPDATE users SET failed_login_attempt = :attempts WHERE username = :username';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":attempts", $totalAttempts, PDO::PARAM_INT);
        $statement->bindParam(":username", $username, PDO::PARAM_STR);

        $statement->execute();
        // var_dump($totalAttempts);

        // echo 'failed attempt';
    }

    /*
     * Reset failed login attempt when user logged in successfully
     */
    public function resetAttempts($username)
    {
        $sqlQuery = 'UPDATE users SET failed_login_attempt = 0 WHERE username = :username';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":username", $username, PDO::PARAM_STR);
        $statement->execute();
    }
}