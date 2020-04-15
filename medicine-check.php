<?php 
    
    session_start();
    include("include.php");
    
    $error = "";
    $error_msg = "";
    $med_error = "";
    $error_name ="";
    if($_POST['name']){
        $name = $_POST['name'];
        $category = $_POST['category'];
        $units_available = $_POST['unitsAvailable'];
        $units_sold = $_POST['unitsSold'];
        $price = $_POST['price'];

        $query = "SELECT name FROM stocks WHERE name='".mysqli_real_escape_string($connection,$name)."'";
        
        $result = mysqli_query($connection,$query);
        
        if(mysqli_num_rows($result)>0){
            while($rows = mysqli_fetch_array($result)){
                if($rows['name'] == $name && $error_name==""){
                    $error_name.="<p>Medicine already in stock</p>";
                }
            }
             $error_msg="<div class='alert alert-danger' role='alert'><p><strong>There were following error(s) in signup form:</strong></p>".$error_name."</div>";
            
        }else{
            if($_POST['name'] == ""){
                $error.="<p>Name cannot be empty</p>";
            }

            if($_POST['category'] == ""){
                $error.="<p>Category cannot be empty</p>";
            }
            
            if($_POST['unitsAvailable'] == ""){
                $error.="<p>Units Available cannot be empty</p>";
                if(is_numeric($_POST['unitsAvailable']) || $_POST['unitsAvailable']<0){
                    $error.="<p>Units Available entry is invalid";
                }
            }
            
            if($_POST['unitsSold'] == ""){
                $error.="<p>Units Sold cannot be empty</p>";
                if(is_numeric($_POST['unitsSold']) || $_POST['unitsSold']<0){
                    $error.="<p>Units Sold entry is invalid";
                }
            }

            if($_POST['price'] == ""){
                $error.="<p>Price cannot be empty</p>";
                if(is_numeric($_POST['price']) || $_POST['price']<0){
                    $error.="<p>Price entry is invalid";
                }
            }
            
            if($error!=""){
                $error_msg="<div class='alert alert-danger' role='alert'><p><strong>There were following error(s) in signup form:</strong></p>".$error."</div>";

            }else{
                $query = "INSERT INTO stocks(name,category,price,units_available,units_sold) VALUES('".mysqli_real_escape_string($connection,$name)."','".mysqli_real_escape_string($connection,$category)."','".mysqli_real_escape_string($connection,$price)."','".mysqli_real_escape_string($connection,$units_available)."','".mysqli_real_escape_string($connection,$units_sold)."')";
            
                if($result = mysqli_query($connection, $query)){
                    echo "Medicine Added Successfully";
                }else{
                    $med_error.="<div class='alert alert-danger' role='alert'><p>There was a problem in adding the user.</p>".mysqli_error($connection)."</div>";
                }
            }
        }
    }

?>