<?php 
    session_start();
    
    if (!isset($_SESSION['userID'])){
        include "loginPage.html";
    } else{
        include "test.html";
    }
?>