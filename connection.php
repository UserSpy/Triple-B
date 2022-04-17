<?php 
$host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "db1";

   if(!$con = new mysqli($host, $dbUsername, $dbPassword, $dbname)){
       die("Failed to connect");
   }
?>