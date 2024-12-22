<?php
include('../includes/auth.php');
require_role('3');
include('../includes/database.php');



function getPrimaryKeys($connection, $table) {
    $keys = [];
    $result = $connection->query("SHOW KEYS FROM $table WHERE Key_name = 'PRIMARY'");
    while ($row = $result->fetch_assoc()) {
        $keys[] = $row['Column_name'];
    }
    return $keys;
}

if (!isset($_REQUEST['action'], $_REQUEST['table'])) {
    die("Invalid request.");
}

$table = $_REQUEST['table'];
$action = $_REQUEST['action'];
$primary_keys = getPrimaryKeys($connection, $table);

if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $columns = array_keys($_POST['data']);
    $values = array_map([$connection, 'real_escape_string'], array_values($_POST['data']));
    $query = "INSERT INTO $table (" . implode(',', $columns) . ") VALUES ('" . implode("','", $values) . "')";
    if ($connection->query($query)) {
        header("Location: ../pages/admin.php?table=$table");
        exit;
    } else {
        echo "Error: " . $connection->error;
    }
} elseif ($action === 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $where_conditions = [];
    foreach ($primary_keys as $key) {
        $where_conditions[] = "$key = '" . $connection->real_escape_string($_GET[$key]) . "'";
    }
    $where_clause = implode(' AND ', $where_conditions);

    $updates = [];
    foreach ($_POST['data'] as $column => $value) {
        $updates[] = "$column='" . $connection->real_escape_string($value) . "'";
    }
    $query = "UPDATE $table SET " . implode(',', $updates) . " WHERE $where_clause";
    if ($connection->query($query)) {
        header("Location: ../pages/admin.php?table=$table");
        exit;
    } else {
        echo "Error: " . $connection->error;
    }
} elseif ($action === 'delete') {
    if (isset($_GET['id'])) {
        // Single primary key delete
        $id = (int) $_GET['id'];
        $query = "DELETE FROM $table WHERE $primary_key = $id";
    } elseif (isset($_GET['student_id'], $_GET['course_id'])) {
        // Composite key delete for students_courses
        $student_id = (int) $_GET['student_id'];
        $course_id = (int) $_GET['course_id'];
        $query = "DELETE FROM $table WHERE student_id = $student_id AND course_id = $course_id";
    } elseif (isset($_GET['teacher_id'], $_GET['course_id'])) {
        // Composite key delete for teachers_courses
        $teacher_id = (int) $_GET['teacher_id'];
        $course_id = (int) $_GET['course_id'];
        $query = "DELETE FROM $table WHERE teacher_id = $teacher_id AND course_id = $course_id";
    } else {
        die("Invalid delete request.");
    }

    // Execute query
    if ($connection->query($query)) {
        header("Location: ../pages/admin.php?table=$table");
        exit;
    } else {
        echo "Error: " . $connection->error;
    }
} else {
    die("Invalid action.");
}
?>
