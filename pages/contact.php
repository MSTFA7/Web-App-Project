<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/contact.css">
</head>

<body>
    <nav>
        <div>
            <ul>
                <li> <a href="../index.php"><img class="logo" src="../assets/images/home.png" alt="Home"></a></li>
            </ul>
        </div>
        <ul>
            <li><a class="active" href="">Contact Us</a></li>
            <li><a href="sign-up.html">Sign Up</a></li>
            <li><a href="login.php">Login</a></li>

        </ul>
    </nav>

    <div class="contact-container">
        <form class="contact-form" action="../includes/form-handler.php" method="POST">
            <!-- Replace with your Access Key -->
            <h1>Contact Us</h1>
            <div style="background-color: grey; height: 3px; margin-bottom: 12px; border-radius: 20px;"></div>

            <input type="text" name="name" id="name" placeholder="Full Name" required>
            <input type="email" id="email" name="email" placeholder="Email" required>
            <textarea required name="issue" id="issue" placeholder="Describe your issue."></textarea>

            <div style="display: flex; flex-direction: row-reverse; margin-top: 10px;">
                <button type="submit">Send</button>
            </div>
        </form>
    </div>
</body>

</html>