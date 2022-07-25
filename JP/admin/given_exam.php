<?php
include '../inc/top.php';
require '../db/dbcon.php';


if (isset($_GET['group_id'])>0 && $_GET['group_id']!='') 
	{
		// pagination of 5 pages code
		$limit=10; // limit of the rows per table ex. 5 item per page

		// if page admin clicks on page then it runs
		if (isset($_GET['page'])) {
			$page=$_GET['page'];
		}else{
			$page=1;
		}

		$offset=($page-1)*$limit;
		$group_id=safe_string($_GET['group_id']);

?>

    
    <body>
        <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="text-center font-weight-bold text-decoration-underline">Given Exam & Result</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table thover ts table-bordered ">
                        <thead class="table-success">
                            <tr>
                                <th  width="1%" style="text-align: center">No</th>
                                <th  width="10%" style="text-align: center">Name</th>
                                <th  width="8%" style="text-align: center">Enrollment</th>
                                <th  width="5%" style="text-align: center">Total</th>
                                <th  width="5%" style="text-align: center">Right Answer</th>
                                <th  width="5%" style="text-align: center">Wrong Answer</th>
                                <th  width="5%" style="text-align: center">View Response</th>
                                <th  width="12%" style="text-align: center">Finishing Time</th>
                                <th  width="2%" style="text-align: center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $sql="SELECT * FROM result WHERE group_id='$group_id'";
                            $result=mysqli_query($con,$sql) or die(mysqli_error($con));
                            $records=mysqli_num_rows($result);
                            if ($records==0){
								echo "<td colspan='9' align='center' class='text-danger'><b>No given exam by students!</td></b>";

							}else{			
							 $No=$offset;
                            while ($row=mysqli_fetch_array($result)) {
                                $No = $No + 1;
                                $stu_id=$row['stu_id'];
                                $stu_idSQL="SELECT * FROM student WHERE stu_id='$stu_id'";
                                $stu_idResult=mysqli_query($con,$stu_idSQL) or die(mysqli_error($con));
                                $stu_idROW=mysqli_fetch_array($stu_idResult);

                        ?>
                            
                            <tr>
                                <td style="text-align: center"><?php echo "<b>".$No."</b>"; ?></td>
                                <td style="text-align: center"><h6><?php echo $stu_idROW['username']; ?> </h6></td>
                                <td style="text-align: center"><h6><?php echo $stu_idROW['enrollment']; ?> </h6></td>
                                <td style="text-align: center"><h6><?php echo $row['total']; ?> </h6></td>
                                <td style="text-align: center"><h6><?php echo $row['right_ans']; ?> </h6></td>
                                <td style="text-align: center"><h6><?php echo $row['wrong_ans']; ?> </h6></td>
                                <td style="text-align: center"> <a href="view_response.php?group_id=<?php echo $group_id; ?>&stu_id=<?php echo $stu_id; ?>" class="btn btn-md btn-warning mb-2 mx-3">View Response</a> </td>
                                <td style="text-align: center"><h6><?php echo DateFormat($row['create_time']); ?> </h6></td>
                                <td style="text-align: center"> <a href="delete.php?stu_id=<?php echo $stu_id; ?>" class="btn btn-md btn-danger mb-2 mx-3">Delete</a> </td>
                            </tr>
                            <?php
                        }
                    }
                }
                        ?>
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
    	<div class="container mt-3">	

	<?php

	// pagination code starts here with department wise		
		
	
		if ($records>0) {
		
			$total_page=ceil($records/$limit); 

			echo'<ul class="pagination justify-content-center">';
			for ($i=1; $i<=$total_page; $i++) {

				if ($i==$page) {
					$active='active';
				} else{
					$active="";
				}
				
				$PageNo='<li class="page-item '.$active.'"><a class="page-link" href="given_exam.php?group_id='.$group_id.'&page='.$i.'">'.$i.'</a></li>';
				
				echo $PageNo;
			}
			echo'</ul>';
			}
		?>
</div>
</body>
</html>
