<?php
 session_start();
 //db include
 require '../db/dbcon.php';

 if(!isset($_SESSION['loggedin']) OR $_SESSION['loggedin'] != true)
{
    session_abort();
    // header("location:Admin_Login.php");
  
} 
 session_destroy();
 
//  $con=mysqli_connect('localhost','root');
//  mysqli_select_db($con,'studyacademy');

 $admin_id=$_SESSION['admin_id'];

 $q="UPDATE admin SET status='offline' where admin_id='$admin_id'";
 
 $status=mysqli_query($con,$q);
    if($status==1)
    {   
        header('location:../Index.php');    
    }   

 echo "<script>alert( 'Logout Successfully' );</script>";
           
?>