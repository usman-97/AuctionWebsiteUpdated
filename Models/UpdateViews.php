<?php
require_once ("Database.php");

class UpdateViews {

    protected $_dbInstance, $_dbHandle;

    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    public function generateViewNumber()
    {
        return rand(0, 2000);
    }

    public function updateView($lot_id)
    {
        $number = $this->generateViewNumber();

        $sqlQuery = "UPDATE Lots SET views = :viewNumber WHERE lotID = :id";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":viewNumber", $number, PDO::PARAM_INT);
        $statement->bindParam(":id", $lot_id, PDO::PARAM_INT);
        // var_dump($statement->execute());
        $statement->execute();

        // var_dump($number);
    }
}