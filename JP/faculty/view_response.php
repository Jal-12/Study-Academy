<?php
include '../inc/faculty.php';
require '../db/dbcon.php';
    if (isset($_GET['group_id'])&&isset($_GET['stu_id'])){
      	$group_id= safe_string($_GET['group_id']);
        $stu_id=safe_string($_GET['stu_id']);

        $limit=5; // limit of the rows per table ex. 5 item per page

        // if page admin clicks on page then it runs
        if (isset($_GET['page'])) {
            $page=$_GET['page'];
        }else{
            $page=1;
        }

        $offset=($page-1)*$limit;
?>
<div class="container-fluid">


<?php
            $resultSQL="SELECT distinct * FROM exam JOIN response ON exam.exam_id = response.exam_id WHERE group_id = $group_id AND stu_id = $stu_id ORDER BY `exam`.`que_no` ASC LIMIT {$offset},{$limit}";
            $result=mysqli_query($con, $resultSQL);
            if (mysqli_num_rows($result)>0) {

            	while ($row=mysqli_fetch_assoc($result)) {
					$success1=$success2=$success3=$success4=$right=$right1=$right2=$right3=$right4='';
// pr($row);
            	?>

	<div class="container bg-white p-4 mt-3 rounded-lg ">
		<table class="p-3 m-1 " style="font-weight: 480; font-family: 'roboto';">
			<thead>
				
			<tr>
				<th class="p-2">
					<h4 class="font-weight-bold">(<?php echo $row['que_no']; ?>)&nbsp;</h4>
				</th>
				<th class="p-2">
					<h4 class="font-weight-bold"><?php echo $row['question']; ?> </h4>					
				</th>

			</tr>
			</thead>
			<?php 

			
			


			if ($row['response']=="option_1"){

				if ($row['response']==$row['answer']) {
					$success1="table-success";
				}else{
					$success1="table-danger";
					// if ($row['answer']=="option_1") {
					// 	$right1="table-success";
					// } else
					if ($row['answer']=="option_2") {
						$right2="table-success";
					} elseif ($row['answer']=="option_3") {
						$right3="table-success";
					} elseif ($row['answer']=="option_4") {
						$right4="table-success";
					}else{
						$right1=$right2=$right3=$right4='';
					}
				}
			}elseif ($row['response']=="option_2"){

				if ($row['response']==$row['answer']) {
					$success2="table-success";
				}else{
					$success2="table-danger";
					if ($row['answer']=="option_1") {
						$right1="table-success";
					// } elseif ($row['answer']=="option_2") {
					// 	$right2="table-success";
					} elseif ($row['answer']=="option_3") {
						$right3="table-success";
					} elseif ($row['answer']=="option_4") {
						$right4="table-success";
					}else{
						$right1=$right2=$right3=$right4='';
					}
				}
			}elseif ($row['response']=="option_3"){

				if ($row['response']==$row['answer']) {
					$success3="table-success";
				}else{
					$success3="table-danger";
					if ($row['answer']=="option_1") {
						$right1="table-success";
					} elseif ($row['answer']=="option_2") {
						$right2="table-success";
					// } elseif ($row['answer']=="option_3") {
					// 	$right3="table-success";
					} elseif ($row['answer']=="option_4") {
						$right4="table-success";
					}else{
						$right1=$right2=$right3=$right4='';
					}
				}
			}elseif ($row['response']=="option_4"){

				if ($row['response']==$row['answer']) {
					$success4="table-success";
				}else{
					$success4="table-danger";
					if ($row['answer']=="option_1") {
						$right1="table-success";
					} elseif ($row['answer']=="option_2") {
						$right2="table-success";
					} elseif ($row['answer']=="option_3") {
						$right3="table-success";
					// } elseif ($row['answer']=="option_4") {
					// 	$right4="table-success";
						// die($success4." and1 ".$right1." and2 ".$right2." and3 ".$right3." and4 ".$right4);
					}else{
						$right1=$right2=$right3=$right4='';
					}
				}
			}else{
				$success1=$success2=$success3=$success4=$right1=$right2=$right3=$right4='';
			}

				
				?>
			<tbody>				
				
				<tr  class="<?php if(isset($success1)||isset($right1)){ echo $success1; echo $right1;} ?>">
					<td class="p-2 ">(A)</td>
					<td class="p-2 "><?php echo $row['option_1']; ?> </td>
				</tr>
				<tr  class="<?php if(isset($success2)||isset($right2)){ echo $success2.$right2;} ?>">
					<td class="p-2 ">(B)</td>
					<td class="p-2 "><?php echo $row['option_2']; ?> </td>
				</tr>
				<tr  class="<?php if(isset($success3)||isset($right3)){ echo $success3.$right3;} ?>">
					<td class="p-2 ">(C)</td>
					<td class="p-2 "><?php echo $row['option_3']; ?> </td>
				</tr>
				<tr  class="<?php if(isset($success4)||isset($right4)){ echo $success4.$right4;} ?>">
					<td class="p-2 ">(D)</td>
					<td class="p-2 "><?php echo $row['option_4']; ?> </td>
				</tr>
			</tbody>
		</table>
		
	</div>

            	

      <?php
      }
       
  }
  ?>

</div>
<div class="container mt-3">    

    <?php

    // pagination code starts here with department wise    
    $pSQL="SELECT distinct * FROM exam JOIN response ON exam.exam_id = response.exam_id WHERE group_id = $group_id AND stu_id = $stu_id ORDER BY `exam`.`que_no` ASC";
	$records=mysqli_num_rows(mysqli_query($con,$pSQL));    
        if ($records>0) {
        
            $total_page=ceil($records/$limit); 

            echo'<ul class="pagination justify-content-center">';
            for ($i=1; $i<=$total_page; $i++) {

                if ($i==$page) {
                    $active='active';
                } else{
                    $active="";
                }

                
                    $PageNo='<li class="page-item '.$active.'"><a class="page-link" href="view_response.php?group_id='.$group_id.'&stu_id='.$stu_id.'&page='.$i.'">'.$i.'</a></li>';

                echo $PageNo;
            }
            echo'</ul>';
            }
        }else{
        	echo "Not found!!";
        }
    ?>
</div>

  <?php

include 'footer.php';
?>