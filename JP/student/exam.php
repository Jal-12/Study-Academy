<?php
session_start();
include '../inc/links.php';
include '../inc/function.php';
require '../db/dbcon.php';

	if (isset($_SESSION['group_id'])) {
		$group_id=$_SESSION['group_id'];
		$exam="SELECT exam.question, exam.option_1, exam.option_2, exam.option_3, exam.option_4, exam_group.sub_id FROM exam,exam_group WHERE exam.group_id=$group_id && exam_group.group_id=$group_id";
		$ExamResult=mysqli_query($con,$exam) or die(mysqli_error($con));
		$total=mysqli_num_rows($ExamResult) ;

		if($total){
			$No=1;
			$option=0;
			$question=mysqli_fetch_array($ExamResult)
						// $No=$No+1;
		
		

			
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Exam</title>
	<style type="text/css">
		@font-face{
			font-family: "Fira Code";
		}
		.hoverradio{ 
			margin: 2px;
			padding: 3px;
			cursor: pointer;
		}
	</style>
</head>
<hr>
<body style="background-color:  rgb(15,204,218);">
	
	<center>
	<div class="col-lg-6 justify-content-center">
		<h3 class="rounded-pill shadow-lg text-light font-italic font-weight-bold mt-3 p-3 text-decoration-underline"><?php echo sub_id($question['sub_id']) ?></h3>
	</div>
	</center>
	<div class="container">
		
		<div class="col-md-8 offset-md-2 bg-light p-4 mt-5 rounded-lg">
			<div  style="float: right; display: block; ">
				<span class="" style="font-size: 20px;"><b>Time Remaining: </b></span>
				<br>
				<div class="" id="timer" style="font-size: 25px;"></div>
			</div>
			<br>
			
			<div style="min-height: 300px; margin-top: 25px; " ><br><br>
				<div style="float: left;"> 
					Quesion: 
					<label id="current_que_no">0</label>/
					<label id="total_que">0</label>

				</div> <br><br><br>


				<form  method="post" class="form-horizontal">
					<!-- load questions -->
					<div id="load_questions">
						load qusetions
						
					</div>
					<!-- end load questions -->
						<div class="row" style="margin-top: 30px;">
							<div style="min-height: 50px; " >
								<!-- <div class="col-md-12">
									<input type="button" name="" class="btn btn-lg btn-warning " value="Priveous" id="previos_question">&nbsp;&nbsp;&nbsp;
									<input type="button" name="" class="btn btn-lg btn-primary " value="Next" id="next_question">&nbsp;&nbsp;&nbsp;
								</div> -->
								<!-- <div class="col-md-12">
									<button class="btn-primary mt-3 btn-lg">1</button>
								</div> -->
							</div>
						</div>
					</div>
			</div>
		</div>
		<?php
			}else{
				echo"No Questions";
			}
		?>
	</div>
	<div class="col-md-12">&nbsp;</div>



	<script type="text/javascript">
//timer funtion start
		setInterval(function(){
			timer();
		},1000);

		function timer() {
			  	
				var xhr=new XMLHttpRequest();
				xhr.onreadystatechange=function(){
					if (xhr.readyState == 4 && xhr.status == 200) {
						if (xhr.responseText=="00:00:00") {
							window.location="result.php";
						}
						document.getElementById("timer").innerHTML=xhr.responseText;
					}
				};
				xhr.open("GET","ajax/load_timer.php",true);
				xhr.send();
			}
	//timer funtion ends


//load questions

	function total_que(){
		var xhr=new XMLHttpRequest();
				xhr.onreadystatechange=function(){
					if (xhr.readyState == 4 && xhr.status == 200) {
						total=xhr.responseText;
						document.getElementById("total_que").innerHTML=total;
					}
				};
				xhr.open("GET","ajax/total_que.php",true);
				xhr.send();
	}
			var que_no='1';
			load_questions(que_no);

			function load_questions(que_no){
				document.getElementById("current_que_no").innerHTML=que_no;
				var xhr=new XMLHttpRequest();
				xhr.onreadystatechange=function(){
					if (xhr.readyState == 4 && xhr.status == 200) {
						questions=this.responseText;
						if (questions == false) {
							console.log(this.responseText);
							window.location="result.php";
						}else{
							document.getElementById("load_questions").innerHTML=questions;
							total_que();
						}
					}
				};
				xhr.open("GET","ajax/load_questions.php?que_no="+que_no,true);
				xhr.send(); 
			}

var pq=document.getElementById("previos_question");
pq.addEventListener('click',previos_question)


			function previos_question(){
				if (que_no=='1') {
					load_questions(que_no);
				}else{
					que_no=eval(que_no)-1;
					load_questions(que_no);
					document.getElementById("next_question").value='Next';
					document.getElementById("next_question").style.backgroundColor = "#007bff";
				}
			}

var nq=document.getElementById("next_question");
nq.addEventListener('click',next_question)
			function next_question(){
				
				// if (que_no === total-1) {
				// 	console.log(que_no);
				// 	document.getElementById("next_question").value='SUBMIT';
				// 	document.getElementById("next_question").style.backgroundColor = "red";
				// }
					que_no=eval(que_no)+1;
					load_questions(que_no);
				}
				
				function radioClick(radioValue,exam_id){
					id="row"+radioValue;
					document.getElementById(id).checked = true;
					console.log(id);
				
					var xhr=new XMLHttpRequest();

					xhr.onreadystatechange=function(){

						if(xhr.readyState == 4 && xhr.status == 200) {
					
							console.log(this.responseText);
						}
					
					};
					
					xhr.open("GET","ajax/save_answer_session.php?exam_id="+exam_id+"&value="+radioValue,true);
					xhr.send();	
				}
				function page(id){
					// console.log(id);
					// que_no=eval(que_no)-1;
					load_questions(id);
				}
				function submit(){
					// console.log(id);
					// que_no=eval(que_no)-1;
					window.location="result.php";
				}
// function row1(radioValue,exam_id){
//         document.getElementById("row1").checked = true;
//     }
//     function row2(){
//         document.getElementById("row2").checked = true;
//     }
//     function row3(){
//         document.getElementById("row3").checked = true;
//     }
//     function row4(){
//         document.getElementById("row4").checked = true;
//     }
	</script>



</body>
</html>

<?php 
	}else{
	echo "<h1>Please Go with connected again or Login again!</h1>";
	}
?>