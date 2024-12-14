<?php
session_start();
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];

    if ($student_id && $course_id) {
        // var_dump($student_id, $course_id);
        // exit();
        $query = "DELETE FROM students_courses WHERE student_id = ? AND course_id = ?";

        if ($stmt = $connection->prepare($query)) {
            $stmt->bind_param("ii", $student_id, $course_id);
            if ($stmt->execute()) {
                $_SESSION['message'] = "Course successfully deleted!";
                header("Location: ../pages/student-home.php");
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
    header("Location: ../pages/student-home.php");
    exit();
} else {
    header("Location: ../pages/student-home.php");
    exit();
}