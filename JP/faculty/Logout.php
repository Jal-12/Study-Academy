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

 $faculty_id=$_SESSION['faculty_id'];

 $q="UPDATE faculty SET status='offline' where faculty_id='$faculty_id'";
 
 $status=mysqli_query($con,$q);
    if($status==1)
    {   
        header('location:../Index.php');    
    }   

 echo "<script>alert( 'Logout Successfully' );</script>";
           
?>