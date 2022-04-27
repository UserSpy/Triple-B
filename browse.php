<?php
$host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "accounts";

   if(!$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname)){
       die("Failed to connect");
   }
?>

<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">

    <link rel="stylesheet" href="styles.css">
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <link rel="stylesheet" href="nav-styles.css">
    <style>
      * {box-sizing:border-box;}
    .column{
      float: left;
      width: 25%;
      padding: 0 10px;
    }

    .row {
      margin: 0 -5px;
    }

    .row:after{
      content: "";
      display: table;
      clear: both;
    }

    @media screen and (max-width:600px){
      .column{
        width:100%;
        display:block;
        margin-bottom:20px;
      }
    }

    .card{
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
      padding: 16px;
      text-align:center;
    }
  </style>
  <title>Browsing</title>
  <!-- <link rel="stylesheet" href="styles.css"> -->
  </head>

  <body>

    <h1>Categories</h1>
    <!-- We'll first be needing to add items to the nav bar (So what we plan on doing this first sprint meeting) -->
    <nav>
        <div class ="container">
          <a href="index.html" class="init">
            <h1>Logo</h1>
            <ul class="nav-right">
              <li><a href="browse.html"  class="underline">Browse</a></li>
              <li><a href="listing.html"  class="underline">Listings</a></li>
              <li><a href="profile.php"  class="underline">Profile</a></li>
              <li><a href="login.html" class="action">Log In</a></li>
            </ul>
          </a>
        </div>
      </nav>

      <!--Search Bar-->
     <form action = "search.php" method = "POST">
      <input type ="text" name="search" placeholder="Search...">
      <button type = "submit" name = "submit-search">Search</button>
    </form>
    

    <div class="row"> <!-- Just tempory, to fill up the website -->
      <div class = "column">
      <div class ="card">
        <div class ="card-headings">
            <!-- redirects to home page for now -->
            <a href="index.html">
             <h2>Hot Deals</h2>
         </div>
        </a>
      <p>
        The best discounts on the web!
     </p>
     </div>
    </div>

    <div class="row"> <!-- Just tempory, to fill up the website -->
      <div class = "column">
      <div class ="card">
        <div class ="card-headings">
            <!-- redirects to home page for now -->
            <a href="index.html">
             <h2>Subject</h2>
         </div>
        </a>
      <p>
        Browse through math/history/science/etc.
     </p>
     </div>
    </div>


    <div class="row"> <!-- Just tempory, to fill up the website -->
      <div class = "column">
      <div class ="card">
        <div class ="card-headings">
            <!-- redirects to home page for now -->
            <a href="index.html">
             <h2>Course Number</h2>
         </div>
        </a>
      <p>
        Enter your course number to find matching textbooks and items.
     </p>
     </div>
    </div>

    <div class="row"> <!-- Just tempory, to fill up the website -->
      <div class = "column">
      <div class ="card">
        <div class ="card-headings">
            <!-- redirects to home page for now -->
            <a href="index.html">
             <h2>Lowest Prices</h2>
         </div>
        </a>
      <p>
        Sorts through the lowest prices.
     </p>
     </div>
    </div>
    <!--Can add more categories here-->

    </div>

    <footer>

    </footer>
  </body>
  <body>
  <h1>Listings</h1>
  <?php 
    
    $sql = "SELECT * FROM listings";
    $result = mysqli_query($conn, $sql);
    $queryResults = mysqli_num_rows($result);

    if ($queryResults > 0){
        while ($row = mysqli_fetch_assoc($result)){
            echo "<div class = 'article-box'>
            <h3>".$row['TextbookTitle']."</h3>
            <p>".$row['ISBN']."</p>
            <p>".$row['Price']."</p>
            <p>".$row['BookCondition']."</p>
            <p>".$row['Description']."</p>
            </div>";
        }
    }
?>
</body>
</html>
