<?php
   include "../login/requireSession.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Reports - OJT Portal</title>

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

<section class="companies">

   <h1 class="heading">Reports</h1>

   <div class="box-container">

      <div class="box">
         <div class="tutor">
            <img src="../public/images/pic-2.jpg" alt="">
            <div class="info">
               <h3>john deo</h3>
               <span>21-10-2023</span>
            </div>
         </div>
         <div class="thumb">
            <img src="../public/images/thumb-1.png" alt="">
            <span>JPmorgan</span>
         </div>
         <h3 class="title">Web Developer</h3>
         <a class="inline-btn">Apply</a>
      </div>

      <div class="box">
         <div class="tutor">
            <img src="../public/images/pic-3.jpg" alt="">
            <div class="info">
               <h3>john deo</h3>
               <span>21-10-2023</span>
            </div>
         </div>
         <div class="thumb">
            <img src="../public/images/thumb-2.png" alt="">
            <span>JPmorgan</span>
         </div>
         <h3 class="title">Web Developer</h3>
         <a class="inline-btn">Apply</a>
      </div>

      <div class="box">
         <div class="tutor">
            <img src="../public/images/pic-4.jpg" alt="">
            <div class="info">
               <h3>john deo</h3>
               <span>21-10-2023</span>
            </div>
         </div>
         <div class="thumb">
            <img src="../public/images/thumb-3.png" alt="">
            <span>JPmorgan</span>
         </div>
         <h3 class="title">Web Developer</h3>
         <a class="inline-btn">Apply</a>
      </div>

      <div class="box">
         <div class="tutor">
            <img src="../public/images/pic-5.jpg" alt="">
            <div class="info">
               <h3>john deo</h3>
               <span>21-10-2023</span>
            </div>
         </div>
         <div class="thumb">
            <img src="../public/images/thumb-4.png" alt="">
            <span>JPmorgan</span>
         </div>
         <h3 class="title">Web Developer</h3>
         <a class="inline-btn">Apply</a>
      </div>

      <div class="box">
         <div class="tutor">
            <img src="../public/images/pic-6.jpg" alt="">
            <div class="info">
               <h3>john deo</h3>
               <span>21-10-2023</span>
            </div>
         </div>
         <div class="thumb">
            <img src="../public/images/thumb-5.png" alt="">
            <span>JPmorgan</span>
         </div>
         <h3 class="title">Web Developer</h3>
         <a class="inline-btn">Apply</a>
      </div>

      <div class="box">
         <div class="tutor">
            <img src="../public/images/pic-7.jpg" alt="">
            <div class="info">
               <h3>john deo</h3>
               <span>21-10-2023</span>
            </div>
         </div>
         <div class="thumb">
            <img src="../public/images/thumb-6.png" alt="">
            <span>JPmorgan</span>
         </div>
         <h3 class="title">Web Developer</h3>
         <a class="inline-btn">Apply</a>
      </div>

      <div class="box">
         <div class="tutor">
            <img src="../public/images/pic-8.jpg" alt="">
            <div class="info">
               <h3>john deo</h3>
               <span>21-10-2023</span>
            </div>
         </div>
         <div class="thumb">
            <img src="../public/images/thumb-7.png" alt="">
            <span>JPmorgan</span>
         </div>
         <h3 class="title">Web Developer</h3>
         <a class="inline-btn">Apply</a>
      </div>

      <div class="box">
         <div class="tutor">
            <img src="../public/images/pic-9.jpg" alt="">
            <div class="info">
               <h3>john deo</h3>
               <span>21-10-2023</span>
            </div>
         </div>
         <div class="thumb">
            <img src="../public/images/thumb-8.png" alt="">
            <span>JPmorgan</span>
         </div>
         <h3 class="title">Web Developer</h3>
         <a class="inline-btn">Apply</a>
      </div>

      <div class="box">
         <div class="tutor">
            <img src="../public/images/pic-1.jpg" alt="">
            <div class="info">
               <h3>john deo</h3>
               <span>21-10-2023</span>
            </div>
         </div>
         <div class="thumb">
            <img src="..../public/images/thumb-9.png" alt="">
            <span>JPmorgan</span>
         </div>
         <h3 class="title">Web Developer</h3>
         <a class="inline-btn">Apply</a>
      </div>

   </div>

</section>














<footer class="footer">

   &copy; copyright @ 2023 by <span>Team Croods</span> | all rights reserved!

</footer>

<!-- custom js file link  -->
<script src="../public/js/script.js"></script>

   
</body>
</html>