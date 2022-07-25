<?php
session_start();
//db include
require '../db/dbcon.php';
include '../inc/function.php';

$emailmsg=$passmsg='';

if (isset($_POST['blogin']) && $_SERVER["REQUEST_METHOD"] == "POST") 
{   
    if (empty($_POST['email'])) {
        $flag=false;
        $emailmsg="Please enter email";
    }
    if (empty($_POST['password'])) {
        $flag=false;
        $passmsg="Please enter password";
    }
    
    $email= safe_string($_POST['email']);
    $password= safe_string($_POST['password']);
    
    $q="SELECT * from admin where email='$email'";
      
    $result=mysqli_query($con,$q);
    $num=mysqli_num_rows($result);
    if($num==1)
    {   
    while ($row = mysqli_fetch_array($result)) {
            $s=$row['status'];
            if($s=="online")
            {
            if ($password==$row['password']) 
            {
                $_SESSION['admin'] = true;
                $_SESSION['admin_id'] = $row['admin_id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['status'] = $row['status'];
                header('location:index.php');    
    }
}
    }}
    if($num==0)
    {
        echo"<script> alert('Email or Password is invalid');</script>";
        header('location:Login.php');
    }
  }
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin-Login</title>
        <link rel="stylesheet" href="css/Login.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css?family=Poppins&amp;display=swap" 
         rel="stylesheet">
        </head>
    <body>
        <form action="Login.php" method="post">
<!-- emoji  -->
        <div class="box">
            <div class="faceContainer">
                <div class="eye" id="left"></div>
                <div class="eye" id="right"></div>
                <div class="mouth"></div>
            </div>
            <h1>Admin-Login</h1>
<!-- login box  -->
            <input type="email" id="Email" name="email" autocomplete="off" required>
            <label for="email" class="labelemail">
                <span class="contentemail">Email</span></label>
            <input type="password" id="pass" name="password" required>
           <label for="pass" class="labelpassword"> 
             <span class="contentpassword">Password
             </span>
             </label>
             <i class="fas fa-eye" aria-hidden="true" id="eye" onclick="toggle()"></i>
             
            
<!-- forgot link  -->
            <div class="link">
                <a href="Forgot.php">Forgot Password?</a>
            </div>
           <button class="btn" type="submit" name="blogin">
                <span>Login </span>
            </button>
           </div>
<!-- include js  -->
        <script src="js/Login.js"></script>
        <script src="js/Verification.js"></script>
        </form>
<!-- text  -->
        <div class="heading">
            <h2>Login</h2>
        </div>
        <div class="status">
           <h3>Your Account </h3>
        </div>
    </body>
</html>

