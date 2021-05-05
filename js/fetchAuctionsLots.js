/**
 * Fetch auction lots using ajax request from server side
 * @param auctionLotContainer
 * @param filter
 * @param category
 * @param minPrice
 * @param maxPrice
 * @constructor
 */
function FetchAuctionsLots(auctionLotContainer, filter = "", category = "", minPrice = "", maxPrice = "")
{
    let xmlhttp = new XMLHttpRequest(); // XMLREQUEST

    xmlhttp.onreadystatechange = function ()
    {
        // Check status of request
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            let auctionLots = JSON.parse(this.responseText); // The request data from server side
            auctionLotContainer.innerHTML = ""; // reset container

            let counter = 1;
            auctionLots.forEach(function (obj){
                // Generate HTML to display lots in view
                let container = document.createElement("div"); // New div element
                container.className = "col-lg-6 portfolio-item";
                container.innerHTML = '<form action="" method="post"><div class="card h-100">' +
                    '<h4 id="cardHeader' + counter +'" class="card-header">Lot ID #' + obj._lotID +
                    ': ' + obj._lot_title + ' - ' + obj._lot_main + '</h4>' +
                    '<img id="cardImage' + counter + '" src="images/' + obj._image + '.jpg">' +
                    '<div id="cardBody' + counter +'" class="card-body">' +
                    '<h5><b>' + obj._auction_name + '</b>  <span id="liveTxt'+ counter +'"></span></h5>' +
                    '<p class="card-text">' + obj._description + '</p>' +
                    '<p class="card-text"><b>Opening bid Price: £' + obj._price + '</b></p>' +
                    '<p style="color: #4e555b"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16"> ' +
                    '<path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/> ' +
                    '</svg><b><i>' + obj._location + '</i></b></p>' +
                    '<p id="startTime' + counter +'" style="color: #4e555b"><b><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar3" viewBox="0 0 16 16"> ' +
                    '<path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857V3.857z"/> ' +
                    '<path d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/> ' +
                    '</svg> ' + obj._datetime + ' GMT</b></p>' +
                    '<p id="countDownTimer' + counter +'"></p>' +
                    '<p id="endDateTxt' + counter +'"></p>' +
                    '<input id="lot_id' + counter +'" type="hidden" name="lotID" value="' + obj._lotID + '">' +
                    '<input id="start'+ counter +'" type="hidden" name="auctionDatetime" value="' + obj._datetime + '">' +
                    '<input id="endDateTime'+ counter +'" type="hidden" name="auctionEndDatetime" value="' + obj._endDatetime + '">' +
                    '<input id="trackCount' + counter +'" type="hidden" name="auctionAdmin" value="' + counter + '">' +
                    '</div><div class="card-footer"><input type="submit" name="view" value="View" class="btn btn-primary"/></div></div>' +
                    '<input type="hidden" name="lotTitle" value="' + obj._lot_title + '">' +
                    '<input type="hidden" name="lotMain" value="' + obj._lot_main + '">' +
                    '<input type="hidden" name="lotImage" value="' + obj._image + '.jpg">' +
                    '<input type="hidden" name="lotDescription" value="' + obj._description + '">' +
                    '<input type="hidden" name="lotPrice" value="' + obj._price + '">' +
                    '<input type="hidden" name="auctionID" value="' + obj._auction_id + '">' +
                    '<input type="hidden" name="auctionName" value="' + obj._auction_name + '">' +
                    '<input type="hidden" name="auctionLocation" value="' + obj._location + '">' +
                    '</form>';

                auctionLotContainer.appendChild(container); // Add all generated HTML in new div element to existing div container

                // Set count down timer for auctions which are live
                let timer = document.getElementById("countDownTimer" + counter);
                let liveTxt = document.getElementById("liveTxt" + counter);
                let endDateTxt = document.getElementById("endDateTxt" + counter);
                let startDateTxt = document.getElementById("startTime" + counter);

                var x = new CountDown(obj._datetime, obj._endDatetime, timer, liveTxt, endDateTxt, startDateTxt); // CountDown class instance
                counter++;
            });


        }
    }

    // Send Ajax request to server side
    xmlhttp.open("GET", "ajax/fetchAllLots.php?q=" + filter + "&r=" + category + "&s=" + minPrice + "&t=" + maxPrice + "&token=" + token, true);
    xmlhttp.send();
}