<!DOCTYPE html>
<html lang="en">
    <?php
        include("../includes/auth.php");
        require_role(1);
        include("../includes/getinfo.php");
        include("../includes/database.php");
    ?>
    
    <script src="../assets/js/status.js"></script>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/student-home.css">
</head>
<body>
    <div class="container">
        <div class="navbar"></div>
        <div class="sidebar">
            <div class="name"> 
                <h2>Student</h2>
                <h1>Hello,</h1>
                <h1><?php echo $first_name; ?></h1>
            </div>
            <div class="linebreak"></div>
            <div>
                <ul>
                    <li><a href="">Courses</a></li>
                    <li><a href="">Enroll</a></li>
                    <li><a href="">Help</a></li>
                    <li><a href="../includes/logout.php" class="logout">LOGOUT</a></li>
                </ul>
            </div>
        </div>
        <div class="cont"></div>
    </div>








    <div class="status" id="status"></div>
</body>
</html>