<?php
    $username = $_SESSION['username'];
    include('database.php');

    // Run the query
    $query = "SELECT * FROM users WHERE username = '$username'";  
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
    } else {
        echo "No user found with the username: $username";
    }

    mysqli_free_result($result);
    
?>