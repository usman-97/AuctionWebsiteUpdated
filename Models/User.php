<?php
require_once ('Models/Database.php');

class User {
    protected $_dbInstance, $_dbHandle;
    protected $user_id, $username, $password;

    public function __construct()
    {
        // Database class instance
        $this->_dbInstance = Database::getInstance();
        // Establish connection with database
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    /*
     * Checks if user exists in users database
     * @param $username The username typed by user
     */
    public function checkUser()
    {
        // SQL query to check if user exists in database
        // Binds parameter for username
        $sqlQuery = 'SELECT username FROM users WHERE username = :username';

        // Prepare PDO statement to find user
        $statement = $this->_dbHandle->prepare($sqlQuery);
        // Bind parameter is assigned
        $statement->bindParam(':username', $this->username, PDO::PARAM_STR);

        // PDO statement is executed
        $statement->execute();

        // Checks if there is any record found containing given username
        // var_dump($statement->rowCount());
        if ($statement->rowCount() == 1)
        {
            return false;
        }
        else {
            return true;
        }
        // unset($statement);
    }

    /*
     * Register new account for user
     * @param $user The new username of account
     * @param $pwd The new password of account
     */
    public function registerAccount()
    {
        // SQL query to get total number of rows in user table
        $countStatement = 'SELECT COUNT(userID) FROM users';
        // Prepare PDO statement
        $countRows = $this->_dbHandle->prepare($countStatement);
        //Execute PDO statement
        $countRows->execute();
        // Store Total number of rows
        $totalRows = $countRows->fetchColumn();
        // var_dump($totalRows);

        // SQL query to insert user detail into users database
        // Bind username and password parameters
        $sqlQuery = 'INSERT INTO users (userID, username, password) VALUES (:id, :username, :password)';

        // Prepare PDO statement
        $statement = $this->_dbHandle->prepare($sqlQuery);

        // Bind parameters in SQL query are assigned
        $statement->bindParam(':id', $userID, PDO::PARAM_INT);
        $statement->bindParam(':username', $username, PDO::PARAM_STR);
        $statement->bindParam(':password', $password, PDO::PARAM_STR);

        $userID = $totalRows + 1; // New userID
        $username = $this->username; // New username

        // Password is encrypted using hash
        $password = password_hash($this->password, PASSWORD_DEFAULT);
        // var_dump(strlen($password));

        // SQL query is executed
        $statement->execute();
        // var_dump($statement->execute());

        echo "New Account created";
        // unset($statement);

    }

    /*
     * Verify user by using user given credentials
     * @param $user The username credential
     * @param $pwd The password credential which user try to login
     */
    public function verifyUser()
    {
        // SQL query to get username and password from users table
        // Uses parameter for username
        $sqlQuery = 'SELECT userID, username, password FROM users WHERE username = :username';

        $statement = $this->_dbHandle->prepare($sqlQuery);
        // Assign parameter for SQL query
        $statement->bindParam(":username", $username, PDO::PARAM_STR);
        $username = $this->username;

        $statement->execute();;

        // var_dump($statement->rowCount());
        // If a row in table exist with given username
        if ($statement->rowCount() == 1) {
            $dbRow = $statement->fetch(); // Get the row which matches with username
            $this->user_id = $dbRow['userID']; // Get user id
            $username = $dbRow['username']; // Get username
            $encryptedPassword = $dbRow['password']; // Get user encrypted password

            // Check if user given password matches with the one stored
            // in users table
            if (password_verify($this->password, $encryptedPassword)) {
                return true;
            }
            else
            {
                return false;
            }
        }
        return null;
    }

    /*
     * @return user id
     */
    public function getUserID()
    {
        return $this->user_id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
}