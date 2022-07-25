<?php
include '../inc/top.php';
require '../db/dbcon.php';

$err="";
$success='';
$msgs='';
if (isset($_POST['update']) && $_SERVER["REQUEST_METHOD"] == "POST")
{
	$flag=true;
	if (empty($_POST['department']) || empty($_POST['semester']) || empty($_POST['username'])|| empty($_POST['email']) ||empty($_POST['mobile']) ) {
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
	if ($flag==true) {
	require '../db/dbcon.php';
	$enrollment = safe_string( $_POST["enrollment"]);
	$semester = safe_string( $_POST["semester"]);
	$username = safe_string( $_POST['username']);
	$email = safe_string( $_POST['email']);
	$mobile = safe_string( $_POST['mobile']);
	$topic = safe_string( $_POST['topic']);
	
	$sql="UPDATE `student` SET `semester`='$semester', `username`='$username', `email`='$email',`mobile`='$mobile',`update_time`=current_timestamp() WHERE enrollment=$enrollment";
		
		$result = mysqli_query($con, $sql);
			if ($result) {					
				$success='Data Updated Successfully';
				echo "<script>  window.history.go(-2); </script>";
		    }
		    else{
		    	echo "<h1>PROBLEM</h1>". mysqli_error($con);
		    }		
	}
}

	// getting edit data id
	if (isset($_GET['enrollment'])) {
		$enrollment=$_GET['enrollment'];
		$sql="SELECT * FROM `student` WHERE enrollment=$enrollment";
		$result = mysqli_query($con, $sql);
		if (mysqli_num_rows($result)) {
			$row=mysqli_fetch_array($result);

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Update Student</title>
	<!-- <link rel="stylesheet" href="../css/reg.css"> -->
</head>
<body>
	<div class="container bg-white">
		<div class="card-header">
			<div class="row">
				<div class="col-md-12">
					<h3 class="card-title text-lg-center ">Update Student</h3>					
				</div>
				<div class="col-md-3" align="right">
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				
				<form action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>" method="POST" enctype="multipart/form-data">
					<table class="table table-hover table-striped  ">
						<span class="text-danger"><?php echo $msgs; ?></span>
						<tr>
						<td><label for="enrollment">Enrollment No: </lable></td>
						<td><?php echo $row['enrollment']; ?>
						<input type="text" id="username" hidden value="<?php echo $row['enrollment']; ?>" name="enrollment" autocomplete="off"><br/></td>
					</tr>
					<tr>
						<td><label>Department:</label></td>
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
							    	}
    							  }
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td><label for="username">User Name: </label></td>
						<td><input type="text" id="uname" value="<?php echo $row['username']; ?>" name="username" autocomplete="off" placeholder="Enter UserName" ></td>
					</tr>			
					<tr>
						<td><label for="email">E-mail: </label></td>
						<td><input type="email" id="email" value="<?php echo $row['email']; ?>" name="email" autocomplete="off" placeholder="Enter Email" require><br/></td>
					</tr>
					<tr>
						<td><label for="mobile">Contact Number: </label></td>
						<td><input type="number" id="mobile" value="<?php echo $row['mobile']; ?>" name="mobile" autocomplete="off" placeholder="Enter ContactNumber"><br/></td>
					</tr>
					<tr>
		            	<td>
		            	<label for="semester">Semester:</label></td>
						<td>
							<select class='form-control' id='semester' name='semester' size='1'>
							<?php
							for ($sem=1; $sem <=8 ; $sem++) { 
								if ($sem==$row['semester']) {
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
						<td colspan="2" align="center">
							<button class="btn btn-primary" type="submit" name="update">UPDATE</button>
						</td>
					</tr>
				</table>
			</form>
		</div>
	<?php include 'footer.php'; ?>
	</div>
</div>		
		
<?php 
	}else{
		redirect('index.php');
	}
}
?>