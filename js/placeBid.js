/**
 * Allow user to place a bid on a lot
 * @param bid
 * @param error
 * @param lotID
 * @param bidContainer
 * @param loadLotBids
 * @param auctionID
 * @constructor
 */
function PlaceBid(bid, error, lotID, bidContainer, loadLotBids, auctionID = "")
{
    // If bid is not empty
    if (bid.value.length > 0)
    {
        // If bid is a valid number
        if (!isNaN(bid.value))
        {
            error.innerHTML = "";

            let xmlhttp = new XMLHttpRequest(); // xml http request

            xmlhttp.onreadystatechange = function ()
            {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                {
                    let txt = this.responseText;
                    let newBid = parseInt(txt);
                    // console.log(txt);

                    error.innerHTML = isNaN(newBid) ? txt: ""; // If there is an error then display it
                    bid.value = ""; // Clear bid field

                    var loadBids = loadLotBids ? new LoadLotBids(lotID, bidContainer): ""; // LoadBids instance to load bids once user has successfully place a bid
                }
            }

            // Send xml http request with user placed bid
            xmlhttp.open("GET", "ajax/placeUserBid.php?q=" + bid.value + "&r=" + lotID + "&s=" + auctionID + "&token=" + token, true)
            xmlhttp.send();
        }
        else
        {
            error.innerHTML = "Invalid amount";
        }
    }
    else
    {
        error.innerHTML = "Insufficient amount"
    }
}