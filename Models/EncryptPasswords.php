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

    public function updateAuctionDate()
    {
        $dateArray = ["2021-05-25", "2021-05-30", "2021-05-05", "2020-05-21"];
        $timeArray = ["15:00", "07:00", "16:00", "12:00", "18:00"];

        for ($i = 1; $i <= 20; $i++)
        {
            $randDate = array_rand($dateArray, 1);
            $randTime = array_rand($timeArray, 1);
            $randDateTime = $dateArray[$randDate] . " " . $timeArray[$randTime];

            $sqlQuery = 'UPDATE auction SET endDatetime = :datetime WHERE auctionID = :id';
            $statement = $this->_dbHandle->prepare($sqlQuery);
            $statement->bindParam(":datetime", $randDateTime);
            $statement->bindParam(":id", $i);
            var_dump($randDateTime);
            $statement->execute();
        }
    }
}
