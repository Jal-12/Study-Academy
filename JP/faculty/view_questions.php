<?php
include '../inc/faculty.php';
require '../db/dbcon.php';

	if (isset($_GET['group_id'])>0 && $_GET['group_id']!='') {
		// pagination of 5 pages code
		$limit=10; // limit of the rows per table ex. 5 item per page

		// if page admin clicks on page then it runs
		if (isset($_GET['page'])) {
			$page=$_GET['page'];
		}else{
			$page=1;
		}

		$offset=($page-1)*$limit;

		// seleting subject from subject table
		$group_id =$_GET['group_id'];
		$subResult=mysqli_query($con,"SELECT sub_id FROM exam_group WHERE group_id=$group_id");
		$subject=mysqli_fetch_assoc($subResult);
		// seleting questions from exam table
	
?>
	<body class="bg-info">
		<div class="card">
			<div class="card-header">
				<h3 class="text-center font-weight-bold"><?php echo sub_id($subject['sub_id']); ?> Questions</h3>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table thover ts table-bordered">
						<thead class="table-secondary">
							<tr>
								<th width="2%">No</th>
								<th width="25%">Questions</th>
								<th width="12%">Option A</th>
								<th width="12%">Option B</th>
								<th width="12%">Option C</th>
								<th width="12%">Option D</th>
								<th width="5%">Answer</th>
								
								<th width="8%" colspan="2">Action</th>
							</tr>
						</thead>
						<tbody>
		
			<?php
	$sql="SELECT * FROM exam WHERE exam.group_id=$group_id LIMIT {$offset},{$limit}";
	$result=mysqli_query($con,$sql);
	$records=mysqli_num_rows($result);
	if ($records==0){
		echo "<td colspan='9' align='center' class='text-danger'><b>No Questions!</td></b>";

	}else{			
							
			$No = $offset;
		while ($row = mysqli_fetch_array($result)) {
			$No = $No + 1;
		?>
							<tr>
								<td><?php echo "<b>".$No."</b>"; ?></td>
								<td><?php echo $row['question']; ?></td>
								<td><?php echo $row['option_1']; ?></td>
								<td><?php echo $row['option_2']; ?></td>
								<td><?php echo $row['option_3']; ?></td>
								<td><?php echo $row['option_4']; ?></td>
								<td><?php echo $row['answer']; ?></td>
								<td >
									<a href="edit_questions.php?exam_id=<?php echo $row['exam_id']; ?>&group_id=<?php echo $group_id ?>" class="btn  btn-primary">Edit</a>
								</td>
								<td >
									<a href="delete.php?exam_id=<?php echo $row['exam_id']; ?>&group_id=<?php echo $group_id ?>" class="btn  btn-danger">Delete</a>
								</td>
							</tr>
					<?php
							}
					?>

							</tbody>
						</table>
					</div>
				</div>
			</div>
<div class="container mt-3">	
<?php
			$total_page=ceil($records/$limit); 

			echo'<ul class="pagination justify-content-center">';
			// for loop start
			for ($i=1; $i<=$total_page; $i++) {

				if ($i==$page) {
					$active='active';
				} else{
					$active="";
				}
				
					$PageNo='<li class="page-item '.$active.'"><a class="page-link" href="view_questions.php?group_id='.$group_id.'&page='.$i.'">'.$i.'</a></li>';
				
				echo $PageNo;
			}// for loop end
			echo'</ul>';
		}
			
		// pagination code ends here with group wise
} else {
		echo "<h2 class='text-danger text-center mt-5'>Invalid ID</h2> ";
}

?>
</div>
			
					
</body>
</html>