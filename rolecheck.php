<?php 
	error_reporting(E_ALL &~ E_NOTICE);

	if($_SESSION['role'] == "admin" || $_COOKIE['role'] == 'admin'){
		header('Location:admin.php');
	}

	if($_SESSION['role'] == "pharmacist" || $_COOKIE['role'] == 'pharmacist'){
		header('Location:pharmacist.php');
	}

	if($_SESSION['role'] == "cashier" || $_COOKIE['role'] == 'cashier'){
		header('Location:cashier.php');
	}
?>