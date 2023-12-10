<?php
    require("../database/database.php");
    require("../login/requireSession.php");

    $statement = $db->prepare("UPDATE user set password = ? WHERE userId = ?");
    $statement->bind_param('ss', $_POST['password'], $_SESSION['userID']);
    $statement->execute();
    $statement->close();
    header("Location: profile.php");
?>