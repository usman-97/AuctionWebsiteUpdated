/**
 * Allow user to place a bid on a lot
 * @param bid
 * @param error
 * @constructor
 */
function PlaceBid(bid, error)
{
    // console.log(bid);
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
                    // let txt = this.responseText;
                    // console.log(txt);


                    error.innerHTML = this.responseText; // If there is an error then display it
                    bid.value = ""; // Clear bid field
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