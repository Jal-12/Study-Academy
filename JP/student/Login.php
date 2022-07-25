<?php
session_start();
include '../inc/function.php';
require '../db/dbcon.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Student-Login</title>
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
            <h1>Student-Login</h1>
<!-- login box  -->
            <input type="enrollment" id="eno" name="enrollment" autocomplete="off" required>
            <label for="eno" class="labeleno">
                <span class="contenteno">Enrollment_No</span></label>
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
            <div class='lin'><p>Not yet Register?
            <a href="Registration.php">New Register</a>
            </p>
            </div>
            <li><a href="../Index.php"><i class="fas fa-sign-out-alt"></i></a></li>
           </div>
<!-- include js  -->
        <script src="js/Login.js"></script>
        <script src="js/Verification.js"></script>
        </form>
<!-- text  -->
        <div class="heading">
            <h2>Login & Signup</h2>
        </div>
        <div class="status">
        <p>Login/Create account to access this website</p>
        </div>
    </body>
</html>

<?php

if (isset($_POST['blogin'])) 
{   
    
    // $con=mysqli_connect('localhost','root');
    // mysqli_select_db($con,'studyacademy');
    
    $enrollment= safe_string($_POST['enrollment']);
    $password= safe_string($_POST['password']);
    
    
    $q="SELECT * from student where enrollment='$enrollment'";
      
    $result=mysqli_query($con,$q);
    $num=mysqli_num_rows($result);
    if($num==1)
    {   
    while ($row = mysqli_fetch_array($result)) {
            $s=$row['status'];
            if($s=="active")
            {
            if ($password==$row['password']) 
            {
                $_SESSION['student'] = true;
                $_SESSION['stu_id']= $row['stu_id'];
                $_SESSION['enrollment']= $row['enrollment'];
                $_SESSION['username']= $row['username'];
                $_SESSION['email']= $row['email'];
                $_SESSION['mobile']= $row['mobile'];
                $_SESSION['d_id']= $row['d_id'];
                $_SESSION['semester']= $row['semester']; 
                $_SESSION['status']= $row['status'];
                 header('location:Index.php');    
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
