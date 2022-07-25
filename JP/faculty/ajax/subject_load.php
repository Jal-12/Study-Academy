<?php 
require '../../db/dbcon.php';

//select data when semester select option changed start
if (isset($_POST['semester']) && isset($_POST['d_id'])) {

	if (empty($_POST['semester']) || empty($_POST['d_id'])) {
		echo "";
	}else{

	$d_id=$_POST['d_id'];
	$semester=$_POST['semester'];

	$sql="SELECT * FROM subject WHERE d_id={$d_id} && semester={$semester}";
	$result=mysqli_query($con, $sql) or die(mysqli_error($con));
	$No=0;
	while ($row=mysqli_fetch_array($result)) {
		$No=$No+1;
		echo'<tr>
				<td align="right" width="10%" class=" font-weight-bold">'.$No.'.</td>
				<td width="70%" class="text-danger font-weight-bold">'.$row['subject'].'</td>
				<td  width="10%">
					<button class="btn-primary edit-btn"  data-eid="'.$row["sub_id"].'">Edit</button>
				</td>
				<td  width="10%">
					<button class="btn-danger delete-btn"  data-did="'.$row["sub_id"].'">Delete</button>
				</td>
			</tr>';
		}
	}
}
//select data when semester select option changed end


//Insert data fron subject table start
if (isset($_POST['add_d_id']) && isset($_POST['add_semester']) && isset($_POST['add_subject'])) {
	$add_d_id=$_POST['add_d_id'];
	$add_semester=$_POST['add_semester'];
	$add_subject=$_POST['add_subject'];

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

//select data when semester select option changed start
if (isset($_POST['semester']) && isset($_POST['department'])) {
	$department=$_POST['department'];
	$semester=$_POST['semester'];
	
	
		$sql="SELECT * FROM subject WHERE d_id={$department} && semester={$semester}";
		$result=mysqli_query($con, $sql) ;
		// $No=0;
	if($result){
		while ($row=mysqli_fetch_array($result)) {
			// $No=$No+1;
			echo'<option value="'.$row['sub_id'].'" >'.$row['subject'].'</option>';
		}
	}else{
		$error=mysqli_error($con);
		echo $error;

	}
}//select data when semester select option changed end

?>