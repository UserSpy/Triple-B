<?php

session_start();

    include ("connection.php");
    include ("functions.php");

$username = $_POST['j_username'];
$password = $_POST['j_password'];


if (!empty($username) || !empty($password)){
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "accounts";

    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

    if(mysqli_connect_error()){
        die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } else{
        $SELECT_ID="SELECT * FROM users WHERE Username = ? AND password = ?";

        $stmt = $conn->prepare($SELECT_ID);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $stmt->store_result();
        $rnum= $stmt ->num_rows;


        if($rnum==1){
            $_SESSION['user_id'] = $SELECT_ID;
           echo "Login successful";
        }else{
            echo "No records in database";
        }

        $stmt->close();
        $conn->close();
    }
}else{
    echo "All fields are required";
    die();
}
?>