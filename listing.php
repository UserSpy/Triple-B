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
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Tripple B Listing</title>
    <link rel="stylesheet" href="listing.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="nav-styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">


  </head>
  <body>
    <nav>
      <div class ="container">
        <a href="index.php" class="nav-left"><h1>Buy Borrow Books</h1></a>
          <ul class="nav-right">
            <li class="item"><a href="browse.php"  ><ion-icon name="search-outline"></ion-icon></a></li>
            <li  class="item"><a href="profile.php" ><ion-icon name="person-outline"></ion-icon></ion-icon></a></li>
            <!-- Sign Out / Log In Logic -->
            <?php 
              $sqlLoggedIn = "SELECT * FROM users";
              $sqlLogInQuery = mysqli_query($conn, $sqlLoggedIn);

              $LoggedIn = false;

              while($logResult = mysqli_fetch_array($sqlLogInQuery)){
                if ($logResult['Active']) {
                  $LoggedIn = true;
                  break;
                }
              }
              if($LoggedIn){
                echo '<li><a href="login.html" class="action">Sign In/Out</a></li>';
                // $latestListing['Active'] = false;
                $updateActivity = "UPDATE users SET Active=false WHERE Active=true";
                if(mysqli_query($conn, $updateActivity)) {
                } else {  
                }
              } else {
                echo '<li><a href="login.html" class="action">Sign In/Out</a></li>';
              }
            ?>
          </ul>
        
      </div>
    </nav>


  <div class="listing-rectanglecol">
      <h2><?php echo $listing['SellerName'] ?></h2>
      <div class="detailsrow">
        <div class="priceinfocol">
          <h3>$<?php echo $listing['Price'] ?></h3>
          <h4>Condition: <?php echo $listing['BookCondition'] ?></h4>
          <p><?php echo $listing['Description'] ?></p>
        </div>
        <a href="./payment/payment.html"><button type="buttonbuy">BUY</button></a>
        <div class="picturerow">
          <div class="productpicturecol">
          </div>
          <?php
                $urlLink1 = "./uploads/{$listing['Image1']}";
                $urlLink2 = "./uploads/{$listing['Image2']}";
                $urlLink3 = "./uploads/{$listing['Image3']}";
                $urlLink4 = "./uploads/{$listing['Image4']}";
                $urlLink5 = "./uploads/{$listing['Image5']}";
                if ($listing['Image5'] != '') {
                    echo "<img src='$urlLink5' alt='Image 2' width='50'
                    height='50'>";
                }
                if ($listing['Image2'] != '') {
                    echo "<img src='$urlLink2' alt='Image 3' width='50'
                    height='50'>";
                }
                if ($listing['Image3'] != '') {
                    echo "<img src='$urlLink3' alt='Image 4' width='50'
                    height='50'>";
                }
                if ($listing['Image4'] != '') {
                    echo "<img src='$urlLink4' alt='Image 5' width='50'
                    height='50'>";
                }
                echo "<img src='$urlLink1' alt='Image 1' width='200'
                height='200'>";
            ?>
        </div>
        <div class="profilecol">
          <div class="profilerow">
            <h4>Seller:</h4>
            <ion-icon name="person-circle-outline"></ion-icon>
            <h3><?php echo $listing['SellerName'] ?></h3>
        </div>
        <button type="buttoncontact"
        height="40"
        width="60"
        color="#084B8A"
        >Contact</button>
      </div>
  </div>

  <div class="messages">
    <a href="chat2.html">👋</a>
  </div>

  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>