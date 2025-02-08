import '../css/user_signin.css'

document.addEventListener("DOMContentLoaded", function () {
    let errorMessage = document.querySelector(".error-message");

    if (!errorMessage) {
        return;
    }

    if (errorMessage.textContent.trim() !== "") {
        errorMessage.style.display = "block";
    }
});