<?php

  // Database credentials
  $server = "localhost";
  $username = "root";
  $password = "";
  $database = "accounts";

  // Connect to MySQL database
  $conn = mysqli_connect($server, $username, $password, $database);

  // Check connection
  if($conn === false) {
      die("Error: Could not connect to database" . $conn->connect_error);
  }

?>
