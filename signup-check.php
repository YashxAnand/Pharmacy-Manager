<?php 
    
    session_start();
    include("include.php");
    
    $error = "";
    $error_msg = "";
    $signup_error = "";
    $error_username ="";
    $error_email="";
    if($_POST){
        $first_name = $_POST['firstName'];
        $last_name = $_POST['lastName'];
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
                    echo "User Added Successfully";
                    
                }else{
                    $signup_error.="<div class='alert alert-danger' role='alert'><p>There was a problem in adding the user.</p>".mysqli_error($connection)."</div>";
                }
            }
        }
    }

?>