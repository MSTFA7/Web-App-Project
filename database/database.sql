-- 1. Create Roles Table (for role management)
CREATE TABLE roles (
    role_id INT AUTO_INCREMENT PRIMARY KEY,
    role_name ENUM('student', 'teacher') NOT NULL  -- Role names as 'student' or 'teacher'
);

-- 2. Create Users Table with role_id reference
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    role_id INT,  -- Foreign key to reference roles
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(role_id)  -- Referencing role_id from roles table
);

-- 3. Create Subjects Table
CREATE TABLE subjects (
    subject_id INT AUTO_INCREMENT PRIMARY KEY,
    name ENUM('english', 'maths', 'chemistry', 'phys', 'bio', 'economics', 'ict', 'arabic', 'computer science', 'art') NOT NULL
);

-- 4. Create Levels Table (Grades 1 to 12)
CREATE TABLE levels (
    level_id INT AUTO_INCREMENT PRIMARY KEY,
    grade INT NOT NULL CHECK (grade BETWEEN 1 AND 12)
);

-- 5. Create Boards Table (Cambridge, Edexcel, Oxford)
CREATE TABLE boards (
    board_id INT AUTO_INCREMENT PRIMARY KEY,
    name ENUM('camb', 'edexcel', 'oxford') NOT NULL
);

-- 6. Create Semesters Table (June and November)
CREATE TABLE semesters (
    semester_id INT AUTO_INCREMENT PRIMARY KEY,
    name ENUM('june', 'november') NOT NULL
);

-- 7. Create Courses Table to Assign Students to Subjects, Grades, etc.
CREATE TABLE courses (
    course_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,  -- Student
    subject_id INT,  -- Subject
    level_id INT,  -- Grade
    board_id INT,  -- Board
    semester_id INT,  -- Semester
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (subject_id) REFERENCES subjects(subject_id),
    FOREIGN KEY (level_id) REFERENCES levels(level_id),
    FOREIGN KEY (board_id) REFERENCES boards(board_id),
    FOREIGN KEY (semester_id) REFERENCES semesters(semester_id)
);

-- 8. Insert Roles (Student and Teacher)
INSERT INTO roles (role_name)
VALUES 
('student'),
('teacher');

-- 9. Insert Subjects
INSERT INTO subjects (name)
VALUES
('english'),
('maths'),
('chemistry'),
('phys'),
('bio'),
('economics'),
('ict'),
('arabic'),
('computer science'),
('art');

-- 10. Insert Levels (Grades 1 to 12)
INSERT INTO levels (grade)
VALUES 
(1), (2), (3), (4), (5), (6), (7), (8), (9), (10), (11), (12);

-- 11. Insert Boards (Cambridge, Edexcel, Oxford)
INSERT INTO boards (name)
VALUES 
('cambridge'),
('edexcel'),
('oxford');

-- 12. Insert Semesters (June and November)
INSERT INTO semesters (name)
VALUES 
('june'),
('november');

-- 13. Insert Teachers with role_id reference (role_id = 2)
INSERT INTO users (username, password, email, role_id)
VALUES 
('Ms.Wagd', 'hashed_password1', 'ms.wagd@example.com', 2),
('Mr.Ahmed', 'hashed_password2', 'mr.ahmed@example.com', 2),
('Ms.Fatma', 'hashed_password3', 'ms.fatma@example.com', 2),
('Mr.Feras', 'hashed_password4', 'mr.feras@example.com', 2);

-- 14. Insert Students with role_id reference (role_id = 1)
INSERT INTO users (username, password, email, role_id)
VALUES 
('Jana', 'hashed_password1', 'jana@example.com', 1),
('Mohamed', 'hashed_password2', 'mohamed@example.com', 1),
('Salah', 'hashed_password3', 'salah@example.com', 1);

-- 15. Randomly Enroll Students in Courses
INSERT INTO courses (user_id, subject_id, level_id, board_id, semester_id)
VALUES 
(1, 1, 10, 1, 1),  -- Jana enrolls in English grade 10, Cambridge, June
(2, 2, 12, 2, 2),  -- Mohamed enrolls in Maths grade 12, Edexcel, November
(3, 3, 9, 3, 1);   -- Salah enrolls in Chemistry grade 9, Oxford, June
SELECT u.user_id, u.username, u.email, r.role_name 
FROM users u
JOIN roles r ON u.role_id = r.role_id;