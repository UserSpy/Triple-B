<?php
$host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "accounts";

   if(!$con = new mysqli($host, $dbUsername, $dbPassword, $dbname)){
       die("Failed to connect");
   }
?>
