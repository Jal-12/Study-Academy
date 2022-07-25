<?php
include '../inc/student.php';
require '../db/dbcon.php';

	$check_group="SELECT * FROM connect_group WHERE stu_id={$_SESSION['stu_id']}";
	$GroupResult=mysqli_query($con,$check_group) ;
	$group=mysqli_num_rows($GroupResult);
	

	if ($group>0) {
		$id=0;
		while ($row=mysqli_fetch_array($GroupResult)) {
			$id=$id+1;
					
		$array=exam_group($row['group_id']);
		$group_token=$row['group_token'];
		$stu_id=$row['stu_id'];
		$sub_id=$array['sub_id'];
		$subject=sub_id($array['sub_id']);

		$date=$array['date'];
		$time=$array['time'];

		$start_time = date('Y-m-d H:i:s', strtotime("$date $time"));
		$now=date("Y-m-d H:i:s");
// time added
		$time_minutes=$array['time'];
		$total_time_minutes=$array['total_time_minutes'];
		$added_time=date("h:i A",strtotime($time_minutes."+".$total_time_minutes." Minutes"));
		$end_time=date('Y-m-d H:i:s', strtotime("$date $added_time"));
// time added ends

		// prx($array)
?>

<body>
		<div class="container bg-light p-4 my-5 rounded" style="font-size: 15px;">
			<div id="given_exam<?php echo $id; ?>"></div>
			<div class="row">
				
			<div class="col-md-6">
				<div class="table-responsive">
					
				<table class="table thover ts table-bordered ">
<tr>
						<td width="45%"><label class="font-weight-bold">Enrollment :</label></td>
						<td><label id="enrollment<?php echo $id; ?>" ><?php echo $_SESSION['enrollment'];?></label></td>
	
</tr>
<tr>
						<td><label class="font-weight-bold">Subject :</label></td>
						<td><label id="subject<?php echo $id; ?>" class="font-italic text-primary"><?php echo $subject;?></label></td>
					</tr>
					<tr>
						
						
					
						<td><label class="font-weight-bold">Department :</label></td>
						<td><label id=""><?php echo d_id($array['d_id']);?></label></td>
						</tr>
						<tr>
							
						<td><label class="font-weight-bold">Semester :</label></td>
						<td><label id="semester<?php echo $id; ?>"><?php echo $array['semester'];?></label></td>
					</tr>
					<tr>
						
						<td><label class="font-weight-bold">Time in Minutes :</label></td>
						<td><label ><?php echo $array['total_time_minutes'];?>&nbsp;Minutes</label></td>
							
						</tr>

				</table>
				</div>
				
			</div>
			<div class="col-md-6">
				<div class="table-responsive">
					
				<table class="table thover ts table-bordered ">
					
						<tr>
					
						<td width="45%"><label class="font-weight-bold">Total Questions :</label></td>
						<td><label ><?php echo $array['total_questions'];?>&nbsp;Questions</label></td>
					</tr>
					<tr>
						<td><label class="font-weight-bold">Time :</label></td>
						<td><label ><?php echo TimeMinute($time)." to ".$added_time;?></label></td>
					
						
					</tr>
					<tr>

						<td><label class="font-weight-bold">Date :</label></td>
						<td><label ><?php echo DateWeek($date);?></label></td>
					</tr>
					<tr>
						
					
						<td><label class="font-weight-bold">Group Token :</label></td>
						<td><label id="group_token<?php echo $id; ?>"><?php echo $group_token;?></label></td>
							
						</tr>
						<tr>

						<td><label class="font-weight-bold">By Admin:</label></td>
						<td><label ><?php echo admin_id($array['admin_id']);?></label></td>
					</tr>
				</table>
				</div>
			</div>
			</div>
			
	<center>
			<!-- <input type="submit" id="exam<?php echo $id; ?>" class="btn btn-lg btn-success" value="Give Exam" onclick="exam_session(this.id);"> -->
			<?php 

			 if ($now>$end_time) {

                    echo '
                            <p class="btn btn-lg btn-danger mx-3 mt-2" name="">Exam Over</p>

                        <a href="view_response.php?group_id='.$row['group_id'].'&stu_id='.$row['stu_id'].'" class="btn btn-lg btn-success mb-2 mx-3">View Response</a>
                        <a href="view_results.php?group_id='.$row['group_id'].'&stu_id='.$row['stu_id'].'" class="btn btn-lg btn-primary mb-2 mx-3">View Result</a>';
                }elseif($now>$start_time && $now<$end_time){
                    // die($start_time);
                     echo '
                                <button id="exam'.$id.' " value="'.$id.'" class="btn btn-lg btn-warning" onclick="exam_session(this.value)">Exam running</button>
                            ';
                }else{
                    echo '<button id="exam'.$id.'" value="'.$id.'" class="btn btn-lg btn-success" onclick="exam_session(this.value)">Give Exam</button>';
                }

			 ?>
			
			<!-- <button id="exam<?php echo $id; ?>" class="btn btn-lg btn-success" >Give Exam</button> -->
			<!-- <a href="view_results.php?group_id=<?php echo $row['group_id']; ?>&stu_id=<?php echo $row['stu_id'];?>" class="btn btn-lg btn-primary  m-3">View Result</a> -->
		
	</center>
	
		</div>
	</div>
<?php
			}
		}else{
			echo "No group found";
		}
		?>

		<script type="text/javascript">
			// let exam=document.getElementById("exam");
			// exam.addEventListener('click',exam_session)

			function exam_session(value) {
				
console.log("cik");
console.log(value);
				
				// let id = document.getElementById("group_token"+value).innerHTML;
				let group_token = document.getElementById("group_token"+value).innerHTML;
			  	// let enrollment = document.getElementById("enrollment"+value).innerHTML;
				const xhr = new XMLHttpRequest();
console.log(group_token);

// xhr.onreadystatechange=function(){

// 						if(xhr.readyState == 4 && xhr.status == 200) {
					
// 							console.log(this.responseText);
// 							document.getElementById("semester"+value).innerHTML =this.responseText;
// 						}
					
// 					};
				xhr.onload=function(){
					// console.log(this.responseText);

					if (this.responseText == true){
						// window.location.href=window.location.href;
						document.getElementById("given_exam"+value).innerHTML='<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>You have alerady given this exam!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
						

					}else{
						if (this.responseText == false) {
							document.getElementById("given_exam"+value).innerHTML='<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Exam not started!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
							
						}else{

						window.location="exam.php";

						// console.log(this.responseText);
						// document.getElementById("semester"+value).innerHTML =this.responseText;
						}
						
					}
					
					
				}
				xhr.open('GET','ajax/exam_session.php?group_token='+group_token, true);
				 // xhr.open("POST", "ajax/exam_session.php", true);

				xhr.send();
			}
		</script>