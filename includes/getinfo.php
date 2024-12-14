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
        $user_id = htmlspecialchars($user["user_id"]);
        $username = htmlspecialchars($user['username']);
        $email = htmlspecialchars($user['email']);
        $first_name = htmlspecialchars($user['first_name']);
        $last_name = htmlspecialchars($user['last_name']);
        $role_id = htmlspecialchars($user['role_id']);
        

        if($role_id == 1) {
            $student_query = "SELECT * FROM students WHERE user_id = '$user_id'";
            $student_result = mysqli_query($connection, $student_query);
    
            $student = mysqli_fetch_assoc($student_result);
    
            $student_id = htmlspecialchars($student["student_id"]);

        }
        elseif($role_id == 2) {

            $teacher_query = "SELECT * FROM teachers WHERE user_id = '$user_id'";
            $teacher_result = mysqli_query($connection, $teacher_query);
    
            $teacher = mysqli_fetch_assoc($teacher_result);
    
            $teacher_id = htmlspecialchars($teacher["teacher_id"]);

        }

    } else {
        echo "No user found with the username: $username";
    }




    mysqli_free_result($result);
    
?>