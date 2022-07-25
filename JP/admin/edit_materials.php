<?php
include '../inc/top.php';
require '../db/dbcon.php';

$err="";
$success='';
$msgs='';
if (isset($_POST['update']) && $_SERVER["REQUEST_METHOD"] == "POST")
{
$flag=true;

if (empty($_POST['department']) || empty($_POST['semester']) || empty($_POST['sub_id'])|| empty($_POST['unit_id'])) {
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
		$material_id = safe_string( $_GET["material_id"]);
		$department = safe_string( $_POST["department"]);
		$semester = safe_string( $_POST["semester"]);
		$sub_id = safe_string( $_POST['sub_id']);
		$unit_id = safe_string( $_POST['unit_id']);

		//file post method
		$file = $_FILES['file'];
		$fileName = $file['name'];
		$fileTmpName = $file['tmp_name'];
		$fileSize = $file['size'];
		$fileError = $file['error'];
		$fileType = $file['type'];

		if ($fileError!=0){
			$sql="UPDATE `study_materials` SET `semester`='$semester', `sub_id`='$sub_id', `unit_id`='$unit_id',`update_time`=current_timestamp() WHERE material_id=$material_id";
			$result = mysqli_query($con, $sql);
					if ($result) {					
						$success='File Uploaded Successfully';
						echo "<script>  window.history.go(-2); </script>";
				    }
				    else{
				    	echo "<h1>PROBLEM</h1>". mysqli_error($con);
				    }
		}else{



		$fileExt = explode('.', $fileName);
		$fileActualExt = strtolower(end($fileExt));
		$allowed = array('pdf','pptx', 'ppt', 'docx','doc','jpg','png','jpeg');
		// file etension
		if (in_array($fileActualExt, $allowed)) {
			//file error
			if ($fileError === 0) {
				//file size
					$fileNameNew=uniqid('',true).".".$fileActualExt;

					$fileDestination = "../materials/".$fileNameNew;
					// echo $fileDestination;
					
					$move=move_uploaded_file($fileTmpName, $fileDestination);
					if ($move) {
// unlinking old file while updating new file
	$old_Material_SQL="SELECT file FROM `study_materials` WHERE material_id=$material_id";

	$old_Material_Result = mysqli_query($con, $old_Material_SQL);
	$old_Material_Row=mysqli_fetch_array($old_Material_Result);
	$old_material=$old_Material_Row['file'];
	unlink($old_material);
// successfully unliking completed
						
					//insert query
						$sql="UPDATE `study_materials` SET `semester`='$semester', `sub_id`='$sub_id', `unit_id`='$unit_id', `file`='$fileDestination',`update_time`=current_timestamp() WHERE material_id=$material_id";

					$result = mysqli_query($con, $sql);
					if ($result) {					
						$success='File Updated Successfully';
						echo "<script>  window.history.go(-2); </script>";
				    }
				    else{
				    	echo "<h1>PROBLEM</h1>". mysqli_error($con);
				    }
				}else{
					echo "<h1>Unable to move</h1>". mysqli_error($con);
				}
				
			} else {
				echo "There was an error uploading you file";
			}
		} else {
			$err= '<tr>
			<td colspan="2" align="center"><div class="alert alert-danger alert-dismissible fade show" role="alert">
			<strong>PDF files only!</strong>You can upload.
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		</td>
	</tr>';
			// redirect('upload.php');
		}
		// header("Location: upload.php?uploadsucces");
	}
}
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Upload file</title>
	<!-- <link rel="stylesheet" href="../css/reg.css"> -->
</head>
<body>
	<div class="container bg-white">
		<div class="card-header">
			<div class="row">
				<div class="col-md-12">
					<h3 class="card-title text-lg-center ">Update Materials</h3>					
				</div>
				<div class="col-md-3" align="right">
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				
				<form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']) ?>" method="POST" enctype="multipart/form-data">
					<table class="table table-hover table-striped  ">
						<tr>
							<td colspan="2" align="center">
								<span class="text-success "><?php echo $success; ?></span>
								<span class="text-danger font-weight-bold"><?php echo $err; ?></span>
								<span class="text-danger"><?php echo $msgs; ?></span>
							</td>
						</tr>

<?php

if (isset($_GET['material_id'])) {
	$material_id=$_GET['material_id'];
	$sql="SELECT * FROM `study_materials` WHERE material_id=$material_id";
	$result = mysqli_query($con, $sql);
	
	if (mysqli_num_rows($result)) {
		$row=mysqli_fetch_assoc($result);
		

		?>


						<tr>
							<td id="label"><label>Department:</label></td>
							<td>
								<select class='form-control' id='department' name='department' size='1'>
								<?php

								    $Select_d_id = "SELECT * FROM department";
								    $SelectResult = mysqli_query($con, $Select_d_id);

								    while ($d_id_row = mysqli_fetch_array($SelectResult)) {
								    	if ($d_id_row['d_id']==$row['d_id']) {
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
								<!-- hidden material_id -->
								<input class="form-control mr-sm-2" type="text" hidden name="material_id" value="<?php echo $row['material_id']; ?>" >
								<!-- hidden material_id -->
						<tr>
							<td id="label"><label for="subject">Subject:</label></td>
							<td>
								<select class='form-control' name='sub_id' id='subject' size='1'>
									<option value='' selected='' disabled=''>Select Subject</option>
									<?php 

									$Select_sub_id = "SELECT * FROM subject WHERE semester={$row['semester']} && d_id={$row['d_id']}";
								    $SelectResult = mysqli_query($con, $Select_sub_id);

								    while ($sub_id_row = mysqli_fetch_array($SelectResult)) {
								    	if ($sub_id_row['sub_id']==$row['sub_id']) {
								    		echo "<option value='".$sub_id_row['sub_id']."'selected>".$sub_id_row['subject']."</option>";
								    	}else{
								    		echo "<option value='".$sub_id_row['sub_id']."'>".$sub_id_row['subject']."</option>";
								    	}
								    }

	    
								?> 
								</select>
							</td>
						</tr>
						<tr>
							<td id="label"><label for="unit_id">Unit :</label></td>
							<td>
								<select class='form-control' name='unit_id' id='unit' size='1'>
									<option value='' selected='' disabled=''>Select Unit</option>
									<?php 
																		
									$Select_sub_id = "SELECT * FROM unit WHERE sub_id={$row['sub_id']}";
								    $SelectResult = mysqli_query($con, $Select_sub_id);

								    while ($unit_id_row = mysqli_fetch_array($SelectResult)) {
								    	if ($unit_id_row['unit_id']==$row['unit_id']) {
								    		echo "<option value='".$unit_id_row['unit_id']."'selected>".$unit_id_row['unit_number'].".&nbsp;".$unit_id_row['unit_name']."</option>";
								    	}else{
								    		echo "<option value='".$unit_id_row['unit_id']."'>".$unit_id_row['unit_number'].".&nbsp;".$unit_id_row['unit_name']."</option>";
								    	}
								    }
	    
								?> 
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="2" colspan="center"><input style="padding-bottom:28px  ; " type="file" name="file" id="file" class="form-control "><br>
							<span style="font-size: 10px; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">(Maximum size limit= 40MB)</span> <span class="text-danger"><?php echo $err; ?></span>
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
	</div>
</div>
		<?php include 'footer.php'; ?>

	<?php 
	}else{
		redirect('index.php');
	}
}
?>