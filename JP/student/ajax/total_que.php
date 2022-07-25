<?php 
session_start();
require '../../db/dbcon.php';
date_default_timezone_set("Asia/Kolkata");

$group_id=$_SESSION['group_id'];
		$exam="SELECT * FROM exam WHERE group_id=$group_id";
		$ExamResult=mysqli_query($con,$exam);
		$total_que=mysqli_num_rows($ExamResult);
		echo $total_que;

 ?>
