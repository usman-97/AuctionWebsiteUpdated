/**
 * Countdown timer class to count down the time of auction
 * @param start
 * @param endDate
 * @param timer
 * @param liveTxt
 * @param endDateTxt
 * @param startTime
 * @constructor
 */
function CountDown(start, endDate, timer, liveTxt, endDateTxt, startTime = "")
{

    let startDate = new Date(start); // Auction start date
    let countDownTime = new Date(endDate).getTime(); // auction end date time
    let now = new Date().getTime(); // current time

    // If auction start date has been passed
    if (startDate <= now) {
        endDateTxt.innerHTML = "<b>Ends on " + endDate + "</b>"; // Then display auction end date
        endDateTxt.style.color = "#4e555b";

        if (startTime != "")
        {
            startTime.innerHTML = "";
        }

        // Interval to count the time until the auction end date
        let x = setInterval(function () {
            let now = new Date().getTime(); // current time
            let difference = countDownTime - now; // Difference between current time and auction end date

            let days = Math.floor(difference / (1000 * 60 * 60 * 24)); // Total days left to auction end date
            let hours = Math.floor((difference / (1000 * 60 * 60)) % 24); // Total hours left to auction end date
            let minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60)); // Total minutes
            let seconds = Math.floor((difference % (1000 * 60)) / 1000); // Total seconds

            // Display timer
            timer.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
            // Show Live as the status of an auction
            liveTxt.innerHTML = "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-broadcast\" viewBox=\"0 0 16 16\">\n" +
                "  <path d=\"M3.05 3.05a7 7 0 0 0 0 9.9.5.5 0 0 1-.707.707 8 8 0 0 1 0-11.314.5.5 0 0 1 .707.707zm2.122 2.122a4 4 0 0 0 0 5.656.5.5 0 1 1-.708.708 5 5 0 0 1 0-7.072.5.5 0 0 1 .708.708zm5.656-.708a.5.5 0 0 1 .708 0 5 5 0 0 1 0 7.072.5.5 0 1 1-.708-.708 4 4 0 0 0 0-5.656.5.5 0 0 1 0-.708zm2.122-2.12a.5.5 0 0 1 .707 0 8 8 0 0 1 0 11.313.5.5 0 0 1-.707-.707 7 7 0 0 0 0-9.9.5.5 0 0 1 0-.707zM10 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0z\"/>\n" +
                "</svg> LIVE";
            liveTxt.style.display = "inline-block";
            liveTxt.style.padding = "5px";
            liveTxt.style.backgroundColor = "#c42121";
            liveTxt.style.color = "#ffffff";

            // When timer ends
            if (difference < 0) {
                clearInterval(x);
                timer.innerText = "END";
            }
        }, 1000)
    }
}