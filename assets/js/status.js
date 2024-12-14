document.addEventListener("DOMContentLoaded", () => {
    const statusIcon = document.getElementById("status");

    if (typeof dbStatus !== "undefined") {
        if (dbStatus === "connected") {
            statusIcon.style.backgroundColor = "green"; // Success
            console.log("Database Connected");
        } else {
            statusIcon.style.backgroundColor = "red"; // Failure
            console.log("Database Disconnected");
        }
    }
});