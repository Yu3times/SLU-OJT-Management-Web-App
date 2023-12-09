<?php
require("../database/database.php");
include "../database/constructors/user.php";
session_start();

if (isset($_POST['userID'])){
    $userId = $_POST['userID'];
    $password = $_POST['password'];
    $_SESSION['isStudent'] = false;

    $statement = $db->prepare("SELECT * FROM user WHERE userId = ? AND password = ?");
    $statement->bind_param('ss', $userId, $password);
    $statement->execute();
    $result = $statement->get_result();

    if ($result->num_rows != 0){
        $user = $result->fetch_assoc();
        $_SESSION['userID'] = $user['userId'];

        if ($user['type'] == 1){
            $_SESSION['isStudent'] = true;
        }

        $statement->close();

        if ($_SESSION['isStudent']) {
            header("Location: ../student/index.php");
            exit();
        } else {
            $includeJS = true;
            header("Location: ../teacher/views/index.ejs");
            exit();
        }
    } else {
        $_SESSION['invalidLogin'] = true;
        header("Location: ../login/loginPage.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Redirecting...</title>
   <?php
        if (isset($includeJS) && $includeJS) {
            echo '<script> window.localStorage.setItem("uid", ' . $_SESSION['userID'] .'</script>';
            echo '<script src="./js/confirm.js"></script>';
        }
    ?>

</head>
<body>

</body>
</html>
