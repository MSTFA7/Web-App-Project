<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            <li><a href="sign-up.html">Sign Up</a></li>
            <li><a class="active" href="login.php">Login</a></li>

        </ul>
    </nav>
    <div class="login-container">
        <form class="login-form" action="">
            <h1>Login</h1>
            <div style="background-color: grey; height: 3px; margin-bottom: 12px; border-radius: 20px;"></div>
            <input type="text" id="username" placeholder="Username">
            <input type="password" id="password" placeholder="Password">

            <div style="display: flex; flex-direction: row-reverse; margin-top: 10px;">
                <button type="submit">Join</button>
            </div>
        </form>
    </div>


</body>

</html>