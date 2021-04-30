
function ShowHints(str, hintTxt)
{
    // console.log(token);
    let xmlhttp = new XMLHttpRequest();

    let isLive = (startDate, endDate) => {
        let now = new Date().getTime();
        let start = new Date(startDate).getTime();
        let end = new Date(endDate).getTime();

        // console.log(now);
        // console.log(start);
        // console.log(end);

        return start <= now && end >= now;
    }

    xmlhttp.onreadystatechange = function ()
    {
        console.log(JSON.parse(this.responseText));
        let hints = JSON.parse(this.responseText);

        hintTxt.innerHTML = "";
        hintTxt.style.display = "block";

        let counter = 1;
        hints.forEach(function (obj){
            let hint = document.createElement("div");
            hint.innerHTML = "<div id='txtHint" + counter +"' class='row searchItemHint'><div class='col-sm-3'><a href='viewItem.php?q=" + obj._lotID + "&token=" +
                token +"&a=" + obj._auction_id +"'>" +
                "<img src='images/" + obj._image +".jpg' width='50px' height='50px'></div>" +
                "<div class='col-sm-4'><span>" + obj._lot_title + " " + obj._lot_main + "</span></div></a></div>";
            hint.id = "hint" + counter;
            hint.className = "hintContainers";
            hintTxt.appendChild(hint);

            // console.log(obj._datetime);
            // console.log(obj._endDatetime);
            // console.log(isLive(obj._datetime, obj.endDatetime));

            let searchHint = document.getElementById("txtHint" + counter);
            if (isLive(obj._datetime, obj._endDatetime))
            {
                searchHint.innerHTML += "<div class='col-sm-3' >Live</div>";
            }
            else
            {
                searchHint.innerHTML += "<div class='col-sm-3'>£" + obj._price +"</div>";
            }
            counter++;
        });
    }

    if (str.length >= 3)
    {
        xmlhttp.open("GET", "ajax/liveSearch.php?q=" + str + "&token=" + token, true);
        xmlhttp.send();
    }
}