/**
 * Load bids for the lot
 * @param str
 * @param bidContainer
 * @constructor
 */
function LoadLotBids(str, bidContainer)
{
    let xmlhttp = new XMLHttpRequest(); // xml http request

    xmlhttp.onreadystatechange = function ()
    {
        // Hide user name for privacy
        let hideUsername = user => {
            let firstLetter = user.substring(0, 1); // The first letter of the username
            let lastLetter = user.substring(user.length - 1, user.length); // The last letter of the username

            // Display only first and last letter of the username
            // between first and last letter display "*"
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
            let lotBid = JSON.parse(this.responseText); // User bids for the lot
            // console.log(lotBid);
            bidContainer.innerHTML = ""; // Reset bid container

            let counter = 1;
            lotBid.forEach(function (obj){
                let container = document.createElement("div"); // Create a div element
                container.id = "bidRow" + counter; // New id
                container.className = "row dfContainer"; // Give class to new div element
                // Set inner html for new div element
                container.innerHTML = "<div class='col-sm-4'>" + obj._bidID + "</div>" +
                        "<div class='col-sm-4'>" + hideUsername(obj._username) + "</div>" +
                        "<divclass='col-sm-4'>£" + obj._bid +"</div>";
                bidContainer.appendChild(container); // Make new element child of bid container
                counter++;
            });
        }
    }

    // Send xml http request with lot id
    xmlhttp.open("GET", "ajax/fetchLotBids.php?q=" + str, true);
    xmlhttp.send();
}