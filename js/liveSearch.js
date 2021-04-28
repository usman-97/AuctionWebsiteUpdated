
function ShowHints(str, hintTxt)
{
    // console.log(token);
    let xmlhttp = new XMLHttpRequest();

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
                token +"'>" +
                "<img src='images/" + obj._image +".jpg' width='50px' height='50px'></div>" +
                "<div class='col-sm-5'><span>" + obj._lot_title + " " + obj._lot_main + "</span></div></a></div>";
            hint.id = "hint" + counter;
            hintTxt.appendChild(hint);
            // hint.style.border = "2px solid #000000";
            // hintTxt.innerHTML += "<br>";
            counter++;
        });
    }

    if (str.length >= 3)
    {
        xmlhttp.open("GET", "ajax/liveSearch.php?q=" + str, true);
        xmlhttp.send();
    }
}