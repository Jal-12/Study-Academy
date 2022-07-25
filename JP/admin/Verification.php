<?php
session_start();
//db include
require '../db/dbcon.php';
error_reporting(0);
?>
<!DOCTYPE html>
 <html>
  <head> 
   <title>Verification</title>
   <link rel="stylesheet" href="css/Verification.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
   <link href="https://fonts.googleapis.com/css?family=Poppins&amp;display=swap" 
    rel="stylesheet">
  </head>
  <body>
    <form action="Verification.php" method="post">
     <div class="box">
      <h1>Admin-Verification</h1>
    <!-- <input class="box-1" type="number" name="code" placeholder="Verification code" required> -->
    
     <label for="code">Verification Code: </label>
     <input type="password" id="pass" name="code" placeholder="Enter Code" autocomplete="off" required>
     <span1><i class="fas fa-eye" aria-hidden="true" id="eye" onclick="toggle()"></i></span1>
    <div class="link">
                <a href="Send_code.php">Send Code</a>
            </div>
    <button class="btn" type="submit" name="btncheck">
     <span>Submit</span>
    </button>
    <li><a href="../Index.php"><i class="fas fa-sign-out-alt"></i></a></li>
      </div>
    </form>
    <div class="heading">
            <h2>Verify Your Account </h2>
        </div> 
        <script src="js/Verification.js">
          </script>
   </body>
  </html>      

 <?php
 
 if(isset($_POST['btncheck']))
 {
     $code=$_POST['code'];

//db connection
    // $con=mysqli_connect('localhost','root');
    // mysqli_select_db($con,'studyacademy');

    $q="UPDATE admin SET status='online' WHERE code='$code'";
 
    $status=mysqli_query($con,$q);
    // $num=mysqli_num_rows($result);
    if($status==1)
    {   
        $_SESSION['code']=$code;
        echo'<script type="text/javascript">alert("Status Update");</script>';
        header('location: Login.php');    
       }
    if($status==0)
    {
        echo'<script type="text/javascript">alert("Verification code is invalid");</script>';
        // header('location:Verification.php');
       }
}
?>  