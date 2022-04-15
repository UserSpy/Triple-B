<?php

$username = $_POST['j_username'];
$password = $_POST['j_password'];


if (!empty($username) || !empty($password)){
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "db1";

    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

    if(mysqli_connect_error()){
        die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } else{
        $SELECT="SELECT * FROM users WHERE Username = ? AND password = ?";

        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $stmt->store_result();
        $rnum= $stmt ->num_rows;

        if($rnum==1){
           echo "Login successful";
        }else{
            echo "No records in database";
            echo $username;
            echo $password;
        }

        $stmt->close();
        $conn->close();
    }
}else{
    echo "All fields are required";
    die();
}
?>