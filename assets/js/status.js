document.addEventListener("DOMContentLoaded", () => {
    const statusIcon = document.getElementById("status");

    if (typeof dbStatus !== "undefined") {
        if (dbStatus === "connected") {
            statusIcon.style.backgroundColor = "green"; // Success
        } else {
            statusIcon.style.backgroundColor = "red"; // Failure
        }
    }
});