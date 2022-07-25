<?php
include '../inc/student.php';
require '../db/dbcon.php';
if ($_SERVER['REQUESTED_METHOD']='POST'&&isset($_POST['connect_group'])) {
	$group_token=safe_string($_POST['group_token']);
	$enrollment=safe_string($_POST['enrollment']);

	$check_group="SELECT group_id FROM exam_group WHERE group_token='$group_token'";
	$GroupResult=mysqli_query($con,$check_group);
	$group=mysqli_num_rows($GroupResult);

	$check_enroll="SELECT stu_id FROM student WHERE enrollment=$enrollment";
	$EnrollResult=mysqli_query($con,$check_enroll);
	$enroll=mysqli_num_rows($EnrollResult);
	if ($group>0&&$enroll>0) {
		$group_id=mysqli_fetch_array($GroupResult);
		$stu_id=mysqli_fetch_array($EnrollResult);
		$g=$group_id['group_id'];
		$s=$stu_id['stu_id'];


		$InsertGroup="INSERT INTO `connect_group`(`group_id`, `stu_id`, `group_token`) VALUES ('$g','$s', '$group_token')";
		$InsertResult=mysqli_query($con,$InsertGroup) or die(mysqli_error($con));
		if ($InsertResult) {
				echo "<script>
					   	 alert('Connect Group Successfully');
				   	  </script>";
		}else{
			echo "<script>
					   	 alert('Group Not inserted');
				   	  </script>";
		}
	}else{
		echo "No group found";
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Connect group</title>
</head>
<body class="bg-info">
		<div class="container" style="font-size: 15px;">
			<div class="col-md-8 offset-md-2 bg-light p-4 mt-5 rounded">
				<form action="" method="POST">
					<div class="form-group">
						<label for="question">Add Group Token :</label>
						<input type="text" name="group_token" placeholder="Enter group token" class="form-control" ><br>
					</div>
					<div class="form-group">
						<label for="question">Enrollment :</label>
						<input type="text" name="enrollment" placeholder="Enter enrollment" class="form-control" ><br>
					</div>
					
					<center>
						<button name="connect_group" type="submit" class="btn btn-lg btn-dark">Connect Group</button>						
					</center>
				</form>
			</div>
		</div>
	</body>
</html>