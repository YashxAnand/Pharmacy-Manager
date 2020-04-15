<?php
    include('include.php');

    $query = "SELECT * FROM users WHERE username='".$_GET['username']."'";
    if(!($result=mysqli_query($connection,$query))){
        echo mysqli_error($connection);
    }

    $row = mysqli_fetch_array($result);
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $username = $row['username'];
    $email = $row['email'];
    $mobile = $row['mobile'];

    if(array_key_exists("firstName", $_POST)){
            $error = "";

            $query="";
            if($_POST['username'] == ""){
                $error.="<p>Username cannot be empty</p>";
            }
            
            if($_POST['firstName'] == ""){
                $error.="<p>First Name cannot be empty</p>";
            }
            
            if($_POST['email'] == ""){
                $error.="<p>Email cannot be empty</p>";
            }
            
            if($_POST['email'] && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $error.="<p>Invalid email</p>";
            }
            
            if($_POST['mobile'] == ""){
                $error.="<p>Mobile cannot be empty</p>";
            }
            
            if($error!=""){
                $error_msg="<div class='alert alert-danger' role='alert'><p><strong>There were following error(s) in signup form:</strong></p>".$error."</div>";
            }else{

                if($_POST['username']!=$username && $_POST['email'] != $email){
                    $query = "SELECT first_name FROM users WHERE username = '".$_POST['username']."' OR email = '".$_POST['email']."'";
                    $error = "<p>Username & Email already exists</p>";
                    }else{
                        if($_POST['username']!=$username){
                            $query = "SELECT first_name FROM users WHERE username = '".$_POST['username']."'";
                            $error = "<p>Username already exists</p>";
                            }

                        if($_POST['email']!=$email){
                            $query = "SELECT first_name FROM users WHERE email = '".$_POST['email']."'";
                            $error = "<p>Email already exists</p>";
                            }

                    }

                    if($query!=""){
                        $result = mysqli_query($connection,$query);

                        if(mysqli_num_rows($result)>0){
                            $error_msg="<div class='alert alert-danger' role='alert'><p><strong>There were following error(s) in signup form:</strong></p>".$error."</div>";
                            }else{
                                $query = "UPDATE users SET username='".$_POST['username']."', first_name='".$_POST['firstName']."',last_name='".$_POST['lastName']."',email='".$_POST['email']."',mobile='".$_POST['mobile']."' WHERE username = '".$username."'";

                                if(!($result = mysqli_query($connection,$query))){
                                    echo mysqli_error($connection);
                                }
                                $success_msg = "<div class='alert alert-success' role='alert'><p><strong>Profile edited successfully</strong></p></div>";
                            }
                    }else{
                        $query = "UPDATE users SET first_name='".$_POST['firstName']."',last_name='".$_POST['lastName']."',mobile='".$_POST['mobile']."' WHERE username = '".$username."'";
                        if(!($result = mysqli_query($connection,$query))){
                                    echo mysqli_error($connection);
                                }
                                $success_msg = "<div class='alert alert-success' role='alert'><p><strong>Profile edited successfully</strong></p></div>";
                    }
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
    <p id="edit-user-title">Edit User</p>
        <div id="edit-user-container" class="shadow p-3 mb-5 bg-white rounded">
            <?php echo $error_msg.$success_msg; ?>
            <form method="post" style="font-size: 100%;">
                
                    <div class="col">
                        <div class="row">
                            <label for="firstName">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" value=<?php echo $first_name; ?> required>
                        </div>
                        <div class="row">
                            <label for="lastName">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" value=<?php echo $last_name; ?>>
                        </div>
                        <div class="row">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" aria-describedby="inputGroupPrepend2"  name="username" value=<?php echo $username; ?> required>
                        </div>
                        <div class="row">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value=<?php echo $email; ?> required>
                        </div>
                        <div class="row">
                            <label for="mobile">Mobile</label>
                            <input type="text" id="mobile" maxlength="14" data-fv-numeric="true" data-fv-numeric-message="Please enter valid phone numbers" data-fv-phone-country11="IN" data-fv-notempty-message="This field cannot be left blank." class="form-control" name="mobile" value=<?php echo $mobile; ?> required>
                        </div>
                    <br>
                    <button class="btn btn-success" type="submit" id="submit-edit">Edit</button>
            </form>
        </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <script type="text/javascript" src="js/script.js">
    </script>
</body>
</html>
