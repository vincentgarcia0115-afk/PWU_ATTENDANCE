let html5QrCode = null;
let scannerRunning = false;

const scanBtn = document.getElementById("scanBtn");
const stopCamera = document.getElementById("stopCamera");

scanBtn.addEventListener("click", async () => {

    if (scannerRunning) {
        return;
    }

    html5QrCode = new Html5Qrcode("reader");

    try {

        await html5QrCode.start(
            { facingMode: "environment" },
            {
                fps: 10,
                qrbox: 250
            },
            (decodedText) => {

                alert("QR Code: " + decodedText);

            },
            (error) => {
                // Ignore scan errors
            }
        );

        scannerRunning = true;

    } catch (err) {

        console.error(err);

    }

});


stopCamera.addEventListener("click", async () => {

    if (!scannerRunning || !html5QrCode) {
        return;
    }

    try {

        await html5QrCode.stop();
        await html5QrCode.clear();

        scannerRunning = false;
        html5QrCode = null;

        document.getElementById("reader").innerHTML = "";

    } catch (err) {

        console.error(err);

    }

});

const form = document.getElementById("loginForm");
const username = document.getElementById("username");
const password = document.getElementById("password");
const error = document.getElementById("error");

form.addEventListener("submit", function (e) {

    error.textContent = "";

    if (username.value.trim() === "") {
        e.preventDefault();
        error.textContent = "Username is required.";
        username.focus();
        return;
    }

    if (password.value.trim() === "") {
        e.preventDefault();
        error.textContent = "Password is required.";
        password.focus();
        return;
    }

    if (password.value.length < 6) {
        e.preventDefault();
        error.textContent = "Password must be at least 6 characters.";
        password.focus();
        return;
    }

});