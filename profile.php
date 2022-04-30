<?php
  session_start();
  error_reporting(E_ALL); ini_set('display_errors', 1);
  if (!$_SESSION["loggedIn"]) {
    header("Location: login.php");
  }
  require('dbConnect.php');
?>

<!DOCTYPE html>
<html lang="en" dir="ltr" style="background-color:lightblue">
  <head>
    <meta charset="utf-8">
    <title>Triple-B</title>
    <link rel="stylesheet" href="profile-styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="nav-styles.css?v=<?php echo time(); ?>">
  </head>
  <body>
    <nav>
      <div class ="container">
        <a href="index.php" class="nav-left"><h1>Buy Borrow Books</h1></a>
          <ul class="nav-right">
            <li class="item"><a href="browse.php"  ><ion-icon name="search-outline"></ion-icon></a></li>
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
    <br></br>
    <br></br>
    <?php
      $result = mysqli_query($conn, "SELECT FirstName FROM Users WHERE  Username='".$_SESSION['username']."'");

    $row = $result->fetch_assoc();

    echo "<h3> Welcome,  {$row['FirstName']}!</h3>";
    ?>

    <div class="three-cards" style="width:1000px; margin:0 auto;">
      <div class="card">
        <!-- redirects to home page for the time being -->
        <a href="index.html">
          <!-- Licensed under Creative Commons CC-BY Pixabay -->
          <img src="images/order-icon.png" alt="Order Icon" class="icon-image" align="left">
        </a>
        <div class="card-headings">
          <h2>Orders</h2>
        </div>
        <!-- Unordered List displaying all the choices user's have. -->
        <ul style="list-style-type:none">
          <!-- redirects to home page for the time being -->
          <a href="index.html">
            <li>History</li>
          </a>
          <a href="index.html">
            <li>Return</li>
          </a>
          <a href="index.html">
            <li>Shipping</li>
          </a>
        </ul>
      </div>
      <div class="card">
        <!-- redirects to home page for the time being -->
        <a href="index.html">
          <!-- Licensed under Creative Commons CC-BY Pixabay -->
          <img src="images/payment-icon.png" alt="Payment Icon" class="icon-image" align="left">
        </a>
        <div class="card-headings">
          <h2>Payment Details</h2>
        </div>
        <!-- Unordered List displaying all the choices user's have. -->
        <ul style="list-style-type:none">
          <!-- redirects to home page for the time being -->
          <a href="index.html">
            <li>Add Payment</li>
          </a>
          <a href="index.html">
            <li>Delete Payment</li>
          </a>
          <a href="index.html">
            <li>Edit Payment</li>
          </a>
        </ul>
      </div>
      <div class="card">
        <!-- redirects to home page for the time being -->
        <a href="index.html">
          <!-- Licensed under Creative Commons CC-BY Pixabay -->
          <img src="images/messages-icon.png" alt="Messages Icon" class="icon-image" align="left">
        </a>
        <div class="card-headings">
          <h2>Messages</h2>
        </div>
        <!-- Unordered List displaying all the choices user's have. -->
        <ul style="list-style-type:none">
          <!-- redirects to home page for the time being -->
          <a href="index.html">
            <li>History</li>
          </a>
          <a href="index.html">
            <li>Recent</li>
          </a>
        </ul>
      </div>
    </div>

    <div class="three-cards" style="width:1000px; margin:0 auto;">
      <div class="card">
        <!-- redirects to home page for the time being -->
        <a href="index.html">
          <!-- Licensed under Creative Commons CC-BY Pixabay -->
          <img src="images/notification-icon.png" alt="Notifcation Bell Icon" class="icon-image" align="left">
        </a>
        <div class="card-headings">
          <h2>Notification Settings</h2>
        </div>
        <!-- Unordered List displaying all the choices user's have. -->
        <ul style="list-style-type:none">
          <!-- redirects to home page for the time being -->
          <a href="index.html">
            <li>Muted People</li>
          </a>
          <a href="index.html">
            <li>Configuration</li>
          </a>
        </ul>
      </div>
      <div class="card">
        <!-- redirects to home page for the time being -->
        <a href="index.html">
          <!-- Licensed under Creative Commons CC-BY Pixabay -->
          <img src="images/security-icon.png" alt="Security Icon" class="icon-image" align="left">
        </a>
        <div class="card-headings">
          <h2>Account Settings</h2>
        </div>
        <!-- Unordered List displaying all the choices user's have. -->
        <ul style="list-style-type:none">
          <!-- redirects to home page for the time being -->
          <a href="index.html">
            <li>Update Email</li>
          </a>
          <a href="index.html">
            <li>Update Password</li>
          </a>
          <?php
            $result = mysqli_query($conn, "SELECT * FROM Sellers WHERE Username='".$_SESSION['username']."'");;
            if (!mysqli_num_rows($result)) {
              $_SESSION["seller-loggedIn"] = False;
              echo '<a href="seller-register.php">';
              echo '<li>Register as a Seller</li>';
              echo '</a>';
            } else {
              $_SESSION["seller-loggedIn"] = True;
            }
          ?>
        </ul>
      </div>
      <!-- Create listing card -->
      <?php
      if ($_SESSION["seller-loggedIn"]) {
      ?>
      <div class="card">
        <!-- redirects to home page for the time being -->
        <a href="index.html">
          <!-- Licensed under Creative Commons CC-BY Pixabay -->
          <img src="images/create-listing-icon.png" alt="Cardboard Box Icon" class="icon-image" align="left">
        </a>
        <div class="card-headings">
          <h2>Notification Settings</h2>
        </div>
        <!-- Unordered List displaying all the choices user's have. -->
        <ul style="list-style-type:none">
            <a href="create-listing.php">
              <li>Create Listing</li>
            </a>
            <a href="index.html">
              <li>View Listing</li>
            </a>
          </ul>
      </div>
      
      <?php
        }
      ?>
    </div>


        <div class="card" style="opacity: 0">
        </div>

      </div>

      <div class="messages">
      <a href="chat2.html">👋</a>
    </div>
    
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  </body>

</html>
