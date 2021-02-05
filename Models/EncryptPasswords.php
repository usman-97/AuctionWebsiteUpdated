<?php
require_once ('Database.php');

class EncryptPasswords {
    protected $_dbInstance, $_dbHandle;

    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    public function encryptPassword()
    {
        $sqlQuery = 'SELECT password FROM users WHERE userID = 1103';

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch())
        {
            $dataSet[] = $row['password'];
        }
        return $dataSet;
    }

    public function updatePassword($userID, $pwd)
    {
        $sqlQuery = 'UPDATE users SET password = :password WHERE userID = :user_id';

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $password = password_hash($pwd, PASSWORD_DEFAULT);

        $statement->bindParam(":user_id", $userID, PDO::PARAM_STR);
        $statement->bindParam(":password", $password, PDO::PARAM_STR);

        // var_dump($statement->bindParam(":password", $password, PDO::PARAM_INT));
        // var_dump($password);

        $statement->execute();
        var_dump($password);
    }
}
