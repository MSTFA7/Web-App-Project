<?php
session_start();
include("database.php");
include("getinfo.php");

// Ensure only teachers can access this
if ($_SESSION['role_id'] != 2) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo'test';
    echo $teacher_id;
    $subject_id = mysqli_real_escape_string($connection, $_POST['subject_id']);
    $level_id = mysqli_real_escape_string($connection, $_POST['level_id']);
    $board_id = mysqli_real_escape_string($connection, $_POST['board_id']);
    $semester_id = mysqli_real_escape_string($connection, $_POST['semester_id']);

    // Check if the course already exists in the `courses` table
    $check_query = "SELECT course_id FROM courses WHERE subject_id = ? AND level_id = ? AND board_id = ? AND semester_id = ?";
    $stmt = mysqli_prepare($connection, $check_query);
    mysqli_stmt_bind_param($stmt, "iiii", $subject_id, $level_id, $board_id, $semester_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Course already exists, fetch its ID
        $course_id = $row['course_id'];
    } else {
        // Insert new course into the `courses` table
        $insert_course_query = "INSERT INTO courses (subject_id, level_id, board_id, semester_id) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($connection, $insert_course_query);
        mysqli_stmt_bind_param($stmt, "iiii", $subject_id, $level_id, $board_id, $semester_id);
        if (mysqli_stmt_execute($stmt)) {
            $course_id = mysqli_insert_id($connection);
        } else {
            echo "Failed to create the course.";
            exit;
        }
    }

    // Assign the course to the teacher in the `teachers_courses` table
    $insert_teacher_course_query = "INSERT INTO teachers_courses (teacher_id, course_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($connection, $insert_teacher_course_query);
    mysqli_stmt_bind_param($stmt, "ii", $teacher_id, $course_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "Course started successfully!";
        header("Location: ../pages/teacher-home.php"); // Redirect back to dashboard
    } else {
        echo "Failed to assign the course to the teacher.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($connection);
} else {
    echo "Invalid request method.";
}
?>
