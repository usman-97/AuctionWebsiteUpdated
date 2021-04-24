

function UserBidStatus(bidStatus, lot)
{
    var xmlhttp = new XMLHttpRequest();
    // console.log(lot);
    // console.log(bidStatus);

    xmlhttp.onreadystatechange = function ()
    {
        if (this.readyState == 4 && this.status == 200)
        {
            // console.log(this.responseText);
            bidStatus.innerHTML = this.responseText;

            if (this.responseText == "Highest bid")
            {
                bidStatus.style.backgroundColor = "#036311";
            }
            else if (this.responseText == "Outbid")
            {
                bidStatus.style.backgroundColor = "#bf130a";
            }
            else
            {
                bidStatus.innerHTML = "error";
            }
        }
    }

    xmlhttp.open("GET", "ajax/getBidStatus.php?q=" + lot, true);
    xmlhttp.send();
}