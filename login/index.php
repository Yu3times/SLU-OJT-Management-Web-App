<?php 
    session_start();
    
    if (!isset($_SESSION['userID'])){
        include "loginPage.html";
    } else{
        if (isset($_SESSION['isStudent'])) {
            include "student/index.html"
        } else {
            header("Location: admin/index.html");
        }
    }
?>