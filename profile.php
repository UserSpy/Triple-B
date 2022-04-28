<?php
  session_start();
  error_reporting(E_ALL); ini_set('display_errors', 1);
  if (!$_SESSION["loggedIn"]) {
    header("Location: login.html");
  }
  require('dbConnect.php');
?>

<!DOCTYPE html>
<html lang="en" dir="ltr" style="background-color:lightblue">
  <head>
    <meta charset="utf-8">
    <title>Triple-B</title>
    <link rel="stylesheet" href="profile-styles.css">
    <link rel="stylesheet" href="nav-styles.css">
  </head>
  <body>
    <nav>
      <div class ="container">
        <a href="index.php" class="init">
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
            <li>Option 1</li>
          </a>
          <a href="index.html">
            <li>Option 2</li>
          </a>
          <a href="index.html">
            <li>Option 3</li>
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
            <li>Option 1</li>
          </a>
          <a href="index.html">
            <li>Option 2</li>
          </a>
          <a href="index.html">
            <li>Option 3</li>
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
            <li>Option 1</li>
          </a>
          <a href="index.html">
            <li>Option 2</li>
          </a>
          <a href="index.html">
            <li>Option 3</li>
          </a>
        </ul>
      </div>
    </div>

    <div class="three-cards" style="width:1000px; margin:0 auto;">
      <div class="card">
        <!-- redirects to home page for the time being -->
        <a href="index.html">
          <!-- Licensed under Creative Commons CC-BY Pixabay -->
          <img src="images/information-icon.png" alt="Information Icon" class="icon-image" align="left">
        </a>
        <div class="card-headings">
          <h2>Customer Service</h2>
        </div>
        <!-- Unordered List displaying all the choices user's have. -->
        <ul style="list-style-type:none">
          <!-- redirects to home page for the time being -->
          <a href="index.html">
            <li>Option 1</li>
          </a>
          <a href="index.html">
            <li>Option 2</li>
          </a>
          <a href="index.html">
            <li>Option 3</li>
          </a>
        </ul>
      </div>
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
            <li>Option 1</li>
          </a>
          <a href="index.html">
            <li>Option 2</li>
          </a>
          <a href="index.html">
            <li>Option 3</li>
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
    </div>
    <?php
      if ($_SESSION["seller-loggedIn"]) {
    ?>
      <div class="three-cards" style="width:1000px; margin:0 auto;">
        <div class="card" style="opacity: 0">
        </div>

        <div class="card">
          <!-- redirects to home page for the time being -->
          <a href="index.html">
            <!-- Licensed under Creative Commons CC-BY Pixabay -->
            <img src="images/create-listing-icon.png" alt="Cardboard Box Icon" class="icon-image" align="left">
          </a>
          <div class="card-headings">
            <h2>My Listings</h2>
          </div>
          <!-- Unordered List displaying all the choices user's have. -->
          <ul style="list-style-type:none">
            <a href="create-listing.php">
              <li>Create Listing</li>
            </a>
            <a href="index.html">
              <li>View Listing</li>
            </a>
            <a href="index.html">
              <li>Option 3</li>
            </a>
          </ul>
        </div>

        <div class="card" style="opacity: 0">
        </div>

      </div>
    <?php
      }
    ?>

  </body>

</html>
