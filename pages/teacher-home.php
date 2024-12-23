<!DOCTYPE html>
<html lang="en">
<?php
include("../includes/auth.php");
require_role(2); // Ensure only teachers can access
include("../includes/getinfo.php"); // For fetching `$first_name`
include("../includes/database.php"); // Database connection


?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,700,0,200" />
    <link rel="stylesheet" href="../assets/css/teacher-home.css">
    <script src="../assets/js/status"></script>
</head>

<body>
    <div class="container">
        <div class="navbar">
            <div>TEACHER DASHBOARD</div>
        </div>
        <div class="sidebar">
            <div class="name">
                <h1>Hello,</h1>
                <h1><?php echo $first_name; ?></h1>
            </div>
            <div class="linebreak"></div>
            <div>
                <ul>
                    <li><a href="#" onclick="showTab('active-courses')"><span
                                class="material-symbols-outlined">check</span>Active Courses</a></li>
                    <li><a href="#" onclick="showTab('start-course')"><span
                                class="material-symbols-outlined">start</span>Start Course</a></li>
                    <li><a href="contact.php"><span class="material-symbols-outlined">help</span>Help</a></li>
                    <li><a href="../includes/logout.php" class="logout"> <span
                                class="material-symbols-outlined">logout</span>LOGOUT</a></li>
                </ul>
            </div>
        </div>
        <div class="cont">
            <!-- Tabs Content -->
            <div id="active-courses" class="tab-content" style="display: block;">
                <h2 class="course-title">Active Courses</h2>
                <div class="courses-container">
                    <div class="active-courses">

                        <?php
                        // SQL query with aliases for the column names
                        $query = "
                            SELECT 
                            courses.course_id, 
                            subjects.name AS subject_name, 
                            levels.grade AS level_name, 
                            boards.name AS board_name, 
                            semesters.name AS semester_name
                            FROM teachers_courses
                            JOIN courses ON teachers_courses.course_id = courses.course_id
                            JOIN subjects ON courses.subject_id = subjects.subject_id
                            JOIN levels ON courses.level_id = levels.level_id
                            JOIN boards ON courses.board_id = boards.board_id
                            JOIN semesters ON courses.semester_id = semesters.semester_id
                            WHERE teachers_courses.teacher_id = ?;
                        ";

                        // Prepare the SQL statement
                        $stmt = mysqli_prepare($connection, $query);
                        if ($stmt === false) {
                            die("Error preparing the SQL statement: " . mysqli_error($connection));
                        }

                        // Bind the teacher_id parameter to the query
                        mysqli_stmt_bind_param($stmt, "i", $teacher_id);

                        // Execute the query
                        if (mysqli_stmt_execute($stmt) === false) {
                            die("Error executing the SQL query: " . mysqli_error($connection));
                        }

                        // Get the result set from the prepared statement
                        $result = mysqli_stmt_get_result($stmt);
                        if ($result === false) {
                            die("Error retrieving the result set: " . mysqli_error($connection));
                        }

                        // Check if any courses were found
                        if (mysqli_num_rows($result) > 0) {
                            // Loop through each active course
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "
                                <div class='course-card'>
                                    <h3 style='cursor: pointer;' onclick='viewStudents({$row['course_id']})'>Subject: {$row['subject_name']}</h3>
                                    <p class='details' style='cursor: pointer;' onclick='viewStudents({$row['course_id']})'>Level: Grade {$row['level_name']}</p>
                                    <p class='details' style='cursor: pointer;' onclick='viewStudents({$row['course_id']})'>Board: {$row['board_name']}</p>
                                    <p class='details' style='cursor: pointer;' onclick='viewStudents({$row['course_id']})'>Semester: {$row['semester_name']}</p>
                                    <p class='details' style='cursor: pointer;' onclick='viewStudents({$row['course_id']})'>Course ID: {$row['course_id']}</p>
                                    <form action='../includes/teacher-course-delete.php' method='POST'>
                                        <input type='hidden' name='course_id' value='{$row['course_id']}'>
                                        <input type='hidden' name='teacher_id' value='$teacher_id'>
                                        <button type='submit' class='delete-button'>Delete</button>
                                    </form>
                                </div>
                                ";


                            }
                        } else {
                            echo "<p class='no-courses'>No active courses found.</p>";
                        }

                        ?>


                    </div>
                    <?php if (isset($_SESSION['exists'])): ?>
                        <div class="exists" id="exists">
                            <?= htmlspecialchars($_SESSION['exists']); ?>
                            <?php unset($_SESSION['exists']); ?>
                        </div>
                    <?php endif; ?>
                    <div id="students-container">
                        <!-- Students will load here dynamically -->
                    </div>

                </div>
            </div>


            <div id="start-course" class="tab-content" style="display: none;">
                <h2 class="course-title">Start a Course</h2>
                <form action="../includes/start-course-handler.php" method="POST">
                    <div class="grid">

                        <div class="dropdown-box">
                            <label for="subject_id">Subject:</label>
                            <select id="subject_id" name="subject_id" required>
                                <option value="" disabled selected>Select Subject</option>
                                <?php
                                // Fetch subjects from the database
                                $query = "SELECT subject_id, name FROM subjects";
                                $result = mysqli_query($connection, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='{$row['subject_id']}'>{$row['name']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="dropdown-box">
                            <label for="level_id">Level:</label>
                            <select id="level_id" name="level_id" required>
                                <option value="" disabled selected>Select Level</option>
                                <?php
                                // Fetch levels (grades) from the database
                                $query = "SELECT level_id, grade FROM levels ORDER BY grade ASC";
                                $result = mysqli_query($connection, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='{$row['level_id']}'>Grade {$row['grade']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="dropdown-box">
                            <label for="board_id">Board:</label>
                            <select id="board_id" name="board_id" required>
                                <option value="" disabled selected>Select Board</option>
                                <?php
                                // Fetch boards from the database
                                $query = "SELECT board_id, name FROM boards";
                                $result = mysqli_query($connection, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='{$row['board_id']}'>{$row['name']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="dropdown-box">
                            <label for="semester_id">Semester:</label>
                            <select id="semester_id" name="semester_id" required>
                                <option value="" disabled selected>Select Semester</option>
                                <?php
                                // Fetch semesters from the database
                                $query = "SELECT semester_id, name FROM semesters";
                                $result = mysqli_query($connection, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='{$row['semester_id']}'>{$row['name']}</option>";
                                }
                                ?>
                            </select>
                        </div>




                    </div>
                    <button type="submit">Start Course</button>
                </form>

            </div>
        </div>
    </div>
    </div>

    <div id="studentsModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <div id="modal-body">
                <!-- Students data will be loaded here -->
            </div>
        </div>
    </div>
    <script>
        setTimeout(function () {
            document.querySelector('.exists').classList.add('hidden'); // Target by class
        }, 3000);


        function showTab(tabId) {
            const tabs = document.querySelectorAll(".tab-content");
            tabs.forEach(tab => {
                tab.style.display = tab.id === tabId ? "block" : "none";
            });
        }


        function viewStudents(courseId) {
            console.log("Course ID: ", courseId); // Debugging: Check the course ID being passed.

            // Open the modal
            const modal = document.getElementById("studentsModal");
            modal.style.display = "block";

            // Clear previous content
            document.getElementById("modal-body").innerHTML = "<p>Loading...</p>";

            // Create a new XMLHttpRequest
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "../includes/fetch-students.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onload = function () {
                if (xhr.status === 200) {
                    console.log("Response: ", xhr.responseText); // Debugging: Log server response.
                    document.getElementById("modal-body").innerHTML = xhr.responseText;
                } else {
                    document.getElementById("modal-body").innerHTML = "<p>Failed to load students. Status: " + xhr.status + "</p>";
                }
            };

            xhr.onerror = function () {
                document.getElementById("modal-body").innerHTML = "<p>An error occurred. Please try again.</p>";
            };

            // Send the course ID as POST data
            xhr.send("course_id=" + encodeURIComponent(courseId));
        }

        // Function to close the modal
        function closeModal() {
            const modal = document.getElementById("studentsModal");
            modal.style.display = "none";
        }
    </script>
</body>

</html>