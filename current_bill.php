<?php
	 include('bill.php');

    $search_engine = '<div style="padding:0"><form class="form-inline" method="post"><div class="form-group mx-sm-3 mb-2"><input type="text" class="form-control" id="search" name="search" placeholder="Search bill"></div><button type="submit" id="submit-search" name="submit-search" class="btn btn-success mb-2">Search</button></form></div>';

    $query = "SELECT * FROM billing";
    if(!$result = mysqli_query($connection,$query)){
        echo "Error connecting to database";
    }

    $result = mysqli_query($connection, $query);
    $table_row = "";
    $count = 1;
    while($row = mysqli_fetch_array($result)){
        $search_engine = "";
        $customer_Details = '<div class="row customer-details">
                    <div class="col">
                        <label for="customer-name">Customer Name</label>
                        <input type="text" class="form-control" id="customer-name" placeholder="Full Name" required>
                    </div>
                    <div class="col">
                        <label for="mobile">Phone</label>
                        <input type="text" id="customer-mobile" maxlength="10" data-fv-numeric="true" data-fv-numeric-message="Please enter valid phone numbers" data-fv-phone-country11="IN" data-fv-notempty-message="This field cannot be left blank." class="form-control" name="customer-mobile" placeholder="Mobile No." required>
                    </div>
                </div>';

        $generate_bill = "<button type='button' id = 'generate-bill' class = 'btn btn-success'>Generate Bill</button>";
        $id = $row['id'];
        $name = $row['name'];
        $price = $row['price'];
        $quantity = $row['quantity'];
        $table_head = "<tr><th scope='col'>S.No.</th><th scope='col'>Name</th><th scope='col'>Price</th><th scope='col'>Quantity</th><th scope='col'>Update</th></tr>";
        $table_row.="<tr id='row".$id."'><th scope='row' name='".$id."' class='".$count."'>".$count."</th><td id='name".$id."'>".$name."</td><td id='price".$id."'>Rs. ".$price."</td><td><input class='quantity' id='quantity".$id."' type='number' min='0' name='".$quantity."' value='".$quantity."'></td><td><input type='button' class='update bill' name='".$id."'></tr>";

        $table_row_receipt.="<tr id='row".$id."'><th scope='row' name='".$id."' class='".$count."'>".$count."</th><td id='name".$id."'>".$name."</td><td id='price".$id."'>Rs. ".$price."</td><td>".$quantity."</td><td>".($price*$quantity)."</td></tr>";

        $total+=$price*$quantity;
        $count+=1;
    }

    $gst = 0.12*$total;
    $net = $total+$gst;
?>