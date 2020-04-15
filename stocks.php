<?php
    session_start();
    
    if(array_key_exists('username',$_COOKIE) && ($_COOKIE['role'] == 'admin' || $_COOKIE['role'] == 'pharmacist')){
        $_SESSION['username'] = $_COOKIE['username'];
        $_SESSION['role'] = $_COOKIE['role'];
    }
    
    if(array_key_exists('username',$_SESSION) && ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'pharmacist')){
        $logout_link = "index.php?logout=1";

        if($_SESSION['role'] == 'pharmacist'){
            $sidebar = "<a href='billing.php'>Billing</a>";
        }

        if($_SESSION['role'] == 'admin'){
            $sidebar = "<a href='users.php'>Users</a>";
        }
        
    }else{
    	include('rolecheck.php');
        header('LOCATION:index.php');
        die();
    }
    include("include.php");

    $query = "SELECT * FROM stocks";
    if(!$result = mysqli_query($connection,$query)){
		echo "Error connecting to database";
	}

    $result = mysqli_query($connection, $query);
    $table_row = "";
    $count = 1;
    while($row = mysqli_fetch_array($result)){
    	$id = $row['id'];
    	$category = $row['category'];
    	$name = $row['name'];
	    $units_avl = $row['units_available'];
	    $units_sold = $row['units_sold'];
	    $price = $row['price'];
	    $table_row.="<tr><th scope='row'>".$count."</th><td>".$name."</td><td>".$category."</td><td><input type='text' class='editable units_available' value='".$units_avl."' name='".$id."'></td><td><input type='text' class='editable units_sold' value='".$units_sold."' name='".$id."'></td><td>Rs.<input type='text' class='editable price' value='".$price."' name='".$id."'></td><td><input type='button' class='delete stocks' name='".$id."'></td></tr>";
	    $count+=1;
    }

    include('search.php')
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
	<div id="dialog">
		<p>Are you sure, you want to delete user?</p>
		<br>
		<button type="button" class="btn btn-danger" id="yes">Yes</button>
		<button type="button" class="btn btn-success" id="no">No</button>
	</div>

	<div id="add-medicine">
		<p align="center" style="font-size: 130%;">Add Medicine</p>
		<?php include('add-medicine-container.php') ?>
	</div>

	<div id="main-container-pages" style="position: relative;z-index: 0;">
    	    <nav class="navbar navbar-dark bg-danger" >
    	    	<button type="button" id="menu-toggler" style="padding:0;border:none"><img src="Images/menu.jpg" width="45" style="border-radius: 5px;float: left;"></button>
    	    	<div style="padding:0">
    	    		<form class="form-inline" method='post'>
					  <div class="form-group mx-sm-3 mb-2">
					    <input type="text" class="form-control" id="search" name="search" placeholder="Search medicine">
					  </div>
					  <button type="submit" id="submit-search" name="submit-search" class="btn btn-success mb-2">Search</button>
					</form>
    	    	</div>
    	        <a class="navbar-brand py-2" href="#" id="top-bar">
    	            Pharmacy Manager
    	            <img src="Images/logo.jpg" id="logo" width="50" height="50" class="d-inline-block align-top" alt="Logo">
    	        </a>
    	    </nav>

			<div id="add-container">
				<button type="button" class="btn btn-success" name='cashier' id='add-med-btn'>Add Medicine</button>
			</div>

    	    <div class='error_notice'><?php echo $error_msg.$med_error; ?></div>
    	    
    	    <div id="stock-table">
	    	    <form method="post">
		    	    <table class="table table-bordered">
					  <thead>
					    <tr>
					      <th scope="col">S.No.</th>
					      <th scope="col">Name</th>
					      <th scope="col">Category</th>
					      <th scope="col">Available</th>
					      <th scope="col">Sold</th>
					      <th scope="col">Price</th>
					      <th scoper="col">Delete</th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php echo $table_row; ?>
					  </tbody>
					</table>
				</form>
			</div>
    </div>

	<div class="off">
		<a class="closebtn">&times;</a>
		<div id="mySidenav">
		  <a href="admin.php">Home</a>
		  <a href="dashboard.php">Dashboard</a>
		  <?php echo $sidebar; ?>
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
