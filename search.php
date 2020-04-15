<?php
	if(array_key_exists("search", $_POST)){
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

				$table_row.="<tr><th scope='row'>".$count."</th><td>".$name."</td><td>".$category."</td><td><input type='text' class='editable units_available' value='".$units_avl."'></td><td><input type='text' class='editable units_sold' value='".$units_sold."'></td><td>Rs.<input type='text' class='editable price' value='".$price."'></td><td><input type='button' class='delete stocks' name='".$id."'></td></tr>";
				$count+=1;
			}
		}else{
			$table_row="<div class='alert alert-danger' role='alert'><p><strong>Sorry no results found.</p></strong></div>";
		}
	}
?>