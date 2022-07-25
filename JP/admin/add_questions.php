<?php
include '../inc/top.php';
require '../db/dbcon.php';

if (isset($_GET['group_id']))
{
$group_id=$_GET['group_id'];
$msgs="";
$msg="";
$success='';

	if (isset($_POST['add_question'])  && isset($_GET['group_id']))
	 {
		$flag=true;

		if (empty($_POST['question']) || empty($_POST['option_1'])|| empty($_POST['option_2']) ||empty($_POST['option_3']) || empty($_POST['option_4']) || empty($_POST['answer'])) 
		{
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

		if ($flag==true)
		 {
			$question=safe_string($_POST['question']);
			$option_1=safe_string($_POST['option_1']);
			$option_2=safe_string($_POST['option_2']);
			$option_3=safe_string($_POST['option_3']);
			$option_4=safe_string($_POST['option_4']);
			$answer=safe_string($_POST['answer']);

			$loop=0;
			$count=0;
			$res=mysqli_query($con,"SELECT * from exam WHERE group_id=$group_id ORDER BY group_id ASC");
			$count=mysqli_num_rows($res);
			if ($count==0)
			 {
			 }else{
				while ($row=mysqli_fetch_array($res))
				 {
					$loop=$loop+1;
					mysqli_query($con,"UPDATE exam SET que_no='$loop' WHERE group_id=$group_id");
				}
			}
			$loop=$loop+1;
			$sql="INSERT INTO `exam` (`group_id`,`que_no`,`question`, `option_1`, `option_2`, `option_3`, `option_4`, `answer`) VALUES ('$group_id','$loop', '$question', '$option_1', '$option_2', '$option_3', '$option_4', '$answer')";
			// die($sql);
			$result=mysqli_query($con, $sql);
			if (!$result)
			 {// if any erroe in inserting
				$error = mysqli_error($con);
				echo "<center><h2>No reocrds inserted !!<br>" . $error . "<h2></center>";
			}else{
				$success='<tr>
						<td colspan="2" align="center">
							<div class="alert alert-success alert-dismissible fade show" role="alert">
								<strong>1 Question added Successfully !</strong> 
								  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
								  	</button>
							</div>
						</td>
						</tr>';
				}
			}
		}
	$sub_id=mysqli_fetch_array(mysqli_query($con,"SELECT sub_id FROM exam_group WHERE group_id=$group_id"));
?>

	<body >
		<div class="container" style="font-size: 17px;">
			<center>
				<div class="row col-md-6">
				<h3 class="rounded-pill shadow-lg text-light  mt-3 p-3" >
				Add Questions In <b class="text-warning"><i><?php echo sub_id($sub_id['sub_id']); ?></i></b></h3>
			</div>
			</center>
			
			<div class="row">
			<div class="col-md-10 offset-md-1 bg-light p-4 mt-3 rounded">

				<form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']) ?>" method="POST">
				<span class="text-danger"><?php echo $msgs; ?></span>
				<span class="text-success "><?php echo $success; ?></span>

					<label for="question">Add Questions</label>
					<div class="form-group">
						<label for="question">Question :</label>
						<input type="text" name="question" placeholder="Enter question" class="form-control" required><br>
					</div>
					<div class="form-group">
						<label for="question">Enter Options</label>
						<input type="text" name="option_1" placeholder="Enter Option A" class="form-control" required><br>
						<input type="text" name="option_2" placeholder="Enter Option B" class="form-control" required><br>
						<input type="text" name="option_3" placeholder="Enter Option C" class="form-control" required><br>
						<input type="text" name="option_4" placeholder="Enter Option D" class="form-control" required><br>
						<label for="question">Correct Option</label>
						<!-- <input type="text" name="answer" placeholder="Enter correct answer" class="form-control" ><br> -->
						<select name="answer" class="form-control">
							<option value="option_1">A</option>
							<option value="option_2">B</option>
							<option value="option_3">C</option>
							<option value="option_4">D</option>
						</select>
					</div>
					<center>
						<button name="add_question" type="submit" class="btn btn-primary">
							Add Question
						</button>
						<a href="view_questions.php?group_id=<?php echo $group_id; ?>" class="btn  btn-success ">View Questions</a>
					</center>
				</form>
			</div>
		</div>
		<?php include 'footer.php'; ?>
	</div>
	</body>
</html>
<?php
	} else{
	echo "Error 404 Not found Invalid Group Id";
	}
?>