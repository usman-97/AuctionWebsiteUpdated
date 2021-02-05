<?php
require_once ('Models/Database.php');
require_once ('Models/AuctionData.php');

class AuctionDataSet {
    protected $_dbInstance, $_dbHandle;

    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    /*
     *
     */
    public function fetchAllAuctions()
    {
        $sqlQuery = 'SELECT * FROM auction';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch())
        {
            $dataSet[] = new AuctionData($row);
        }
        return $dataSet;
    }
}
