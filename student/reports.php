<?php
require "../database/database.php";
include "../login/requireSession.php";

//remove if login is modified
$idQuery = "SELECT studentId FROM student WHERE userId = '{$_SESSION['userID']}'";
$result = mysqli_query($db, $idQuery);
if ($row = mysqli_fetch_assoc($result)) {
    $_SESSION['studentId'] = $row['studentId']; 
}
mysqli_free_result($result);


$maxWeekQuery = "SELECT MAX(weekNum) AS maxWeek FROM reports WHERE studentId = '{$_SESSION['studentId']}'";
$result = mysqli_query($db, $maxWeekQuery);
$maxWeek = 1;
if ($row = mysqli_fetch_assoc($result)) {
    $maxWeek = $row['maxWeek'];
}
$_SESSION['weekNum'] = $maxWeek + 1;

mysqli_free_result($result);

$currentWeekStart = date('Y-m-d H:i:s', strtotime('last monday', strtotime('tomorrow')));

$checkReportQuery = "SELECT COUNT(*) AS reportCount FROM reports WHERE studentId = '{$_SESSION['studentId']}' AND weekNum = '$maxWeek' AND submittedAt >= '$currentWeekStart'";
$checkResult = mysqli_query($db, $checkReportQuery);

if ($checkResult === false) {
    echo "Error: " . mysqli_error($db);
} else {
    $checkRow = mysqli_fetch_assoc($checkResult);

    if ($checkRow !== null) {
        $reportCount = $checkRow['reportCount'];
    } else {
        $reportCount = 0;
    }

    $_SESSION['reportSubmitted'] = $reportCount > 0;
    echo $_SESSION['reportSubmitted'];
    mysqli_free_result($checkResult);
}


// Submit button clicked
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $weekNumber = $_SESSION['weekNum'];
    $hoursWorked = $_POST['hoursWorked'];

    if ($hoursWorked < 0) {
        echo "<script>alert('Error: Hours Worked cannot be negative.');</script>";
        $_SESSION['negativeHrs'] = true;
        exit;
    }

    $uploadFolder = '../public/uploads';
    $allowedFileTypes = ['pdf', 'doc', 'docx'];

    $uploadedFileName = $_FILES['uploadFiles']['name'];
    $uploadedFileType = pathinfo($uploadedFileName, PATHINFO_EXTENSION);

    if (!in_array($uploadedFileType, $allowedFileTypes)) {
        echo "<script>alert('Error: Only PDF, DOC, and DOCX files are allowed.');</script>";
    } else {
        $reportFile = $uploadFolder . '/' . uniqid() . '.' . $uploadedFileType;

        if (move_uploaded_file($_FILES['uploadFiles']['tmp_name'], $reportFile)) {
            $insertQuery = "INSERT INTO reports (studentId, weekNum, hoursWorked, reportFile, status) 
                            VALUES ('{$_SESSION['studentId']}', '$weekNumber', '$hoursWorked', '$reportFile', 1)";

            if (mysqli_query($db, $insertQuery)) {
                echo "<script>alert('Report submitted successfully.');</script>";
            } else {
                echo "<script>alert('Error: " . $insertQuery . " " . mysqli_error($db) . "');</script>";
            }
        } else {
            echo "<script>alert('Error: Failed to move the uploaded file.');</script>";
        }
        
        unset($_SESSION['negativeHrs']);
    }

    mysqli_close($db);
}
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

<section class="reports">
   <h1 class="heading">Reports</h1>
   <div class="box-container">
      <script>
      window.addEventListener('DOMContentLoaded', (event) => {
         var formSubmitted = <?php echo json_encode($_SESSION['reportSubmitted']); ?>;
         if (formSubmitted) {
            disableForm();
         }
      });

      function disableForm() {
         var form = document.querySelector('form');
         var elements = form.elements;

         for (var i = 0; i < elements.length; i++) {
            elements[i].disabled = true;
         }

         var messageContainer = document.getElementById('message-container');
         messageContainer.innerHTML = '<h3>Report already submitted for this week. The form will be available next week.</h3>';
      }
      </script>

      <form action="" method="post" enctype="multipart/form-data" onsubmit="return checkFormSubmission();">

        <label for="weekNumber">Week Number: <?php echo $_SESSION['weekNum']; ?> </label>

        <label for="hoursWorked">Hours Worked:</label>
        <input type="number" id="hoursWorked" name="hoursWorked" required>

        <label for="uploadFiles">Upload Files:</label>
        <input type="file" id="uploadFiles" name="uploadFiles" required>

        <button type="submit">Submit Report</button>
      </form>
      <div id="message-container"></div>
   </div>
</section>

<footer class="footer">
   &copy; copyright @ 2023 by <span>Team Croods</span> | all rights reserved!
</footer>

<!-- custom js file link  -->
<script src="../public/js/script.js"></script>

</body>
</html>
