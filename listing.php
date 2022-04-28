<?php
    session_start();

    $conn = new mysqli("localhost", "root", "", "accounts");
    $yoinked = $_GET['tupleID'];


    if(mysqli_connect_error()){
        die('Connect Error('. mysqli_connect_error().')'. mysqli_connect_error());
    }else {
        // change sql statement to include where???

        
        $sql = "SELECT * FROM listings WHERE ID=$yoinked";
        $sqlData = mysqli_query($conn, $sql);
        $listing = mysqli_fetch_assoc($sqlData);
   
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1><?php echo $listing['SellerName'] ?></h1>
    <?php
        $urlLink = "./uploads/{$listing['Image1']}";
        echo "<img src='$urlLink' alt='Image 1'>"
    ?>
   
</body>
</html>