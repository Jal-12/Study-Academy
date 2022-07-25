<?php 
session_start();
if (isset($_GET['group_id']) && isset($_SESSION['admin_id'])) {
	require '../db/dbcon.php';

	include '../inc/function.php';
	$group_id=$_GET['group_id'];
	$admin_id=$_SESSION['admin_id'];
	$row=exam_group($group_id);
	$date=$row['date'];
    $time=$row['time'];
    $d_id=$row['d_id'];
    $group_id=$row['group_id'];
    $group_token=$row['group_token'];
    $start_time = date('Y-m-d H:i:s', strtotime("$date $time"));
    // $start_time=$combinedDT;
    $now=date("Y-m-d H:i:s");
    // $time_minutes=$row['time'];
    $total_time_minutes=$row['total_time_minutes'];
    $added_time=date("h:i:s A",strtotime($time."+".$total_time_minutes." Minutes"));

	$notice="Exam of <i><b>".sub_id($row['sub_id'])."</b></i> on <i>".TimeMinute($start_time)." to ".TimeMinute($added_time)." on ".DateWeek($date)."</i>. Group Token of exam is <b>&#8216;".$group_token."&#8217;</b>." ;
	// die($notice);
	$noticeSql="INSERT INTO `notice` (`admin_id`, `d_id`, `notice`) VALUES('$admin_id', '$d_id' , '$notice')";
	$result=mysqli_query($con,$noticeSql) or die(mysqli_error($con));
	if ($result) {
		echo false;
	} else {
		echo true;
	}
	
} else {
	echo true;
}

 ?>