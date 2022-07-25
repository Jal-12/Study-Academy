<?php
include '../inc/top.php';
require '../db/dbcon.php';

$err=$success=$msg=$msgs=$department=$semester=$sub_id=$unit_id='';

if (isset($_POST['update']) && $_SERVER["REQUEST_METHOD"] == "POST")
{
	$flag=true;

	if (empty($_POST['department']) || empty($_POST['semester']) || empty($_POST['sub_id'])|| empty($_POST['unit_id']) || empty($_POST['topic'])) {
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
		$lec_id = safe_string( $_GET["lec_id"]);
		$department = safe_string( $_POST["department"]);
		$semester = safe_string( $_POST["semester"]);
		$sub_id = safe_string( $_POST['sub_id']);
		$unit_id = safe_string($_POST['unit_id']);
		$topic = safe_string( $_POST['topic']);
		$lecture_link = safe_string( $_POST['lecture_link']);
		//file post method
		$file = $_FILES['file'];
		$fileName = $file['name'];
		$fileTmpName = $file['tmp_name'];
		$fileSize = $file['size'];
		$fileError = $file['error'];
		$fileType = $file['type'];

		// pr($_FILES['file']);
		if ($fileError!=0 || $fileSize==0 || $fileError==4){
			if (empty($_POST['lecture_link'])) {

				$sql="UPDATE `lectures` SET `d_id`='$department', `semester`='$semester', `sub_id`='$sub_id', `unit_id`='$unit_id',`topic`='$topic', `update_time`=current_timestamp() WHERE lec_id=$lec_id";

			} else {

				$old_lecture_SQL="SELECT lecture_path FROM `lectures` WHERE lec_id=$lec_id";
				$old_lecture_Result = mysqli_query($con, $old_lecture_SQL);

				if (mysqli_num_rows($old_lecture_Result)>0) {					
					$old_lecture_Row=mysqli_fetch_array($old_lecture_Result);
					$old_lecture=$old_lecture_Row['lecture_path'];
					if ($old_lecture!=NULL) {

					unlink($old_lecture);
					}
				}
				$sql="UPDATE `lectures` SET `d_id`='$department', `semester`='$semester', `sub_id`='$sub_id', `unit_id`='$unit_id',`topic`='$topic',`lecture_link`='$lecture_link', `lecture_path`= NULL, `update_time`=current_timestamp() WHERE lec_id=$lec_id";
			}
			$result = mysqli_query($con, $sql);
					if ($result) {	
			
						$success='File Updated Successfully';
						
						echo "<script>  window.history.go(-2); </script>";
				    }
				    else{
				    	echo "<h1>PROBLEM</h1>". mysqli_error($con);
				    }
		}else{



		$fileExt = explode('.', $fileName);
		$fileActualExt = strtolower(end($fileExt));
		$allowed = array('mp4');
		// file etension
		if (in_array($fileActualExt, $allowed)) {
			//file error
			if ($fileError === 0) {
				//file size
				if ($fileSize < 41943040 ) {
				// $uniqid=rand(10000,99999);
					$fileNameNew=uniqid('',true).".".$fileActualExt;

					$fileDestination = "../lectures/".$fileNameNew;
					// echo $fileDestination;
					
					$move=move_uploaded_file($fileTmpName, $fileDestination);
					if ($move) {
			// unlinking old file while updating new file
				$old_lecture_SQL="SELECT lecture_path FROM `lectures` WHERE lec_id=$lec_id";

						$old_lecture_Result = mysqli_query($con, $old_lecture_SQL);

						if (mysqli_num_rows($old_lecture_Result)>0) {
							
							$old_lecture_Row=mysqli_fetch_array($old_lecture_Result);
							$old_lecture=$old_lecture_Row['lecture_path'];
							if ($old_lecture!=NULL) {

							unlink($old_lecture);
							}
						}

// successfully unliking completed
						
					//insert query
						$sql="UPDATE `lectures` SET `d_id`='$department', `semester`='$semester', `sub_id`='$sub_id', `unit_id`='$unit_id',`topic`='$topic',`lecture_link`= NULL,`lecture_path`='$fileDestination',`update_time`=current_timestamp() WHERE lec_id=$lec_id";

						$result = mysqli_query($con, $sql);
						if ($result) {					
							$success='File Uploaded Successfully';
							echo "<script>  window.history.go(-2); </script>";
					    }
					    else{
					    	$err= "<h1>PROBLEM</h1>". mysqli_error($con);
					    }
					}else{
						$err= "<h1>Unable to move</h1>". mysqli_error($con);
					}
				} else {
					$err= "Your file is too big!";

				}
			} else {
				$err= "There was an error uploading you file";
			}
		} else {
			$err= "You can upload MP4 files only";
			// redirect('upload.php');
		}
		// header("Location: upload.php?uploadsucces");
	}
}
}

?>
<div class="container bg-white">
		<div class="card-header">
			<div class="row">
				<div class="col-md-9">
					<h3 class="card-title text-lg-center ">Update Lectures</h3>					
				</div>
				<div class="col-md-3" align="right">
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				
				<form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']) ?>" method="POST" enctype="multipart/form-data">
					<table class="table table-hover table-striped  ">
						
								<span class="text-success "><?php echo $success; ?></span>
								<span class="text-danger font-weight-bold"><?php echo $err; ?></span>
								<span class="text-danger"><?php echo $msgs; ?></span>
						

<?php

if (isset($_GET['lec_id'])) {
	$lec_id=$_GET['lec_id'];
	$sql="SELECT * FROM `lectures` WHERE lec_id=$lec_id";
	$result = mysqli_query($con, $sql);
		if (mysqli_num_rows($result)) {
			$row=mysqli_fetch_array($result);


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
								<!-- hidden lec_id -->
								<input class="form-control mr-sm-2" type="text" hidden name="lec_id" value="<?php echo $row['lec_id']; ?>" >
								<!-- hidden lec_id -->
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
							<td id="label"><label for="topic">Topic Name:</label></td>
							<td>
								<input class="form-control" type="text" name="topic" value="<?php echo $row['topic']; ?>" placeholder="Enter Topic Name">
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center" class="text-danger font-weight-bold">Please upload You Tube video-link or upload video</td>
						</tr>
						<tr>
							<td id="label"><label for="lecture_link">Video Link:</label></td>
							<td>
								<input class="form-control" type="text" value="<?php echo $row['lecture_link']; ?>" name="lecture_link" placeholder="Enter You Tube Video Link"><br>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center" class="text-danger  font-weight-bolder">OR</td>
						</tr>
						<tr>
						<td colspan="2" colspan="center">
							<input style="padding-bottom:28px  ; " type="file" name="file" id="file" class="form-control ">
							<span style="font-size: 12px; color: red;">(Maximum size limit= 40MB)</span> <span class="text-danger"><?php echo $err; ?></span>
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
