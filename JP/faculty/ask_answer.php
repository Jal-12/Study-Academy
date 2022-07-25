<?php 
include '../inc/faculty.php';
require '../db/dbcon.php';

if (isset($_GET['que_id']))
 {
	$que_id=($_GET['que_id']);
	
    if (isset($_POST['ask_answer']))
     {
		$question = safe_string( $_POST["question"]);
		$answer = safe_string($_POST['answer']);
		$admin_id=$_SESSION['admin_id'];
		$faculty_id=$_SESSION['faculty_id'];
		
		$loop=0;
		$count=0;
		$res=mysqli_query($con,"SELECT * from ask_question WHERE que_id=$que_id");
		$count=mysqli_num_rows($res);
		if ($count==0)
		 {
		}else{
			while ($row=mysqli_fetch_array($res)) {
			$loop=$loop+1;
			mysqli_query($con,"UPDATE ask_question SET `answer`='$answer', `faculty_id`='$faculty_id', `admin_id`=NULL, `update_time`=current_timestamp() WHERE que_id=$que_id");
			}
		}
		if (!$count) 
		{
			// if any erroe in inserting
			$error = mysqli_error($con);
				echo "<center><h2>No reocrds inserted !!<br>" . $error . "<h2></center>";
		}else{
				echo "<script> alert('Answer Added Successfully'); </script>";
                echo "<script>  window.history.go(-2); </script>";
			 }
	}
	// question
	if (isset($_GET['que_id']))
	 {
		$que_id=$_GET['que_id'];
		$sql="SELECT * FROM `ask_question` WHERE que_id=$que_id";
		$status = mysqli_query($con, $sql);
		if (mysqli_num_rows($status)) {
			$row=mysqli_fetch_array($status);
?>

<body >
	<div class="container mt-5 bg-light p-3">
	<div class="card-header">
		<div class="row">
	        <div class="col-md-12">
			<h3 class="text-center font-weight-bold">Add Answer</h3>
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="table-responsive">		
			
			<form action="" method="POST">
			<table class="table table-hover table-striped  ">
			<tr>
				<td><label for="question">Question:</label></td>
				<td><?php echo $row['que_id']; ?>. 
					<?php echo $row['question']; ?>
				<input type="text" id="question" name="question" hidden value="<?php echo $row['question']; ?>" autocomplete="off"><br/></td>
			</tr>
			<tr>
				<td><label for="answer">Answer:</label></td>
				<td>
				<input type="text" name="answer" placeholder="Enter Answer" class="form-control" autocomplete="off"><br>
				</td>
			</tr>	
			<tr>
				<td colspan="2" align="center">
				<button name="ask_answer" type="submit" class="btn btn-primary">
					Add Question
				</button>
			</tr>
			</table>
			</form>
            <?php
			
			 }
            ?>
		</div>
    </div>
	<?php include 'footer.php'; ?>
</div>  
<?php 
	}
}
?>