<?php
	include('include.php');
	if(array_key_exists("customer_name", $_POST)){
		$customer_name = $_POST['customer_name'];
		$customer_mobile = $_POST['customer_mobile'];
		$total = $_POST['total'];
		$total_qty = $_POST['total_qty'];
		if($customer_mobile){
			$query = "INSERT INTO customers(customer_name,phone,total,total_qty) VALUES('".$customer_name."','".$customer_mobile."','".$total."','".$total_qty."')";
		}else{
			$query = "INSERT INTO customers(customer_name,phone,total) VALUES('".$customer_name."',NULL,'".$total."','".$total_qty."')";
		}
		mysqli_query($connection,$query);
	}

	if(array_key_exists('med_name', $_POST)){

		$med_name = $_POST['med_name'];
		$quantity = $_POST['quantity'];
		$price = $_POST['price'];
		$query = "SELECT (number) FROM customers ORDER BY number DESC LIMIT 0,1";
		$result = mysqli_query($connection,$query);

		if(mysqli_num_rows($result)>0){
			$row = mysqli_fetch_array($result);
			$invoice_number = $row['number'];

			$query = "INSERT INTO sells(invoice_number,med_name,quantity,price) VALUES('".$invoice_number."','".mysqli_real_escape_string($connection,$med_name)."','".$quantity."','".$price."')";

			if(mysqli_query($connection,$query)){
				$query = "UPDATE billing SET processed='1' WHERE name = '".mysqli_real_escape_string($connection,$med_name)."'";
				if(mysqli_query($connection,$query)){
					$query = "SELECT units_sold FROM stocks WHERE name = '".mysqli_real_escape_string($connection,$med_name)."'";
					$row = mysqli_fetch_array(mysqli_query($connection,$query));
					$sold = $row['units_sold']+$quantity;

					$query = "UPDATE stocks SET units_sold = '".$sold."' WHERE name = '".mysqli_real_escape_string($connection,$med_name)."'";
					mysqli_query($connection,$query);
				}
			}else{
				$query = "DELETE FROM customers WHERE number = '".$invoice_number."'";
				mysqli_query($connection,$query);
			}
		}
	}

?>