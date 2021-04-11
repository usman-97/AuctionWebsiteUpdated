<?php
require_once ('Database.php');
require_once('BidItemData.php');
require_once ('AuctionItemData.php');

class BidItemDataSet {
    protected $_dbInstance, $_dbHandle;

    /*
     * Constructor for BideItemDataSet class
     * It establishes the connection to database
     */
    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

/*    private function userHighestLotsBid($dataSet)
    {
        $tempDataSet = [];

        for ($i = 0; $i < count($dataSet); $i++)
        {
            $tempLotDataSet = [];
            $lot = $dataSet[$i]->getLotID();
            $bid = $dataSet[$i]->getBid();

            while ($dataSet[$i] == $lot)
            {
                if ($bid < $dataSet[$i]->getBid())
                {
                    $bid = $dataSet[$i]->getBid();
                }

                $i++;
            }
        }
    }*/

    /**
     * Gets all bid for users.
     * Displays the list of user bids
     * @param - $id The ID of user
     * @return array|false
     */
    public function fetchAllBids($id)
    {
        // SQL query to get all user's bids on all items
        $sqlQuery = 'SELECT * FROM users, bid, Lots, auction WHERE users.userID = bid.user_id AND Lots.lotID = bid.lot_id AND auction.auctionID = bid.auction_id AND bid.user_id = :id ORDER BY lot_id';
        $statement = $this->_dbHandle->prepare($sqlQuery); // Prepare PDO statement
        $statement->bindParam(":id", $id, PDO::PARAM_INT); // Assign parameter :id in query
        $statement->execute(); // execute SQL query

        $dataSet = []; // List where all details about users' bids will be stored;
        while ($row = $statement->fetch())
        {
            $dataSet[] = new BidItemData($row);
        }

        if (count($dataSet) == 0)
        {
            return false;
        }
        else
        {
            return $dataSet;
        }

    }

    /**
     *Gets all bids which are made on specific item.
     * @param $id
     * @return array|false
     */
    public function fetchItemBids($id)
    {
        $sqlQuery = 'SELECT * FROM users, bid, Lots, auction WHERE Lots.lotID = bid.lot_id AND bid.user_id = users.userID AND auction.auctionID = bid.auction_id AND bid.lot_id = :id ORDER BY bid DESC ';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();


        $dataSet = [];
        if ($statement->rowCount() > 0)
        {
            while ($row = $statement->fetch())
            {
                $dataSet[] = new BidItemData($row);
                // $dataSet['userID'] = $row['user_id'];
                // $dataSet['bid'] = $row['bid'];
            }
            return $dataSet;
        }
        else
        {
            return false;
        }
    }

    /**
     * Count total number of records in bid table
     * @return mixed
     */
    public function countBidID()
    {
        // SQL query counts number of total bids in bid table
        $bidIDQuery = 'SELECT bidID FROM bid ORDER BY bidID DESC LIMIT 1';
        $bidStatement = $this->_dbHandle->prepare( $bidIDQuery);
        $bidStatement->execute();

        return $bidStatement->fetchColumn();
    }

    /**
     * Check if user has already placed a bid on a specific
     * item.
     * @param $lot
     * @param $user
     * @return bool
     */
    public function checkUserLotBid($lot, $user)
    {
        $sqlQuery = 'SELECT * FROM bid WHERE lot_id = :lot AND user_id = :usr';
        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->bindParam(":lot", $lot);
        $statement->bindParam(":usr", $user);

        $statement->execute();

        if ($statement->rowCount() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Allows user to place a bid on item.
     * Insert new record in bid table
     * @param $userID - The user who is placing bid
     * @param $lotID - The item which user is placing bid on
     * @param $auctionID - The auction where user is placing bid
     * @param $bid - The amount of bid
     */
    public function placeBid($userID, $lotID, $auctionID, $bid)
    {
        $id = $this->countBidID() + 1;
        // var_dump($lotID);

        $sqlQuery = 'INSERT INTO bid (bidID, user_id, lot_id, auction_id, bid) VALUES (:id, :user_id, :lot_id, :auction_id, :userBid)';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->bindParam(":user_id", $userID, PDO::PARAM_INT);
        $statement->bindParam(":lot_id", $lotID, PDO::PARAM_INT);
        $statement->bindParam(":auction_id", $auctionID, PDO::PARAM_INT);
        $statement->bindParam(":userBid", $bid, PDO::PARAM_STR);

        $statement->execute();
        // var_dump($statement->execute());
    }

    /**
     * Update user bid for where user has already
     * placed a bid
     * @param $lot
     * @param $user
     * @param $bid
     */
    public function updateUserBid($lot, $user, $bid)
    {
        $sqlQuery = 'UPDATE bid SET bid = :bid WHERE user_id = :usr AND lot_id = :lot';
        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->bindParam(":bid", $bid);
        $statement->bindParam(":lot", $lot);
        $statement->bindParam(":usr", $user);

        $statement->execute();
    }

    /**
     * Removes user bid from bid table
     * @param $id - The bid which user wants to remove
     */
    public function removeBid($id)
    {
        $sqlQuery = 'DELETE FROM bid WHERE bidID = :id';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Modify or edit current user bid.
     * @param $id - The bid which user wants to modify
     */
    public function editBid($id, $newBid)
    {
        $sqlQuery = 'UPDATE bid SET bid = :bid WHERE bidID = :id';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":bid", $newBid, PDO::PARAM_STR);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Get the highest bid on selected item and check if user
     * given amount for bid is higher than current highest bid
     * @param $id - The item which user wants to place a bid
     * @param $amount - amount The amount which user wants to
     */
    public function checkHighestBid($id, $amount)
    {
        $sqlQuery = 'SELECT MAX(bid) FROM bid WHERE lot_id = :lot_id';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":lot_id", $id, PDO::PARAM_INT);
        $statement->execute();

        if ($statement->rowCount() == 1)
        {
            $highestBid = $statement->fetchColumn();
            // var_dump($highestBid);
            if ($amount > $highestBid)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return true;
        }
    }

    /**
     * Gets The highest bid of user on specific item
     * @param $_lot_id - the lot id
     * @return false|mixed
     */
    public function getItemHighestBid($_lot_id)
    {
        $sqlQuery = 'SELECT MAX(bid) FROM bid WHERE lot_id = :lot_id';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":lot_id", $_lot_id, PDO::PARAM_INT);
        $statement->execute();

        // var_dump($statement->fetchColumn());
        if ($statement->rowCount() > 0)
        {
            return $statement->fetchColumn();
        }
        else
        {
            return false;
        }
    }

    /**
     * Checks if user is the highest bidder or not
     * @param $userID - The current user
     * @param $lotID - The item which user have bid on
     */
    public function getUserHighestBid($userID, $lotID)
    {
        $sqlQuery = 'SELECT MAX(bid) FROM bid WHERE lot_id = :id AND user_id = :user_id';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(":id", $lotID, PDO::PARAM_INT);
        $statement->bindParam(":user_id", $userID, PDO::PARAM_INT);
        $statement->execute();

        if ($statement->rowCount() > 0)
        {
            return $statement->fetchColumn();
        }
    }
}