<?php
  require("../database/database.php");
  include "../database/constructors/user.php";
  session_start();

  if (isset($_POST['userID'])){
    $userId = $_POST['userID'];
    $password = $_POST['password'];

    $statement = $db->prepare("SELECT * FROM USER WHERE userId = ? AND password = ?");
    $statement->bind_param('ss', $userId, $password);
    $statement->execute();
    $result = $statement->get_result();

    if ($result->num_rows != 0){
      $user = $result->fetch_assoc();
      $_SESSION['userID'] = $user['userId'];

      if ($user['type'] == 1){
        $_SESSION['isStudent'] = true;
      }
    }

    $statement->close();
    if ($_SESSION['isStudent']) {
      header("Location: ../student/index.html");
      exit();
    } else {
      header("Location: ../admin/index.html");
      exit();
    }

  } else {
    echo "Invalid login credentials";
}
  
  header("Location: index.php");
  exit();
?>
