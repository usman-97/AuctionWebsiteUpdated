
function PlaceBid(bid)
{
    if (bid.value.length > 0)
    {
        if (!isNaN(bid.value))
        {
            error.innerHTML = "";

            let xmlhttp = new XMLHttpRequest();

            xmlhttp.onreadystatechange = function ()
            {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                {
                    // let txt = this.responseText;
                    // console.log(txt);

                    error.innerHTML = this.responseText;
                    bid.value = "";
                }
            }

            xmlhttp.open("GET", "ajax/placeUserBid.php?q=" + bid.value, true)
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