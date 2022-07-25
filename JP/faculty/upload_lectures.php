<?php
include '../inc/faculty.php';
require '../db/dbcon.php';

$err= $success= $msg=$msgs=$department=$semester=$sub_id=$unit_id='';
if (isset($_POST['upload']) && $_SERVER["REQUEST_METHOD"] == "POST"  && isset($_SESSION['admin_id'])) 
{
	$flag=true;
	$faculty_id=$_SESSION['faculty_id'];	

	if (empty($_POST['semester']) || empty($_POST['sub_id'])|| empty($_POST['unit_id']) || empty($_POST['topic'])) {
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

	if (empty($_POST['lecture_link']) AND empty($_FILES['file'])) {
		$flag=false;
		$msg="Plese enter value";
	}
	if ($flag==true) {
		
	
		$department = $_SESSION['d_id'];
		$semester = safe_string($_POST["semester"]);
		$sub_id = safe_string($_POST['sub_id']);
		$unit_id = safe_string($_POST['unit_id']);
		$topic = safe_string($_POST['topic']);
		$lecture_link = safe_string($_POST['lecture_link']);

		//file post method
		$file = $_FILES['file'];
		$fileName = $file['name'];
		$fileTmpName = $file['tmp_name'];
		$fileSize = $file['size'];
		$fileError = $file['error'];
		$fileType = $file['type'];
		
		if ($fileError!=0) {
		
			$sql = "INSERT INTO `lectures` (`faculty_id`, `d_id`, `semester`, `sub_id`, `unit_id`, `topic`, `lecture_link`) VALUES ('$faculty_id', '$department', '$semester', '$sub_id', '$unit_id', '$topic', '$lecture_link')";
					$result1 = mysqli_query($con, $sql) ;
					if ($result1) {
						$success='<div class="alert alert-success alert-dismissible fade show" role="alert">
									  <strong>Yotube Video ID!</strong> Uploaded Successfully.
									  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
									    <span aria-hidden="true">&times;</span>
									  </button>
								</div>';
					} else {
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
		
				$fileNameNew=uniqid('',true).".".$fileActualExt;

					$fileDestination = "../lectures/".$fileNameNew;
		// echo $fileDestination;
					
					$move=move_uploaded_file($fileTmpName, $fileDestination);
					if ($move) {

						$sql = "INSERT INTO `lectures` (`faculty_id`, `d_id`, `semester`, `sub_id`, `unit_id`, `topic`,`lecture_path`) VALUES ('$faculty_id', '$department', '$semester', '$sub_id', '$unit_id', '$topic','$fileDestination')";
						$result = mysqli_query($con, $sql);
						if ($result) {
							$success='<tr>
										<td colspan="2" align="center">
											<div class="alert alert-success alert-dismissible fade show" role="alert">
									  			<strong>Video File Uploaded Successfully !</strong> 
											  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											    	<span aria-hidden="true">&times;</span>
											  	</button>
											</div>
										</td>
									</tr>';
						} else {
							echo "<h1>PROBLEM</h1>". mysqli_error($con);
						}
					}
				}
			}else {
			$err='<tr>
					<td colspan="2" align="center">
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<strong>MP4 files only You can upload.!</strong>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    		<span aria-hidden="true">&times;</span>
						 		</button>
						</div>
					</td>
				  </tr>';
			// redirect('upload.php');
			}
		}
	}
}
?>

<body>
		<div class="container bg-white">
			<div class="card-header">
			<div class="row">
				<div class="col-md-12">
					<h3 class="card-title text-lg-center">Upload Lectures  : <em class="text-warning"><?php echo d_id($_SESSION['d_id']); ?></em></h3>
				</div>
				<div class="col-md-3" align="right">
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				
			<form action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>" method="POST" enctype="multipart/form-data">
				<table class="table table-hover table-striped  ">
					
								<span class="text-success "><?php echo $success; ?></span>
								<span class="text-danger font-weight-bold"><?php echo $err; ?></span>
								<span class="text-danger"><?php echo $msgs; ?></span>

						<input type="hidden" name="" id="department" value="<?php echo $_SESSION['d_id']; ?> ">	
						<tr>
							<td id="label"><label for="semester">Semester:</label></td>
							<td>
								<select class='form-control' id='semester' name='semester' size='1'>
									<option value='' disabled='' selected=''>Select Semester</option>
								<?php

									for ($sem=1; $sem <=8 ; $sem++) { 
										if ($sem==$semester) {
									    		echo "<option value='".$semester."'selected>".$semester."</option>";
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
									if ($sub_id!='') {
										# code...
									
									$Select_sub_id = "SELECT * FROM subject WHERE semester={$semester} && d_id={$department}";
								    $SelectResult = mysqli_query($con, $Select_sub_id);

								    while ($sub_id_row = mysqli_fetch_array($SelectResult)) {
								    	if ($sub_id_row['sub_id']==$sub_id) {
								    		echo "<option value='".$sub_id_row['sub_id']."'selected>".$sub_id_row['subject']."</option>";
								    	}else{
								    		echo "<option value='".$sub_id_row['sub_id']."'>".$sub_id_row['subject']."</option>";
								    	}
								    }
}
	    
								?> 
								</select>
						</td>
					</tr>
					<tr>
						<td id="label"><label for="unit_number">Unit Number:</label></td>
						<td>
						<select class='form-control' name='unit_id' id='unit' size='1'>
							<option value='' selected='' disabled=''>Select Unit</option>
							<?php 
								if ($unit_id!='') {
									
									$Select_sub_id = "SELECT * FROM unit WHERE sub_id={$sub_id}";
								    $SelectResult = mysqli_query($con, $Select_sub_id);

								    while ($unit_id_row = mysqli_fetch_array($SelectResult)) {
								    	if ($unit_id_row['unit_id']==$unit_id) {
								    		echo "<option value='".$unit_id_row['unit_id']."'selected>".$unit_id_row['unit_number'].".&nbsp;".$unit_id_row['unit_name']."</option>";
								    	}else{
								    		echo "<option value='".$unit_id_row['unit_id']."'>".$unit_id_row['unit_number'].".&nbsp;".$unit_id_row['unit_name']."</option>";
								    	}
								    }
								} 
							?> 
						</select>
						</td>
					</tr>
					<tr>
						<td id="label"><label for="topic">Topic Name:</label></td>
						<td>
							<input class="form-control" type="text" name="topic" placeholder="Enter Topic Name" required>

						</td>
					</tr>
					<tr>
						<td colspan="2" align="center" class="text-danger font-weight-bold">Please upload You Tube video-link or upload video</td>
					</tr>
					<tr>
						<td id="label"><label for="lecture_link">Video Link:</label></td>
						<td><input class="form-control" type="text" name="lecture_link" placeholder="Enter You Tube Video Link"><br>
							<span class="text-danger"><?php echo $msg; ?></span>
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center" class="text-danger font-weight-bolder">OR</td>
					</tr>
					<tr>
						<td colspan="2" colspan="center">
							<input style="padding-bottom:28px  ; " id="file" type="file" name="file" class="form-control ">
							<span style="font-size: 12px; color: red;">(MP4 only:Maximum size limit= 40MB)</span> <span class="text-danger"><?php echo $err; ?></span>
						</td>
					</tr>
				<tr>
					<td colspan="2" align="center">
						<button class="btn btn-warning" type="submit" name="upload">UPLOAD</button>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
</div>

<script type="text/javascript">
	
</script>
	<?php include 'footer.php'; ?>