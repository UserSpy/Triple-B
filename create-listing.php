<?php
  session_start();
  error_reporting(E_ALL); ini_set('display_errors', 1);


  if (!$_SESSION["loggedIn"] || !$_SESSION["seller-loggedIn"]) {
    header("Location: login.html");
  }

  require('dbConnect.php');

  if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['submit'])) {

    $SellerName = $Title = $ISBN = $Price = $BookCondition = $Description = $Email = $Phone = "";

    $valid_data = True;


    $result = mysqli_query($conn, "SELECT SellerName, SellerEmail, Phone FROM Sellers WHERE  Username='".$_SESSION['username']."'");

    $row = $result->fetch_assoc();

    echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';

    // Initialize and validate $SellerName, $Email, $Phone
    $SellerName = $row['SellerName'];

    if (empty($SellerName)) {
      $valid_data = False;
      echo '<script type="text/javascript">';
      echo 'setTimeout(function () { swal("Error!", "Seller Name cannot be empty!","error");';
      echo '}, 0);</script>';
    }

    $Email = $row['SellerEmail'];

    if (empty($Email)) {
      $valid_data = False;
      echo '<script type="text/javascript">';
      echo 'setTimeout(function () { swal("Error!", "Email cannot be empty!","error");';
      echo '}, 0);</script>';
    }

    $Phone = $row['Phone'];

    if (empty($Phone)) {
      $valid_data = False;
      echo '<script type="text/javascript">';
      echo 'setTimeout(function () { swal("Error!", "Phone Number cannot be empty!","error");';
      echo '}, 0);</script>';
    }


    // Check if Textbook Title is of appropriate length.
    if (strlen($_POST['textbook']) > 200) {
      $valid_data = False;
      echo '<script type="text/javascript">';
      echo 'setTimeout(function () { swal("Warning!", "Textbook Name must be less than 200 characters!", "warning");';
      echo '}, 0);</script>';
    } else {
      $Title = $_POST['textbook'];
    }

    // Check if ISBN is of appropriate length.
    if (strlen($_POST['isbn']) != 13 and strlen($_POST['isbn']) != 10) {
      $valid_data = False;
      echo '<script type="text/javascript">';
      echo 'setTimeout(function () { swal("Error!", "ISBN must be 10 or 13 Digits!","error");';
      echo '}, 0);</script>';
    } else {
      $ISBN = $_POST['isbn'];
    }

    // Store user-entered price in $Price
    $Price = $_POST['price'];
    if (empty($Price)) {
      $valid_data = False;
      echo '<script type="text/javascript">';
      echo 'setTimeout(function () { swal("Error!", "Price cannot be empty!","error");';
      echo '}, 0);</script>';
    }

    // Check if Texbook Condition Radio button was selected.
    if (!isset($_POST['bookcondition'])) {
        $valid_data = False;
        echo '<script type="text/javascript">';
        echo 'setTimeout(function () { swal("Error!", "Select the condition of your textbook!", "error");';
        echo '}, 0);</script>';
    } else {
        $BookCondition = $_POST['bookcondition'];
    }

    // Check if Description is of appropriate length.
    if (!strlen(trim($_POST['description'])) || strlen($_POST['description']) > 1000) {
      $valid_data = False;
      echo '<script type="text/javascript">';
      echo 'setTimeout(function () { swal("Warning!", "Description must be less than 1000 characters and not be left empty!", "warning");';
      echo '}, 0);</script>';
    } else {
      $Description = $_REQUEST['description'];
    }

    // array to store the file path of each of the uploaded files
    $file_array = ["", "", "", "", "", ""];

    // Stores the number of files that were uploaded
    $file_count = count((array)$_FILES['fileToUpload']['name']);

    if ($file_count > 6) {
      echo '<script type="text/javascript">';
      echo 'setTimeout(function () { swal("Warning!", "Max File Limit Reached. Listing will not be created!", "warning");';
      echo '}, 0);</script>';
      $valid_data = False;
    }
    // Iterate through all the files
    for($i = 0; $i < $file_count; $i++) {
       $target_file = basename($_FILES["fileToUpload"]["name"][$i]);
       $file_array[$i] = $target_file;
       $extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

       if ($extension != 'jpg' and $extension != 'png' and $extension != 'jpeg') {
         echo '<script type="text/javascript">';
         echo 'setTimeout(function () { swal("Warning!", "File extensions .jpg, .jpeg, .gif, and .png are only supported!", "warning");';
         echo '}, 0);</script>';
         $valid_data = False;
       } else if ($_FILES["fileToUpload"]["size"][$i] > 8000000) {
         echo '<script type="text/javascript">';
         echo 'setTimeout(function () { swal("Warning!", "Your file is too large! It must be less than 8 MB!", "warning");';
         echo '}, 0);</script>';
         $valid_data = False;
       }
    }

    // Data from form is all validated, insert data into database.
    if ($valid_data) {
      // if all images and data are valid, upload the image path(s) to the data base
      for($i = 0; $i < $file_count; $i++) {
        $target_file = $target_dir . rand() . basename($_FILES["fileToUpload"]["name"][$i]);
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file);
      }

      $sql = "INSERT INTO Listings (sellername, textbooktitle, isbn, price, bookcondition, description, email, phone, image1, image2, image3, image4, image5, image6)
      VALUES ('$SellerName', '$Title', '$ISBN', '$Price', '$BookCondition', '$Description', '$Email', '$Phone', '$file_array[0]', '$file_array[1]', '$file_array[2]', '$file_array[3]', '$file_array[4]', '$file_array[5]')";

      if ($conn->query($sql) === TRUE) {
        header('Location: profile.php');
        exit;
      } else {
        header('Location: login.html');
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Triple-B</title>
    <link rel="stylesheet" href="create-listing.css">
    <link rel="stylesheet" href="nav-styles.css">
  </head>
  <body>
  <nav>
      <div class ="container">
        <a href="index.php" class="nav-left">
          <h1>Buy Borrow Books</h1>
        </a>
          <ul class="nav-right">
          <li class="item"><a href="index.php"  ><ion-icon name="home-outline" class="mobileHome"></ion-icon></ion-icon></a></li>
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
  <br></br>
  <br></br>
  <br></br>
  <div id="signupID" class="form-style" style="width:1000px; margin:0 auto;">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
        <h2 class="register-title"> Create a Listing </h2>
        <label for="textbook">Textbook Title</label><br>
        <input type="text" name="textbook" placeholder="Enter Textbook Title" required
        value="<?= isset($_POST['textbook']) ? $_POST['textbook'] : ''; ?>"><br>
        <label for="isbn">ISBN</label><br>
        <input type="text" name="isbn" placeholder="Enter 10 or 13 Digit ISBN" required
        value="<?= isset($_POST['isbn']) ? $_POST['isbn'] : ''; ?>"><br>
        <label for="price">Price</label><br>
        <input type="number" step="0.01" name="price" placeholder="Enter Price of the Textbook" required
        value="<?= isset($_POST['price']) ? $_POST['price'] : ''; ?>"><br><br>
        <label for="bookcondition">Select the Condition of Your Textbook</label><br><br>
        <div class="radio-class" style="padding-left: 20px">
          <input class="radio" type="radio" id="verypoor" name="bookcondition" value="VeryPoor" required>
          <label style="padding-right: 50px" for="verypoor">  Very Poor</label>
          <input class="radio" type="radio" id="poor" name="bookcondition" value="Poor" required>
          <label style="padding-right: 50px" for="poor">Poor</label>
          <input class="radio" type="radio" id="fair" name="bookcondition" value="Fair" required>
          <label style="padding-right: 50px" for="fair">Fair</label>
          <input class="radio" type="radio" isd="good" name="bookcondition" value="Good" required>
          <label style="padding-right: 50px" for="good">Good</label>
          <input class="radio" type="radio" id="excellent" name="bookcondition" value="Excellent" required>
          <label style="padding-right: 50px" for="excellent">Excellent</label>
        </div>
        <br>
        <label for="description">Description</label><br>
        <textarea required name="description"
        value="<?= isset($_POST['description']) ? $_POST['description'] : ''; ?>">Enter a Description of the textbook you are selling.
        </textarea>
        <br><br>
        <label for="fileToUpload">Upload Images of Your Textbook (Up to 6)</label><br>
        <input multiple type="file" name="fileToUpload[]" id="fileToUpload" accept=".jpg, .jpeg, .png"  onchange="loadFile(event)">
        <p id="over-file-limit" style="color:Red; font-size: 40px;"> </p>
        <!-- Partial Implementation using https://stackoverflow.com/a/27165977 CC BY-SA 4.0  -->
        <img id="show_img"> </img>
        <img id="show_img2"> </img>
        <img id="show_img3"> </img>
        <img id="show_img4"> </img>
        <img id="show_img5"> </img>
        <img id="show_img6"> </img>

        <script>
          const image_index = ["show_img", "show_img2", "show_img3", "show_img4", "show_img5", "show_img6"];

          var loadFile = function(event) {
            if (event.target.files.length > 6) {
              var warning_msg = document.getElementById("over-file-limit").innerHTML = "Error! 6 Files is the Max!";
            }

            for (let i = 0; i < event.target.files.length; i++) {

              var output = document.getElementById(image_index[i]);
              output.src = URL.createObjectURL(event.target.files[i]);
              output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
              }
            }
          };

        </script>
        <input type="submit" name="submit" value="Submit">
    </form>
  </div>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  </body>
</html>
