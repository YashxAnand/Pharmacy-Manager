<?php 
	session_start();

    
    if(array_key_exists('username',$_COOKIE) && ($_COOKIE['role'] == 'pharmacist' || $_COOKIE['role'] == 'cashier')){
        $_SESSION['username'] = $_COOKIE['username'];
        $_SESSION['role'] = $_COOKIE['role'];
    }
    
    if(array_key_exists('username',$_SESSION) && ($_SESSION['role'] == 'pharmacist' || $_SESSION['role'] == 'cashier')){
        $logout_link = "'index.php?logout=1'";
        
    }else{
    	include('rolecheck.php');
        header('LOCATION:index.php');
        die();
    }

    include('include.php');

        $query = "SELECT med_name,quantity,price FROM sells WHERE invoice_number = '".$_GET['invoice']."'";
        if(!$result = mysqli_query($connection,$query)){
            echo "Error connecting to database";
        }

        $result = mysqli_query($connection, $query);
        $table_row_receipt = "";
        $count = 1;

        while($row = mysqli_fetch_array($result)){
	        $name = $row['med_name'];
	        $price = $row['price'];
	        $quantity = $row['quantity'];

	        $table_row_receipt.="<tr id='row".$id."'><th scope='row' name='".$id."' class='".$count."'>".$count."</th><td id='name".$id."'>".$name."</td><td id='price".$id."'>Rs. ".$price."</td><td>".$quantity."</td><td>".($price*$quantity)."</td></tr>";

	        $total+=$price*$quantity;
	        $count+=1;
    }

	    $gst = 0.12*$total;
	    $net = $total+$gst;
?>

<!DOCTYPE html>
<html>
<head>
	<title>Pharmacy Manager</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<link rel="stylesheet" href="css/style.css">

	<style type="text/css">
		body{
			background-color:white !important;
		}
	</style>
</head>
<body>
	<p id="invoice-title">Tax Invoice</p>
	<div id="address-container">
		<p id="address-head">ABC Pharmacy</p>
		<div id="address-body">
			<p>Address line 1<br>Address line 2<br>City<br>Tel: 2398732</p>
		</div>
	</div>

	<div id="customer-details">
		<p >Invoice Number:<?php echo $_GET['invoice'];?><br><?php echo $_GET['customer'];?><br><?php echo $_GET['phone'];?><br>Date:<?php echo $_GET['date'];?></p>
	</div>

	<div class='clear'></div>

	<table class="table table-striped" id="receipt-body">
	  <thead>
	    <tr>
	      <th scope="col">S.No.</th>
	      <th scope="col">Medicine Name</th>
	      <th scope="col">Base Price</th>
	      <th scope="col">Quantity</th>
	      <th scope="col">Amount</th>
	    </tr>
	  </thead>
	  <tbody>
	    <tr>
	      <?php echo $table_row_receipt; ?>
	      <th scope="row">Total</th>
	      <td></td>
	      <td></td>
	      <td></td>
	      <td><?php echo $total; ?>
</td>
	    </tr>
	    <tr>
	      <th scope="row">SGST(6% on Total)</th>
	      <td></td>
	      <td></td>
	      <td></td>
	      <td><?php echo $gst; ?>
</td>
	    </tr>
	    <tr>
	      <th scope="row">SGST(6% on Total)</th>
	      <td></td>
	      <td></td>
	      <td></td>
	      <td><?php echo $gst; ?>
</td>
	    </tr>
	    <tr>
	      <th scope="row">Net Amount</th>
	      <td></td>
	      <td></td>
	      <td></td>
	      <td><?php echo $net; ?>
</td>
	    </tr>
	  </tbody>
	</table>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<script type="text/javascript" src="script.js">
	</script>
</body>
</html>