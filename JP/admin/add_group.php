<?php
include '../inc/top.php';
if (isset($_POST['add_group']) && $_SERVER["REQUEST_METHOD"] == "POST")
 {
	$flag=true;
	$msg="";
	if (empty($_POST['department'])) {
		$flag=false;
		$msg="Plese enter value";
	}
	if (empty($_POST['semester'])) {
		$flag=false;
		$msg="Plese enter value";
	}
	if (empty($_POST['sub_id'])) {
		$flag=false;
		$msg="Plese enter value";
	}
	if (empty($_POST['total_questions'])) {
		$flag=false;
		$msg="Plese enter value";
	}
	if (empty($_POST['total_time_minutes'])) {
		$flag=false;
		$msg="Plese enter value";
	}
	if (empty($_POST['date'])) {
		$flag=false;
		$msg="Plese enter value";
	}
	if (empty($_POST['time'])) {
		$flag=false;
		$msg="Plese enter value";
	}
	// die($flag);
	if ($flag==true) {

		require '../db/dbcon.php';

			$department=safe_string($_POST['department']);
			$semester=safe_string($_POST['semester']);
			$sub_id=safe_string($_POST['sub_id']);
			$total_questions=safe_string($_POST['total_questions']);
			$total_time_minutes=safe_string($_POST['total_time_minutes']);
			$date=safe_string($_POST['date']);
			$time=safe_string($_POST['time']);

			$group_token=bin2hex(random_bytes(5));

			$sql = "INSERT INTO `exam_group` (`d_id`, `semester`, `sub_id`, `total_questions`,`total_time_minutes`, `date`, `time`,`admin_id`, `group_token`) VALUES ('$department', '$semester', '$sub_id', '$total_questions','$total_time_minutes', '$date', '$time','{$_SESSION['admin_id']}', '$group_token')";
	// echo $sql;
		
		$result=mysqli_query($con, $sql) or die(mysqli_error($con));
	// die($result);

			if (!$result) {
					$error = mysqli_error($con);
					echo "<center><h2>No reocrds inserted !!<br>" . $error . "<h2></center>";
				}else {
					 echo "<script type='text/javascript'>
					       	   	alert('Group Successfully created');
					       </script>";
				}
		}
}
?>
<style type="text/css">
	table {
        font-size: 15px;
    }
</style>
<body>
	<div class="container bg-white">
		<div class="card-header">
			<div class="row">
				<div class="col-md-12">
					<h3 class="card-title" style="text-align: center;">Add Group</h3>
				</div>
				<div class="col-md-3" align="right">
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				
				<form action="" method="POST">
					<table class="table table-hover table-striped">
						<tr>
							<td id="label"><label>Department:</label></td>
							<td>
								<?php echo department();	?>
							</td>
						</tr>
						<tr>
							<td id="label"><label for="semester">Semester:</label></td>
							<td>
								<?php echo semester(); ?>
							</td>
						</tr>
						<tr>
							<td id="label"><label for="subject">Name:</label></td>
							<td>
								<select class='form-control' name='sub_id' id='subject' size='1'>
									<option value='' selected='' disabled=''>Select Subject</option>
									
								</select>
							</td>
						</tr>

						<tr>
							<td id="label"><label for="total_questions">Total Questions:</label></td>
							<td>
								<input class="form-control mr-sm-2" type="text" name="total_questions" placeholder="Enter Total question">
							</td>
						</tr>
						<tr>
							<td id="label"><label for="total_time_minutes">Total Time in Minutes:</label></td>
							<td>
								<input class="form-control mr-sm-2" type="text" name="total_time_minutes" placeholder="Enter Total Time in Minutes">
							</td>
						</tr>

						<tr>
							<td id="label"><label for="date">Date:</label></td>
							<td>
								<input class="form-control" type="date" name="date" min="2021-04-26 " placeholder="Enter starting date">
							</td>
						</tr>

						<tr>
							<td id="label"><label for="time">Time:</label></td>
							<td>
								<input class="form-control" type="time" name="time" placeholder="Enter starting time">
							</td>
						</tr>

						<tr>
						<td colspan="2" align="center">
							<button class="btn btn-primary" type="submit" name="add_group">Add Group</button>
						</td>
					</tr>
						</table>
					</form>
				</div>
			</div>
		</div>
		<?php include 'footer.php'; ?>
		<script type="text/javascript">
			var d = new Date();
document.getElementById("demo").innerHTML = d;
		</script>
