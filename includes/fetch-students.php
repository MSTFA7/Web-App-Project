<?php
include("database.php"); // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['course_id'])) {
        $course_id = intval($_POST['course_id']);

        // Query to fetch students for the given course ID
        $query = "
            SELECT users.first_name, users.last_name, students.student_id
            FROM students_courses
            JOIN students ON students_courses.student_id = students.student_id
            JOIN users ON students.user_id = users.user_id
            WHERE students_courses.course_id = ?;
        ";

        $stmt = mysqli_prepare($connection, $query);
        if ($stmt === false) {
            die("Error preparing the statement: " . mysqli_error($connection));
        }

        mysqli_stmt_bind_param($stmt, "i", $course_id);

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                echo "<h3>Registered Students</h3>";
                echo "<ul>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<li>{$row['first_name']} {$row['last_name']} (ID: {$row['student_id']})</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No students registered for this course.</p>";
            }
        } else {
            echo "Error executing query: " . mysqli_error($connection);
        }
    } else {
        echo "Course ID is missing.";
    }
} else {
    echo "Invalid request.";
}
?>
