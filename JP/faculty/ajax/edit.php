<?php 

include '../../inc/function.php';
//select data when semester select option changed start
if (isset($_POST['enrollment'])) {
	$enrollment=$_POST['enrollment'];
require '../../db/dbcon.php';
	$sql="SELECT * FROM student WHERE enrollment={$enrollment}";
	$result=mysqli_query($con, $sql) or die(mysqli_error($con));
	$No=0;
	while ($row=mysqli_fetch_array($result)) {
		$No=$No+1;
		echo'<tr>
				<td><label for="enrollment">Enrollment_No: </lable></td>
				<td>'.$row['enrollment'].'
				<input type="text" id="uname" hidden value="'.$row['enrollment'].'" name="enrollment" autocomplete="off" placeholder="Enter UserName" required><br/></td>
			</tr>
			<tr >
				<td><label for="username">User Name: </label></td>
				<td><input type="text" id="uname" value="'.$row['username'].'" name="username" autocomplete="off" placeholder="Enter UserName" required><br/></td>
			</tr>			
			<tr>
				<td><label for="email">E-mail: </label></td>
				<td><input type="email" id="email" value="'.$row['email'].'" name="email" autocomplete="off" placeholder="Enter Email" require><br/></td>
			</tr>
			<tr>
				<td><label for="mobile">Contact_Number: </label></td>
				<td><input type="num" id="mobile" value="'.$row['mobile'].'" name="mobile" autocomplete="off" placeholder="Enter ContactNumber" require><br/></td>
			</tr>
			<tr>
				<td><label>Department:</label></td>
				<td>'.d_id($row['d_id']).'</td>
			</tr>
			<tr>
            <td><label for="semester">Semester:</label></td>
				<td>'.$row['semester'].'</td>
			</tr>	
			<tr>';
	}
}//select data when semester select option changed end


//Insert data fron subject table start
if (isset($_POST['enrollment']) &&isset($_POST['uname']) && isset($_POST['email']) && isset($_POST['mobile'])) {
	$enrollment=$_POST['enrollment'];
	$uname=$_POST['uname'];
	$email=$_POST['email'];
	$mobile=$_POST['mobile'];

	$sql="UPDATE `student` SET `username`='$uname', `email`='$email', `mobile`='$mobile' WHERE enrollment=$enrollment";
	$result=mysqli_query($con, $sql);
	if($result){
		echo 1;

	}else{
		$error=mysqli_error($con);
		echo $error;

	}
}


?>