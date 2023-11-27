<?php
class DB {
    private $dbHost = "localhost";
    private $dbUsername = "root";
    private $dbPassword = "";
    private $dbName = "ojt_monitoring";

    public function __construct(){
        if(!isset($this -> db)){
            $connect = new mysqli($this -> dbHost, $this -> dbUsername, $this -> dbPassword, $this -> dbName);
            if($connect -> connect_error){
                die("Failed to connect with mySQL: " . $connect -> connect_error)
            } else{
                $this -> db = $connect;
            }
        }
    }
}

?>