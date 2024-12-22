<!DOCTYPE html>
<html lang="en">
<?php
include("../includes/database.php");

session_start();
// if (isset($_SESSION['error_message'])) {
//     echo "<p style='color: red;'>" . $_SESSION['error_message'] . "</p>";
//     unset($_SESSION['error_message']); // Clear the error message after displaying it
// }

if (isset($_SESSION['error_message'])) {
    echo '<div class="error-box">';
    echo '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.708c.889 0 1.437-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                  </svg>';
    echo "<span>" . $_SESSION['error_message'] . "</span>";
    echo '</div>';
    unset($_SESSION['error_message']); // Clear the error message after displaying it
}

?>
<script src="../assets/js/status.js"></script>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet"> -->
    <link rel="stylesheet" href="../assets/css/login.css">

</head>

<body>
    <nav>
        <div>
            <ul>
                <li> <a href="../index.php"><img class="logo" src="../assets/images/home.png" alt="Home"></a></li>
            </ul>
        </div>
        <ul>
            <li><a href="contact.php">Contact Us</a></li>
            <li><a href="sign-up.php">Sign Up</a></li>
            <li><a class="active" href="login.php">Login</a></li>

        </ul>
    </nav>
    <div class="login-container">
        <form id="form" class="login-form" action="../includes/login-handler.php" method="POST">
            <h1>Login</h1>
            <div style="background-color: grey; height: 3px; margin-bottom: 12px; border-radius: 20px;"></div>

            <div class="input-control">
                <input type="text" id="username" name="username" placeholder="Username">
                <div class="error"></div>
            </div>
            <div class="input-control">
                <input type="password" id="password" name="password" placeholder="Password">
                <div class="error"></div>
            </div>
            <div style="display: flex; flex-direction: row-reverse; margin-top: 10px;">
                <button type="submit">Join</button>
            </div>
        </form>
    </div>

</body>


<script src="../assets/js/login-validation.js"></script>

</html>