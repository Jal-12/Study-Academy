<?php
session_start();
//db include
require '../db/dbcon.php';
?>

<!DOCTYPE html>
 <html>
  <head>
   <meta charset="UTF-8">
	<title>Forgot-Password</title>
    <link rel="stylesheet" type="text/css" href="css/Forgot.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins&amp;display=swap" 
    rel="stylesheet">
</head>
  <body>
   <form action="Forgot.php" method="post">
	<div class="box">
	 <h1>Forgot-Password</h1>
     
     <label for="email">Email-Id: </label>
     <input type="email" id="email" name="email" placeholder="Enter Email" required>
    </br>      
     <label for="pass">New Password: </label>
     <input type="password" id="pass" name="password" placeholder="New Password" required>
         <span1><i class="fas fa-eye" aria-hidden="true" id="eye" onclick="toggle()"></i></span1>
         
         <button class="btn" type="submit" name="btnupdate">
                <span>UPDATE </span>
            </button>
         
            <div class="link">
                <a href="Login.php">Login here</a>
            </div>
     <div class="heading">
            <h2>Forgot Password </h2>
        </div> 
     
            
            <script src="js/Verification.js"></script>
</body>
</html>

<?php

if (isset($_POST['btnupdate'])) 
{   

    $email=$_POST['email'];
    $password=$_POST['password'];
    
//db connection
    // $con=mysqli_connect('localhost','root');
    // mysqli_select_db($con,'studyacademy');

// value update query for password
    $q="UPDATE student SET password ='$_POST[password]' WHERE email = '$_POST[email]' ";

    $status=mysqli_query($con,$q);
    if($status==1)
    {
     $_SESSION['email']=$email;
     $_SESSION['password']=$password;   
    
// email sending        
    $subject= "Password Change";
    $body= "Hello Admin,

        Your's credentials are as below:
   
        [ Email:- $email ]
        [ New-Password:- $password ]
  
        Thanks,
    
        Study-Academy 
    
        Note:This is an auto generated mail.
        Please do not reply to this email.";
        $headers= "From: studyacademy11@gmail.com";
        if (mail($email, $subject, $body, $headers)) 
        {
        echo"<script> alert( 'Password Update' );</script>";
       }else 
       {
           echo'<script type="text/javascript">alert("Email sending failed...");</script>';
       }
    }
    if($status==0) 
     {
      echo"<script> alert( 'There is a problem' );</script>";
     }

}
?>    