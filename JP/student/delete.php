<?php 
require '../db/dbcon.php';

if (isset($_POST['comment_id'])) {

	$comment_id=$_POST['comment_id'];
	$sql="DELETE FROM comments WHERE comment_id=$comment_id";
	$result=mysqli_query($con,$sql) or die(mysqli_error($con));
	// die($result);
	if ($result) {
		echo 1;
	}else{
		echo 0;
	}

}

if (isset($_POST['question_id'])) {

	$question_id=$_POST['question_id'];
	$sql="DELETE FROM ask_question WHERE que_id=$question_id";
	$result=mysqli_query($con,$sql) or die(mysqli_error($con));
	// die($result);
	if ($result) {
		echo 1;
	}else{
		echo 0;
	}

}

?>

