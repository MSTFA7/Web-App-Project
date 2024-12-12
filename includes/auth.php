<?php
session_start();
include('database.php');
$username = $_SESSION['username'];
// checks if user is logged in
if (!isset($username)) {
    header("Location: ../pages/login.php");
    exit;
}

// checks correct role
function require_role($role_id) {
    if ($_SESSION['role_id'] != $role_id) {
        header("Location: ../pages/login.php");
        exit;
    }
}






































// $query = "SELECT * FROM users WHERE username = '$username'";  // You can use this directly, but remember it's less secure

// // Run the query
// $result = mysqli_query($connection, $query);

// if ($result && mysqli_num_rows($result) > 0) {
//     // Fetch the user data
//     $user = mysqli_fetch_assoc($result);

//     // Now you can access all the user's details, for example:
//     $username = htmlspecialchars($user['username']);
//     $email = htmlspecialchars($user['email']);
//     $first_name = htmlspecialchars($user['first_name']);
//     $last_name = htmlspecialchars($user['last_name']);
//     $role_id = htmlspecialchars($user['role_id']);
//     // And so on for other fields
// } else {
//     echo "No user found with the username: $username";
// }

// // Close the result set (optional)
// mysqli_free_result($result);
?>