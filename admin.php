<?php
	include("admincheck.php");
    
    include("include.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Pharmacy Manager</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="css/style.css">

	<style type="text/css">
		
	</style>

</head>
<body>
	<div id="main-container-pages">
    	    <nav class="navbar navbar-dark bg-danger" >
    	    	<button id="menu-toggler" style="padding:0;border:none"><img src="Images/menu.jpg" width="45" style="border-radius: 5px;float: left;"></button>
    	        <a class="navbar-brand py-2" href="#" id="top-bar">
    	            Pharmacy Manager
    	            <img src="Images/logo.jpg" id="logo" width="50" height="50" class="d-inline-block align-top" alt="Logo">
    	        </a>
    	    </nav>

    	    <div id="content">
    	    		<div class="images"><a href="dashboard.php"><img src="Images/dashboard.jpg" width="140" ><p>Dashboard</p></a></div>
    	    		<div class="images"><a href="users.php"><img src="Images/users.jpg" width="140" ><p>Users</p></a></div>
    	    		<div class="images"><a href="stocks.php"><img src="Images/stock.jpg" width="140" ><p>Stock</p></a></div>  	    		
    	    		<div class="images"><a href=<?php echo $logout_link; ?>><img src="Images/logout.jpg" width="140"><p>Logout</p></a></div>
    	    </div>

    </div>

	<div class="off">
		<a class="closebtn">&times;</a>
		<div id="mySidenav">
		  <a href="dashboard.php">Dashboard</a>
		  <a href="users.php">Users</a>
		  <a href="stocks.php">Stock</a>
		  <a href=<?php echo $logout_link; ?>>Log Out</a>
		</div>
	</div>
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<script type="text/javascript" src="js/script.js">
	</script>
</body>
</html>
