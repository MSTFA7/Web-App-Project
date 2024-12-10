<?php 
    include("database.php");

    // Query to fetch all rows from a table named 'users'
    // $query = "SELECT * FROM usrs";
    // $result = mysqli_query($connection, $query);
    $flag = true;
    try {
        $query = "SELECT * FROM users";
        $result = mysqli_query($connection, $query);
    }
    catch(mysqli_sql_exception) {
        echo "<br>Query Failed.";
        $flag = false;
    }

    // Check if the query was successful
    // if (!$result) {
    //     die("Query Failed: " . mysqli_error($connection));
    // }
?>
    
<!DOCTYPE html>
<html lang="en">
        
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Display Table</title>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
            }
            table, th, td {
                border: 1px solid black;
            }
            th, td {
                padding: 8px;
                text-align: left;
            }
        </style>
    </head>
       
    <body>
        <h1>User Table</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Email</th>
                    <th>Usertype</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Loop through the result set and display each row in the table
                if($flag == true) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        foreach ($row as $value) {
                            echo "<td>{$value}</td>";
                        }
                        echo "</tr>";
                    }
                }elseif ($flag == false) {
                    echo "";
                }
                ?>
            </tbody>
        </table>


        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
            
            <input type="email" placeholder="email" name="email" require> <br>
            <input type="text" placeholder="username" name="username" require> <br>
            <input type="password" placeholder="password" name="password" require> <br>
            <select name="usertype" require>
                <option disabled selected value="">-Select Value-</option>
                <option value="S">Student</option>
                <option value="I">Instructor</option>
            </select>
            <input type="submit" value="register">
        </form>

        <?php
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
                $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
                $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
                $usertype = filter_input(INPUT_POST, "usertype", FILTER_SANITIZE_SPECIAL_CHARS);
                $hash = password_hash($password, PASSWORD_DEFAULT);
                
                $sql = "INSERT INTO users (`username`, `password`, `email`, `usertype`) VALUES('$username', '$hash', '$email', '$usertype')";

                try {
                    mysqli_query($connection, $sql);
                    echo "Successful";
                }
                catch(mysqli_sql_exception) {
                    echo "";
                }

                
                
                
            }

        ?>
    </body>

</html>
