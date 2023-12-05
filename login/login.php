<?php
  require("database/database.php");
  include "database/constructors/user.php";
  session_start();

  if (isset($_POST['userID'])){
    $userId = $_POST['userID'];
    $password = $_POST['password'];

    $statement = $db -> prepare("SELECT * FROM USER WHERE userId = ? AND password = ?");
    $statement -> bind_param('ss', $userId, $password);
    $statement -> execute();
    $result = $statement -> get_result();

    if ($result -> num_rows != 0){
      $_SESSION['userID'] = $userId;
      $data = $result -> fetch_assoc();
      if ($data['type'] = 1){
        $_SESSION['isStudent'] = true;
      }
    }

    $statement -> close();
  }
  header("Location: index.php");
  exit();
?>