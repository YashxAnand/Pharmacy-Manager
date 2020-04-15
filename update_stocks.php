<?php
	session_start();
	include('include.php');

	if(array_key_exists("update", $_POST)){
		$query = "UPDATE stocks SET ".$_POST['column']."='".$_POST['update']."' WHERE id='".$_POST['med_id']."'";
		if(mysqli_query($connection,$query)){
		    }else{
		    	echo mysqli_error($connection);
		    }
		}

?>