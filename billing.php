<?php
    session_start();
    
    if(array_key_exists('username',$_COOKIE) && ($_COOKIE['role'] == 'pharmacist' || $_COOKIE['role'] == 'cashier')){
        $_SESSION['username'] = $_COOKIE['username'];
        $_SESSION['role'] = $_COOKIE['role'];
    }
    
    if(array_key_exists('username',$_SESSION) && ($_SESSION['role'] == 'pharmacist' || $_SESSION['role'] == 'cashier')){
        $logout_link = "'index.php?logout=1'";

        if($_SESSION['role'] == 'pharmacist'){
            $sidebar = "<a href='dashboard.php'>Dashboard</a><a href='stocks.php'>Stocks</a>";
        }

        if($_SESSION['role'] == 'cashier'){
            $sidebar = "";
        }
        
    }else{
    	include('rolecheck.php');
        header('LOCATION:index.php');
        die();
    }
    
    include('current_bill.php');

    include('invoice.php');

    if(array_key_exists("search", $_POST)){
        $table_head = "<tr><th>Invoice Number</th><th>Name</th><th>Phone</th><th>Total</th><th>Date & time </th><th>View</th></tr>";
        $table_row = "";

        $query = "SELECT * FROM customers WHERE number = '".$_POST['search']."' OR customer_name LIKE '%".$_POST['search']."%'";
        $result = mysqli_query($connection,$query);
        if(mysqli_num_rows($result)>0){
            
            while($row = mysqli_fetch_array($result)){
                $number = $row['number'];
                $customer_name = $row['customer_name'];
                $phone = $row['phone'];
                $total = $row['total'];
                $date = $row['date'];

                $table_row.="<tr><td >".$number."</td><td id='".$number."'>".$customer_name."</td><td id = 'phone".$number."'>".$phone."</td><td>".$total."</td><td id='date".$number."'>".$date."</td><td><button type='button' class='btn btn-success bill-btn view' name='".$number."'>View</button></td></tr>";
            }

        }else{
            echo "No result found";
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
                <?php echo $search_engine; ?>
    	        <a class="navbar-brand py-2" href="#" id="top-bar">
    	            Pharmacy Manager
    	            <img src="Images/logo.jpg" id="logo" width="50" height="50" class="d-inline-block align-top" alt="Logo">
    	        </a>
    	    </nav>

        <div id="bill-processing">
            <div id="stock-table">
                <?php echo $customer_Details; ?>
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
            <div id="create-bill-container"><?php echo $generate_bill; ?></div>
        </div>
        <div ></div>
    </div>

	<div class="off">
        <a class="closebtn">&times;</a>
        <div id="mySidenav">
          <a href="pharmacist.php">Home</a>
          <?php echo $sidebar; ?>
          <a href=<?php echo $logout_link; ?>>Log Out</a>
        </div>
    </div>
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<script type="text/javascript" src="js/billing_script.js">
	</script>
</body>
</html>
