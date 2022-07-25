<?php
include '../inc/student.php';
require '../db/dbcon.php';

$err=$success=$msg=$msgs=$department=$semester=$unit_id='';

if (isset($_POST['question']) && $_SERVER['REQUEST_METHOD']=='POST'  && isset($_SESSION['stu_id'])) {

    $flag=true;
	$stu_id=$_SESSION['stu_id'];

    if (empty($_POST['semester']) || empty($_POST['sub_id']) || empty($_POST['unit_id']) || empty($_POST['question']) ) {
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

    require '../db/dbcon.php';
    $department = $_SESSION['d_id'];
    $semester = safe_string( $_POST["semester"]);
    $sub_id = safe_string( $_POST['sub_id']);
    $unit_id = safe_string( $_POST['unit_id']);
    $question = safe_string( $_POST['question']);
                
    // $sub_id=safe_string($_GET['sub_id']);
        
        //insert query 
        $sql="INSERT INTO `ask_question` (`stu_id`, `d_id`, `semester`, `sub_id`, `unit_id`,`question`) VALUES('$stu_id', '$department', '$semester', '$sub_id',  '$unit_id', '$question')";
            $result=mysqli_query($con,$sql) or die(mysqli_error($con));
            if ($result) {
                $success= '
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Question Added Successfully!</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                   ';
            
               }else{
                    echo "<h1>PROBLEM</h1>". mysqli_error($con);
                }
            }
    ?> 
    <body>
	<div class="container bg-white">
		<div class="card-header">
			<div class="row">
				<div class="col-md-12">
					<h3 class="card-title text-lg-center ">Ask-Question: <em class="text-warning"><?php echo d_id($_SESSION['d_id']); ?></em></h3>					
				</div>
				<div class="col-md-3" align="right">
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				
				<form action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>" method="POST" enctype="multipart/form-data">
					<table class="table thover ts">
						
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
							<td id="label"><label for="unit_number">Unit:</label></td>
							<td>
							<select class='form-control' name='unit_id' id='unit' size='1'>
								<option value='' selected='' disabled=''>Select Unit</option>
								<?php 
								if ($unit_id!='')
								 {	
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
							<td colspan="2" colspan="center"><input style="padding-bottom:28px  ; " type="file" name="file" class="form-control " id="file" required>
							<span style="font-size: 12px; color: red;">(Maximum size limit= 40MB)</span> <span class="text-danger"><?php echo $err; ?></span>
							</td>
						</tr>
					<tr>
						<td colspan="2" align="center">
							<button class="btn btn-warning" type="submit" name="question">UPLOAD</button>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</div>
   <?php include 'footer.php'; ?>