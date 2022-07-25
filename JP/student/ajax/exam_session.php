<?php 
session_start();
require '../../db/dbcon.php';
date_default_timezone_set("Asia/Kolkata");

if (isset($_GET['group_token']) && isset($_SESSION['stu_id'])) {
	$group_t=$_GET['group_token'];
	$stu_id=$_SESSION['stu_id'];


		$group_t = trim($group_t);
  		$group_t = stripslashes($group_t);
  		$group_t = htmlspecialchars($group_t);
	   	$group_token = mysqli_real_escape_string($con,$group_t);

		$stu_id = trim($stu_id);
  		$stu_id = stripslashes($stu_id);
  		$stu_id = htmlspecialchars($stu_id);
	   	$stu_id = mysqli_real_escape_string($con,$stu_id);
	// $stu_id=$_SESSION['stu_id'];
		// $resultSQL="SELECT * FROM RESULT WHERE stu_id='$stu_id' AND group_id='$group_id'";
  //       $result=mysqli_query($con, $resultSQL);
  //       $row=mysqli_fetch_array($result);

		// checking group
		$check_group="SELECT * FROM connect_group WHERE group_token='$group_token' && stu_id=$stu_id";
		$GroupResult=mysqli_query($con,$check_group);
		$group=mysqli_num_rows($GroupResult);
		// var_dump($group);
		// die(mysqli_error($con));


		//checking if given exam by student
		$row1=mysqli_fetch_array($GroupResult);
		$stu_id=$row1['stu_id'];
		$group_id=$row1['group_id'];
		$resultSQL="SELECT * FROM RESULT WHERE stu_id='$stu_id' AND group_id='$group_id'";
        $result=mysqli_query($con, $resultSQL);
        $no=mysqli_num_rows($result);
        // echo mysqli_error($con);
        if ($no>0) {
        	echo true;
        }else{

			if ($group>0) {
				$sql="SELECT * FROM exam_group WHERE exam_group.group_token='$group_token'";
				$res=mysqli_query($con,$sql);
				$row=mysqli_fetch_array($res);
				
				// creating session of stu_id
				$stu_id=mysqli_fetch_array($GroupResult);
				// $_SESSION['stu_id']= $stu_id;

				$date=date("Y-m-d H:i:s");
				$edate=$row['date'];
				$etime=$row['time'];

				$start_time = date('Y-m-d H:i:s', strtotime("$edate $etime"));
				if ($start_time>$date) {
					echo false;
				} else {
					
				
					
					// session of 
					$_SESSION['duration']=$row['total_time_minutes'];
					$_SESSION['group_id']=$row['group_id'];
					// $date=date("Y-m-d H:i:s");
					$_SESSION['start_time']=$date;

					$end_time=date('Y-m-d H:i:s',strtotime($date.'+'.$_SESSION["duration"].' minutes'));
					$_SESSION['end_time']=$end_time;
					echo "SUCCESS";
				}
			}
		}
}else{
	echo "Please Login again! To give the exam";
}


?>
