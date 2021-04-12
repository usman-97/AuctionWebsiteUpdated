

function UserBidStatus(bidStatus, userBid)
{
    var xmlhttp = new XMLHttpRequest();
    // console.log(userBid);
    // console.log(bidStatus);

    xmlhttp.onreadystatechange = function ()
    {
        if (this.readyState == 4 && this.status == 200)
        {
            // console.log(this.responseText);
            bidStatus.innerHTML = this.responseText;

            if (this.responseText == "Highest bid")
            {
                bidStatus.style.backgroundColor = "green";
            }
            else if (this.responseText == "Outbid")
            {
                bidStatus.style.backgroundColor = "red";
            }
        }
    }

    xmlhttp.open("GET", "ajax/getBidStatus.php?q=" + userBid, true);
    xmlhttp.send();
}