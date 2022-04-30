<?php

session_start();
error_reporting(E_ALL); ini_set('display_errors', 1);

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
        die('Connect Error('. mysqli_connect_error().')'. mysqli_connect_error());
    } else{
        $SELECT_ID="SELECT * FROM Users WHERE Username = ? AND Password = ?";

        $stmt = $conn->prepare($SELECT_ID);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $stmt->store_result();
        $rnum= $stmt ->num_rows;

        $sqlInfo = "SELECT * FROM Users WHERE Username = '$username'";
        $loggedUser = mysqli_query($conn, $sqlInfo);
        $latestListing = mysqli_fetch_assoc($loggedUser);

        if($rnum==1){
            $_SESSION['user_id'] = $SELECT_ID;
            $_SESSION['loggedIn'] = true;
            $_SESSION['username'] = $username;
            
            $updateActivity = "UPDATE users SET Active=true WHERE Username='$username'";
            if(mysqli_query($conn, $updateActivity)) {
                // sleep(3);
                echo "Login successful: ".$username;
                
                header("Location: ./profile.php");
            } else {
                echo "Login NOT successful: ".$username;
            }
            
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
