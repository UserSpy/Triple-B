<?php
// Start the session with cookie that lasts a day.
session_start();
?>
<!DOCTYPE html>
<style>
  label {
    color: Black;
    font-size: 16px;
  }
</style>

<html>
  <head>
      <meta charset="utf-8"/>
      <title>Sign Up!</title>
      <link rel="stylesheet" href="registration.css" />
      <link rel="stylesheet" href="nav-styles.css" /  >
  </head>
  <body>
    <nav>
    <div class ="container">
        <a href="index.php" class="nav-left"><h1>Buy Borrow Books</h1></a>
          <ul class="nav-right">
            <li class="item"><a href="browse.php"  ><ion-icon name="search-outline"></ion-icon></a></li>
            <li><a href="login.html" class="action">Sign In/Out</a></li>
          </ul>
        
      </div>
    </nav>

    <h1 class=profile>
<?php
  require('dbConnect.php');
  echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';

  $fname = $lname = $email = $username = $password = $confirmPass = "";
  $good_data = True;

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['fname'])) {
        $fname = $_REQUEST['fname'];
        $_SESSION['fname'] = $fname;
    }

    if (!empty($_POST['lname'])) {
        $lname = $_REQUEST['lname'];
    }

    // If email is not null...
    if (!empty($_POST['email'])) {
      // Check the Users table for the user's email.
      $result = mysqli_query($conn, "SELECT * FROM Users WHERE email='".$_POST['email']."'");;

      // If email does not exist...
      if (!mysqli_num_rows($result)) {
        $email = $_REQUEST['email'];
      } else {
          $good_data = False;
          echo '<script> swal("Error!", "Email is already in use!", "error"); </script>';
      }
    }

    // if username is not null...
    if (!empty($_POST['username'])) {
      // Check the Users table for the user's username.
      $result = mysqli_query($conn, "SELECT * FROM Users WHERE username='".$_POST['username']."'");;

      // If username does not exist...
      if (!mysqli_num_rows($result)) {
        // ...username is verified.
        $username = $_REQUEST['username'];
        $_SESSION['username'] = $username;
      } else {
        // ... else prompt a pop-up message.
        $good_data = False;
        echo '<script> swal("Error!", "Username is already in use!", "error"); </script>';
      }
    }

    if ((strlen($_POST['password']) >= 6) && preg_match('@[A-Z]@', $_POST['password']) &&  preg_match('@[a-z]@', $_POST['password'])
        && preg_match('@[0-9]@', $_POST['password']) && preg_match('@[^\w]@', $_POST['password'])) {
      $password = $_REQUEST['password'];
    } else {
      $good_data = False;
      echo '<script> swal("Error!", "Password should be at least 6 characters long and contain at least 1 uppercase letter, lowercase letter, 1 number, and 1 special character!", "error"); </script>';
    }

    // If password and password confirmation do not match...
    if ($_POST['password'] != $_POST['confirmPass']) {
      // ... display a pop-up message.
      $good_data = False;
      echo '<script> swal("Oops!", "Passwords do not match.", "error"); </script>';
    }

    // insert user-inputted data into Users Table
    if ($good_data) {
      $sql = "INSERT INTO Users (firstname, lastname, email, username, password)
      VALUES ('$fname', '$lname', '$email', '$username', '$password')";
      if ($conn->query($sql) === TRUE) {
        $_SESSION["loggedIn"] = true;
        header('Location: profile.php');
        exit;
      }
    }
  }

  if ($good_data == False || isset($_POST['submit']) == False) {
?>

  <head>
      <meta charset="utf-8"/>
      <title>Sign Up!</title>
      <link rel="stylesheet" href="registration.css" />
      <link rel="stylesheet" href="nav-styles.css" />
  </head>

  <footer>
    <section>
      <br></br>
      <br></br>
      <div class="containers">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <div class="form-elements">
            <h2 class="signup-header"> Sign Up </h2>
            <label for="fname">First Name</label><br>
            <input type="text" name="fname" placeholder="Enter First Name" required
                   value="<?= isset($_POST['fname']) ? $_POST['fname'] : ''; ?>"><br>
            <label for="lname">Last Name</label><br>
            <input type="text" name="lname" placeholder="Enter Last Name" required
                   value="<?= isset($_POST['lname']) ? $_POST['lname'] : ''; ?>"><br>
            <label for="email">Email</label><br>
            <input type="email" name="email" placeholder="Enter Email" required
                   value="<?= isset($_POST['email']) ? $_POST['email'] : ''; ?>"><br>
            <label for="username">Username</label><br>
            <input type="text" name="username" placeholder="Enter Username" required
                   value="<?= isset($_POST['username']) ? $_POST['username'] : ''; ?>"><br>
            <label for="password">Password</label><br>
            <input type="password" name="password" placeholder="Enter Password" required
                   value="<?= isset($_POST['password']) ? $_POST['password'] : ''; ?>"><br>
            <label for="confirmPass">Confirm Password</label><br>
            <input type="password" name="confirmPass" placeholder="Re-Type Password" required
                   value="<?= isset($_POST['confirmPass']) ? $_POST['confirmPass'] : ''; ?>"><br>
            <input type="submit" name="submit" value="Submit">
          </div>
        </form>
      </div>
    </section>
  </footer>

<?php
}
?>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  </body>
</html>
