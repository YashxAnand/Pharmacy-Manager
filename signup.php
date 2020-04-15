<?php 
    
    session_start();
    include("include.php");
    
    $error = "";
    $error_msg = "";
    $signup_error = "";
    $error_username ="";
    $error_email="";
    if($_POST){
        $first_name = $_POST['first-name'];
        $last_name = $_POST['last-name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $mobile = $_POST['mobile'];
        $role = $_POST['role'];

        $query = "SELECT username,email FROM users  where username='".mysqli_real_escape_string($connection,$username)."' OR email='".mysqli_real_escape_string($connection,$email)."'";
        
        $result = mysqli_query($connection,$query);
        
        if(mysqli_num_rows($result)>0){
            while($rows = mysqli_fetch_array($result)){
                if(strtolower($rows['username']) == strtolower($username) && $error_username==""){
                    $error_username.="<p>Username already taken</p>";
                }
                
                if(strtolower($rows['email']) == strtolower($email) && $error_email==""){
                    $error_email.="<p>Email already in use</p>";
                }
            }
             $error_msg="<div class='alert alert-danger' role='alert'><p><strong>There were following error(s) in signup form:</strong></p>".$error_username.$error_email."</div>";
            
        }else{
            if($_POST['username'] == ""){
                $error.="<p>Username cannot be empty</p>";
            }
            
            if($_POST['password'] == ""){
                $error.="<p>Password cannot be empty</p>";
            }
            
            if($_POST['first-name'] == ""){
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

            if($_POST['role'] == ""){
                $error.="<p>Role cannot be empty</p>";
            }
            
            if($error!=""){
                $error_msg="<div class='alert alert-danger' role='alert'><p><strong>There were following error(s) in signup form:</strong></p>".$error."</div>";

            }else{
                $query = "INSERT INTO users(first_name, last_name, username, email, password, mobile,role) VALUES('".mysqli_real_escape_string($connection,$first_name)."','".mysqli_real_escape_string($connection,$last_name)."','".mysqli_real_escape_string($connection,$username)."','".mysqli_real_escape_string($connection,$email)."','".mysqli_real_escape_string($connection,$password)."','".mysqli_real_escape_string($connection,$mobile)."','".mysqli_real_escape_string($connection,$role)."')";
            
                if($result = mysqli_query($connection, $query)){
                    $query = "SELECT id FROM users WHERE username='".mysqli_real_escape_string($connection,$username)."'";
                    $result = mysqli_query($connection, $query);
                    $row = mysqli_fetch_array($result);
                    $password=md5(md5($row['id']).$password);
                    $query = "UPDATE users SET password = '".$password."' WHERE id='".$row['id']."'";
                    mysqli_query($connection,$query);
                    $_SESSION['username'] = $username;
                    $_SESSION['role'] = $role;
                    include('rolecheck.php');
                    
                }else{
                    $signup_error.="<div class='alert alert-danger' role='alert'><p>There was a problem in adding the user.</p>".mysqli_error($connection)."</div>";
                }
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
	<div id="main-container">
    	    <nav class="navbar navbar-dark bg-danger" >
    	        <a class="navbar-brand py-2" href="#" id="top-bar">
    	            <img src="Images/logo.jpg" id="logo" width="50" height="50" class="d-inline-block align-top" alt="Logo">
    	            Pharmacy Manager
    	        </a>
    	    </nav>
    	

    	<div id="signup-container" class="shadow p-3 mb-5 bg-white rounded">
    	    <form id="sign-up" method="post">
    	        <p align="center" style="font-size: 270%;">Sign Up</p>
    	        <div><?php echo $error_msg.$signup_error; ?></div>
    	            <div class="form-group">
    	                <label for="first-name">First Name</label>
    	                <input type="text" class="form-control" id="first-name" name="first-name" required>
    	            </div>
    	            <div class="form-group">
    	                <label for="last-name">Last Name</label>
    	                <input type="text" class="form-control" id="last-name" name="last-name">
    	            </div>
    	            <div class="form-group">
    	                <label for="username">Username</label>
    	                <div class="input-group">
    	                    <input type="text" class="form-control" id="username" aria-describedby="inputGroupPrepend2"  name="username" required>
    	                </div>
    	            </div>
    	            <div class="form-group">
    	                <label for="email">Email</label>
    	                <input type="email" class="form-control" id="email" name="email" required>
    	            </div>
    	            <div class="form-group">
    	                <label for="password">Password</label>
    	                <input type="password" class="form-control" id="password" name="password" required>
    	            </div>
    	            <div class="form-group">
    	                <label for="mobile">Mobile</label>
    	                <input type="text" id="mobile" maxlength="14" data-fv-numeric="true" data-fv-numeric-message="Please enter valid phone numbers" data-fv-phone-country11="IN" data-fv-notempty-message="This field cannot be left blank." class="form-control" name="mobile" required>
    	            </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select name="role" id="role" required>
                            <option value="">Select a role</option>
                            <option value="pharmacist">Pharmacist</option>
                            <option value="cashier">Cashier</option>
                        </select>
                    </div>
    	            <button class="btn btn-success" type="submit">Sign Up</button>
    	    </form>
    	</div>
    </div>

	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<script type="text/javascript">
	</script>
</body>
</html>