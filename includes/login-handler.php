<?php
include("database.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitization
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    // Input validation
    if (empty($username) || empty($password)) {
        $_SESSION['error_message'] = "Username or Password cannot be empty.";
        header("Location: ../pages/login.php");
        exit;
    }

    if (strlen($username) < 3) {
        $_SESSION['error_message'] = "Username must be at least 3 characters long.";
        header("Location: ../pages/login.php");
        exit;
    }

    if (strlen($password) < 8) {
        $_SESSION['error_message'] = "Password must be at least 8 characters long.";
        header("Location: ../pages/login.php");
        exit;
    }

    // Query the database
    $query = "SELECT user_id, username, password, role_id FROM users WHERE username = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verify the password
        if (password_verify($password, $user['password'])) {
            $user_id = $user['user_id'];
            $role_id = $user['role_id'];

            $_SESSION['user_id'] = $user_id; // Store user_id in session
            $_SESSION['username'] = $username;
            $_SESSION['role_id'] = $role_id;

            // Redirect based on role_id
            if ($role_id == 1) {
                header("Location: ../pages/student-home.php");
                exit;
            } elseif ($role_id == 2) {
                header("Location: ../pages/teacher-home.php");
                exit;
            } elseif ($role_id == 3) {
                header("Location: ../pages/admin.php");
                exit;
            } else {
                $_SESSION['error_message'] = "Invalid role.";
                header("Location: ../pages/login.php");
                exit;
            }
        } else {
            $_SESSION['error_message'] = "Invalid username or password.";
            header("Location: ../pages/login.php");
            exit;
        }
    } else {
        $_SESSION['error_message'] = "Invalid username or password.";
        header("Location: ../pages/login.php");
        exit;
    }

    // Close the statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($connection);
} else {
    $_SESSION['error_message'] = "Invalid request method.";
    header("Location: ../pages/login.php");
    exit;
}
