<?php
	session_start();
	include('include.php');

	if(array_key_exists("delete", $_POST)){
		$query = "DELETE FROM users WHERE username='".mysqli_real_escape_string($connection,$_POST['delete'])."'";
		if(mysqli_query($connection,$query) && $_POST['delete'] != $_SESSION['username']){
			echo "Deleted";
		}else{
			echo "Can't delete this user as this user is currently logged in.";
		}
    }

?>