<?php

class AuctionData {

    protected $_auction_id, $_auction_name, $_location, $_datetime, $_admin;

    /*
     * Constructor auctionData which will be used to fetch
     * data from auction table
     * @param $dbRow The row from auction table
     */
    public function __construct($dbRow)
    {
        $this->_auction_id = $dbRow['auctionID'];
        $this->_auction_name = $dbRow['auction_name'];
        $this->_location = $dbRow['location'];
        $this->_datetime = $dbRow['datetime'];
        $this->_admin = $dbRow['user_id'];
    }

    /*
     * Gets auction id from auction table
     */
    public function getAuctionID()
    {
        return $this->_auction_id;
    }

    /*
     * Gets auction name from auction table
     */
    public function getAuctionName()
    {
        return $this->_auction_name;
    }

    /*
     * Gets auction location from auction table
     */
    public function getLocation()
    {
        return $this->_location;
    }

    /*
     * Gets auction data time from auction table
     */
    public function getDatetime()
    {
        return $this->_datetime;
    }

    /*
     * Gets auction admin from auction table
     */
    public function getAdmin()
    {
        return $this->_admin;
    }
}