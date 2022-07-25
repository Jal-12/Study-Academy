<?php
function pr($arr){
	echo "<pre>";
	print_r($arr);
	echo "</pre>";
}

function prx($arr){
	echo "<pre>";
	print_r($arr);
	die();
}

function redirect($link){
	?>
	<script>
		window.location.href='<?php echo $link;?>'; 
	</script>
<?php
die();
}

function department() {
include '../inc/links.php';
require '../db/dbcon.php';
echo"<select class='form-control' id='department' name='department' size='1'>
<option value='' disabled='' selected=''>Select Department</option>";
    
    /* it is for select d_id and department name from database and put data into opetion tag dynamically  */
	    $Select_d_id = "SELECT * FROM department";
	    $SelectResult = mysqli_query($con, $Select_d_id);
	    while ($row = mysqli_fetch_array($SelectResult)) {
	// data arrive from databse dynamicallyin opetion tag
	    echo "<option value=".$row['d_id'].">".$row['department']."</option>";
    }

echo "</select>";
// return;
}
function semester(){
include '../inc/links.php';
	echo"<select class='form-control' id='semester' name='semester' size='1'>
			<option value='' selected='' disabled=''>Select Semester</option>
			<option value=1>1</option>
			<option value=2>2</option>
			<option value=3>3</option>
			<option value=4>4</option>
			<option value=5>5</option>
			<option value=6>6</option>
			<option value=7>7</option>
			<option value=8>8</option>

		</select>";
}

function subject() {
include '../inc/links.php';
require '../db/dbcon.php';
echo"<select class='form-control' name='sub_id' id='subject' size='1'>";
    
	    $Select_sub_id = "SELECT * FROM subject";
	    $SelectResult = mysqli_query($con, $Select_sub_id);
	    while ($row = mysqli_fetch_array($SelectResult)) {
    // data arrive from databse dynamicallyin option tag
	    echo "<option value=".$row['sub_id'].">".$row['subject']."</option>";
    }

echo "</select>";
// return;
}

function sub_id($sub_id) {
	require '../db/dbcon.php';
	    $Select_Subject = "SELECT subject.subject FROM subject WHERE sub_id=$sub_id";
	    $SelectResult = mysqli_query($con, $Select_Subject);
	    $row = mysqli_fetch_array($SelectResult);
	     return $row['subject'];
}

function unit_id($unit_id) {
	require '../db/dbcon.php';
	    $Select_Subject = "SELECT * FROM unit WHERE unit_id=$unit_id";
	    $SelectResult = mysqli_query($con, $Select_Subject);
	    $row = mysqli_fetch_array($SelectResult);
	     return $row;
}

function d_id($d_id) {
	require '../db/dbcon.php';
	    $Select_department = "SELECT department.department FROM department WHERE d_id=$d_id";
	    $SelectResult = mysqli_query($con, $Select_department);
	    $row = mysqli_fetch_array($SelectResult);
	     return $row['department'];
}

function admin_id($admin_id) {
	require '../db/dbcon.php';
	    $Select_department = "SELECT admin.username FROM admin WHERE admin_id=$admin_id";
	    $SelectResult = mysqli_query($con, $Select_department);
	    $row = mysqli_fetch_array($SelectResult);
	     return $row['username'];
}

function faculty_id($faculty_id) {
	require '../db/dbcon.php';
	    $Select_ = "SELECT faculty.username FROM faculty WHERE faculty_id=$faculty_id";
	    $SelectResult = mysqli_query($con, $Select_);
	    $row = mysqli_fetch_array($SelectResult);
	     return $row['username'];
}

function stu_id($stu_id) {
	require '../db/dbcon.php';
	    $Select_department = "SELECT * FROM student WHERE stu_id=$stu_id";
	    $SelectResult = mysqli_query($con, $Select_department);
	    // $num = mysqli_num_rows($SelectResult);
	    $row = mysqli_fetch_array($SelectResult);
	     return $row;
}

function exam_group($group_id) {
	require '../db/dbcon.php';
	    $Select_group_id = "SELECT * FROM exam_group WHERE group_id=$group_id";
	    $SelectResult = mysqli_query($con, $Select_group_id);
	    $row = mysqli_fetch_array($SelectResult);
	     return $row;
}

function safe_string($str) {
	require '../db/dbcon.php';

	   	$str = trim($str);
  		$str = stripslashes($str);
		$str = strip_tags($str);
  		$str = htmlspecialchars($str);
	   	$str = mysqli_real_escape_string($con,$str);
	return $str;
}

function DateFormat($date)
	{ 
        return date("F d,Y  h:i:s A",strtotime($date));
	}

 	function DateMinute($date)
	{ 
        return date("F d,Y  h:i A",strtotime($date));
	}

function DateWeek($date)
	{
         return date("l, F d,Y",strtotime($date));
	}

function FullDate($date)
	{
         return date("l, F d,Y  h:i:s A",strtotime($date));
	}

function TimeSeconds($time)
	{
         return date("h:i:s A",strtotime($time));
	}

function TimeMinute($time)
	{
         return date("h:i A",strtotime($time));
	}

function textExerpt($text,$limit=400)
	{
        $text = $text." ";
        $text = substr($text,0,$limit);
        $text = substr($text,0,strrpos($text," "));
        $text = $text."....";
        return $text;
	}

function validation($data)
	{
		$data = trim($data);
		$data = stripcslashes($data);
		$data = htmlspecialchars($data);
		$data = strip_tags($data);
		return $data;
	}

function validation1($data)
	{
		$data = trim($data);
		$data = stripcslashes($data);
		$data = htmlspecialchars($data);
		$data = htmlentities($data);
		$data = strip_tags($data);
		return $data;
	}

function RemoveTags($data){
       $data = strip_tags(html_entity_decode($data));
       return $data;
	}
	
function fortitle(){
		$path = $_SERVER['SCRIPT_NAME'];
		$title = basename($path,'.php');
		if($title=="index"){
			$title = 'home';
		}elseif($title=="contact"){
			$title ="contact";
		}
		$title = ucwords($title);
		return $title;
	}
?>