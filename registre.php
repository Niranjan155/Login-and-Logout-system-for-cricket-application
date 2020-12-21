<?php
require_once "config.php";
$username=$password=$confirm_password="";
$username_err=$password_err=$confirm_password_err="";
if($_SERVER['REQUEST_METHOD']=="POST")
{
    if(empty(trim($_POST["username"]))){
        $username_err="Username cannot be blank";
    }
    else{
        $sql="SELECT id FROM users WHERE username=?";
        $stmt=mysqli_prepare($conn,$sql);
        if($stmt){


            mysqli_stmt_bind_param($stmt,"s",$param_username);
            //set value of username
            $param_username=trim($_POST['username']);
            //try to execute statement
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt)==1){
                    $username_err="This username is already taken";
                }
                else{
                    $username=trim($_POST['username']);
                }
            }
            else{
                echo "Something went wrong";
            }
        }
    }
    mysqli_stmt_close($stmt);


if(empty(trim($_POST['password']))){
    $password_err="Password cannot be blank";
}
elseif(strlen(trim($_POST['password']))<5){
    $password_err="Password cannot be less than 5";
}
else{
    $password=trim($_POST['password']);
}
//checking for confirm password
if(trim($_POST['confirm_password'])!=trim($_POST['password'])){
    $password_err="Password should match";
}
if(empty($username_err)&&empty($password_err)&&empty($confirm_password_err)){
    $sql="INSERT INTO users (username,password) VALUES (?,?)";
    $stmt= mysqli_prepare($conn,$sql);
    if($stmt){
        mysqli_stmt_bind_param($stmt,"ss",$param_username,$param_password);
        //set these parameters
        $param_username=$username;
        $param_password=password_hash($password,PASSWORD_DEFAULT);
        //try to execte query
        if(mysqli_stmt_execute($stmt))
        {
           // echo "<script>window.location.href='login.php';</script>";
           header("location:login..php");
            exit();
            
        }
        else{
            echo "Something went wrong";
        }
    }
    mysqli_stmt_close($stmt);
}
else{
    echo $username_err.$password_err;
}
mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="register.css">
    <script  src="form.js">
       
    </script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
<style>
</style>
</head>
<body>
   <div class="bg-img">
      <header class="he">Welcome to crichub</head>
       <div class="content">
           <header>Register</header>
           <form action="registre.php" method="POST">
               <div class="field">
                   <span class=" fa fa-user"></span>
                   <input type="text" placeholder="Phone or email" id="username" name="username">
               </div><br>
               <div class="field">
                   <span class="fa fa-lock"></span>
               <input type="password" placeholder="password" id="password" name="password"></div><br>


               <div class="field">
                <span class="fa fa-lock"></span>
            <input type="password" placeholder="confirm-password" id="confirm_password" name="confirm_password"></div>
            <div class="pass">
               <div class="field space">
                   <input type="submit" value="Register">
               </div>
           </form><br>
           <div class="He">
           <p class="hello" style="color:rgb(202, 113, 113)">Already Register?<a href="login..php" style="color:rgb(255, 255, 255);">Login here</a></p>
        </div>
       </div>
   </div>
    
</body>
</html>
