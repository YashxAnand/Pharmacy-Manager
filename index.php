<?php 
    
    session_start();
    include("include.php");
    
    if(array_key_exists('logout',$_GET)){
        unset($_SESSION['username']);
        unset($_SESSION['role']);
        setcookie('username','',time()-60*60*24);
        $_COOKIE['username'] = '';
        setcookie('role','',time()-60*60*24);
        $_COOKIE['role'] = '';
    }else if(array_key_exists('username',$_SESSION) || array_key_exists('username', $_COOKIE)){
        include('rolecheck.php');
    }
    
    $error = "";
    $error_msg = "";
    if($_POST){
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $query = "SELECT id,password FROM users WHERE username='".mysqli_real_escape_string($connection,$username)."' LIMIT 1";
        
        $result = mysqli_query($connection, $query);
        
        if($_POST['username'] == ""){
            $error.="<p>Username cannot be empty</p>";
        }
        
        if($_POST['password'] == ""){
            $error.="<p>Password cannot be empty</p>";
        }
        
        if(mysqli_num_rows($result)>0){
            
            $row = mysqli_fetch_array($result);
            
            if($row['password'] == md5(md5($row['id']).$password)){
                $query = "SELECT role FROM users WHERE username = '".mysqli_real_escape_string($connection,$username)."'";
                $result = mysqli_query($connection, $query);
                $row = mysqli_fetch_array($result);
                $role = $row['role'];

                if($_POST['stayLoggedIn'] == 'on'){
                    setcookie("username",$username, time()+60*60*24*365);
                    setcookie("role",$role,time()+60*60*24*365);
                }
            
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;
                include('rolecheck.php');
            }else{
                $error.="<p>Incorrect password!</p>";
            }
        }elseif($username!=""){
            $error.="<p>Username is incorrect!</p>";
        }
        
        if($error!=""){
            $error_msg="<div class='alert alert-danger' role='alert'>".$error."</div>";
        }
    }

?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>

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
    	

    	<div  id="login-container" class="shadow p-3 mb-5 bg-white rounded" >
    		<form id="login" method="post">
    			<p align="center" style="font-size: 270%;">Login</p>
    			<div class="error"><?php echo $error_msg; ?></div>
    		    <div class="form-group">
    		        <label for="username">Username</label>
    		        <input type="text" class="form-control" id="username" name="username" required>
    		    </div>
    		    <div class="form-group">
    		        <label for="password">Password</label>
    		        <input type="password" class="form-control" id="password" name="password" required>
    		    </div>
    		    <p><a href="signup.php">Create Account</a></p>
    		    <p><input type="checkbox" name="stayLoggedIn" id="stayLoggedIn">Keep me logged in</p>
    		    <button type="submit" class="btn btn-success">Login</button>
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