<?php
   include "../login/requireSession.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Profile - OJT Portal</title>

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

<section class="user-profile">

   <h1 class="heading">your profile</h1>

   <div class="info">

      <div class="user">
         <img src="../public/images/pic-1.jpg" alt="">
         <h3><?php echo $_SESSION['fullName'] ?></h3>
         <p>Student</p>
      </div>
   
      <!--
      <div class="box-container">
   
         <div class="box">
            <div class="flex">
               <i class="fas fa-bookmark"></i>
               <div>
                  <span>4</span>
                  <p>total Likes</p>
               </div>
            </div>
            <a href="#" class="inline-btn">View Likes</a>
         </div>
   
         <div class="box">
            <div class="flex">
               <i class="fas fa-heart"></i>
               <div>
                  <span>33</span>
                  <p>Total Connections</p>
               </div>
            </div>
            <a href="#" class="inline-btn">view connections</a>
         </div>
   
         <div class="box">
            <div class="flex">
               <i class="fas fa-comment"></i>
               <div>
                  <span>12</span>
                  <p>total interactions</p>
               </div>
            </div>
            <a href="#" class="inline-btn">view interactions</a>
         </div>
   
      </div>
      -->
      <?php
          require("../database/database.php");

          $userId = $_SESSION['userID'];
          $statement = $db->prepare("SELECT * FROM user NATURAL JOIN student WHERE userId = ?");
          $statement->bind_param('s', $userId);
          $statement->execute();
          $result = $statement->get_result();
          
          $data = $result->fetch_assoc();
          $firstName = $data['firstName'];
          $lastName = $data['lastName'];
          $email = $data['email'];
          $password = $data['password'];
          $course = $data['course'];
          $classCode = $data['classCode'];

          $statement->close();
      ?>

      <form id="profile-form" method="post">

      <label>
         First Name: <input type="text" value=<?php echo "\"$firstName\""; ?> disabled> 
      </label>
      <label>
         Last Name: <input type="text" value=<?php echo "\"$lastName\""; ?> disabled> 
      </label>
      <label>
         Email: <input type="text" value=<?php echo "\"$email\""; ?> disabled> 
      </label>
      <label>
         Course: <input type="text" value=<?php echo "\"$course\""; ?> disabled> 
      </label>
      <label>
         Class Code: <input type="text" value=<?php echo "\"$classCode\""; ?> disabled> 
      </label>
      <label>
         Change Password: <input type="text" value=<?php echo "\"$password\""; ?> > 
         <input type="submit" required maxlength="20" formaction="change-password.php" value="Change Password" name="submit" class="change-password-btn">
      </label>

      </form>
   </div>

</section>

<footer class="footer">

   &copy; copyright @ 2023 by <span>Team Croods</span> | all rights reserved!

</footer>

<!-- custom js file link  -->
<script src="../js/script.js"></script>

   
</body>
</html>