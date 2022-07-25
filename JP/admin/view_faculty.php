<?php
// session_start();
	include '../inc/top.php';
	require '../db/dbcon.php';

	if(isset($_GET['d_id'])>0 && $_GET['d_id']<5 && $_GET['d_id']!='') 
	{
// pagination of 5 pages code
		$limit=5; // limit of the rows per table ex. 5 item per page

// if page admin clicks on page then it runs
		if (isset($_GET['page'])) {
			$page=$_GET['page'];
		}else{
			$page=1;
		}

		$offset=($page-1)*$limit;

		$d_id =$_GET['d_id'];
		$Query="SELECT department FROM department WHERE d_id=$d_id";
		$qResult=mysqli_query($con,$Query);
		$dep=mysqli_fetch_assoc($qResult);
?>
<!DOCTYPE html>
<head>
	<title>View Student Records</title>
	<style type="text/css">
		.ts tbody tr:nth-of-type(odd) {
		background-color: rgba(0, 0, 0, 0.05);
	}
	.thover tbody tr:hover {
		color: #212529;
		background-color: #ffe8a1;
	}
	</style>
</head>
<body>
<div class="container-fluid mt-3">
	<div class="card">
		<div class="card-header">
			<h3 class="text-center font-weight-bold"><?php echo $dep['department']; ?> Records</h3>
		</div>
		<div class="card-body">
			<div class="row grid_box">
				<!-- <div class="col-12"> -->
					<div class="table-responsive">
						<table class="table thover ts table-bordered">
							<thead class="table-primary">
								<tr class="">
									<th width="1%" style="text-align: center">No</th>
									<th width="10%" style="text-align: center">Faculty ID</th>
									<th width="13%" style="text-align: center">Username</th>
									<th width="13%" style="text-align: center">Email</th>
									<th width="8%" style="text-align: center">Mobile</th>
									<th width="10%" style="text-align: center">Department</th>
									<th width="6%" style="text-align: center">Status</th>
									<th width="10%" colspan="2">Action</th>
								</tr>
							</thead>
							<tbody>
		<?php
	// data fetching through department wise
		$sql="SELECT faculty.faculty_id, faculty.username, faculty.mobile, faculty.email, faculty.status, department.department FROM faculty,department WHERE faculty.d_id=$d_id && department.d_id=$d_id LIMIT {$offset},{$limit}";

	//pagination query through department wise
		$sql1="SELECT * FROM `faculty` WHERE faculty.d_id=$d_id";

	//fetch the student data from databse
		$result=mysqli_query($con,$sql);
		$records=mysqli_num_rows($result);
		if ($records>0) {
			$No = 0;
		while ($row = mysqli_fetch_array($result)) {
			$No = $No + 1;
		?>
								<tr>
									<td style="text-align: center"><?php echo "<b>".$No."</b>"; ?></td>
									<td style="text-align: center"><h6><?php echo $row['faculty_id']; ?></h6></td>
									<td style="text-align: center"><h6><?php echo $row['username']; ?></h6></td>
									<td style="text-align: center"><h6><?php echo $row['email']; ?></h6></td>
									<td style="text-align: center"><h6><?php echo $row['mobile']; ?></h6></td>
									<td style="text-align: center"><h6><?php echo $row['department']; ?></h6></td>
									<td style="text-align: center">
									<?php
										echo'<div class="float-center" style="color: #00c6ff; font-size:16px;">
												<h6>'.$row['status'].'</h6>
											</div>'; 
									?></td>
									<td style="text-align: center">
									<a href="edit_faculty.php?faculty_id=<?php echo $row['faculty_id']; ?>" class="btn btn-sm btn-primary" >Update</a>
									</td>
									<td style="text-align: center">
									<a href="delete.php?faculty_id=<?php echo $row['faculty_id']; ?>" class="btn btn-sm btn-danger" >Delete</a>
									</td>
								</tr>
					<?php
							}
					} 
			?>

							</tbody>
						</table>
						</div>
					</div>
				</div>
	<div class="container mt-3">	

	<?php

	// pagination code starts here with department wise		
		$records1=mysqli_num_rows(mysqli_query($con,$sql1));
	
		if ($records1>0) {
		
			$total_page=ceil($records1/$limit); 

			echo'<ul class="pagination justify-content-center">';
			for ($i=1; $i<=$total_page; $i++) {

				if ($i==$page) {
					$active='active';
				} else{
					$active="";
				}
					$PageNo='<li class="page-item '.$active.'"><a class="page-link" href="view_faculty.php?d_id='.$d_id.'&page='.$i.'">'.$i.'</a></li>';
				echo $PageNo;
			}
			echo'</ul>';
			}
			
	// pagination code ends here with department wise
	} else {
		echo "<h2 class='text-danger text-center mt-5'>Invalid ID</h2> ";
	}
	?>
</div>
</div>
<?php include 'footer.php'; ?>					
</body>
</html>