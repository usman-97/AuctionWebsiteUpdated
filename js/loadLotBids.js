
function LoadLotBids(str, bidContainer)
{
    let xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function ()
    {
        let hideUsername = user => {
            let firstLetter = user.substring(0, 1);
            let lastLetter = user.substring(user.length - 1, user.length);

            let hiddenName = firstLetter;
            for (let i = 1; i < user.length - 1; i++)
            {
                hiddenName += "*";
            }
            hiddenName += lastLetter;

            return hiddenName;
        }

        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            let lotBid = JSON.parse(this.responseText);
            console.log(lotBid);
            bidContainer.innerHTML = "";

            let counter = 1;
            lotBid.forEach(function (obj){
                // let container;
                // try {
                //     container = document.getElementById("bidRow" + counter);
                // }
                // catch (err)
                // {
                //     container = document.createElement("div");
                //     container.id = "bidRow" + counter;
                //     document.getElementById("bidContainer").appendChild(container);
                // }

                // container.innerHTML = "<div class='col-sm-4'>" + obj._bidID + "</div>" +
                //     "<div class='col-sm-4'>" + hideUsername(obj._username) + "</div>" +
                //     "<divclass='col-sm-4'>£" + obj._bid +"</div>";

                let container = document.createElement("div");
                container.id = "bidRow" + counter;
                container.className = "row dfContainer";
                container.innerHTML = "<div class='col-sm-4'>" + obj._bidID + "</div>" +
                        "<div class='col-sm-4'>" + hideUsername(obj._username) + "</div>" +
                        "<divclass='col-sm-4'>£" + obj._bid +"</div>";
                bidContainer.appendChild(container);
                counter++;
            });
        }
    }

    xmlhttp.open("GET", "ajax/fetchLotBids.php?q=" + str, true);
    xmlhttp.send();
}