<!DOCTYPE html>
<html>
  <head>
      <meta charset="utf-8"/>
      <title>Sign Up!</title>
      <link rel="stylesheet" href="registration.css"/>
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
            <li><a href="profile.html"  class="underline">Profile</a></li>
            <li><a href="login.html" class="action">Log In</a></li>
          </ul>
        </a>
      </div>
    </nav>

    <h1 class=profile>
<?php
  require('dbConnect.php');

  function prompt_message($message) {
    echo "<script>alert('$message');</script>";
  }
  // Define and initialize variables to empty strings.
  // These variables will be used to display error messages when processing
  // a user account registration form.
  $FirstNameError = $LastNameError = $EmailError = $UsernameError = $PasswordError = $confirmPassError= "";
  $fname = $lname = $email = $username = $password = $confirmPass = "";
  $good_data = True;

  validate:
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['fname'])) {
        $fname = $_REQUEST['fname'];
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
          prompt_message("Email is already in use.");
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
      } else {
        // ... prompt a pop-up message.
        $good_data = False;
        prompt_message("This username is already taken.");
      }
    }

    if (!empty($_POST['password'])) {
      $password = $_REQUEST['password'];
    } else {
      $good_data = False;
      $PasswordError = "Password is Required";
    }

    // If password and password confirmation do not match...
    if ($_POST['password'] != $_POST['confirmPass']) {
      // ... display a pop-up message.
      $good_data = False;
      prompt_message("Passwords do not match.");
    }
    // insert user-inputted data into Users Table
    if ($good_data) {
      $sql = "INSERT INTO Users (firstname, lastname, email, username, password)
      VALUES ('$fname', '$lname', '$email', '$username', '$password')";

      if ($conn->query($sql) === TRUE) {
        prompt_message("Account Successfully Created!");
        header('Location: login.html');
        exit;
      }
    }
  }

  if ($good_data == False || isset($_POST['submit']) == False) {
?>

  <footer>
    <section>
      <div class="card-body" style="background-color:white;">
        <form class="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <h2 class="signup-header"> Sign Up </h2>
            <input type="text" name="fname" placeholder="First Name" required
                   value="<?= isset($_POST['fname']) ? $_POST['fname'] : ''; ?>">
            <br><br>
            <input type="text" name="lname" placeholder="Last Name" required
                   value="<?= isset($_POST['lname']) ? $_POST['lname'] : ''; ?>">
            <br><br>
            <input type="text" name="email" placeholder="Email" required
                   value="<?= isset($_POST['email']) ? $_POST['email'] : ''; ?>">
            <br><br>
            <input type="text" name="username" placeholder="Username" required
                   value="<?= isset($_POST['username']) ? $_POST['username'] : ''; ?>">
            <br><br>
            <input type="password" name="password" placeholder="Password" required
                   value="<?= isset($_POST['password']) ? $_POST['password'] : ''; ?>">
            <br><br>
            <input type="password" name="confirmPass" placeholder="Confirm Password" required
                   value="<?= isset($_POST['confirmPass']) ? $_POST['confirmPass'] : ''; ?>">
            <br><br>
            <input type="submit" name="submit" value="Submit">
        </form>
      </div>
    </section>
  </footer>

<?php
  }
?>
  </body>
</html>
