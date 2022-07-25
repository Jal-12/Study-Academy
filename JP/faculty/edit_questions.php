<?php
include '../inc/faculty.php';
require '../db/dbcon.php';


if (isset($_GET['group_id']) && isset($_GET['exam_id'])) {
	$group_id=safe_string($_GET['group_id']);
	$exam_id=safe_string($_GET['exam_id']);

	if (isset($_POST['add_question'])  && isset($_GET['group_id'])) {
			
		// $group_id=$_GET['group_id'];
			$question=safe_string($_POST['question']);
			$option_1=safe_string($_POST['option_1']);
			$option_2=safe_string($_POST['option_2']);
			$option_3=safe_string($_POST['option_3']);
			$option_4=safe_string($_POST['option_4']);
			$answer=safe_string($_POST['answer']);

		// prx($loop);
			$sql="UPDATE `exam` SET `question`='$question', `option_1`='$option_1', `option_2`='$option_2', `option_3`='$option_3', `option_4`='$option_4', `answer`='$answer' WHERE group_id=$group_id AND exam_id=$exam_id";
			// die($sql);
			$result=mysqli_query($con, $sql);
			if (!$result) {// if any erroe in inserting
				$error = mysqli_error($con);
				echo "<center><h2>No reocrds inserted !!<br>" . $error . "<h2></center>";
			}else{
				echo "<script>  window.history.go(-2); </script>";	
			}
	}else{

		$esql="SELECT * from exam WHERE exam_id=$exam_id AND group_id=$group_id";
		$eres=mysqli_query($con,$esql);
		if(mysqli_num_rows($eres)>0){
			$erow=mysqli_fetch_assoc($eres);
		}else{
			echo "Error 404 Not found Invalid Group Id";
		}
	}

	$sub_id=mysqli_fetch_array(mysqli_query($con,"SELECT sub_id FROM exam_group WHERE group_id=$group_id"));
?>

	<body >
		<div class="container" style="font-size: 17px;">
			<center>
				<div class="row col-md-6">
				<h3 class="rounded-pill shadow-lg text-light  mt-4 p-3 ">Add Questions in <b class="text-warning"><i><?php echo sub_id($sub_id['sub_id']); ?></i></b></h3>
			</div>
			</center>
			
			<div class="row">
			<div class="col-md-8 offset-md-2 bg-light p-4 mt-5 rounded">

				<form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']) ?>" method="POST">
					<label for="question">Update Questions</label>
					<div class="form-group">
						<label for="question">Question :</label>
						<input type="text" name="question" value="<?php echo $erow['question'] ?> " placeholder="Enter question" class="form-control" ><br>
					</div>
					<div class="form-group">
						<label for="question">Enter Options</label>
						<input type="text" name="option_1" value="<?php echo $erow['option_1'] ?> " placeholder="Enter Option A" class="form-control" ><br>
						<input type="text" name="option_2" value="<?php echo $erow['option_2'] ?> " placeholder="Enter Option B" class="form-control" ><br>
						<input type="text" name="option_3" value="<?php echo $erow['option_3'] ?> " placeholder="Enter Option C" class="form-control" ><br>
						<input type="text" name="option_4" value="<?php echo $erow['option_4'] ?> " placeholder="Enter Option D" class="form-control" ><br>
						<label for="question">Correct Option</label>
						<!-- <input type="text" name="answer" placeholder="Enter correct answer" class="form-control" ><br> -->
						<select name="answer" class="form-control">

							<option  value="option_1" <?php if($erow['answer']=='option_1'){
								echo "selected";
							}  ?> >A</option>
							<option value="option_2" <?php if($erow['answer']=='option_2'){
								echo "selected";
							}  ?> >B</option>
							<option value="option_3" <?php if($erow['answer']=='option_3'){
								echo "selected";
							}  ?> >C</option>
							<option value="option_4" <?php if($erow['answer']=='option_4'){
								echo "selected";
							}  ?> >D</option>
						</select>
					</div>
					<center>
						<button name="add_question" type="submit" class="btn btn-primary">
							Update Question
						</button>
                                <a href="view_questions.php?group_id=<?php echo $group_id; ?>" class="btn  btn-success ">View Questions</a>						
					</center>
				</form>
			</div>
		</div>
		</div>

<?php }else{
	echo "Error 404 Not found Invalid Group Id";
}
include 'footer.php'; ?>