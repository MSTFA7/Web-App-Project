<?php
include('../includes/auth.php');
require_role('3');
include('../includes/database.php');

function getPrimaryKeys($connection, $table)
{
    $keys = [];
    $result = $connection->query("SHOW KEYS FROM $table WHERE Key_name = 'PRIMARY'");
    while ($row = $result->fetch_assoc()) {
        $keys[] = $row['Column_name'];
    }
    return $keys;
}

// Allowed tables for CRUD operations
$tables = [
    'students_courses',
    'teachers_courses',
    'subjects',
    'levels',
    'boards',
    'semesters'
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../styles/admin.css">
    <script>
        // Handle delete confirmation
        function confirmDelete(table, keyParams) {
            if (confirm("Are you sure you want to delete this record?")) {
                window.location.href = `../includes/admin-handler.php?action=delete&table=${table}&${keyParams}`;
            }
        }
    </script>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body>
    <header>
        <h1>Admin Panel</h1>
        <nav>
            <a href="../includes/logout.php">Logout</a>
        </nav>
    </header>
    <main>
        <h2>Manage Tables</h2>
        <form method="GET">
            <label for="table">Choose a table:</label>
            <select name="table" id="table" onchange="this.form.submit()">
                <option value="" disabled selected>Select a table</option>
                <?php foreach ($tables as $table): ?>
                    <option value="<?php echo $table; ?>" <?php echo isset($_GET['table']) && $_GET['table'] == $table ? 'selected' : ''; ?>>
                        <?php echo ucwords(str_replace('_', ' ', $table)); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

        <?php if (isset($_GET['table']) && in_array($_GET['table'], $tables)): ?>
            <?php
            $table = $_GET['table'];

            // Check the table value and modify the query accordingly
            if ($table == 'students_courses') {
                $query = "
                    SELECT sc.student_id, CONCAT(u.first_name, ' ', u.last_name) AS student_name, c.course_id, sc.enrollment_date 
                    FROM students_courses sc
                    JOIN students s ON sc.student_id = s.student_id
                    JOIN users u ON s.user_id = u.user_id
                    JOIN courses c ON sc.course_id = c.course_id
                ";
                
            } elseif ($table == 'teachers_courses') {
                $query = "
                    SELECT tc.teacher_id, CONCAT(u.first_name, ' ', u.last_name) AS teacher_name, c.course_id, tc.course_creation 
                    FROM teachers_courses tc
                    JOIN teachers t ON tc.teacher_id = t.teacher_id
                    JOIN users u ON t.user_id = u.user_id
                    JOIN courses c ON tc.course_id = c.course_id
                ";
            } else {
                $query = "SELECT * FROM $table";
            }
            $primary_keys = getPrimaryKeys($connection, $table);
            $result = $connection->query($query);
            $columns = $result->fetch_fields();
            ?>
            <h3>Managing <?php echo ucwords(str_replace('_', ' ', $table)); ?></h3>
            <table border="1">
                <thead>
                    <tr>
                        <?php foreach ($columns as $column): ?>
                            <th><?php echo $column->name; ?></th>
                        <?php endforeach; ?>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <?php foreach ($row as $value): ?>
                                <td><?php echo htmlspecialchars($value); ?></td>
                            <?php endforeach; ?>
                            <?php
                            $key_params = [];
                            foreach ($primary_keys as $key) {
                                $key_params[] = "{$key}=" . urlencode($row[$key]);
                            }
                            $key_query_string = implode('&', $key_params);
                            ?>
                            <td class="actions">
                                    <?php if ($table !== 'students_courses' && $table !== 'teachers_courses'): ?>
                                        <a class="edit" href="?action=edit&table=<?php echo $table; ?>&<?php echo $key_query_string; ?>">Edit</a>
                                    <?php endif; ?>


                                    <a class="delete" href="#"
                                        onclick="confirmDelete('<?php echo $table; ?>', '<?php echo $key_query_string; ?>')">Delete</a>
                            </td>

                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <?php if (isset($_GET['action']) && $_GET['action'] === 'edit'): ?>
                <?php
                $where_conditions = [];
                foreach ($primary_keys as $key) {
                    $where_conditions[] = "$key = '" . $connection->real_escape_string($_GET[$key]) . "'";
                }
                $where_clause = implode(' AND ', $where_conditions);
                $edit_query = "SELECT * FROM $table WHERE $where_clause";
                $edit_result = $connection->query($edit_query);
                $edit_data = $edit_result->fetch_assoc();
                ?>
                <h3>Edit Record</h3>
                <form method="POST"
                    action="../includes/admin-handler.php?action=edit&table=<?php echo $table; ?>&<?php echo $key_query_string; ?>">
                    <?php foreach ($columns as $column): ?>
                        <label
                            for="<?php echo $column->name; ?>"><?php echo ucwords(str_replace('_', ' ', $column->name)); ?>:</label>
                        <input type="text" name="data[<?php echo $column->name; ?>]" id="<?php echo $column->name; ?>"
                            value="<?php echo htmlspecialchars($edit_data[$column->name]); ?>" <?php echo in_array($column->name, $primary_keys) ? 'readonly' : ''; ?>>
                    <?php endforeach; ?>
                    <button type="submit">Save Changes</button>
                </form>
            <?php endif; ?>

            <h3>Add New Entry</h3>
            <form method="POST" action="../includes/admin-handler.php">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="table" value="<?php echo $table; ?>">
                <?php foreach ($columns as $column): ?>
                    <label
                        for="<?php echo $column->name; ?>"><?php echo ucwords(str_replace('_', ' ', $column->name)); ?>:</label>
                    <input type="text" name="data[<?php echo $column->name; ?>]" id="<?php echo $column->name; ?>" required>
                <?php endforeach; ?>
                <button type="submit">Add</button>
            </form>
        <?php endif; ?>
    </main>
</body>

</html>