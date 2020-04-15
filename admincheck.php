<?php 
	session_start();
    
    if(array_key_exists('username',$_COOKIE) && $_COOKIE['role'] == 'admin'){
        $_SESSION['username'] = $_COOKIE['username'];
        $_SESSION['role'] = $_COOKIE['role'];
    }
    
    if(array_key_exists('username',$_SESSION) && $_SESSION['role'] == 'admin'){
        $logout_link = "index.php?logout=1";
        
    }else{
    	include('rolecheck.php');
        header('LOCATION:index.php');
        die();
    }
?>