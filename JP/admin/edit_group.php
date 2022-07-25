<?php
include '../inc/top.php';
require '../db/dbcon.php';
if (isset($_POST['update_group']) && $_SERVER["REQUEST_METHOD"] == "POST") {

$flag=true;
$msg="";
	$flag=true;
	if (empty($_POST['department']) || empty($_POST['semester']) || empty($_POST['sub_id'])|| empty($_POST['total_questions']) ||empty($_POST['total_time_minutes'])||empty($_POST['date'])||empty($_POST['time']) ) {
		$flag=false;
		$msgs='<tr>
				<td colspan="2" align="center">
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<strong>Fields can not be empty!</strong>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    	<span aria-hidden="true">&times;</span>
						 	</button>
					</div>
				</td>
			  </tr>';
	}
	// die($flag);
	if ($flag==true)
	 {
		$d_id=safe_string($_POST['department']);
		$semester=safe_string($_POST['semester']);
		$group_id=safe_string($_POST['group_id']);
		$sub_id=safe_string($_POST['sub_id']);
		$total_questions=safe_string($_POST['total_questions']);
		$total_time_minutes=safe_string($_POST['total_time_minutes']);
		$date=safe_string($_POST['date']);
		$time=safe_string($_POST['time']);

		$sql="UPDATE `exam_group` SET `d_id`='$d_id', `semester`='$semester', `sub_id`='$sub_id', `total_questions`='$total_questions',`total_time_minutes`='$total_time_minutes',`date`='$date',`time`='$time',`update_time`=current_timestamp() WHERE group_id=$group_id";
			$result = mysqli_query($con, $sql);
					if ($result) {					
						$success='Group Updated Successfully';
						echo "<script>  window.history.go(-2); </script>";
				    }
				    else{
				    	echo "<h1>PROBLEM</h1>". mysqli_error($con);
				    }
		
		$result=mysqli_query($con, $sql) or die(mysqli_error($con));
		// die($result);
			if (!$result)
			 {
				$error = mysqli_error($con);
				echo "<center><h2>No reocrds updated !!<br>" . $error . "<h2></center>";
			}
	 }
}
?>
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
				<form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']) ?>" method="POST">
				<table class="table table-hover table-striped">
		<?php
		if (isset($_GET['group_id']))
		 {
			$group_id=$_GET['group_id'];
			$sql="SELECT * FROM `exam_group` WHERE group_id=$group_id";
			$result = mysqli_query($con, $sql);
	
			if (mysqli_num_rows($result))
			 {
				$row=mysqli_fetch_array($result);
		?>
		
		<tr>
			<td id="label"><label>Department:</label></td>
			<td>
				<select class='form-control' id='department' name='department' size='1'>
				<?php
					$Select_d_id = "SELECT * FROM department";
					$SelectResult = mysqli_query($con, $Select_d_id);

				    while ($d_id_row = mysqli_fetch_array($SelectResult)) 
					{
			    	if ($d_id_row['d_id']==$row['d_id'])
					 {
						echo "<option value='".$d_id_row['d_id']."'selected>".$d_id_row['department']."</option>";
					}else{
						echo "<option value='".$d_id_row['d_id']."'>".$d_id_row['department']."</option>";
					}
					}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td id="label"><label for="semester">Semester:</label></td>
			<td>
				<select class='form-control' id='semester' name='semester' size='1'>
				<?php

				for ($sem=1; $sem <=8 ; $sem++)
				 { 
					if ($sem==$row['semester'])
					 {
						echo "<option value='".$row['semester']."'selected>".$row['semester']."</option>";
					}else{
						echo "<option value='".$sem."'>".$sem."</option>";
					}
				 }
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td id="label"><label for="subject">Subject:</label></td>
			<td>
				<select class='form-control' name='sub_id' id='subject' size='1'>
				<option value='' selected='' disabled=''>Select Subject</option>
				<?php 
					$Select_sub_id = "SELECT * FROM subject WHERE semester={$row['semester']} && d_id={$row['d_id']}";
					$SelectResult = mysqli_query($con, $Select_sub_id);

					while ($sub_id_row = mysqli_fetch_array($SelectResult))
					 {
						if ($sub_id_row['sub_id']==$row['sub_id'])
						 {
							echo "<option value='".$sub_id_row['sub_id']."'selected>".$sub_id_row['subject']."</option>";
						 }else{
							echo "<option value='".$sub_id_row['sub_id']."'>".$sub_id_row['subject']."</option>";
						}
					 }
				?> 
				</select>
			</td>
		</tr>
<!-- hidden material_id -->
		<input class="form-control mr-sm-2" type="text" hidden name="group_id" value="<?php echo $row['group_id']; ?>" >
		<tr>
			<td id="label"><label for="total_questions">Total Questions:</label></td>
			<td>	
				<input class="form-control mr-sm-2" type="text" name="total_questions" value="<?php echo $row['total_questions']; ?>" placeholder="Enter Total question">
			</td>
		</tr>
		<tr>
			<td id="label"><label for="total_time_minutes">Total Time in Minutes:</label></td>
			<td>
				<input class="form-control mr-sm-2" type="text" name="total_time_minutes" value="<?php echo $row['total_time_minutes']; ?>" placeholder="Enter Total Time in Minutes">
			</td>
		</tr>
		<tr>
			<td id="label"><label for="date">Date:</label></td>
			<td>
				<input class="form-control" type="date" name="date" value="<?php echo $row['date']; ?>" min="2021-04-26 " placeholder="Enter starting date">
			</td>
		</tr>
		<tr>
			<td id="label"><label for="time">Time:</label></td>
			<td>
				<input class="form-control" type="time" name="time" value="<?php echo $row['time']; ?>" placeholder="Enter starting time">
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<button class="btn btn-primary" type="submit" name="update_group">Update Group</button>
			</td>
		</tr>
				</table>
				</form>
			</div>
		</div>
	</div>

<?php include 'footer.php'; ?>

	<?php 
	}else{
		redirect('index.php');
	}
}
?>