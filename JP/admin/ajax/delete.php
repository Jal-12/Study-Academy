<?php 

//select data when semester select option changed start
if (isset($_GET['enrollment'])) {
	$enrollment=$_GET['enrollment'];
require '../db/dbcon.php';
	$sql="DELETE FROM student WHERE enrollment=$enrollment";
	$result=mysqli_query($con, $sql) or die(mysqli_error($con));
	if ($result) {
		echo "<script>  window.history.go(-1); </script>";
	}else{
		$error=mysqli_error($con);
		echo $error;
	}
}

// faculty
if (isset($_GET['faculty_id'])) {
	$faculty_id=$_GET['faculty_id'];
require '../db/dbcon.php';
	$sql="DELETE FROM faculty WHERE faculty_id=$faculty_id";
	$result=mysqli_query($con, $sql) or die(mysqli_error($con));
	if ($result) {
		echo "<script>  window.history.go(-1); </script>";
	}else{
		$error=mysqli_error($con);
		echo $error;
	}
}


// material
if (isset($_GET['material_id'])) {
	$material_id=$_GET['material_id'];
require '../db/dbcon.php';
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
		echo "<script>  window.history.go(-1); </script>";;
	}else{
		$error=mysqli_error($con);
		echo $error;
	}
}

// lecture
if (isset($_GET['lec_id'])) {
	$lec_id=$_GET['lec_id'];
require '../db/dbcon.php';
// unlinking old file while updating new file
	$old_lecture_SQL="SELECT lecture_path FROM `lectures` WHERE lec_id=$lec_id";
	$old_lecture_Result = mysqli_query($con, $old_lecture_SQL);

	if ($old_lecture_Result) {
		
		$old_lecture_Row=mysqli_fetch_array($old_lecture_Result);
		$old_lecture=$old_lecture_Row['lecture_path'];
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


?>