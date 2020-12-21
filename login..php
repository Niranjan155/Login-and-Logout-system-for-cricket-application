<?php
//handle login
session_start();
if(isset($_SESSION['username'])){
   echo "<script>window.location.href='home.php';</script>";
    exit();
}
require_once "config.php";
$username=$password="";
$username_err=$password_err="";
if($_SERVER['REQUEST_METHOD']=="POST"){
    if(empty(trim($_POST['username'])) || empty(trim($_POST['password']))){
        $err="Please enter username+password";
        echo $err;
    }
    else{
        $username=trim($_POST['username']);
        $password=trim($_POST['password']);
        

    }
    if(empty($err)){
        $sql="SELECT id,username,password FROM users WHERE username=?";
        $stmt=mysqli_prepare($conn,$sql);
        mysqli_stmt_bind_param($stmt,"s",$param_username);
        
        $param_username=$username;
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            
            if(mysqli_stmt_num_rows($stmt)==1){
                mysqli_stmt_bind_result($stmt,$id,$username,$hashed_password);
                
                if(mysqli_stmt_fetch($stmt)){
                    
                    if(password_verify($password,$hashed_password)){
                        echo "helloi";
                        session_start();
                        $_SESSION['username']=$username;
                        $_SESSION['id']=$id;
                        $_SESSION['loggedin']=true;

                    echo "<script>window.location.href='home.php';</script>";
                   // header("location:home.php");
                        exit();

                    }
                }
            }
        }

    }
}


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    <script  src="form.js">
       
    </script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
<style>
</style>
</head>
<body>
   <div class="bg-img">
       <div class="content">
           <header>Login</header>
           <form action="" method="POST">
               <div class="field">
                   <span class=" fa fa-user"></span>
                   <input type="text" placeholder="Phone or email" id="username" name="username">
               </div><br>
               <div class="field">
                   <span class="fa fa-lock"></span>
               <input type="password" placeholder="password" id="password" name="password"></div>
               <div class="pass">
                   <a href="#"
               </div>
               <div class="field space">
                   <input type="submit" value="Login">
               </div>
           </form><br>
           <div class="He">
           <p class="hello">Didn't Register?<a href="registre.php" style="color:Red;">register here</a></p>
        </div>
       </div>
   </div>
    
</body>
</html>
