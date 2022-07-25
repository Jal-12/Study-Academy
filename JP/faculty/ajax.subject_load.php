<?php 
require '../db/dbcon.php';
include '../inc/function.php';

//Unit selction
if (isset($_GET['sub_id'])) {

	if (empty($_GET['sub_id'])) {
		echo "";
	}else{

	$sub_id=safe_string($_GET['sub_id']);

	$sql="SELECT * FROM unit WHERE sub_id={$sub_id}";
	$result=mysqli_query($con, $sql) or die(mysqli_error($con));
	?>
	<tr><td colspan="4" align="center" class="font-weight-bold text-primary"><?php echo '<button class="btn-purple">'.sub_id($sub_id).'</button>'; ?></td> </tr>
	<?php

	if (mysqli_num_rows($result)>0) {
	
		while ($row=mysqli_fetch_array($result)) {
			echo'
			<input id="add_unit_sub_id" type="hidden" name="add_unit_sub_id" value="'.$sub_id.'">
			<tr>
					<td align="right" width="8%" class=" font-weight-bold">'.$row['unit_number'].'.</td>
					<td width="70%" class="text-primary font-weight-b old">'.$row['unit_name'].'</td>
					
					<td  width="15%">
						<button class="btn-primary edit-ubtn"  data-euid="'.$row["unit_id"].'" data-toggle="modal" data-target="#unitModal">Edit</button>
					</td>
					<td  width="15%">
						<button class="btn-danger delete-ubtn"  data-duid="'.$row["unit_id"].'">Delete</button>
					</td>
				</tr>';
			}
		} else {
			echo '<input id="add_unit_sub_id" type="hidden" name="add_unit_sub_id" value="'.$sub_id.'">
			<tr><td colspan="4" align="center" class="text-danger">No units found</td></tr>';
		}
	}
}
//Unit selection end

//Insert data fron unit table start
if (isset($_POST['add_unitNumber']) && isset($_POST['add_unitName']) && isset($_POST['add_unit_sub_id'])) {
	$add_unitNumber=safe_string($_POST['add_unitNumber']);
	$add_unitName=safe_string($_POST['add_unitName']);
	$add_unit_sub_id=safe_string($_POST['add_unit_sub_id']);

	$sql="INSERT INTO `unit` (`sub_id`, `unit_number`, `unit_name`) VALUES ('$add_unit_sub_id', '$add_unitNumber', '$add_unitName')";
	$result=mysqli_query($con, $sql);
	// prx($add_unit_sub_id);
	if($result){
		echo 1;
	}else{
		$error=mysqli_error($con);
		
		echo $error;

	}
}
//Insert data fron unit table end

// delete data fron unit table start
elseif (isset($_POST['unit_id'])) {
	$unit_id=$_POST['unit_id'];
	$sql="DELETE FROM unit WHERE unit_id={$unit_id}";
	$result=mysqli_query($con, $sql);
	if($result){
		echo 1;
	}else{
		$error=mysqli_error($con);
		echo $error;
	}
}
// delete data fron unit table end

// update unit 
elseif (isset($_POST['updateUnitNo']) && isset($_POST['updateUnitName']) && isset($_POST['update_unit_id'])) {
	$updateUnitName=safe_string($_POST['updateUnitName']);
	$updateUnitNo=safe_string($_POST['updateUnitNo']);
	$update_unit_id=safe_string($_POST['update_unit_id']);
	$sql="UPDATE `unit` SET `unit_name`='$updateUnitName', `unit_number`='$updateUnitNo',`update_time`=current_timestamp() WHERE unit_id=$update_unit_id";
	$result=mysqli_query($con, $sql);
	
    if($result){
		echo 1;
	
    }else{
		$error=mysqli_error($con);
		echo $error;
	}
}
// update data fron subject table end

// update data fron unit table start
elseif (isset($_POST['update_unit_id'])) {
	$update_unit_id=safe_string($_POST['update_unit_id']);
	
    $sql="SELECT * FROM unit WHERE unit_id={$update_unit_id}";
	$result=mysqli_query($con, $sql);
	$row=mysqli_fetch_array($result);
	if($result){
		echo '<input id="updateUnitNo" class="form-control mr-sm-2 " type="text" name="unit1" value="'.$row['unit_number'].'" placeholder="Enter unit number">
		<label for="unit">Update Unit Name:</label>
		<input id="updateUnitName" class="form-control mr-sm-2 " type="text" name="unit3" value="'.$row['unit_name'].'" placeholder="Enter unit name">
		<input id="update_unit_id"type="hidden" name="unit2" value="'.$row['unit_id'].'">';
	
	}else{
		$error=mysqli_error($con);
		echo $error;
	}
}

//select data when semester select option changed start
if (isset($_POST['semester']) && isset($_POST['d_id'])) {

	if (empty($_POST['semester']) || empty($_POST['d_id'])) {
		echo "";
	}else{

	$d_id=safe_string($_POST['d_id']);
	$semester=safe_string($_POST['semester']);

	$sql="SELECT * FROM subject WHERE d_id={$d_id} && semester={$semester}";
	$result=mysqli_query($con, $sql) or die(mysqli_error($con));

	if (mysqli_num_rows($result)>0) {
	
		$No=0;
		while ($row=mysqli_fetch_array($result)) {
			$No=$No+1;
			echo'<tr>
					<td align="right" width="7%" class=" font-weight-bold">'.$No.'.</td>
					<td width="70%" class="text-danger font-weight-bold">'.$row['subject'].'</td>
					
					<td  width="9%">
						<button class="btn-purple unit"  data-unit="'.$row["sub_id"].'" >Units</button>
					</td>
					<td  width="9%">
						<button class="btn-primary edit-btn"  data-eid="'.$row["sub_id"].'" data-toggle="modal" data-target="#subjectModal">Edit</button>
					</td>
					<td  width="9%">
						<button class="btn-danger delete-btn"  data-did="'.$row["sub_id"].'">Delete</button>
					</td>
				</tr>';
			}
		} else {
			echo '<tr><td colspan="4" align="center" class="text-danger">No subjects found</td></tr>';
		}
	}
}
//select data when semester select option changed end

//Insert data fron subject table start
if (isset($_POST['add_d_id']) && isset($_POST['add_semester']) && isset($_POST['add_subject'])) {
	$add_d_id=$_POST['add_d_id'];
	$add_semester=safe_string($_POST['add_semester']);
	$add_subject=safe_string($_POST['add_subject']);

	$sql="INSERT INTO `subject` (`d_id`, `semester`, `subject`) VALUES ('$add_d_id', '$add_semester', '$add_subject')";
	$result=mysqli_query($con, $sql);
	if($result){
		echo 1;
	}else{
		$error=mysqli_error($con);
		echo $error;
	}
}
//Insert data fron subject table end

// update data fron subject table start
if (isset($_POST['update_sub_id'])) {
	$update_sub_id=safe_string($_POST['update_sub_id']);
	
    $sql="SELECT * FROM subject WHERE sub_id={$update_sub_id}";
	$result=mysqli_query($con, $sql);
	$row=mysqli_fetch_array($result);
	if($result){
		echo '<input id="updateSub" class="form-control mr-sm-2 " type="text" name="subject" value="'.$row['subject'].'" placeholder="Enter subject">
		<input id="updateSub_id" class="form-control mr-sm-2 " type="hidden" name="subject" value="'.$row['sub_id'].'" placeholder="Enter subject">';
	
	}else{
		$error=mysqli_error($con);
		echo $error;
	}
}

if (isset($_POST['updateSubject']) && isset($_POST['updateSub_id'])) {
	$updateSubject=safe_string($_POST['updateSubject']);
	$updateSub_id=safe_string($_POST['updateSub_id']);
	$sql="UPDATE `subject` SET `subject`='$updateSubject',`update_time`=current_timestamp() WHERE sub_id=$updateSub_id";
	$result=mysqli_query($con, $sql);
	
    if($result){
		echo 1;
	}else{
		$error=mysqli_error($con);
		echo $error;
	}
}
// update data fron subject table end

// delete data fron subject table start
if (isset($_POST['sub_id'])) {
	$sub_id=$_POST['sub_id'];
	$sql="DELETE FROM subject WHERE sub_id={$sub_id}";
	$result=mysqli_query($con, $sql);
	if($result){
		echo 1;

	}else{
		$error=mysqli_error($con);
		echo $error;

	}
}
// delete data fron subject table end

// for upload /edit materials and lectures
//select data when semester select option changed start
if (isset($_POST['semester']) && isset($_POST['department'])) {
	$department=safe_string($_POST['department']);
		$semester=safe_string($_POST['semester']);
	
		$sql="SELECT * FROM subject WHERE d_id={$department} && semester={$semester}";
		$result=mysqli_query($con, $sql) ;
		
	if($result){
		while ($row=mysqli_fetch_array($result)) {
		    echo'<option value="'.$row['sub_id'].'" >'.$row['subject'].'</option>';
		}
	}else{
		$error=mysqli_error($con);
		echo $error;
	}
}//select data when semester select option changed end

//select data when semester select option changed start
if (isset($_POST['uploadEditsub_id'])) {
	$sub_id=safe_string($_POST['uploadEditsub_id']);

		$sql="SELECT * FROM unit WHERE sub_id={$sub_id}";
		$result=mysqli_query($con, $sql) ;
	
        if($result){
		while ($row=mysqli_fetch_array($result)) {
			echo "<option value='".$row['unit_id']."'>".$row['unit_number'].".&nbsp;".$row['unit_name']."</option>";
		}
	}else{
		$error=mysqli_error($con);
		echo $error;
	}
}//select data when semester select option changed end

?>