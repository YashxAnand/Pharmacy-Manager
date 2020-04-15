<?php
include("admincheck.php");

include("include.php");

//admin table
$query = "SELECT first_name, last_name, username FROM users WHERE role = 'admin'";
$result = mysqli_query($connection, $query);
$table_row = "";
$count = 1;
while ($row = mysqli_fetch_array($result)) {
	$first_name = $row['first_name'];
	$last_name = $row['last_name'];
	$username = $row['username'];
	$table_row .= "<tr><th scope='row'>" . $count . "</th><td>" . $first_name . "</td><td>" . $last_name . "</td><td>" . $username . "</td><td><a href='edit-user.php' target='popup' onclick='window.open(\"edit-user.php?username=" . $username . "\",\"edit-user\",\"width=600,height=600\")'><input type='button' class='edit' name='" . $username . "'></a></td><td><input type='button' class='delete' name='" . $username . "'></td></tr>";
	$count += 1;
}

//pharmacist table
$query = "SELECT first_name, last_name, username FROM users WHERE role = 'pharmacist'";
$result = mysqli_query($connection, $query);
$table_row_pharmacist = "";
$count = 1;
while ($row = mysqli_fetch_array($result)) {
	$first_name = $row['first_name'];
	$last_name = $row['last_name'];
	$username = $row['username'];
	$table_row_pharmacist .= "<tr><th scope='row'>" . $count . "</th><td>" . $first_name . "</td><td>" . $last_name . "</td><td>" . $username . "</td><td><a href='edit-user.php' target='popup' onclick='window.open(\"edit-user.php?username=" . $username . "\",\"edit-user\",\"width=600,height=600\")'><input type='button' class='edit' name='" . $username . "'></a></td><td><input type='button' class='delete' name='" . $username . "'></td></tr>";
	$count += 1;
}

//cashier table
$query = "SELECT first_name, last_name, username FROM users WHERE role = 'cashier'";
$result = mysqli_query($connection, $query);
$table_row_cashier = "";
$count = 1;
while ($row = mysqli_fetch_array($result)) {
	$first_name = $row['first_name'];
	$last_name = $row['last_name'];
	$username = $row['username'];
	$table_row_cashier .= "<tr><th scope='row'>" . $count . "</th><td>" . $first_name . "</td><td>" . $last_name . "</td><td>" . $username . "</td><td><a href='edit-user.php' target='popup' onclick='window.open(\"edit-user.php?username=" . $username . "\",\"edit-user\",\"width=600,height=600\")'><input type='button' class='edit' name='" . $username . "'></a></td><td><input type='button' class='delete' name='" . $username . "'></td></tr>";
	$count += 1;
}

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

	<div id="add-user">
		<p align="center" style="font-size: 130%;">Add User</p>
		<?php include('signup-container.php') ?>
	</div>

	<div id="main-container-pages" style="position: relative;z-index: 0;">
		<nav class="navbar navbar-dark bg-danger">
			<button type="button" id="menu-toggler" style="padding:0;border:none"><img src="Images/menu.jpg" width="45" style="border-radius: 5px;float: left;"></button>
			<a class="navbar-brand py-2" href="#" id="top-bar">
				Pharmacy Manager
				<img src="Images/logo.jpg" id="logo" width="50" height="50" class="d-inline-block align-top" alt="Logo">
			</a>
		</nav>

		<div class="error_notice"><?php echo $error_msg . $signup_error; ?></div>

		<form id="users-tab" method="post">
			<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-Admin" role="tab" aria-controls="pills-Admin" aria-selected="true">Admin</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-Pharmacist" role="tab" aria-controls="pills-Pharmacist" aria-selected="false">Pharmacist</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-Cashier" role="tab" aria-controls="pills-Cashier" aria-selected="false">Cashier</a>
				</li>
			</ul>

			<div class="tab-content shadow p-3 mb-5 bg-white rounded" id="pills-tabContent">
				<div class="tab-pane fade show active" id="pills-Admin" role="tabpanel" aria-labelledby="pills-Admin-tab">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th scope="col">S.No.</th>
								<th scope="col">First Name</th>
								<th scope="col">Last Name</th>
								<th scope="col">Username</th>
								<th scope="col">Edit</th>
								<th scope="col">Delete</th>
							</tr>
						</thead>
						<tbody>
							<?php echo $table_row; ?>
						</tbody>
					</table>
				</div>
				<div class="tab-pane fade" id="pills-Pharmacist" role="tabpanel" aria-labelledby="pills-Pharmacist-tab">
					<table class="table table-bordered">
						<thead>
							<th scope="col">S.No.</th>
							<th scope="col">First Name</th>
							<th scope="col">Last Name</th>
							<th scope="col">Username</th>
							<th scope="col">Edit</th>
							<th scope="col">Delete</th>
						</thead>
						<tbody>
							<?php echo $table_row_pharmacist; ?>
						</tbody>
					</table>
				</div>
				<div class="tab-pane fade" id="pills-Cashier" role="tabpanel" aria-labelledby="pills-Cashier-tab">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th scope="col">S.No.</th>
								<th scope="col">First Name</th>
								<th scope="col">Last Name</th>
								<th scope="col">Username</th>
								<th scope="col">Edit</th>
								<th scope="col">Delete</th>
							</tr>
						</thead>
						<tbody>
							<?php echo $table_row_cashier; ?>
						</tbody>
					</table>
				</div>
				<button type="button" class="btn btn-success" name='cashier' id='add-user-btn'>Add User</button>
			</div>
		</form>
	</div>

	<div class="off">
		<a class="closebtn">&times;</a>
		<div id="mySidenav">
			<a href="admin.php">Home</a>
			<a href="dashboard.php">Dashboard</a>
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