<?php

require_once ('Database.php');

class Register {

    protected $_dbHandle, $_dbInstance;
    private $username, $password;
    protected $username_error;

    /*
     * Constructor for Register model
     * Gets instance from Database class
     * Creates connection to access database
     * @param $username The username given by user
     * @param $password The password given by user
     */
    public function __construct($username, $password)
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
        $this->username = $username;
        $this->password = $password;
    }

    /*
     * Checks if user exists in users database
     */
    /*public function checkUser()
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
        if ($statement->rowCount() == 1) {
            $this->username_error = "This username is already taken
                  , please use different username...";
            return false;
        }
        else
            {
                return true;
            }
            // unset($statement);
    }*/

    /*
     * Register new user account
     */
    /*public function registerAccount()
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
        $password= password_hash($this->password, PASSWORD_DEFAULT);
        // var_dump(strlen($password));

        // SQL query is executed
        $statement->execute();
        // var_dump($statement->execute());

        echo "New Account created";
        // unset($statement);

    }*/

        /*
         * Gets username error
         */
        /*public function getUsernameError()
        {
            return $this->username_error;
        }*/
}
