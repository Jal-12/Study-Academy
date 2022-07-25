<?php
include '../inc/top.php';
require '../db/dbcon.php';

if (isset($_GET['d_id'])>0 && $_GET['d_id']<5 && $_GET['d_id']!='') 
	{
// pagination of 5 pages code
	$limit=5; // limit of the rows per table ex. 5 item per page

// if page admin clicks on page then it runs
	if (isset($_GET['page'])) {
		$page = safe_string($_GET['page']);
	}else{
		$page = 1;
	}

	$offset=($page-1)*$limit;
	$d_id= safe_string($_GET['d_id']);
		
?>
<body>
	<div class="container-fluid mt-2">
	<center>

		<?php 
		$dark = $semActive = $semEcho = $sub = $subActive = $sub_id1='';
		$flag=false;

	// data fetching through department wise
		$sql = "SELECT  mcqs.*, department.department FROM mcqs,department WHERE mcqs.d_id=$d_id && department.d_id=$d_id LIMIT {$offset},{$limit}";

 	//pagination query through department wise
		$pageSql = "SELECT * FROM `mcqs` WHERE mcqs.d_id=$d_id";

	// this condition checks get variable of sem_id  if admin click on semester 1 then sem_id available and records will view as semester wise
		
		if (isset($_GET['sem_id']) && $_GET['sem_id']!='' ){
		
			if ($_GET['d_id'] > 0 && $_GET['sem_id'] <= 8) {

				$sem_id = safe_string($_GET['sem_id']);

	//pagination query through semester wise
				$pageSql = "SELECT * FROM `mcqs` WHERE mcqs.d_id=$d_id and mcqs.semester=$sem_id";
				$subSql = "SELECT * FROM `subject` WHERE subject.d_id=$d_id and subject.semester=$sem_id";

	// data fetching through semester wise with row limit
				$sql = "SELECT mcqs.*, department.department FROM mcqs,department WHERE mcqs.d_id=$d_id && department.d_id=$d_id && mcqs.semester=$sem_id LIMIT {$offset},{$limit}";

	// getting semester for create buttons of semester
				$semActive = safe_string($_GET['sem_id']);
				$semEcho = 'Semester&nbsp;' . $semActive . '&nbsp;in';

				if (isset($_GET['sub_id']) && $_GET['sub_id'] != '') {
					$sub_id1 = safe_string($_GET['sub_id']);
					$flag=true;
							
					$pageSql="SELECT * FROM `mcqs` WHERE mcqs.d_id=$d_id and mcqs.semester=$sem_id and sub_id=$sub_id1 ";
					$sql="SELECT * FROM `mcqs` WHERE mcqs.d_id=$d_id and mcqs.semester=$sem_id and sub_id=$sub_id1 LIMIT {$offset},{$limit}";	
					$unitSQL="SELECT * FROM `unit` WHERE sub_id=$sub_id1";
					}
				} else {
				echo "<b class='text-center text-danger font-weight-bold' > sem_id must between 1 to 8. Data is shown according to department wise </p>";
			}
		}
		
	//1 to 8 semesters
			for ($sem = 1; $sem <= 8; $sem++) {

				if ($sem==$semActive) {
					$dark='btn-warning';
				} else{
					$dark="btn-primary";
				}
				echo '<a class="btn '.$dark.'  m-2 my-4" href="view_mcqs.php?d_id='.$d_id.'&sem_id='.$sem.'">Semester '.$sem.'</a>';	 
			}
			?>
	</center>
<div class="card">
		<div class="card-header">
			<h3 class="text-center font-weight-bold"><?php echo $semEcho.d_id($d_id); ?>-MCQS</h3>
		</div>
		<center>
		<!-- showing sujects according to semester start -->
			<?php
				if (isset($subSql)) {
						
				$subResult = mysqli_query($con, $subSql);
				 while ($subRow = mysqli_fetch_assoc($subResult)) {

					if ($subRow['sub_id'] == $sub_id1) {
						echo '<a class="btn btn-warning  m-2 my-4" href="view_mcqs.php?d_id=' . $d_id . '&sem_id=' . $sem_id . '&sub_id=' . $subRow['sub_id'] . '">' . sub_id($subRow['sub_id']) . '</a>';
					} else {
						echo '<a class="btn btn-primary  m-2 my-4" href="view_mcqs.php?d_id=' . $d_id . '&sem_id=' . $sem_id . '&sub_id=' . $subRow['sub_id'] . '">' . sub_id($subRow['sub_id']) . '</a>';
						}
					}
				}
			?>
		<!-- showing sujects according to semester ends-->
		</center>
		<?php
            echo'</center>';
            if (isset($_GET['sub_id']) && $_GET['sub_id']!='') 
            {
                $unit_id=false;
                $sub_id=safe_string($_GET['sub_id']);
                $unitSQL="SELECT * FROM `unit` WHERE sub_id=$sub_id";
            // unit wise mcqs
                    if (isset($_GET['unit_id'])&& $_GET['unit_id'] != '') 
                    {
                        $unit_id = safe_string($_GET['unit_id']);    
                    }


if (isset($unitSQL)) {

            $unitResult = mysqli_query($con, $unitSQL);
            $num=mysqli_num_rows($unitResult);
            if ($num>0) {
?>
<div class="card">
    
        <!-- showing units according to unit start -->
        <?php
            
                while ($unitRow = mysqli_fetch_assoc($unitResult)) {
                    $unitArr=unit_id($unitRow['unit_id']);
                        
                        echo '
    	<div class="shadow ahover my-2">
                            
                        <a style="font-size: 17px; font-weight: 500;" class="col-9  p-3 text-left btn  " href="add_mcq.php?sub_id='.$sub_id.'&unit_id='.$unitRow['unit_id'].'">'.$unitArr["unit_number"].'.&nbsp;'.$unitArr["unit_name"].'</a>
                        <a style="font-size: 13px; font-weight: 500;" class="col-1 btn  btn-primary" href="view_mcqs.php?sub_id='.$sub_id.'&unit_id='.$unitRow['unit_id'].'">View MCQs</a>
                        </div>
                        ';
                    
                    
                }
            

        ?>
        <!-- showing units according to unit ends-->
    
    </div>

	

<?php
} else {
                echo '<p class="text-center text-danger bg-light font-weight-bold">No units found!!</p>';
                                
            }
        }
    }

}			
?>
 </div>
 </div>
 <?php include 'footer.php'; ?>
 </body>