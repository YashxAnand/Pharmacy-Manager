<?php 
    
    error_reporting(E_ALL &~ E_NOTICE);
    $connection = mysqli_connect("localhost","root","","yash");
    
    if(mysqli_connect_error()){
        die("Database connection failed");
    }
    
?>