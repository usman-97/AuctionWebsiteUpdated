<?php

class AuctionItemData {

    // Class fields
    protected $_lotID, $_lot_title, $_lot_main, $_description, $_price, $_image, $_category, $_auction_id;
    protected $_auction_name, $_location, $_datetime, $_endDatetime, $_user_id;

    /**
     * Constructor for AuctionItemData
     * Assign fields to records in Lots and auction table
     * @param $dbRow - the row which is selected from SQL statement
     */
    public function __construct($dbRow) {
        $this->_lotID = $dbRow['lotID'];
        $this->_lot_title = $dbRow['lot_title'];
        $this->_lot_main = $dbRow['lot_main'];
        $this->_description = $dbRow['description'];
        $this->_price = $dbRow['price'];
        $this->_image = $dbRow['image'];
        $this->_category = $dbRow['category'];
        $this->_auction_id = $dbRow['auction_id'];
        $this->_auction_name = $dbRow['auction_name'];
        $this->_location = $dbRow['location'];
        $this->_datetime = $dbRow['datetime'];
        $this->_endDatetime = $dbRow['endDatetime'];
        $this->_user_id = $dbRow['user_id'];
    }

    /**
     * The lot id
     */
    public function getLotId() {
        return $this->_lotID;
    }

    /**
     * The lot title
     */
    public function getLotTitle() {
       return $this->_lot_title;
    }

    /**
     * The lot main from Lots table
     */
    public function getLotMain() {
       return $this->_lot_main;
    }

    /**
     * The lot description
     */
    public function getDescription() {
       return $this->_description;
    }


    /**
     * The opening bid of lot
     * @return mixed
     */
    public function getPrice() {
       return $this->_price;
    }

    /**
     * The picture of the lot
     */
    public function getImage() {
        return $this->_image;
    }

    /**
    * The picture of the lot
    */
    public function getCategory() {
        return $this->_category;
    }

    /**
     * The auction ID
     */
    public function getAuctionID() {
        return $this->_auction_id;
    }

    /**
     * The lot's auction name
     */
    public function getAuctionName() {
        return $this->_auction_name;
    }

    /**
     * The lot's auction location
     */
    public function getLocation() {
        return $this->_location;
    }

    /**
     * The date of lot's auction
     */
    public function getDatetime() {
        return $this->_datetime;
    }

    /**
     * The date of lot's auction
     */
    public function getEndDatetime() {
        return $this->_endDatetime;
    }

    /**
     * The date of lot's auction
     */
    public function getUserID() {
        return $this->_user_id;
    }
}


