CREATE TABLE `boards` (
  `board_id` int(11) NOT NULL,
  `name` enum('Cambridge','Edexcel','Oxford') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `boards` (`board_id`, `name`) VALUES
(1, 'Cambridge'),
(2, 'Edexcel'),
(3, 'Oxford');

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `level_id` int(11) DEFAULT NULL,
  `board_id` int(11) DEFAULT NULL,
  `semester_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `courses` (`course_id`, `subject_id`, `level_id`, `board_id`, `semester_id`) VALUES
(1, 1, 1, 1, 1),
(2, 2, 2, 2, 2),
(3, 3, 3, 3, 1),
(4, 3, 3, 1, 1),
(5, 1, 1, 2, 1),
(6, 4, 2, 2, 1),
(7, 3, 2, 2, 1),
(8, 2, 3, 2, 1),
(9, 4, 2, 1, 2),
(10, 7, 1, 1, 1),
(11, 6, 2, 1, 1),
(12, 2, 1, 1, 2),
(13, 10, 3, 1, 2),
(14, 4, 3, 3, 1),
(15, 2, 1, 1, 1),
(16, 3, 1, 1, 1),
(17, 1, 3, 2, 1),
(18, 3, 3, 2, 2),
(19, 2, 3, 1, 1);

CREATE TABLE `levels` (
  `level_id` int(11) NOT NULL,
  `grade` int(11) NOT NULL CHECK (`grade` between 1 and 12)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `levels` (`level_id`, `grade`) VALUES
(1, 1),
(2, 5),
(3, 12);

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` enum('Student','Teacher','Admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'Student'),
(2, 'Teacher'),
(3, 'Admin');

CREATE TABLE `semesters` (
  `semester_id` int(11) NOT NULL,
  `name` enum('June','November') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `semesters` (`semester_id`, `name`) VALUES
(1, 'June'),
(2, 'November');

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- INSERT INTO `students` (`student_id`, `user_id`) VALUES
-- (1, 4),
-- (2, 6);

CREATE TABLE `students_courses` (
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `enrollment_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- INSERT INTO `students_courses` (`student_id`, `course_id`, `enrollment_date`) VALUES
-- (1, 3, '2024-12-13 19:32:27'),
-- (1, 8, '2024-12-13 19:35:42'),
-- (1, 10, '2024-12-13 19:32:35'),
-- (1, 11, '2024-12-13 19:34:51'),
-- (2, 8, '2024-12-13 18:00:00'),
-- (2, 16, '2024-12-15 15:19:09'),
-- (2, 19, '2024-12-15 15:15:24');

CREATE TABLE `subjects` (
  `subject_id` int(11) NOT NULL,
  `name` enum('English','Maths','Chemistry','Physics','Biology','Economics','ICT','Arabic','Computer Science','Art') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `subjects` (`subject_id`, `name`) VALUES
(1, 'English'),
(2, 'Maths'),
(3, 'Chemistry'),
(4, 'Physics'),
(5, 'Biology'),
(6, 'Economics'),
(7, 'ICT'),
(8, 'Arabic'),
(9, 'Computer Science'),
(10, 'Art');

CREATE TABLE `teachers` (
  `teacher_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- INSERT INTO `teachers` (`teacher_id`, `user_id`) VALUES
-- (1, 7),
-- (2, 8);

CREATE TABLE `teachers_courses` (
  `teacher_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `course_creation` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- INSERT INTO `teachers_courses` (`teacher_id`, `course_id`, `course_creation`) VALUES
-- (1, 19, '2024-12-15 15:14:38'),
-- (2, 16, '2024-12-15 15:18:58');

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `username`, `password`, `email`, `role_id`, `created_at`) VALUES
-- (4, 'Mustafa', 'Othman', 'MSTFA', '$2y$10$mC.c8A63tRoWtqZyP9h/wesqNbL/VqTVaRhMwwAvFt4Cew9kuBPmy', 'mustafaothman7@gmail.com', 1, '2024-12-13 12:18:53'),
-- (6, 'Youssef', 'Wael', 'joe', '$2y$10$dYGCOiOws2MWsLhep9FNm.9BZaoVViPyGUNsmxYowLGZncRuB35Bu', 'yousef@email.com', 1, '2024-12-13 12:26:09'),
-- (7, 'mustafa', 'othman', 'teacher', '$2y$10$efbW3M4K2UdzO7s64s2cueoJ6NYbok2bhA/YRYlQRYg659Q7nt8YW', 'teacher@email.com', 2, '2024-12-13 13:18:07'),
-- (8, 'Wagd', 'Hossam', 'wagd', '$2y$10$Bwoq4s0C9liz908YHyzA9.XA6DHX05R8x/OjbDcgvHL0Cyj/m3s.q', 'wagd@email.com', 2, '2024-12-15 15:18:29');


ALTER TABLE `boards`
  ADD PRIMARY KEY (`board_id`);

ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `level_id` (`level_id`),
  ADD KEY `board_id` (`board_id`),
  ADD KEY `semester_id` (`semester_id`);

ALTER TABLE `levels`
  ADD PRIMARY KEY (`level_id`);

ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

ALTER TABLE `semesters`
  ADD PRIMARY KEY (`semester_id`);

ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `students_courses`
  ADD UNIQUE KEY `unique_enrollment` (`student_id`,`course_id`),
  ADD KEY `course_id` (`course_id`);

ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`);

ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `teachers_courses`
  ADD KEY `course_id` (`course_id`),
  ADD KEY `teacher_id` (`teacher_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `role_id` (`role_id`);


ALTER TABLE `boards`
  MODIFY `board_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

ALTER TABLE `levels`
  MODIFY `level_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `semesters`
  MODIFY `semester_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `teachers`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;


ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`),
  ADD CONSTRAINT `courses_ibfk_3` FOREIGN KEY (`level_id`) REFERENCES `levels` (`level_id`),
  ADD CONSTRAINT `courses_ibfk_4` FOREIGN KEY (`board_id`) REFERENCES `boards` (`board_id`),
  ADD CONSTRAINT `courses_ibfk_5` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`semester_id`);

ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

ALTER TABLE `students_courses`
  ADD CONSTRAINT `students_courses_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`),
  ADD CONSTRAINT `students_courses_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

ALTER TABLE `teachers_courses`
  ADD CONSTRAINT `teachers_courses_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`),
  ADD CONSTRAINT `teachers_courses_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`);

ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);
