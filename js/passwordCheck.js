
var userPassword = document.getElementById("newPassword"); // text from new password field

var weak = document.getElementById("weak"); // Weak strength container
var fair = document.getElementById("fair"); // Fair strength container
var strong = document.getElementById("strong"); // Strong strength container
var status = document.getElementById("passwordStatus"); // password strength status text

/**
 * Checks the strength of the password
 * @param str - value of new password field
 */
function Strength(str)
{
    let fairStrength = /\d/g; // Fair password condition
    //let strongStrength = /[A-Z]*[a-z]*[0-9]*[-+_!@#$%^&*.,?]/; // Strong password condition
    let uppercaseCheck = /[A-Z]/g; // Upper case letter check
    let lowercaseCheck = /[a-z]/g; // Upper case letter check
    let specialCharacterCheck = /[-+_!@#$%^&*.,?]/g; // special character check

    var status = document.getElementById("passwordStatus");

    var changeColour = (element, colour) => {element.style.backgroundColor = colour;} // change the colour of element

    // Get all nodes inside element with id 'passwordStrength'
    var containers = document.getElementById("passwordStrength").children;
    for (var i = 0; i < containers.length - 1; i++)
    {
        containers[i].style.display = "inline-block"; // set child elements' display to inline block
    }
    // console.log(containers);

    // If user typed password length is less than 8
    if (str.length < 8)
    {
        changeColour(weak, "red");
        changeColour(fair, "#4e555b");
        changeColour(strong, "#4e555b");
        status.innerHTML = "Weak";
    }

    // If user password has a number and greater than or equal to 8 characters
    if (fairStrength.test(str) && str.length >= 8)
    {
        changeColour(weak, "orange");
        changeColour(fair, "orange");
        changeColour(strong, "#4e555b");
        status.innerHTML = "Fair";
    }

    // If user password is greater than or equal to 8 character
    // and contains one Uppercase or one lowercase with a number and a special character
    if (uppercaseCheck.test(str) && specialCharacterCheck.test(str) && fairStrength.test(str) && lowercaseCheck.test(str) && str.length >= 8)
    {
        changeColour(weak, "green");
        changeColour(fair, "green");
        changeColour(strong, "green");
        status.innerHTML = "Strong";
    }
}