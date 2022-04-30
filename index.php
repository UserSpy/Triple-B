<?php
    session_start();

    $conn = new mysqli("localhost", "root", "", "accounts");


    if(mysqli_connect_error()){
        die('Connect Error('. mysqli_connect_error().')'. mysqli_connect_error());
    }else {
        $sqlRows = "SELECT * FROM listings";
        $sqlRowData = mysqli_query($conn, $sqlRows);
        $numRows = mysqli_num_rows($sqlRowData);
        // Get the array of the latest tuple
        $sqlTop = "SELECT * FROM listings WHERE ID=$numRows";
        $sqlTopData = mysqli_query($conn, $sqlTop);
        $latestListing = mysqli_fetch_assoc($sqlTopData);

        $frstImgUrl = "./uploads/{$latestListing['Image1']}";

        // Get the 2nd latest tuple
        $scndTop = $numRows-1;

        $sqlScnd = "SELECT * FROM listings WHERE ID=$scndTop";
        $sqlScndData = mysqli_query($conn, $sqlScnd);
        $scndListing = mysqli_fetch_assoc($sqlScndData);

        $scndImgUrl = "./uploads/{$scndListing['Image1']}";
        // Get the 3rd latest tuple
        $thirdTop = $numRows-2;

        $sqlTHIRDTop = "SELECT * FROM listings WHERE ID=$thirdTop";
        $sqlTHIRDData = mysqli_query($conn, $sqlTHIRDTop);
        $thirdListing = mysqli_fetch_assoc($sqlTHIRDData);

        $thirdImgUrl = "./uploads/{$thirdListing['Image1']}";

        //map {very poor: 1, ..., Excellent: 5}
        //This is for creating star rating later
        $ratingScale = array(
          "Very Poor"=>1,
          "Poor"=>2,
          "Fair"=>3,
          "Good"=>4,
          "Excellent"=>5
        );
    }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Triple-B</title>
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="nav-styles.css?v=<?php echo time(); ?>">
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


    <!-- hero -->
    <div class="hero">
        <h1>Welcome</h1>
    </div>

    
    <!-- First View -->
    <div class="category-section">
      <div class="mix-grid">
        <!-- LATEST BOOK -->
        <div class="nested">
          <h3><?php echo $latestListing['TextbookTitle'];?></h3>
          <?php echo "<a href='listing.php?tupleID=$latestListing[ID]'><img src='$frstImgUrl' alt='Image 1'></a>"?>
          <div>
            <!-- Category Description -->
            <div>
              <div class="category-title">
                <h4>PRICE: $<?php echo $latestListing['Price'];?></h4>
              </div>
              <div class="category-title">
                <h4>ISBN:</h4>
                <?php echo $latestListing['ISBN'];?>
              </div>
              <div class="category-title">
                <h4>DESCRIPTION:</h4>
                <?php echo $latestListing['Description'];?>
              </div>
              <div class="more-info">
                <h6>click the book for more information...</h6>
              </div>
            </div>
          </div>
          <!-- Ranking system -->
          <div class="rating">
              <!-- CREATES 5 STAR RATING BASED ON THE BOOK -->
              <?php
                  $goldStars = $ratingScale[$latestListing['BookCondition']];
                  $blankStars = 5- $goldStars;
                  for($stars = 0; $stars < $goldStars; $stars++){
                    echo '<p class="star s-active"></p>';
                  }
                  for($greystars = 0; $greystars < $blankStars; $greystars++){
                    echo '<p class="star"></p>';
                  }
              ?>
            </div>
        </div>
        <!-- SECOND TO LATEST BOOK -->
        <div class="nested">
          <h3><?php echo $scndListing['TextbookTitle'];?></h3>
          <?php echo "<a href='listing.php?tupleID=$scndListing[ID]'><img src='$scndImgUrl' alt='Image 1'></a>"?>
          <div>
            <!-- Category Description -->
            <div>
              <div class="category-title">
                <h4>PRICE: $<?php echo $scndListing['Price'];?></h4>
              </div>
              <div class="category-title">
                <h4>ISBN:</h4>
                <?php echo $scndListing['ISBN'];?>
              </div>
              <div class="category-title">
                <h4>DESCRIPTION:</h4>
                <?php echo $scndListing['Description'];?>
              </div>
              <div class="more-info">
                <h6>click the book for more information...</h6>
              </div>
            </div>
          </div>
          <!-- Ranking system -->
          <div class="rating">
            <!-- CREATES 5 STAR RATING BASED ON THE BOOK -->
            <?php
                $goldStars = $ratingScale[$scndListing['BookCondition']];
                $blankStars = 5- $goldStars;
                for($stars = 0; $stars < $goldStars; $stars++){
                  echo '<p class="star s-active"></p>';
                }
                for($greystars = 0; $greystars < $blankStars; $greystars++){
                  echo '<p class="star"></p>';
                }
            ?>
          </div>
        </div>
        <!-- THIRD TO LATEST BOOK -->
        <div class="nested">
          <h3><?php echo $thirdListing['TextbookTitle'];?></h3>
          <?php echo "<a href='listing.php?tupleID=$thirdListing[ID]'><img src='$thirdImgUrl' alt='Image 1'></a>"?>
          <div>
            <!-- Category Description -->
            <div>
              <div class="category-title">
                <h4>PRICE: $<?php echo $thirdListing['Price'];?></h4>
              </div>
              <div class="category-title">
                <h4>ISBN:</h4>
                <?php echo $thirdListing['ISBN'];?>
              </div>
              <div class="category-title">
                <h4>DESCRIPTION:</h4>
                <?php echo $thirdListing['Description'];?>
              </div>
              <div class="more-info">
                <h6>click the book for more information...</h6>
              </div>
            </div>
          </div>
          <!-- Ranking system -->
          <div class="rating">
            <!-- CREATES 5 STAR RATING BASED ON THE BOOK -->
            <?php
                $goldStars = $ratingScale[$thirdListing['BookCondition']];
                $blankStars = 5- $goldStars;
                for($stars = 0; $stars < $goldStars; $stars++){
                  echo '<p class="star s-active"></p>';
                }
                for($greystars = 0; $greystars < $blankStars; $greystars++){
                  echo '<p class="star"></p>';
                }
            ?>
          </div>
        </div>
    </div>

    <!-- List sections -->

    <div class="list-section">
      <div class="list-title">
        <h2 class="desktopTitle">🖥️ Popular Computer Science Books 💻</h2>
        <h2 class="mobileTitle">🖥️ Computer Science 💻</h2>
      </div>
      <div class="scroller-grid">
        <!-- cs book 1 -->
        <a href="listing.php?tupleID=11">
          <div class="book-cont">

            <img src="./uploads/204169227771iTDxDY7CL.jpg" alt="image">
            <div class="listing-info">
              <p>Price: $100<br>Condition: Excellent</p>
              <p class="smol-text">click to learn more...</p>
            </div>
          </div>
        </a>
        <!-- cs book 2 -->
        <a href="listing.php?tupleID=13" class="book-cont">
          <img src="./uploads/90625752581Uec7eLvaL.jpg" alt="image">
          <div class="listing-info">
            <p>Price: $200<br>Condition: Very Poor</p>
            <p class="smol-text">click to learn more...</p>
          </div>
        </a>
        <!-- cs book 3 -->
        <a href="listing.php?tupleID=14" class="book-cont">
          <img src="./uploads/411ejyE8obL._SX377_BO1,204,203,200_.jpg" alt="image">
          <div class="listing-info">
            <p>Price: $0<br>Condition: Fair</p>
            <p class="smol-text">click to learn more...</p>
          </div>
        </a>
        <!-- cs book 4 -->
        <a href="listing.php?tupleID=12" class="book-cont">
          <img src="./uploads/12125434891JLJ+dZOUL.jpg" alt="image">
          <div class="listing-info">
            <p>Price: $400<br>Condition: Good</p>
            <p class="smol-text">click to learn more...</p>
          </div>
        </a>
      </div>
    </div>

    <div class="list-section">
      <div class="list-title">
        <h2 class="desktopTitle">🧪 Popular Chemistry Books ⚗️</h2>
        <h2 class="mobileTitle">🧪 Chemistry Books ⚗️</h2>
      </div>
      <div class="scroller-grid">
        <!-- chem book 1 -->
        <a href="listing.php?tupleID=7" class="book-cont">
          <img src="./uploads/fchem.jpg" alt="image">
          <div class="listing-info">
            <p>Price: $275<br>Condition: Fair</p>
            <p class="smol-text">click to learn more...</p>
          </div>
        </a>
        <!-- chem book 2 -->
        <a href="listing.php?tupleID=8" class="book-cont">
          <img src="./uploads/ochem.jpg" alt="image">
          <div class="listing-info">
            <p>Price: $600<br>Condition: Excellent</p>
            <p class="smol-text">click to learn more...</p>
          </div>
        </a>
        <!-- chem book 3 -->
        <a href="listing.php?tupleID=9" class="book-cont">
          <img src="./uploads/bchem.jpg" alt="image">
          <div class="listing-info">
            <p>Price: $350<br>Condition: Good</p>
            <p class="smol-text">click to learn more...</p>
          </div>
        </a>
        <!-- chem book 4 -->
        <a href="listing.php?tupleID=10" class="book-cont">
          <img src="./uploads/chem book.jpg" alt="image">
          <div class="listing-info">
            <p>Price: $828<br>Condition: Good</p>
            <p class="smol-text">click to learn more...</p>
          </div>
        </a></div>
    </div>

    <div class="list-section">
      <div class="list-title">
        <h2 class="desktopTitle">🌎 Popular Geology Books 🌍</h2>
        <h2 class="mobileTitle">🌎 Geology Books 🌍</h2>
      </div>
      <div class="scroller-grid">
        <!-- geo book 1 -->
        <a href="listing.php?tupleID=15" class="book-cont hiddenMobile">
          <img src="./uploads/51e7lVxA-ZL._SL500_.jpg" alt="image">
          <div class="listing-info">
            <p>Price: $123<br>Condition: Poor</p>
            <p class="smol-text">click to learn more...</p>
          </div>
        </a>
        <!-- geo book 2 -->
        <a href="listing.php?tupleID=16" class="book-cont hiddenMobile">
          <img src="./uploads/51el5oz411L.jpg" alt="image">
          <div class="listing-info">
            <p>Price: $452<br>Condition: Excellent</p>
            <p class="smol-text">click to learn more...</p>
          </div>
        </a>
        <!-- geo book 3 -->
        <a href="listing.php?tupleID=17" class="book-cont">
          <img src="./uploads/613OsdBOPXL.jpg" alt="image">
          <div class="listing-info">
            <p>Price: $253452<br>Condition: Very Poor</p>
            <p class="smol-text">click to learn more...</p>
          </div>
        </a>
        <!-- geo book 4 -->
        <a href="listing.php?tupleID=18" class="book-cont">
          <img src="./uploads/9780393667523_300.jpeg" alt="image">
          <div class="listing-info">
            <p>Price: $34343<br>Condition: Poor</p>
            <p class="smol-text">click to learn more...</p>
          </div>
        </a></div>
    </div>

    <div class="messages">
      <a href="chat2.html">👋</a>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  </body>
</html>
