<?php

/**
 * Class BidItemData
 * It stores data from bid table
 */
class BidItemData {
    protected $_bidID, $_bid, $_userID, $_username;
    protected $_lotID, $_lot_title, $_lot_main, $_lot_image;
    protected $_auctionID, $_auction_name, $_auction_location, $_auction_datetime;

    /**
     * BidItemData constructor.
     * @param $dbRow
     */
    public function __construct($dbRow)
    {
        $this->_bidID = $dbRow['bidID'];
        $this->_userID = $dbRow['user_id'];
        $this->_username = $dbRow['username'];
        $this->_lotID = $dbRow['lot_id'];
        $this->_lot_title = $dbRow['lot_title'];
        $this->_lot_main = $dbRow['lot_main'];
        $this->_lot_image = $dbRow['image'];
        $this->_auctionID = $dbRow['auction_id'];
        $this->_auction_name = $dbRow['auction_name'];
        $this->_auction_location = $dbRow['location'];
        $this->_auction_datetime = $dbRow['datetime'];
        $this->_bid = $dbRow['bid'];
    }

    public function getBidID()
    {
        return $this->_bidID;
    }

    public function getBid()
    {
        return $this->_bid;
    }

    public function getUserID()
    {
        return $this->_userID;
    }

    public function getUsername()
    {
        return $this->_username;
    }

    public function getLotID()
    {
        return $this->_lotID;
    }

    public function getLotTitle()
    {
        return $this->_lot_title;
    }

    public function getLotMain()
    {
        return $this->_lot_main;
    }

    public function getLotImage()
    {
        return $this->_lot_image;
    }

    public function getAuctionID()
    {
        return $this->_auctionID;
    }

    public function getAuctionName()
    {
        return $this->_auction_name;
    }

    public function getAuctionLocation()
    {
        return $this->_auction_location;
    }

    public function getAuctionDatetime()
    {
        return $this->_auction_datetime;
    }
}
