<?php 
session_start();
require '../../db/dbcon.php';
date_default_timezone_set("Asia/Kolkata");

$que_no=$question=$option_1=$option_2=$option_3=$option_4=$answer=$count=$ans='';


$que_no=$_GET['que_no'];
$group_id=$_SESSION['group_id'];



		$exam="SELECT * FROM exam WHERE group_id=$group_id && que_no=$que_no";
		$ExamResult=mysqli_query($con,$exam);
		$count=mysqli_num_rows($ExamResult);

		if ($count==0) {
			echo false;
		}else{
			$question=mysqli_fetch_array($ExamResult);
			$option_1=$question['option_1'];
			$option_2=$question['option_2'];
			$option_3=$question['option_3'];
			$option_4=$question['option_4'];
			$exam_id=$question['exam_id'];
		
				if (isset($_SESSION['answer'][$exam_id])) {
					$ans=$_SESSION['answer'][$exam_id];
				}
?>

					<div style="font-size: 20px;" >
						<b>
							<label for="">
								<?php echo "(".$question['que_no'].")&nbsp;".$question['question']; ?>
							</label>
						</b>
						
					</div>

					<div style="font-size: 17px; padding-left: 10px;">
						<div  class="hoverradio" id="<?php echo 'option_1'; ?>" onclick="radioClick(this.id, <?php echo $exam_id; ?>)">
	
							<input  type="radio" name="option" id="row<?php echo 'option_1'; ?>" value="<?php echo 'option_1'; ?>"  
							<?php 
							if ($ans=='option_1') {
								echo "checked";
							}?>>&nbsp;&nbsp;<?php echo $option_1; ?> 
						</div>

						<div  class="hoverradio" id="<?php echo 'option_2'; ?>" onclick="radioClick(this.id, <?php echo $exam_id; ?>)">
							<input type="radio" name="option" id="row<?php echo 'option_2'; ?>" value="<?php echo 'option_2'; ?>"
							<?php 
							if ($ans=='option_2') {
								echo "checked";
							}?>>&nbsp;&nbsp;<?php echo $option_2; ?>
						</div>


						<div  class="hoverradio" id="<?php echo 'option_3'; ?>" onclick="radioClick(this.id, <?php echo $exam_id; ?>)">
							<input type="radio" name="option" id="row<?php echo 'option_3'; ?>" value="<?php echo 'option_3'; ?>"
							<?php 
							if ($ans=='option_3') {
								echo "checked";
							}?>>&nbsp;&nbsp;<?php echo $option_3; ?>
						</div>

						<div  class="hoverradio" id="<?php echo 'option_4'; ?>" onclick="radioClick(this.id, <?php echo $exam_id; ?>)">
							<input type="radio" name="option" id="row<?php echo 'option_4'; ?>" value="<?php echo 'option_4'; ?>"
							<?php 
							if ($ans=='option_4') {
								echo "checked";
							}?>>&nbsp;&nbsp;<?php echo $option_4; ?>
						</div>
						<div class="row" style="margin-top: 30px;">
							<div style="min-height: 50px; " >
								<div class="col-md-12">
									<?php 
									$group_id=$_SESSION['group_id'];
									$ep="SELECT * FROM exam WHERE group_id=$group_id";
									$epr=mysqli_query($con,$ep);
									$total_que=mysqli_num_rows($epr);
									if ($question['que_no']!=1) {
										?>
										<button type="button" class="btn btn-lg  btn-warning " value="<?php echo $question['que_no']-1; ?>" onclick="page(this.value)">Priveous</button>&nbsp;&nbsp;&nbsp;
										<?php 
									}
									if ($question['que_no']!=$total_que) {
										?>
									<button type="button" class="btn btn-lg  btn-primary " value="<?php echo $question['que_no']+1; ?>" onclick="page(this.value)"> Next</button>
										<?php
										
									} 
									
									 ?>

									
								</div>
								<div class="col-md-12" >
									<?php 

									
									while ( $pr=mysqli_fetch_assoc($epr)) {
										if ($pr['que_no']==$question['que_no']) {
											$active="btn-primary";
										} else{
											$active=" btn-outline-primary";
										}
											
											echo '<button type="button" class="btn btn-lg  '.$active.' my-3 mx-2" value="'.$pr['que_no'].' " onclick="page(this.value)"> '.$pr['que_no'].'</button>';
											
										}

											if ($question['que_no']==$total_que) {
												echo '<br><center><p class="btn btn-lg  btn-danger " value="SUBMIT" onclick="submit()"> SUBMIT</p></center>';

											}
									 ?>

								</div >
							</div>
						</div>
					</div>

					</div>
<?php } ?>

