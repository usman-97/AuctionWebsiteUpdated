
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
                searchHint.innerHTML += "<div class='col-sm-3' style='color: #c42121'><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-broadcast\" viewBox=\"0 0 16 16\">\n" +
                    "  <path d=\"M3.05 3.05a7 7 0 0 0 0 9.9.5.5 0 0 1-.707.707 8 8 0 0 1 0-11.314.5.5 0 0 1 .707.707zm2.122 2.122a4 4 0 0 0 0 5.656.5.5 0 1 1-.708.708 5 5 0 0 1 0-7.072.5.5 0 0 1 .708.708zm5.656-.708a.5.5 0 0 1 .708 0 5 5 0 0 1 0 7.072.5.5 0 1 1-.708-.708 4 4 0 0 0 0-5.656.5.5 0 0 1 0-.708zm2.122-2.12a.5.5 0 0 1 .707 0 8 8 0 0 1 0 11.313.5.5 0 0 1-.707-.707 7 7 0 0 0 0-9.9.5.5 0 0 1 0-.707zM10 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0z\"/>\n" +
                    "</svg> LIVE</div>";
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