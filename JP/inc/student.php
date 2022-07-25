<?php
session_start();
include 'function.php';
	if(!isset($_SESSION['student']) OR $_SESSION['student']!= true)
	{
		session_abort();
		redirect("Login.php");
	} 

 
		// prx($_SERVER);
		$current_uri=$_SERVER['SCRIPT_NAME'];
		$current_array=explode('/',$current_uri);
		$current_title=$current_array[count($current_array)-1];
		// prx($current_title);

		$page_title="";
		if ($current_title=="index.php") {
			$page_title="Home";
		}elseif ($current_title=="view_lectures.php") {
			$page_title="View Lectures";
		}elseif ($current_title=="view_materials.php") {
			$page_title="View Materials";
		}elseif ($current_title=="connect_group.php" ) {
			$page_title="Connect New Group For exam";
		}elseif ($current_title=="connected_groups.php") {
			$page_title="Connected Groups";
		}elseif ($current_title=="view_results.php") {
			$page_title="View Results";
		}elseif ($current_title=="notice.php") {
			$page_title="Notice";
		}elseif ($current_title=="comments.php") {
			$page_title="Comments";
		}elseif ($current_title=="edit_comments.php") {
			$page_title="Edit Comment";
		}else{
			$page_title="Home";
		}

include 'constant.php';
include 'links.php';
require '../db/dbcon.php';
if (isset($_SESSION['d_id']) && isset($_SESSION['semester']) ) {

$d_id=$_SESSION['d_id'];
$semester=$_SESSION['semester'];



$subjectSQL="SELECT sub_id,subject FROM subject WHERE d_id=$d_id AND semester=$semester";
$SubSqlResult=mysqli_query($con,$subjectSQL);
if (mysqli_num_rows($SubSqlResult)==0) {
	$NoSubject="Subjects Not Available Or Please Login again";
}else{
	$no=0;
	while ($row=mysqli_fetch_assoc($SubSqlResult)) {
		$sub_id[]=$row['sub_id'];
		$subject[]=$row['subject'];
		$no=$no+1;
	}
}
}else{
	echo "Please Login Again";
}



date_default_timezone_set("Asia/Kolkata");

		?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
		<title><?php echo $page_title; ?></title>
		<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
		<script src="https://kit.fontawesome.com/a076d05399.js"></script>
		
		<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
		<style>
			table,th,td, center {
        		font-size: 15px;
		    }
		    .ts tbody tr:nth-of-type(odd) {
        		background-color: rgba(0, 0, 0, 0.05);
    		}
    		.thover tbody tr:hover {
			    color: #212529;
			    background-color: #ffe8a1;
			}


			@font-face{font-family:"sans-serif";}
		body {
			/* font-family:"Material Design Icons"; */
				background: #36D1DC;
				background: -webkit-linear-gradient(to left, #0ED2F7, #36D1DC);
				background: linear-gradient(to left, #0ED2F7, #36D1DC);
			}
			.dropdown {
			position: relative;
			display: block;
			min-width: 140px;
			margin-left: 9px;
			font-weight: bold;
			
				
			}
			.dropdown ul li{
			font-size: 20px;
			}
			.dropdown ul li:hover{
			color: #ECE9E6;
			text-shadow: 0 0 20px #ECE9E6;
			}
			.dropdown-content {
			display: none;
			position: absolute;
			background-color: #36D1DC;
			min-width: 140px;
			box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
			z-index: 1;
			}
			.dropdown-content a {
				color: black;
				padding: 12px 16px;
				text-decoration: none;
				display: block;
			}
			.sub-menu{
				display: none;
			}
			.me:hover .sub-menu {
				position: absolute;
				display: block;
				margin-top: -50px;
				margin-left: 140px;
				background-color: #36D1DC;
			}
			.dropdown-content a:hover {
				background-color: #ECE9E6;
				text-shadow: 0 0 20px #ECE9E6;
			box-shadow: 0 0 20px black;
				}
			.dropdown:hover .dropdown-content {display: block;}
			.dropdown:hover .dropbtn2 {background-color: #060d0f;}
		</style>
	</head>
	<body>

		<header>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
			<a class="navbar-brand active ml-4" style="text-align: center; margin-right: 14px" href="../student/Index.php"><i class="fas fa-user" style="color: #36D1DC;"></i>User</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto ">
				
				<!-- Material Starts -->
					<div class="dropdown">
						<ul class="navbar-nav mr-auto dropbtn2 nav-link">
							<li class="nav-link ml-4" style="text-align: center; margin-right: 20px;"><i class="fas fa-book" style="color: #36D1DC;"></i>Material</li>
						</ul>
						<div class="dropdown-content" style="text-align: center; min-width: 165px;">
							<?php
							if (isset($sub_id)&&isset($subject)) {
								for ($i=0; $i <$no ; $i++) { 
									echo '<a href="view_materials.php?sub_id='.$sub_id[$i].'">'.$subject[$i].'</a>';
								}
							}else{
								echo'Please login again';
							}
							?>
							<li class="me">
								<a href="javascript:void(0)">Other Semester</a>
								<div class="sub-menu" style="margin-left: 165px;">
								<?php 
								for ($i=1; $i <=8 ; $i++) { 
									if ($i==$_SESSION['semester']) {
										// $i=$i+1;
									} else {
										echo '<a href="view_materials_other_sem.php?semester='.$i.'">Semester&nbsp;'.$i.'</a>';
									}							
									}
								?>
								</div>
							</li>
						</div>
					</div>
				<!-- Material Ends -->

				<!-- Lectures Starts -->
					<div class="dropdown">
						<ul class="navbar-nav mr-auto dropbtn2 nav-link">
							<li class="nav-link ml-4" style="text-align: center; margin-right: 20px;"><i class="fas fa-file-video" style="color: #36D1DC;"></i>Lectures</li>
						</ul>
						<div class="dropdown-content" style="text-align: center; min-width: 165px;">
							<?php
							if (isset($sub_id)&&isset($subject)) {
								for ($i=0; $i <$no ; $i++) { 
									echo '<a href="view_lectures.php?sub_id='.$sub_id[$i].'">'.$subject[$i].'</a>';
								}
								}else{
								echo'Please login again';
							}
							?>
							<li class="me">
								<a href="javascript:void(0)">Other Semester</a>
								<div class="sub-menu" style="margin-left: 165px;">
								<?php 
									for ($i=1; $i <=8 ; $i++) 
									{ 
										if ($i==$_SESSION['semester'])
										 {
										}else {
											echo '<a href="view_lectures_other_sem.php?semester='.$i.'">Semester&nbsp;'.$i.'</a>';
										}
									}
								?>
								</div>
							</li>
						</div>
					</div>
				<!-- Lectures Ends -->

				<!-- Mcqs Starts -->
				<div class="dropdown">
						<ul class="navbar-nav mr-auto dropbtn2 nav-link">
							<li class="nav-link ml-4" style="text-align: center; margin-right: 22px;"><i class="fas fa-chalkboard" style="color: #36D1DC;"></i>MCQS</li>
						</ul>
						<div class="dropdown-content" style="text-align: center; min-width: 160px;">
							<?php
							if (isset($sub_id)&&isset($subject)) {
								for ($i=0; $i <$no ; $i++) { 
									echo '<a href="view_mcqs.php?sub_id='.$sub_id[$i].'">'.$subject[$i].'</a>';
								}
							}else{
								echo'Please login again';
							}
							?>
							<li class="me">
								<a href="javascript:void(0)">Other Semester</a>
								<div class="sub-menu" style="margin-left: 160px;">
								<?php 
								for ($i=1; $i <=8 ; $i++) { 
									if ($i==$_SESSION['semester']) {
										// $i=$i+1;
									} else {
										echo '<a href="view_mcqs_other_sem.php?semester='.$i.'">Semester&nbsp;'.$i.'</a>';
									}							
									}
								?>
								</div>
							</li>
						</div>
					</div>
				<!-- Mcqs Ends -->

				<!-- Ask-question Starts -->
					<div class="dropdown">
						<ul class="navbar-nav mr-auto dropbtn2 nav-link" >
							<li class="nav-link ml-4" style="margin-right: 24px;"><i class="fas fa-comment" style="color: #36D1DC;"></i>Ask Questions</li>
						</ul>
						<div class="dropdown-content " style="text-align: center; min-width: 227px;">
						<?php
							if (isset($sub_id)&&isset($subject)) {
								for ($i=0; $i <$no ; $i++) { 
									echo '<a href="view_ask_question.php?sub_id='.$sub_id[$i].'">'.$subject[$i].'</a>';
								}
								}else{
								echo'Please login again';
							}
							?>
							<li class="me">
								<a href="javascript:void(0)">Other Semester</a>
								<div class="sub-menu" style="margin-left: 227px;">
								<?php 
									for ($i=1; $i <=8 ; $i++) 
									{ 
										if ($i==$_SESSION['semester'])
										 {
										}else {
											echo '<a href="view_ask_question_other_sem.php?semester='.$i.'">Semester&nbsp;'.$i.'</a>';
										}
									}
								?>
								</div>
							</li>	
						</div>
					</div>
				<!-- Ask-question Ends -->
				
				<!-- Notice Starts -->
					<div class="dropdown ">
						<ul class="navbar-nav mr-auto dropbtn2 nav-link">
							<li class="nav-link ml-4" style="margin-right: 20px;"><i class="fas fa-bell" style="color: #36D1DC;"></i>&nbsp;Notice</a></li>
						</ul>
						<div class="dropdown-content " style="text-align: center; min-width: 158px;">
							<a href="notice.php">View Notice</a>
						</div>
					</div>
				<!-- Notice Ends -->

				
				<!-- Exam Starts -->
					<div class="dropdown">
						<ul class="navbar-nav mr-auto dropbtn2 nav-link">
							<li class="nav-link ml-4" style="margin-right: 24px;"><i class="fas fa-pen" style="color: #36D1DC;"></i>Exam</li>
						</ul>
						<div class="dropdown-content " style="text-align: center; min-width: 148px;">
							<a href="connect_group.php">Connect Group</a>
							<a href="connected_groups.php">Connected Groups</a>
							</div>
					</div>
				<!-- Exam Ends -->

				<!-- Result Starts -->
					<div class="dropdown">
						<ul class="navbar-nav mr-auto dropbtn2 nav-link">
							<li class="nav-link ml-4" style="margin-right: 22px;"><i class="fas fa-file-alt" style="color: #36D1DC;"></i>Result</li>
						</ul>
						<div class="dropdown-content" style="text-align: center; min-width: 148px;">
							<a href="view_results.php" >View Result</a>
						</div>
					</div>
				<!-- Result Ends -->

				<!-- Logout Starts -->
					<div class="dropdown ">
						<ul class="navbar-nav dropbtn2 "  style="text-align: center; margin-left: 0px;">
							<li class="nav-link ml-4" style="margin-right: 2px;"><a class="nav-link" href="logout.php"><i class="fas fa-power-off" style="color: #36D1DC;"></i>Logout</a></li>
						</ul>
					</div>
				<!-- Logout Endss -->

				</ul>
			</div>
		</nav>
	</header>
</body>
