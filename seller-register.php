<?php
  session_start();
  error_reporting(E_ALL); ini_set('display_errors', 1);

  if (!$_SESSION["loggedIn"]) {
    header("Location: login.html");
  }

  require('dbConnect.php');
  if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['submit'])) {

    $name = $email = $phone = $address = $city = $state = $zipcode = "";

    $username = $_SESSION["username"];

    $valid_data = True;

    echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';

    // Check if Seller Name is of appropriate length and exists.
    if (strlen($_POST['sellername']) > 100 || strlen($_POST['sellername']) < 3) {
      $valid_data = False;
      echo '<script type="text/javascript">';
      echo 'setTimeout(function () { swal("Error!", "Seller Name must be between 3 and 100 characters!","error");';
      echo '}, 0);</script>';
    } else {
      $result = mysqli_query($conn, "SELECT * FROM Sellers WHERE SellerName='".$_POST['sellername']."'");;
      if (!mysqli_num_rows($result)) {
        $name = $_POST['sellername'];
        $_SESSION["sellername"] = $name;
      } else {
        $valid_data = False;
        echo '<script type="text/javascript">';
        echo 'setTimeout(function () { swal("Error!", "Seller Name already exists!","error");';
        echo '}, 0);</script>';
      }
    }

    // Check if Seller Email is of appropriate length and exists.
    if (strlen($_POST['selleremail']) > 100) {
      $valid_data = False;
      echo '<script type="text/javascript">';
      echo 'setTimeout(function () { swal("Warning!", "Email must be less than 100 characters!","warning");';
      echo '}, 0);</script>';
    } else {
      $result = mysqli_query($conn, "SELECT * FROM Sellers WHERE SellerEmail='".$_POST['selleremail']."'");;
      if (!mysqli_num_rows($result)) {
        $email = $_POST['selleremail'];
      } else {
        $valid_data = False;
        echo '<script type="text/javascript">';
        echo 'setTimeout(function () { swal("Error!", "Email already in use!", "error");';
        echo '}, 0);</script>';
      }
    }

    // Check if Phone is of appropriate length and only contains numbers and if it already exists.
    if (strlen($_POST['phone']) != 10 || preg_match('@[A-Z]@', $_POST['phone'])
        ||  preg_match('@[a-z]@', $_POST['phone']) || preg_match('@[^\w]@', $_POST['phone'])) {
      $valid_data = False;
      echo '<script type="text/javascript">';
      echo 'setTimeout(function () { swal("Error!", "Phone Number must be 10 Digits!", "error");';
      echo '}, 0);</script>';
    } else {
      $result = mysqli_query($conn, "SELECT * FROM Sellers WHERE Phone='".$_POST['phone']."'");;
      if (!mysqli_num_rows($result)) {
        $phone = $_REQUEST['phone'];
      } else {
        $valid_data = False;
        echo '<script type="text/javascript">';
        echo 'setTimeout(function () { swal("Error!", "Phone Number already in use!", "error");';
        echo '}, 0);</script>';
      }
    }

    // Check if Address is of appropriate length.
    if (strlen($_POST['address']) > 100) {
      $valid_data = False;
      echo '<script type="text/javascript">';
      echo 'setTimeout(function () { swal("Warning!", "Address must be less than 100 characters!", "warning");';
      echo '}, 0);</script>';
    } else {
      $address = $_REQUEST['address'];
    }

    // Check if City is of appropriate length and only contains letters.
    if (strlen($_POST['city']) > 50) {
      $valid_data = False;
      echo '<script type="text/javascript">';
      echo 'setTimeout(function () { swal("Warning!", "City must be less than 50 characters!", "warning");';
      echo '}, 0);</script>';
    } else if (preg_match('@[0-9]@', $_POST['city']) || preg_match('@[%\$#\*!*()]@', $_POST['city'])) {
      $valid_data = False;
      echo '<script type="text/javascript">';
      echo 'setTimeout(function () { swal("Error!", "City can only contain letters A-Z or a-z!", "error");';
      echo '}, 0);</script>';
    } else {
      $city = $_REQUEST['city'];
    }

    // Check if State is abbreviated.
    if (strlen($_POST['state']) != 2 || preg_match('@[0-9]@', $_POST['state'])) {
      $valid_data = False;
      echo '<script type="text/javascript">';
      echo 'setTimeout(function () { swal("Error!", "State must be abbreviated and only contain letters A-Z or a-z!", "error");';
      echo '}, 0);</script>';
    } else {
      $state = $_REQUEST['state'];
      $state = strtoupper($state);
    }

    // Display error if 'zipcode' is not a number or a 5-digit number
    if (strlen($_POST['zipcode']) != 5 || preg_match('@[A-Z]@', $_POST['zipcode'])
        ||  preg_match('@[a-z]@', $_POST['zipcode']) || preg_match('@[^\w]@', $_POST['zipcode'])) {
      $valid_data = False;
      echo '<script type="text/javascript">';
      echo 'setTimeout(function () { swal("Error!", "Zipcode must be 5 numerical digits!", "error");';
      echo '}, 0);</script>';
    } else {
      $zipcode = $_REQUEST['zipcode'];
    }

    // Data from form is all validated, insert data into database.
    if ($valid_data) {
      $sql = "INSERT INTO Sellers (username, sellername, selleremail, phone, streetaddress, city, state, zipcode)
      VALUES ('$username', '$name', '$email', '$phone', '$address', '$city', '$state', '$zipcode')";
      if ($conn->query($sql) === TRUE) {
        echo '<script type="text/javascript">';
        echo 'setTimeout(function () { swal("Hooray!", "You Successfully Registered as a Seller!", "success");';
        echo '}, 0);</script>';
        $_SESSION["seller-loggedIn"] = true;
        header('Location: profile.php');
        exit;
      } else {
        echo '<script type="text/javascript">';
        echo 'setTimeout(function () { swal("Error!", "Error Registering!", "error");';
        echo '}, 0);</script>';
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Triple-B</title>
    <link rel="stylesheet" href="seller-register.css">
    <link rel="stylesheet" href="nav-styles.css">
  </head>
  <body>
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
  <br></br>
  <br></br>
  <br></br>
  <div id="signupID" class="form-style" style="width:1000px; margin:0 auto;">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <h2 class="register-title"> Register as a Seller </h2>
        <label for="sellername">Seller Name <sup>1</sup></label><br>
        <input type="text" name="sellername" placeholder="Enter Seller Name" required
        value="<?= isset($_POST['sellername']) ? $_POST['sellername'] : ''; ?>"><br>
        <label for="selleremail">Seller Email <sup>1</sup></label><br>
        <input type="email" name="selleremail" placeholder="Enter Seller Email" required
        value="<?= isset($_POST['selleremail']) ? $_POST['selleremail'] : ''; ?>"><br>
        <label for="address">Street Address</label><br>
        <input type="text" name="address" placeholder="Enter Street Address" required
        value="<?= isset($_POST['address']) ? $_POST['address'] : ''; ?>"><br>
        <label for="phone">Phone <sup>1</sup></label><br>
        <input type="tel" name="phone" placeholder="Enter Phone Number" required
        value="<?= isset($_POST['phone']) ? $_POST['phone'] : ''; ?>"><br>
        <label for="city">City <sup>1</sup></label><br>
        <input type="text" name="city" placeholder="Enter City" required
        value="<?= isset($_POST['city']) ? $_POST['city'] : ''; ?>"><br>
        <label for="state">State<sup>1</sup></label><br>
        <input type="text" name="state" placeholder="Enter State" required
        value="<?= isset($_POST['state']) ? $_POST['state'] : ''; ?>"><br>
        <label for="zipcode">Zipcode<sup>1</sup></label><br>
        <input type="text" name="zipcode" placeholder="Enter Zip Code" required
        value="<?= isset($_POST['zipcode']) ? $_POST['zipcode'] : ''; ?>"><br>
        <input type="submit" name="submit" value="Submit">
    </form>
    <p style="padding-bottom: 50px; color: Red;"> <sup>1</sup> Information will be publicly shown. </p>
  </div>
  </body>
</html>
