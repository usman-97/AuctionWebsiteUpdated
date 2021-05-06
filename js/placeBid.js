/**
 * Allow user to place a bid on a lot
 * @param bid
 * @param error
 * @param lotID
 * @param bidContainer
 * @param loadLotBids
 * @constructor
 */
function PlaceBid(bid, error, lotID, bidContainer, loadLotBids)
{
    // console.log(loadLotBids);
    // If bid is not empty
    this.getUserCurrentBid = bidTxt => bidTxt.innerHTML

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
                    // console.log(!isNaN(newBid));

                    error.innerHTML = isNaN(newBid) ? txt: ""; // If there is an error then display it
                    bid.value = ""; // Clear bid field

                    var loadBids = loadLotBids ? new LoadLotBids(lotID, bidContainer): ""; // LoadBids instance to load bids once user has successfully place a bid
                }
            }

            // Send xml http request with user placed bid
            xmlhttp.open("GET", "ajax/placeUserBid.php?q=" + bid.value + "&token=" + token, true)
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