<!DOCTYPE html>
<html lang="en">
<?php
include("../includes/auth.php");
require_role(1);
include("../includes/getinfo.php");
include("../includes/database.php");

$query = "
    SELECT DISTINCT courses.course_id, levels.grade AS level_name, boards.name AS board_name, semesters.name AS semester_name, subjects.name AS subject_name, CONCAT(users.first_name, ' ', users.last_name) AS teacher_name, teachers.teacher_id FROM teachers_courses JOIN courses ON teachers_courses.course_id = courses.course_id JOIN subjects ON courses.subject_id = subjects.subject_id JOIN levels ON courses.level_id = levels.level_id JOIN boards ON courses.board_id = boards.board_id JOIN semesters ON courses.semester_id = semesters.semester_id JOIN teachers ON teachers_courses.teacher_id = teachers.teacher_id JOIN users ON teachers.user_id = users.user_id;
";
$result = $connection->query($query);
?>
<link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,700,0,200" />
<script src="../assets/js/status.js"></script>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/student-home.css">
</head>

<body>
    <div class="container">
        <div class="navbar">
            <div>STUDENT DASHBOARD</div>
        </div>
        <div class="sidebar">
            <div class="name">
                <h1>Hello,</h1>
                <h1><?php echo htmlspecialchars($first_name); ?></h1>
            </div>
            <div class="linebreak"></div>
            <div>
                <ul>
                    <li><a href="#" onclick="showTab('courses')"><span class="material-symbols-outlined">check</span>My
                            Courses</a></li>
                    <li><a href="#" onclick="showTab('enroll')"><span
                    class="material-symbols-outlined">add_circle</span>Enroll</a></li>
                    <li><a href="#" onclick="showTab('help')"><span class="material-symbols-outlined">help</span>Help</a></li>
                    <li><a href="../includes/logout.php" class="logout"><span
                    class="material-symbols-outlined">logout</span>LOGOUT</a></li>
                </ul>
            </div>
        </div>
        <div class="status" id="status"></div>
        <div class="cont">
            <!-- My Courses Tab -->
            <div id="courses" class="tab-content" style="display: block;">
                <h2>My Courses</h2>
                <div class="courses-container">
                    <?php
                    // Query to fetch enrolled courses
                    $query = "
                        SELECT
                            c.course_id,
                            s.name AS subject_name,
                            l.grade AS level_name,
                            b.name AS board_name,
                            se.name AS semester_name,
                            CONCAT(u.first_name, ' ', u.last_name) AS teacher_name
                        FROM students_courses sc
                        INNER JOIN courses c ON sc.course_id = c.course_id
                        INNER JOIN subjects s ON c.subject_id = s.subject_id
                        INNER JOIN levels l ON c.level_id = l.level_id
                        INNER JOIN boards b ON c.board_id = b.board_id
                        INNER JOIN semesters se ON c.semester_id = se.semester_id
                        INNER JOIN teachers_courses tc ON c.course_id = tc.course_id
                        INNER JOIN teachers t ON tc.teacher_id = t.teacher_id
                        INNER JOIN users u ON t.user_id = u.user_id
                        WHERE sc.student_id = ?
                    ";

                    if ($stmt = $connection->prepare($query)) {
                        $stmt->bind_param("i", $student_id);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <div class="course-card">
                                    <h3> <span class="black-highlight"> <?= htmlspecialchars($row['subject_name']); ?> </span< /h3>
                                            <p><strong>Level:</strong> <?= htmlspecialchars($row['level_name']); ?></p>
                                            <p><strong>Board:</strong> <?= htmlspecialchars($row['board_name']); ?></p>
                                            <p><strong>Semester:</strong> <?= htmlspecialchars($row['semester_name']); ?></p>
                                            <p class="teacher-name"><strong>Teacher:</strong>
                                                <?= htmlspecialchars($row['teacher_name']); ?>
                                            </p>
                                            <form action="../includes/student-course-delete.php" method="POST">
                                                <input type="hidden" name="course_id" value="<?= $row['course_id']; ?>">
                                                <input type="hidden" name="student_id" value="<?= $student_id; ?>">
                                                <button type="submit" class="delete-button">Leave</button>
                                            </form>
                                </div>
                                <?php
                            }
                        } else {
                            echo "<p>No courses enrolled yet.</p>";
                        }

                        $stmt->close();
                    } else {
                        echo "<p>Error fetching courses.</p>";
                    }
                    ?>

                    <?php if (isset($_SESSION['message'])): ?>
                        <div class="success-message">
                            <?= htmlspecialchars($_SESSION['message']); ?>
                            <?php unset($_SESSION['message']); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="error-message">
                            <?= htmlspecialchars($_SESSION['error']); ?>
                            <?php unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

            <!-- Enroll Tab -->
            <div id="enroll" class="tab-content" style="display: none;">
                <h2>Enroll</h2>
                <div class="courses-container">
                    <?php
                    // Query to fetch all available courses (not already enrolled)
                    $query = "
                        SELECT 
                            c.course_id,
                            s.name AS subject_name,
                            l.grade AS level_name,
                            b.name AS board_name,
                            se.name AS semester_name,
                            CONCAT(u.first_name, ' ', u.last_name) AS teacher_name,
                            t.teacher_id
                        FROM courses c
                        INNER JOIN subjects s ON c.subject_id = s.subject_id
                        INNER JOIN levels l ON c.level_id = l.level_id
                        INNER JOIN boards b ON c.board_id = b.board_id
                        INNER JOIN semesters se ON c.semester_id = se.semester_id
                        INNER JOIN teachers_courses tc ON c.course_id = tc.course_id
                        INNER JOIN teachers t ON tc.teacher_id = t.teacher_id
                        INNER JOIN users u ON t.user_id = u.user_id
                        WHERE c.course_id NOT IN (
                            SELECT course_id FROM students_courses WHERE student_id = ?
                        )
                    ";

                    if ($stmt = $connection->prepare($query)) {
                        $stmt->bind_param("i", $student_id);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <div class="course-card">
                                    <h3><span class="black-highlight"><?= htmlspecialchars($row['subject_name']); ?></span> </h3>
                                    <p><strong>Level:</strong> <?= htmlspecialchars($row['level_name']); ?></p>
                                    <p><strong>Board:</strong> <?= htmlspecialchars($row['board_name']); ?></p>
                                    <p><strong>Semester:</strong> <?= htmlspecialchars($row['semester_name']); ?></p>
                                    <p class="teacher-name"><strong>Teacher:</strong> <?= htmlspecialchars($row['teacher_name']); ?>
                                    </p>
                                    <form action="../includes/enroll.php" method="POST">
                                        <input type="hidden" name="course_id" value="<?= $row['course_id']; ?>">
                                        <input type="hidden" name="teacher_id" value="<?= $row['teacher_id']; ?>">
                                        <input type="hidden" name="student_id" value="<?= $student_id; ?>">
                                        <button type="submit">Enroll</button>
                                    </form>
                                </div>
                                <?php
                            }
                        } else {
                            echo "<p>No courses available for enrollment.</p>";
                        }

                        $stmt->close();
                    } else {
                        echo "<p>Error fetching available courses.</p>";
                    }
                    ?>
                </div>
            </div>

            <!-- Help Tab -->
            <div id="help" class="tab-content" style="display: none;">
                <h2>Help</h2>
                <p>Here you can find help and FAQs.</p>
            </div>
        </div>
    </div>

</body>
<script>
    function showTab(tabId) {
        const tabs = document.querySelectorAll(".tab-content");
        tabs.forEach(tab => {
            tab.style.display = tab.id === tabId ? "block" : "none";
        });
    }
</script>


</html>