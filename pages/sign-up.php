<!DOCTYPE html>
<html lang="en">

<?php
include("../includes/database.php"); // Include your database connection file
?>

<!-- <meta http-equiv="refresh" content="5"> -->





<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/sign-up.css">
</head>

<body>
    <nav>
        <div>
            <ul>
                <li><a href="../index.php"><img class="logo" src="../assets/images/home.png" alt="Home"></a></li>
            </ul>
        </div>
        <ul>
            <li><a href="contact.php">Contact Us</a></li>
            <li><a class="active" href="sign-up.php">Sign Up</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
    <div class="sign-up-container">
        <form class="sign-up-form" id="form" action="../includes/signup-handler.php" method="POST">
            <h1>Sign Up</h1>
            <div style="background-color: grey; height: 3px; margin-bottom: 12px; border-radius: 20px;"></div>
            <div class="input-control">
                <input type="text" id="first_name" name="first_name" placeholder="First Name">
                <div class="error"></div>
            </div>


            <div class="input-control">
                <input type="text" id="last_name" name="last_name" placeholder="Last Name">
                <div class="error"></div>
            </div>



            <div class="input-control">
                <input type="text" id="email" name="email" placeholder="Email">
                <div class="error"></div>
            </div>



            <div class="input-control">
                <input type="text" id="username" name="username" placeholder="Username"
                    title="Username must be at least 3 characters long.">
                <div class="error"></div>
            </div>



            <div class="input-control">
                <input type="password" id="password" name="password" placeholder="Password"
                    title="Password must be at least 8 characters long.">
                <div class="error"></div>
            </div>




            <label for="user_type">Select User Type:</label>
            <!-- <div class="input-control-select"> -->
            <select id="user_type" name="user_type">
                <option value="" disabled selected>Select a user type</option>
                <option value="1">Student</option>
                <option value="2">Teacher</option>
            </select>
            <!-- </div> -->
            <div style="display: flex; flex-direction: row-reverse; margin-top: 10px;">
                <button type="submit">Create</button>
            </div>
        </form>
    </div>
</body>


<script src="../assets/js/signup-validation.js"></script>

</html>