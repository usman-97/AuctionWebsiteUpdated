<?php

require_once ('Models/Database.php');
require_once('Models/AuctionItemData.php');

class AuctionItemDateSet {
    protected $_dbHandle, $_dbInstance;

    /*
     * AuctionItemDataSet constructor
     * Establish connection to database
     */
    public function __construct() {
        $this->_dbInstance = Database::getInstance(); // Database class instance
        $this->_dbHandle = $this->_dbInstance->getdbConnection(); // Establish connection to database
    }

    /*
     * Searches item in Lots table by user's given keyword
     * @param $search
     * @return $dataSet The list of lots for Lots table
     */
    public function fetchSomeAuctionItem($searchItem, $start, $limit, $filter)
    {
        $start = intval($start);
        $limit = intval($limit);
        // var_dump($start);
        // var_dump($limit);g

        // SQL query to get item by it's title or main or auction name
        if ($filter == 'popular')
        {
            $sqlQuery = "SELECT * FROM Lots, auction WHERE Lots.auction_id = auction.auctionID  AND lot_title LIKE :item OR lot_main LIKE :item OR auction.auction_name LIKE :item ORDER BY views LIMIT :pageStart, :limitPage";
        }
        elseif ($filter == 'recent')
        {
            $sqlQuery = "SELECT * FROM Lots, auction WHERE Lots.auction_id = auction.auctionID  AND lot_title LIKE :item OR lot_main LIKE :item OR auction.auction_name LIKE :item ORDER BY datetime LIMIT :pageStart, :limitPage";
        }
        else
        {
            if ($filter == 'ascendingOrder')
            {
                $sqlQuery = "SELECT * FROM Lots, auction WHERE Lots.auction_id = auction.auctionID  AND lot_title LIKE :item OR lot_main LIKE :item OR auction.auction_name LIKE :item ORDER BY lot_main LIMIT :pageStart, :limitPage";
            }
            elseif ($filter == 'descendingOrder')
            {
                $sqlQuery = "SELECT * FROM Lots, auction WHERE Lots.auction_id = auction.auctionID  AND lot_title LIKE :item OR lot_main LIKE :item OR auction.auction_name LIKE :item ORDER BY lot_main DESC LIMIT :pageStart, :limitPage";
            }
            else
            {
                $sqlQuery = "SELECT * FROM Lots, auction WHERE Lots.auction_id = auction.auctionID  AND lot_title LIKE :item OR lot_main LIKE :item OR auction.auction_name LIKE :item LIMIT :pageStart, :limitPage";
            }
        }

        // prepare a PDO statement
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":item", $searchItem, PDO::PARAM_STR);
        $statement->bindParam(":pageStart", $start, PDO::PARAM_INT);
        $statement->bindParam(":limitPage", $limit, PDO::PARAM_INT);

        // Execute PDO statement
        $statement->execute();

        // $totalRecords = $statement->fetchColumn();

        // List where are details about a lot will be stored
        $dataSet = [];

        // If a lot is found
        if ($statement->rowCount() > 0)
        {
            // then fetch information to dataSet list
            while ($row = $statement->fetch())
            {
                $dataSet[] = new AuctionItemData($row);
            }
        }
        // var_dump($dataSet);
        return $dataSet;
    }

    /*
     * Displays all lots in Lots table with their auction
     * Displays Lots corresponding to pages
     * @param $start The first page
     * @param $limit The number of lots to display on each page
     * @return dataSet The list will all lots from Lots table
     */
    public function fetchAllAuctionItem($start, $limit) {
        $start = intval($start);
        $limit = intval($limit);

        // SQL query to select all lots with their auctions and use parameter to start it from
        // first page. Used a limit to set the amount of pages to display in each page
        $sqlQuery = "SELECT * FROM Lots, auction WHERE auction.auctionID = Lots.auction_id ORDER BY views DESC LIMIT :pageStart, :limit";

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        // $statement->bindParam(":auctionName", $auction, PDO::PARAM_STR);
        $statement->bindParam(":pageStart", $start, PDO::PARAM_INT);
        $statement->bindParam(":limit", $limit, PDO::PARAM_INT);
        $statement->execute(); // execute the PDO statement

        // List where all lots will be stored
        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new AuctionItemData($row);
        }
        return $dataSet;
    }

    /**
     * @param $start
     * @param $limit
     * @param $category
     * @return mixed
     */
    public function fetchSpecificItem($start, $limit, $category)
    {
        $start = intval($start);
        $limit = intval($limit);

        // SQL query to select all lots with their auctions and use parameter to start it from
        // first page. Used a limit to set the amount of pages to display in each page
        $sqlQuery = "SELECT * FROM Lots, auction WHERE category = CONCAT(:item) AND auction.auctionID = Lots.auction_id LIMIT :pageStart, :limit";

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        // $statement->bindParam(":auctionName", $auction, PDO::PARAM_STR);
        $statement->bindParam(":item", $category, PDO::PARAM_STR);
        $statement->bindParam(":pageStart", $start, PDO::PARAM_INT);
        $statement->bindParam(":limit", $limit, PDO::PARAM_INT);
        $statement->execute(); // execute the PDO statement

        // List where all lots will be stored
        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new AuctionItemData($row);
        }
        return $dataSet;
    }

    /**
     * Fetch lots from specific auction.
     * @param $start
     * @param $limit
     * @param $auction_id
     * @return mixed
     */
    public function fetchAuctionLots($start, $limit, $auction_id)
    {
        $sqlQuery = 'SELECT * FROM auction, Lots WHERE auction_id = :id AND Lots.auction_id = auction.auctionID LIMIT :pageStart, :limit';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":id", $auction_id, PDO::PARAM_INT);
        $statement->bindParam(":pageStart", $start, PDO::PARAM_INT);
        $statement->bindParam(":limit", $limit, PDO::PARAM_INT);
        $statement->execute();

        $dataSet = [];
        if ($statement->rowCount() > 0)
        {
            while ($row = $statement->fetch())
            {
                $dataSet[] = new AuctionItemData($row);
            }
            return $dataSet;
        }
    }

    /**
     * Gets total number of records from Lots table
     * @return mixed
     */
    public function getTotalRecords()
    {
        // SQL query to get total number of lots
        $sqlQuery = 'SELECT COUNT(lotID) FROM Lots';

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
        return $statement->fetchColumn();
    }

    /**
     * Get total number record for selected category of lots
     * @param $category - selected category to fetch lots
     * @return mixed - total number of records of a certain category
     */
    public function getTotalCategoryRecords($category)
    {
        $sqlQuery = "SELECT COUNT(lotID) FROM Lots WHERE category = :item";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":item", $category, PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchColumn();
    }

    /**
     * Gets total number of records searched by user
     * @param $searchItem
     * @return false|mixed
     */
    public function getTotalSearchRecords($searchItem)
    {
        $sqlQuery = "SELECT COUNT(lotID) FROM Lots, auction WHERE Lots.auction_id = auction.auctionID  AND lot_title LIKE :item OR lot_main = :item OR auction_name LIKE :item";
        $statement =$this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":item",$searchItem, PDO::PARAM_STR);
        $statement->execute();
        if ($statement->rowCount() >= 1) {
            return $statement->fetchColumn();
        }
        else
        {
            return false;
        }
    }

    /*
     * Access individual item from database
     */
    /*public function getItem($id)
    {
        $sqlQuery = 'SELECT * FROM Lots, auction WHERE Lots.auction_id = auction.auctionID AND lotID = :id';

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();

        $dataSet = [];
        $dbRow = $statement->fetch();
        $dataSet = new AuctionItemData($dbRow);

        return $dataSet;
    }*/

    /*
     * Gets Auction admin using user_id in auction table
     */
    public function getAuctionAdmin($user_id)
    {
        $sqlQuery = 'SELECT username FROM auction, users WHERE auction.user_id = users.userID AND user_id = :id';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":id", $user_id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchColumn();
    }

    /*
     * Get view value for an item
     * @param $lot_id The id of an item
     */
    public function getView($lot_id)
    {
        $sqlQuery = 'SELECT views FROM Lots WHERE lotID = :id';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":id", $lot_id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchColumn();
    }

    /*
     * Increase view when specific item is viewed by user
     * @param $lot_id The id of an item which is viewd by user
     */
    public function incrementView($lot_id)
    {
        $itemViews = intval($this->getView($lot_id));
        $finalItemView = intval($itemViews + 1);
        // var_dump($itemViews);

        $sqlQuery = 'UPDATE Lots SET views = :itemView WHERE lotID = :id';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":itemView", $finalItemView, PDO::PARAM_INT);
        $statement->bindParam(":id", $lot_id, PDO::PARAM_INT);
        $statement->execute();
    }
}


