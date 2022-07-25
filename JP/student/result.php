<?php  
include '../inc/student.php';

require '../db/dbcon.php';


$correct=0;
$wrong=0;
if (isset($_SESSION['stu_id']) && isset($_SESSION['answer'])) {
	
// pr($_SESSION['stu_id']);
// 	prx($_SESSION['answer']);

$stu_id=$_SESSION['stu_id'];
$group_id=$_SESSION['group_id'];

	foreach($_SESSION['answer'] as $exam_id => $response) {
	  // echo "Key=" . $exam_id . ", Value=" . $response;
	  // echo "<br>";
	  $ResponseSQL="INSERT INTO response(`exam_id`, `stu_id`, `response`) VALUES ('$exam_id', '$stu_id', '$response')";
	  $ResponseResult=mysqli_query($con,$ResponseSQL);

	  if ($ResponseResult==0) {
	  	
	  // }else{
	  	echo "Error= ".mysqli_error($con);
	  }
	}
	if ($ResponseResult) {
		
		$rightSQL="SELECT distinct * FROM exam JOIN response ON  exam.exam_id = response.exam_id  AND exam.answer = response.response WHERE group_id = $group_id AND stu_id = $stu_id ";
		$rightResult=mysqli_query($con,$rightSQL);
		$right_ans=mysqli_num_rows($rightResult);

		$totalSQL="SELECT * FROM exam  WHERE group_id = '$group_id' ";
		$totalResult=mysqli_query($con,$totalSQL);
		$total=mysqli_num_rows($totalResult);


		$wrong_ans=$total-$right_ans;
		// echo "group_id= ".$group_id."  stu_id=".$stu_id;
		// echo "<br>";

		// echo "Right=".$right_ans."  Wrong= ".$wrong_ans."  Total=".$total;

		if (($right_ans&&$total)!=0) {
			$storeResultSQL="INSERT INTO RESULT (`group_id`,`stu_id`, `right_ans`, `wrong_ans`, `total`) VALUES('$group_id', '$stu_id', '$right_ans', '$wrong_ans', '$total')";
			$storeResult=mysqli_query($con,$storeResultSQL) or die(mysqli_error($con));

		}

	if(isset($_SESSION['start_time']) && isset($_SESSION['end_time'])&&$storeResult){
			unset($_SESSION['exam_start']);
			unset($_SESSION['start_time']);
			unset($_SESSION['end_time']);
			unset($_SESSION['group_id']);
			unset($_SESSION['answer']);
			echo "<center><h1>Result Stores Successfully!!!</h1></center>";
		}
	}
echo "<center><h1>Suc!!!</h1></center>";
// die();
}else{
	echo "<center><h1>Pro!!!</h1></center>";

}
echo "<center><h1>Unset!!!</h1></center>";



 ?>

      <script type="text/javascript">
      	window.location="connected_groups.php";
      </script>
                    
</body>
</html>