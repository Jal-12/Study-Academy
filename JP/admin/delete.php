<?php 
include '../inc/function.php';
require '../db/dbcon.php';

//delete group
if (isset($_GET['group_id']))
 {
	$group_id=$_GET['group_id'];	
	$sql="DELETE FROM exam_group WHERE group_id=$group_id";
	$result=mysqli_query($con, $sql) or die(mysqli_error($con));
	if ($result)
	 {
		echo "<script>  window.history.go(-1); </script>";
	}else{
		$error=mysqli_error($con);
		echo $error;
	}
}
//delete group ends

if (isset($_GET['enrollment']))
 {
	$enrollment=$_GET['enrollment'];	
	$sql="DELETE FROM student WHERE enrollment=$enrollment";
	$result=mysqli_query($con, $sql) or die(mysqli_error($con));
	if ($result) {
		echo "<script>  window.history.go(-1); </script>";
	}else{
		$error=mysqli_error($con);
		echo $error;
	}
}
//delete students ends

//delete faculty
if (isset($_GET['faculty_id'])) {
	$faculty_id=$_GET['faculty_id'];
	
	$sql="DELETE FROM faculty WHERE faculty_id=$faculty_id";
	$result=mysqli_query($con, $sql) or die(mysqli_error($con));
	if ($result) {
		echo "<script>  window.history.go(-1); </script>";
	}else{
		$error=mysqli_error($con);
		echo $error;
	}
}

//delete materials starts
if (isset($_GET['material_id']))
 {
	$material_id=$_GET['material_id'];
	$old_Material_SQL="SELECT file FROM `study_materials` WHERE material_id=$material_id";
// unlinking old file while updating new file
	$old_Material_Result = mysqli_query($con, $old_Material_SQL);
	$old_Material_Row=mysqli_fetch_array($old_Material_Result);
	$old_material=$old_Material_Row['file'];
	unlink($old_material);
// successfully unliking completed
	$sql="DELETE FROM study_materials WHERE material_id=$material_id";
	$result=mysqli_query($con, $sql) or die(mysqli_error($con));
	if ($result) {
		echo "<script>  window.history.go(-1); </script>";
	}else{
		$error=mysqli_error($con);
		echo $error;
	}
}
//delete materials ends

//delete lectures starts
if (isset($_GET['lec_id']))
 {
	$lec_id=$_GET['lec_id'];
// unlinking old file while updating new file
	$old_lecture_SQL="SELECT lecture_path FROM `lectures` WHERE lec_id=$lec_id";
	$old_lecture_Result = mysqli_query($con, $old_lecture_SQL);
	
	// prx($old_lecture_Result);
		$old_lecture_Row=mysqli_fetch_array($old_lecture_Result);
		$old_lecture=$old_lecture_Row['lecture_path'];

	if ($old_lecture!=NULL)
	 {
		unlink($old_lecture);
	// successfully unliking completed
		$sql="DELETE FROM lectures WHERE lec_id=$lec_id";
		$result=mysqli_query($con, $sql) or die(mysqli_error($con));
	}else{
		$sql="DELETE FROM lectures WHERE lec_id=$lec_id";
		$result=mysqli_query($con, $sql) or die(mysqli_error($con));
	}
	
	if ($result) {
		echo "<script>  window.history.go(-1); </script>";
	}else{
		$error=mysqli_error($con);
		echo $error;
	}
}
//delete lectures ends

//delete question from exam start
if (isset($_GET['group_id']) && isset($_GET['exam_id']))
 {
	$group_id=$_GET['group_id'];
	$exam_id=$_GET['exam_id'];
	$sql="DELETE FROM exam WHERE group_id=$group_id AND exam_id=$exam_id";
	$result=mysqli_query($con, $sql) or die(mysqli_error($con));
	if ($result) {
		$loop=0;
			$count=0;
			$res=mysqli_query($con,"SELECT * from exam WHERE group_id=$group_id ORDER BY exam_id ASC");
			$count=mysqli_num_rows($res);
			if ($count==0) {
				echo "<script>  window.history.go(-1); </script>";
			}else{
				while ($row=mysqli_fetch_assoc($res)) {
					$loop=$loop+1;
					$ei=$row['exam_id'];
					// pr($loop);
					$r=mysqli_query($con,"UPDATE exam SET que_no=$loop WHERE group_id=$group_id AND exam_id=$ei");
				}
				if ($r) {
					echo "<script>  window.history.go(-1); </script>";
				}
			}	
	}else{
		$error=mysqli_error($con);
		echo $error;
	}
}
//delete question from exam end


if (isset($_POST['comment_id']))
 {
	$comment_id=$_POST['comment_id'];
	$sql="DELETE FROM comments WHERE comment_id=$comment_id";
	$result=mysqli_query($con,$sql) or die(mysqli_error($con));
	if ($result) {
		echo 1;
	}else{
		echo 0;
	}
}

// notice delete
if (isset($_POST['notice_id'])) 
{
	$notice_id=$_POST['notice_id'];
	$sql="DELETE FROM notice WHERE notice_id=$notice_id";
	$result=mysqli_query($con,$sql) or die(mysqli_error($con));
	if ($result) {
		echo 1;
	}else{
		echo 0;
	}
}

//ask_question delete
if (isset($_GET['que_id'])) 
	{
	$que_id=$_GET['que_id'];
	$sql="DELETE FROM ask_question WHERE que_id=$que_id";
	$result=mysqli_query($con,$sql) or die(mysqli_error($con));
	if ($result) {
		echo "<script>  window.history.go(-1); </script>";
	}else{
		$error=mysqli_error($con);
		echo $error;
	}
}

//delete connect_group of student
if (isset($_GET['group_id']) && isset($_GET['stu_id']))
 {
	$group_id=$_GET['group_id'];
	$stu_id=$_GET['stu_id'];
	$sql="DELETE FROM connect_group WHERE group_id=$group_id AND stu_id=$stu_id";
	$result=mysqli_query($con, $sql) or die(mysqli_error($con));
	if ($result) {
		echo "<script>  window.history.go(-1); </script>";
	}else{
		$error=mysqli_error($con);
		echo $error;
	} 
}
//delete result of student
if (isset($_GET['stu_id']))
 {
	$stu_id=$_GET['stu_id'];	
	$sql="DELETE FROM result WHERE stu_id=$stu_id";
	$result=mysqli_query($con, $sql) or die(mysqli_error($con));
	if ($result) {
		echo "<script>  window.history.go(-1); </script>";
	}else{
		$error=mysqli_error($con);
		echo $error;
	}
}

//delete response of student
if (isset($_GET['stu_id']))
 {
	$stu_id=$_GET['stu_id'];	
	$sql="DELETE FROM response WHERE stu_id=$stu_id";
	$result=mysqli_query($con, $sql) or die(mysqli_error($con));
	if ($result) {
		echo "<script>  window.history.go(-1); </script>";
	}else{
		$error=mysqli_error($con);
		echo $error;
	}
}

?>