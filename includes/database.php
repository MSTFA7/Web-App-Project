<?php
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "learningdb";
    $connection = "";


    try {
        $connection = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

    }
    catch(mysqli_sql_exception) {
    }

    if($connection) {
    }

    if ($connection->connect_error) {
        $db_status = "not_connected"; // Connection failed
    } else {
        $db_status = "connected"; // Connection successful
    }

    echo "<script>
    const dbStatus = '$db_status';
    </script>";
?>