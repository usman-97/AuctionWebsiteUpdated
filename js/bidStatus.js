/**
 * UserBidStatus class to get the current status of user bid
 * @param bidStatus
 * @param lot
 * @param endDate
 * @constructor
 */
function UserBidStatus(bidStatus, lot, endDate)
{
    let date = new Date().getTime(); // Get current time
    let end = new Date(endDate).getTime(); // Get lot end date time
    // console.log(lot);

    var xmlhttp = new XMLHttpRequest(); // XMLHttpRequest

    xmlhttp.onreadystatechange = function ()
    {
        if (this.readyState == 4 && this.status == 200)
        {
            // console.log(this.responseText);
            // If user is the highest bidder
            if (this.responseText == true)
            {
                // Display the text according to auction time, if auction is ended
                // then inform that user has won
                // otherwise inform user is the highest bidder
                bidStatus.innerHTML = date > end ? "WON":"Highest bidder";
                bidStatus.style.backgroundColor = "#036311";
            }
            // If user is not the highest bidder
            else
            {
                // If auction is ended then inform user that they have lost
                // if auction is still going on then inform user that they are
                // outbid by other bidder
                bidStatus.innerHTML = date > end ? "LOST":"Outbid"
                bidStatus.style.backgroundColor = "#bf130a";
            }
        }
    }

    // Send xml http request to getBidStatus php script with lot id
    xmlhttp.open("GET", "ajax/getBidStatus.php?q=" + lot + "&token=" + token, true);
    xmlhttp.send(); // Send the request
}