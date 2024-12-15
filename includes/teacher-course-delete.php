<?php
session_start();
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teacher_id = $_POST['teacher_id'];
    $course_id = $_POST['course_id'];
    
    // echo $teacher_id . $course_id;
    // exit();
    if ($teacher_id && $course_id) {
        $query = "DELETE FROM teachers_courses WHERE teacher_id = ? AND course_id = ?";

        if ($stmt = $connection->prepare($query)) {
            $stmt->bind_param("ii", $teacher_id, $course_id);
            if ($stmt->execute()) {
                $_SESSION['message'] = "Course successfully deleted!";
                header("Location: ../pages/teacher-home.php");
                exit();
            } else {
                $_SESSION['error'] = "Error deleting course.";
            }
            $stmt->close();
        } else {
            $_SESSION['error'] = "Failed to prepare the query.";
        }
    } else {
        $_SESSION['error'] = "Invalid student or course ID.";
    }
    header("Location: ../pages/teacher-home.php");
    exit();
} else {
    header("Location: ../pages/teacher-home.php");
    exit();
}