<!DOCTYPE html>
<html lang="en">

<?php
    include("../includes/database.php"); // Include your database connection file
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
        <form class="sign-up-form" action="../includes/signup-handler.php" method="POST">
            <h1>Sign Up</h1>
            <div style="background-color: grey; height: 3px; margin-bottom: 12px; border-radius: 20px;"></div>

            <input type="text" id="first_name" name="first_name" placeholder="First Name" required>
            <input type="text" id="last_name" name="last_name" placeholder="Last Name" required>
            <input type="email" id="email" name="email" placeholder="Email" required>
            <input type="text" id="username" name="username" placeholder="Username" required minlength="8" 
                title="Username must be at least 8 characters long.">
            <input type="password" id="password" name="password" placeholder="Password" required minlength="8" 
                title="Password must be at least 8 characters long.">

            <label for="user_type">Select User Type:</label>
            <select id="user_type" name="user_type" required>
                <option value="1">Student</option>
                <option value="2">Teacher</option>
            </select>
            <div style="display: flex; flex-direction: row-reverse; margin-top: 10px;">
                <button type="submit">Create</button>
            </div>
        </form>
    </div>
</body>

</html>
