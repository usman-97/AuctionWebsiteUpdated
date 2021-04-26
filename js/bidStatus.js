

function UserBidStatus(bidStatus, lot, endDate)
{
    // this.bidStatus = bidStatus;
    // this.lot = lot;
    let date = new Date().getTime();
    let end = new Date(endDate).getTime();

    var xmlhttp = new XMLHttpRequest();
    // console.log(lot);
    // console.log(bidStatus);

    xmlhttp.onreadystatechange = function ()
    {
        if (this.readyState == 4 && this.status == 200)
        {
            // console.log(this.responseText);
            // bidStatus.innerHTML = this.responseText;

            if (this.responseText == true)
            {
                bidStatus.innerHTML = date > end ? "WON":"Highest bidder";
                bidStatus.style.backgroundColor = "#036311";
            }
            else
            {
                bidStatus.innerHTML = date > end ? "LOST":"Outbid"
                bidStatus.style.backgroundColor = "#bf130a";
            }
            // else
            // {
            //     bidStatus.innerHTML = "error";
            // }
        }
    }

    xmlhttp.open("GET", "ajax/getBidStatus.php?q=" + lot, true);
    xmlhttp.send();
}

UserBidStatus.prototype.setColour = function ()
{

}

// UserBidStatus.prototype.getBidEndStatus = function ()
// {
//     let xmlhttp = new XMLHttpRequest();
//
//     xmlhttp.onreadystatechange = function ()
//     {
//         if (xmlhttp.readyState == 4 && xmlhttp.status == 400)
//         {
//             this.bidStatus.innerHTML = this.responseText;
//             this.setColour
//         }
//     }
//
//
// }