<?php
    session_start();
    
    if(array_key_exists('username',$_COOKIE) && $_COOKIE['role'] == 'cashier'){
        $_SESSION['username'] = $_COOKIE['username'];
        $_SESSION['role'] = $_COOKIE['role'];
    }
    
    if(array_key_exists('username',$_SESSION) && $_SESSION['role'] == 'cashier'){
        $logout_link = "<a href='index.php?logout=1'>Log out</a>";
        
    }else{
    	include('rolecheck.php');
        header('LOCATION:index.php');
        die();
    }
    
    include("include.php");

    $query = "DELETE FROM billing WHERE processed = '1'";
    mysqli_query($connection,$query);

    if(array_key_exists("search", $_POST)){
        $content = "";
        $query = "SELECT * FROM stocks WHERE name LIKE '%".mysqli_real_escape_string($connection,$_POST['search'])."%' OR category LIKE '%".mysqli_real_escape_string($connection,$_POST['search'])."%'";
        $result = mysqli_query($connection,$query);
        if(mysqli_num_rows($result)){
            $count=1;
            $table_row="";
            while($row = mysqli_fetch_array($result)){
                $id= $row['id'];
                $category = $row['category'];
                $name = $row['name'];
                $price = $row['price'];
                $units_avl = $row['units_available'];
                $units_sold = $row['units_sold'];

                $table_head = "<tr><th scope='col'>S.No.</th><th scope='col'>Name</th><th scope='col'>Category</th><th scope='col'>Available</th><th scope='col'>Price</th><th scope='col'>Quantity</th><th>Add for Billing</th></tr>";
                $table_row.="<tr><th scope='row'>".$count."</th><td id='med".$id."'>".$name."</td><td>".$category."</td><td id='available".$id."'>".$units_avl."</td><td id='price".$id."'>Rs. ".$price."</td><td><input type='number' class='quantity' id='quantity".$id."' min='0' value='0'></td><td><button type='button' class='btn btn-success bill-btn' name='add".$id."'>Add</button></td></tr>";
                $count+=1;
            }
        }else{
            $table_row="<div class='alert alert-danger' role='alert'><p><strong>Sorry no results found.</p></strong></div>";
            $content = $div;
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Pharmacy Manager</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="css/style.css">

</head>
<body>
	<div id="main-container-pages">
    	    <nav class="navbar navbar-dark bg-danger" >
    	    	<button id="menu-toggler" style="padding:0;border:none"><img src="Images/menu.jpg" width="45" style="border-radius: 5px;float: left;"></button>
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

            <div id="stock-table">
                <form method="post">
                    <table class="table table-bordered">
                      <thead>
                        <?php echo $table_head; ?>
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
		  <a href="billing.php">Billing</a>
		  <a href="#">Cashier</a>
		  <?php echo $logout_link; ?>
		</div>
	</div>
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<script type="text/javascript" src="js/script.js">
	</script>
</body>
</html>
