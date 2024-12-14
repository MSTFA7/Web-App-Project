<?php
include("../includes/database.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve and sanitize user input
    $first_name = mysqli_real_escape_string($connection, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($connection, $_POST['last_name']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $user_type = mysqli_real_escape_string($connection, $_POST['user_type']); // 1 = Student, 2 = Teacher

    // Check for empty fields
    if (empty($first_name) || empty($last_name) || empty($email) || empty($username) || empty($password) || empty($user_type)) {
        echo "All fields are required.";
        exit;
    }

    // Check if the username or email already exists
    $check_query = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = mysqli_prepare($connection, $check_query);
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        echo "Username or email already exists.";
        exit;
    }

    mysqli_stmt_close($stmt);

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert data into the users table
    $user_query = "INSERT INTO users (first_name, last_name, username, password, email, role_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connection, $user_query);
    mysqli_stmt_bind_param($stmt, "sssssi", $first_name, $last_name, $username, $hashed_password, $email, $user_type);

    if (mysqli_stmt_execute($stmt)) {
        $user_id = mysqli_insert_id($connection); // Get the inserted user_id

        // Insert into the respective table based on role
        if ($user_type == 1) { // Student
            $student_query = "INSERT INTO students (user_id) VALUES (?)";
            $stmt = mysqli_prepare($connection, $student_query);
            mysqli_stmt_bind_param($stmt, "i", $user_id);
        } elseif ($user_type == 2) { // Teacher
            $teacher_query = "INSERT INTO teachers (user_id) VALUES (?)";
            
            $stmt = mysqli_prepare($connection, $teacher_query);
            mysqli_stmt_bind_param($stmt, "i", $user_id);
        }

        if (mysqli_stmt_execute($stmt)) {
            echo "Account created successfully!";
            header("Location: ../pages/login.php"); // Redirect to login page
        } else {
            echo "Error inserting into role-specific table.";
        }
    } else {
        echo "Error inserting into users table.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($connection);
} else {
    echo "Invalid request method.";
}
?>
