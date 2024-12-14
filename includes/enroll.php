<?php
// enroll.php

// Database connection
include("database.php");
// Get form data
echo '<pre>';
print_r($_POST); // Check the contents of the $_POST array
echo '</pre>';
if (isset($_POST['teacher_id']) && isset($_POST['course_id']) && isset($_POST['student_id'])) {
    $teacher_id = $_POST['teacher_id'];
    $course_id = $_POST['course_id'];
    $student_id = $_POST['student_id'];
    echo "Teacher ID: " . $teacher_id;
    echo "Course ID: " . $course_id;
    echo "Course ID: " . $student_id;
} else {
    echo "Teacher ID is not set!";
}
echo"line 20";
// Step 1: Check if the course exists in teachers_courses
$checkQuery = "SELECT COUNT(*) AS valid FROM teachers_courses WHERE course_id = ?";
$stmt = $connection->prepare($checkQuery);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$stmt->bind_result($isValid);
$stmt->fetch();
$stmt->close();

if ($isValid <= 0) {
    echo "Invalid course selection. Enrollment failed.";
    exit; // Exit if course is not valid
}

// Step 2: Check if the student is already enrolled in the course
$checkEnrollmentQuery = "SELECT COUNT(*) FROM students_courses WHERE student_id = ? AND course_id = ?";
$stmt = $connection->prepare($checkEnrollmentQuery);
$stmt->bind_param("ii", $student_id, $course_id);
$stmt->execute();
$stmt->bind_result($enrollmentCount);
$stmt->fetch();
$stmt->close();

if ($enrollmentCount > 0) {
    echo "You are already enrolled in this course.";
    exit; // Exit if the student is already enrolled
}

// Step 3: Enroll the student if not already enrolled
$insertQuery = "INSERT INTO students_courses (student_id, course_id) VALUES (?, ?)";
$stmt = $connection->prepare($insertQuery);
$stmt->bind_param("ii", $student_id, $course_id);

if ($stmt->execute()) {
    header("Location: ../pages/student-home.php");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();

// Close database connection
$connection->close();
?>