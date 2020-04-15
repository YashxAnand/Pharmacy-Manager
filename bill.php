<?php
	include("include.php");

    if(array_key_exists("name", $_POST)){
        $name = $_POST['name'];
        $available = $_POST['available'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];

        $new_avl = $available-$quantity;
        $query = "UPDATE stocks SET units_available = '".$new_avl."' WHERE name = '".mysqli_real_escape_string($connection,$name)."'";
        mysqli_query($connection,$query);

        $query = "SELECT quantity FROM billing WHERE name='".mysqli_real_escape_string($connection,$name)."'";
        $result = mysqli_query($connection,$query);

        if(mysqli_num_rows($result)>0){
            $row = mysqli_fetch_array($result);
            $curr_quantity = $row['quantity'];
            $curr_quantity = $curr_quantity + $quantity;

            $query = "UPDATE billing SET quantity = '".$curr_quantity."' WHERE name = '".mysqli_real_escape_string($connection,$name)."'";
            mysqli_query($connection,$query);
            echo "updated";
        }else{

            $query = "INSERT INTO billing(name,price,quantity) VALUES('".mysqli_real_escape_string($connection,$name)."','".$price."','".$quantity."')";
            if(mysqli_query($connection,$query)){
                echo "Added";
            }else{
                echo "Couldn't add item please try again";
                $query = "UPDATE stocks SET units_available = '".$available."' WHERE name = '".mysqli_real_escape_string($connection,$name)."'";
                mysqli_query($connection,$query);
            }
        }
    }

    if(array_key_exists('change', $_POST)){
        $name = $_POST['nameUpdate'];
        $change = $_POST['change'];
        $value = $_POST['quantity'];

        $query = "SELECT units_available FROM stocks WHERE name = '".mysqli_real_escape_string($connection,$name)."'";
        $result = mysqli_query($connection,$query);
        $row = mysqli_fetch_array($result);
        $availability = $row['units_available'];

        if($change<=$availability){

            $availability-=$change;
            $query = "UPDATE stocks SET units_available = '".$availability."' WHERE name = '".mysqli_real_escape_string($connection,$name)."'";
            mysqli_query($connection,$query);

            if($value==0){
                $query = "DELETE FROM billing WHERE name = '".mysqli_real_escape_string($connection,$name)."'";
                if(mysqli_query($connection,$query)){
                    echo "Updated";
                }
            }else{
                $query = "UPDATE billing SET quantity = '".$value."' WHERE name = '".mysqli_real_escape_string($connection,$name)."'";
                if(mysqli_query($connection,$query)){
                    echo "Updated";
                }
            }
        }else{
            echo "Quantity not available in stock.";
        }
    }
?>