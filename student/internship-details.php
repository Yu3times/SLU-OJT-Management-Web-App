<?php
   include "../login/requireSession.php";
   require "../database/database.php";

   //Fetching currently logged in student by their user
   $userId = $_SESSION['userID'];

   //Fetch company name
   $companyNameQuery = $db->prepare("SELECT c.companyName
      FROM internship AS i
      JOIN company AS c ON i.companyId = c.companyID
      JOIN student AS s ON i.studentId = s.studentId
      WHERE s.userId = ?
   ");

   $companyNameQuery->bind_param("i", $userId);
   $companyNameQuery->execute();
   $companyNameResult = $companyNameQuery->get_result();

   if ($companyNameResult->num_rows > 0) {
      $companyNameRow = $companyNameResult->fetch_assoc();
      $companyName = $companyNameRow['companyName'];
   } else {
      $companyName = "No data found";
   }

   $companyNameQuery->close();

   //Fetch company address
   $companyAddressQuery = $db->prepare("SELECT c.companyAddress
      FROM internship AS i
      JOIN company AS c ON i.companyId = c.companyID
      JOIN student AS s ON i.studentId = s.studentId
      WHERE s.userId = ?
   ");

   $companyAddressQuery->bind_param("i", $userId);
   $companyAddressQuery->execute();
   $companyAddressResult = $companyAddressQuery->get_result();

   if ($companyAddressResult->num_rows > 0) {
      $companyAddressRow = $companyAddressResult->fetch_assoc();
      $companyAddress = $companyAddressRow['companyAddress'];
   } else {
      $companyAddress = "No data found";
   }

   $companyAddressQuery->close();

   //Fetch company website
   $companyWebsiteQuery = $db->prepare("SELECT c.website
      FROM internship AS i
      JOIN company AS c ON i.companyId = c.companyID
      JOIN student AS s ON i.studentId = s.studentId
      WHERE s.userId = ?
   ");

   $companyWebsiteQuery->bind_param("i", $userId);
   $companyWebsiteQuery->execute();
   $companyWebsiteResult = $companyWebsiteQuery->get_result();

   if ($companyWebsiteResult->num_rows > 0) {
      $companyWebsiteRow = $companyWebsiteResult->fetch_assoc();
      $companyWebsite = $companyWebsiteRow['website'];
   } else {
      $companyWebsite = "No data found";
   }

   $companyWebsiteQuery->close();

   //Fetch company contact
   $companyContactQuery = $db->prepare("SELECT c.contact
      FROM internship AS i
      JOIN company AS c ON i.companyId = c.companyID
      JOIN student AS s ON i.studentId = s.studentId
      WHERE s.userId = ?
   ");

   $companyContactQuery->bind_param("i", $userId);
   $companyContactQuery->execute();
   $companyContactResult = $companyContactQuery->get_result();

   if ($companyContactResult->num_rows > 0) {
      $companyContactRow = $companyContactResult->fetch_assoc();
      $companyContact = $companyContactRow['contact'];
   } else {
      $companyContact = "No data found";
   }

   $companyContactQuery->close();

   //Fetch advisor name
   $advisorNameQuery = $db->prepare("SELECT adv.firstName, adv.lastName
   FROM internship AS i
   JOIN advisor AS adv ON i.advisorId = adv.advisorId
   JOIN student AS s ON i.studentId = s.studentId
   WHERE s.userId = ?
   ");

   $advisorNameQuery->bind_param("i", $userId);
   $advisorNameQuery->execute();
   $advisorNameResult = $advisorNameQuery->get_result();

   if ($advisorNameResult->num_rows > 0) {
      $advisorNameRow = $advisorNameResult->fetch_assoc();
      $advisorName = $advisorNameRow['firstName'] . ' ' . $advisorNameRow['lastName'];
   } else {
      $advisorName = "No advisor found";
   }

   $advisorNameQuery->close();

   //Fetch advisor email
   $advisorEmailQuery = $db->prepare("SELECT adv.email
   FROM internship AS i
   JOIN advisor AS adv ON i.advisorId = adv.advisorId
   JOIN student AS s ON i.studentId = s.studentId
   WHERE s.userId = ?
   ");

   $advisorEmailQuery->bind_param("i", $userId);
   $advisorEmailQuery->execute();
   $advisorEmailResult = $advisorEmailQuery->get_result();

   if ($advisorEmailResult->num_rows > 0) {
      $advisorEmailRow = $advisorEmailResult->fetch_assoc();
      $advisorEmail = $advisorEmailRow['email'];
   } else {
      $advisorEmail = "No email found";
   }

   $advisorEmailQuery->close();

   //Fetch advisor contact
   $advisorContactQuery = $db->prepare("SELECT adv.contact
   FROM internship AS i
   JOIN advisor AS adv ON i.advisorId = adv.advisorId
   JOIN student AS s ON i.studentId = s.studentId
   WHERE s.userId = ?
   ");

   $advisorContactQuery->bind_param("i", $userId);
   $advisorContactQuery->execute();
   $advisorContactResult = $advisorContactQuery->get_result();

   if ($advisorContactResult->num_rows > 0) {
      $advisorContactRow = $advisorContactResult->fetch_assoc();
      $advisorContact = $advisorContactRow['contact'];
   } else {
      $advisorContact = "No contact found";
   }

   $advisorContactQuery->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Internship Details - OJT Portal</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../public/css/style.css">

</head>
<body>

<header class="header">
   
   <section class="flex">

      <a href="index.html" class="logo">OJT Portal</a>


      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div> 
         <div id="search-btn" class="fas fa-search"></div>
         <div id="toggle-btn" class="fas fa-sun"></div>
      </div>


   </section>

</header>   

<div class="side-bar">

   <div id="close-btn">
      <i class="fas fa-times"></i>
   </div>

   <div class="profile">
      <img src="../public/images/pic-1.jpg" class="image" alt="">
      <h3 class="name"><?php echo $_SESSION['fullName'] ?></h3>
      <p class="role">Student</p>
      <a href="profile.php" class="btn">view profile</a>
   </div>

   <nav class="navbar">
      <a href="index.php"><i class="fas fa-home"></i><span>Home</span></a>
      <a href="internship-details.php"><i class="fa-solid fa-briefcase"></i><span>Intership Details</span></a>
      <a href="reports.php"><i class="fa-regular fa-clipboard"></i><span>Reports</span></a>
      <a href="logout.php"><i class="fa-solid fa-door-open"></i><span>Logout</span></a>
   </nav>

</div>

<!--
<section class="about">

   <div class="row">

      <div class="image">
         <img src="../images/about-img.svg" alt="">
      </div>

      <div class="content">
         <h3>why choose us?</h3>
         <p> We connect future industry leaders with other like minded individuals</p>
         <a href="companies.html" class="inline-btn">Job Listings</a>
      </div>

   </div>

   <div class="box-container">

      <div class="box">
         <i class="fas fa-graduation-cap"></i>
         <div>
            <h3>+10k</h3>
            <p>Parter Companies</p>
         </div>
      </div>

      <div class="box">
         <i class="fas fa-user-graduate"></i>
         <div>
            <h3>+40k</h3>
            <p>Monthly Users</p>
         </div>
      </div>

      <div class="box">
         <i class="fas fa-chalkboard-user"></i>
         <div>
            <h3>+2k</h3>
            <p>Industry Heads</p>
         </div>
      </div>

      <div class="box">
         <i class="fas fa-briefcase"></i>
         <div>
            <h3>100%</h3>
            <p>job placement</p>
         </div>
      </div>

   </div>

</section> 

<section class="reviews">

   <h1 class="heading">Reviews</h1>

   <div class="box-container">

      <div class="box">
         <p>Good shit to kosa</p>
         <div class="student">
            <img src="../images/pic-2.jpg" alt="">
            <div>
               <h3>john deo</h3>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
               </div>
            </div>
         </div>
      </div>

      <div class="box">
         <p>Good shit to kosa</p>
         <div class="student">
            <img src="../images/pic-3.jpg" alt="">
            <div>
               <h3>john deo</h3>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
               </div>
            </div>
         </div>
      </div>

      <div class="box">
         <p>Good shit to kosa</p>
         <div class="student">
            <img src="../images/pic-4.jpg" alt="">
            <div>
               <h3>john deo</h3>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
               </div>
            </div>
         </div>
      </div>

      <div class="box">
         <p>Good shit to kosa</p>
         <div class="student">
            <img src="../images/pic-5.jpg" alt="">
            <div>
               <h3>john deo</h3>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
               </div>
            </div>
         </div>
      </div>

      <div class="box">
         <p>Good shit to kosa</p>
         <div class="student">
            <img src="../images/pic-6.jpg" alt="">
            <div>
               <h3>john deo</h3>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
               </div>
            </div>
         </div>
      </div>

      <div class="box">
         <p>Good shit to kosa</p>
         <div class="student">
            <img src="../images/pic-7.jpg" alt="">
            <div>
               <h3>john deo</h3>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
               </div>
            </div>
         </div>
      </div>

   </div>

</section>

-->

<section class="home-grid">
   <h1 class="heading">Internship Details</h1>
   <div class="box-container">
      <div class="rectangle">
         <h3 class="title">Company Details</h3>
         <p class="requirements">Name: <span><?php echo $companyName ?></span></p>
         <p class="requirements">Address: <span><?php echo $companyAddress ?></span></p>
         <p class="requirements">Website: <span><?php echo $companyWebsite ?></span></p>
         <p class="requirements">Contact: <span><?php echo $companyContact ?></span></p>
      </div>

      <div class="rectangle">
         <h3 class="title">Advisor Details</h3>
         <p class="requirements">Name: <span><?php echo $advisorName ?></span></p>
         <p class="requirements">Email: <span><?php echo $advisorEmail ?></span></p>
         <p class="requirements">Contact: <span><?php echo $advisorContact ?></span></p>
      </div>

</section>


<footer class="footer">

   &copy; copyright @ 2023 by <span>Team Croods</span> | all rights reserved!

</footer>

<!-- custom js file link  -->
<script src="../public/js/script.js"></script>

   
</body>
</html>