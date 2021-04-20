
function CountDown(start, endDate, timer, liveTxt, endDateTxt, startTime)
{
    console.log(start);
    console.log(endDate);
    console.log(timer);
    console.log(liveTxt);

    // for (let i = 1; i <= 20; i++) {
    let startDate = new Date(start);
    // console.log(startDate);
    let countDownTime = new Date(endDate).getTime();
    let now = new Date().getTime();
    // console.log(new Date(start));
    // console.log();

    if (startDate <= now) {
        endDateTxt.innerHTML = "<b>Ends on " + endDate + "</b>";
        endDateTxt.style.color = "#4e555b";

        startTime.innerHTML = "";

        let x = setInterval(function () {
            let now = new Date().getTime();
            let difference = countDownTime - now;
            // console.log(difference);

            let days = Math.floor(difference / (1000 * 60 * 60 * 24));
            let hours = Math.floor((difference / (1000 * 60 * 60)) % 24);
            let minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((difference % (1000 * 60)) / 1000);
            // console.log(days);

            // for (var i = 1; i <= 20; i++)
            // {
            timer.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
            liveTxt.innerHTML = "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-broadcast\" viewBox=\"0 0 16 16\">\n" +
                "  <path d=\"M3.05 3.05a7 7 0 0 0 0 9.9.5.5 0 0 1-.707.707 8 8 0 0 1 0-11.314.5.5 0 0 1 .707.707zm2.122 2.122a4 4 0 0 0 0 5.656.5.5 0 1 1-.708.708 5 5 0 0 1 0-7.072.5.5 0 0 1 .708.708zm5.656-.708a.5.5 0 0 1 .708 0 5 5 0 0 1 0 7.072.5.5 0 1 1-.708-.708 4 4 0 0 0 0-5.656.5.5 0 0 1 0-.708zm2.122-2.12a.5.5 0 0 1 .707 0 8 8 0 0 1 0 11.313.5.5 0 0 1-.707-.707 7 7 0 0 0 0-9.9.5.5 0 0 1 0-.707zM10 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0z\"/>\n" +
                "</svg> LIVE";
            liveTxt.style.display = "inline-block";
            liveTxt.style.padding = "5px";
            liveTxt.style.backgroundColor = "#c42121";
            liveTxt.style.color = "#ffffff";
            // console.log("countDownTimer" + i);

            if (difference < 0) {
                clearInterval(x);
                timer.innerText = "END";
            }
            // }
        }, 1000)
    }
    // }
}