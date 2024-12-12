<!DOCTYPE html>
<html lang="en">
    <?php
        include("../includes/auth.php");
        require_role(2);
        include("../includes/database.php");

        $query = "SELECT * FROM users WHERE username = '$username'";  // You can use this directly, but remember it's less secure

        // Run the query
        $result = mysqli_query($connection, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            // Fetch the user data
            $user = mysqli_fetch_assoc($result);

            // Now you can access all the user's details, for example:
            $username = htmlspecialchars($user['username']);
            $email = htmlspecialchars($user['email']);
            $first_name = htmlspecialchars($user['first_name']);
            $last_name = htmlspecialchars($user['last_name']);
            $role_id = htmlspecialchars($user['role_id']);
            // And so on for other fields
        } else {
            echo "No user found with the username: $username";
        }

        // Close the result set (optional)
        mysqli_free_result($result);
    ?>
    <script src="../assets/js/status.js"></script>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/student-home.css">
</head>
<body>
    <div class="container">
        <div class="navbar"></div>
        <div class="sidebar">
            <div class="name"> 
                <h2>Teacher</h2>
                <h1>Hello,</h1>
                <h1>mustafa</h1>
            </div>
            <div class="linebreak"></div>
            <div>
                <ul>
                    <li><a href="">Courses</a></li>
                    <li><a href="">Enroll</a></li>
                    <li><a href="">Help</a></li>
                    <li><a href="../includes/logout.php" class="logout">LOGOUT</a></li>
                </ul>
            </div>
        </div>
        <div class="cont"></div>
    </div>







    <div class="status" id="status"></div>
</body>
</html>