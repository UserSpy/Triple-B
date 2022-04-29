<?php
$host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "accounts";

   if(!$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname)){
       die("Failed to connect");
   }
?>

<h1>Search Page</h1>

<div class = "article-container">
    <?php
    if(isset($_POST['submit-search'])){
        $search = mysqli_real_escape_string($conn, $_POST['search']);
        $sql = "SELECT * FROM listings WHERE TextbookTitle LIKE '%$search%' OR 
        Description LIKE '%$search%' OR ISBN LIKE '%$search%' OR BookCondition LIKE '%$search%' OR Price LIKE '%$search%'";
        $result = mysqli_query($conn, $sql);
        $queryResult = mysqli_num_rows($result);    

        echo "There are ".$queryResult." results!";

        if($queryResult > 0){
            while($row = mysqli_fetch_assoc($result)){
                echo "<div class = 'article-box'>
                <h3>".$row['TextbookTitle']."</h3>
                <p>".$row['ISBN']."</p>
                <p>".$row['Price']."</p>
                <p>".$row['BookCondition']."</p>
                <p>".$row['Description']."</p>
                </div>";
            }
        }else{
            echo "There are no results matching your search!";
        }
    }
    ?>
</div>
