<?php 
	// prx($_SERVER);
	$current_uri=$_SERVER['SCRIPT_NAME'];
	$current_array=explode('/',$current_uri);
	$current_title=$current_array[count($current_array)-1];
	// prx($current_title);

	$page_title="";
	if ($current_title=="index.php") {
		$page_title="Dashboard";
	}elseif ($current_title=="edit_students.php") {
		$page_title="Edit Students";
	}elseif ($current_title=="view_students.php") {
		$page_title="View Students";
	}elseif ($current_title=="view_lectures.php" ) {
		$page_title="View Lectures";
	}elseif ($current_title=="edit_lectures.php") {
		$page_title="Edit Lectures";
	}elseif ($current_title=="upload_lectures.php") {
		$page_title="Upload Lectures";
	}elseif ($current_title=="view_materials.php") {
		$page_title="View Materials";
	}elseif ( $current_title=="edit_materials.php") {
		$page_title="Edit Materials";
	}elseif ($current_title=="upload_materials.php") {
		$page_title="Upload Materials";
	}elseif ($current_title=="add_questions.php" ) {
		$page_title="Add Questions in Group";
	}elseif ($current_title=="view_questions.php") {
		$page_title="View Questions of Group";
	}elseif ($current_title=="add_faculty.php" ) {
		$page_title="Add Faculty";
	}elseif ( $current_title=="view_faculty.php") {
		$page_title="View Faculty";
	}elseif ( $current_title=="edit_faculty.php") {
		$page_title="Edit Faculty";
	}elseif ($current_title=="add_group.php" ) {
		$page_title="Add Group";
	}elseif ( $current_title=="view_groups.php") {
		$page_title="View Groups";
	}elseif ($current_title=="subjects.php") {
		$page_title="Manage Subjects";
	}elseif ($current_title=="given_exam.php") {
		$page_title="Manage Results";
	}elseif ($current_title=="comments.php") {
			$page_title="Comments";
	}elseif ($current_title=="edit_comments.php") {
			$page_title="Edit Comment";
	}elseif ($current_title=="edit_notice.php") {
			$page_title="Edit Notice";
	}elseif ($current_title=="notice.php") {
			$page_title="Notice";
	}else{
		$page_title="Dashboard";
	}

	?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
		<?php include 'links.php'; ?>
		<title><?php echo $page_title; ?></title>
		<!-- <script src="https://code.jquery.com/jquery-3.5.0.js"></script> -->
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

			@font-face{font-family:"sans-serif";font-weight:normal;font-style:normal }
			body {
			background: #56CCF2;
			background: -webkit-linear-gradient(to right, #2F80ED, #56CCF2);
			background: linear-gradient(to right, #2F80ED, #56CCF2);
			}
			.dropdown {
			position: relative;
			display: block;
			min-width: 140px;
  			font-weight: bold;
			}
			.dropdown ul li{
			font-size: 20px;
			}
			.dropdown ul li:hover{
			color: #ECE9E6;
			text-shadow: 0 0 30px #ECE9E6;
			}
			.dropdown-content {
			display: none;
			position: absolute;
			background-color: #06aaf0;
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
			.dropdown-content a:hover {
				background-color: #ECE9E6;
				text-shadow: 0 0 20px #ECE9E6;
			box-shadow: 0 0 20px black;
			}
			.me:hover .sub-menu {
				position: absolute;
				display: block;
				margin-top: -50px;
				background-color: #06aaf0;
		}
			
			.dropdown:hover .dropdown-content {display: block;}
			.dropdown:hover .dropbtn2 {background-color: #060d0f;}
		</style>
	</head>
	<body>
		<header>
			<nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
				<a class="navbar-brand active ml-3" href="index.php"><i class="fas fa-user" style="color: #56CCF2; font-weight: bold;"></i>User</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav mr-auto ">
						<!-- Faculty Starts -->
						<div class="dropdown">
							<ul class="navbar-nav mr-auto dropbtn2 nav-link">
								<li class="nav-link ml-2" style="margin-right: 2px;"><i class="fas fa-user-graduate" style="color: #56CCF2; margin-left: 3px"></i>Faculty</li>
							</ul>
							<div class="dropdown-content" style="min-width: 140px; text-align: center;">
								<a href="../Faculty/Registration.php">Registration Faculty</a>
								<li class="me">
									<a href="javascript:void(0)">View Faculty</a>
									<div class="sub-menu" style="margin-left: 140px;">
										<a href="view_faculty.php?d_id=1">Civil Engineering</a>
										<a href="view_faculty.php?d_id=2">Computer Engineering</a>
										<a href="view_faculty.php?d_id=3">Electrical Engineering</a>
										<a href="view_faculty.php?d_id=4">Mechanical Engineering</a>
									</div>
								</li>
							</div>
						</div>
						<!-- Faculty Ends -->
					
						<!-- Students Starts -->
						<div class="dropdown">
							<ul class="navbar-nav mr-auto dropbtn2 nav-link">
								<li class="nav-link ml-2" style="margin-right: 2px;"><i class="fas fa-users" style="color: #56CCF2;"></i>Students</li>
							</ul>
							<div class="dropdown-content" style="text-align: center; min-width: 149px;">
							<li class="me">
				 			 <a href="javascript:void(0)">View Student</a>
				  				<div class="sub-menu" style="margin-left: 144px;">
									<a href="view_students.php?d_id=1">Civil Engineering</a>
									<a href="view_students.php?d_id=2">Computer Engineering</a>
									<a href="view_students.php?d_id=3">Electrical Engineering</a>
									<a href="view_students.php?d_id=4">Mechanical Engineering</a>
										
									</div>
								</li> 
							</div>
						</div>
						<!-- Students Edns -->
						
						<!-- Materials Starts -->
						<div class="dropdown">
							<ul class="navbar-nav mr-auto dropbtn2 nav-link">
								<li class="nav-link ml-2" style="margin-right: 2px;"><i class="fas fa-book" style="color: #56CCF2;"></i>Material</li>
							</ul>
							<div class="dropdown-content" style="text-align: center; min-width: 140px;">
								<a href="subjects.php">Subjects</a>
								<a href="upload_materials.php">Upload Material</a>
								<li class="me">
									<a href="javascript:void(0)">View Material</a>
									<div class="sub-menu" style="margin-left: 140px;">
										<a href="view_materials.php?d_id=1">Civil Engineering</a>
										<a href="view_materials.php?d_id=2">Computer Engineering</a>
										<a href="view_materials.php?d_id=3">Electrical Engineering</a>
										<a href="view_materials.php?d_id=4">Mechanical Engineering</a>
									</div>
								</li>
							</div>
						</div>
						<!-- Materials Ends -->

						<!-- Lectures Starts -->
						<div class="dropdown">
							<ul class="navbar-nav mr-auto dropbtn2 nav-link">
								<li class="nav-link ml-2" style="margin-right: 2px;"><i class="fas fa-file-video" style="color: #56CCF2; margin-left: -3px"></i>Lectures</li>
							</ul>
							<div class="dropdown-content" style="min-width: 140px; text-align: center;">
								<a href="upload_lectures.php">Upload Lectures</a>
								<li class="me">
									<a href="javascript:void(0)">View Lectures</a>
									<div class="sub-menu" style="text-align: center; margin-left: 140px;">
										<a href="view_lectures.php?d_id=1">Civil Engineering</a>
										<a href="view_lectures.php?d_id=2">Computer Engineering</a>
										<a href="view_lectures.php?d_id=3">Electrical Engineering</a>
										<a href="view_lectures.php?d_id=4">Mechanical Engineering</a>
									</div>
								</li>
							</div>
						</div>
						<!-- Lectures Ends -->
						
						<!-- MCQS Starts -->
						<div class="dropdown">
							<ul class="navbar-nav mr-auto dropbtn2 nav-link">
								<li class="nav-link ml-2" style="margin-right: 2px;"><i class="fas fa-chalkboard" style="color: #56CCF2; margin-left: 3px"></i>MCQS</li>			
							</ul>
							<div class="dropdown-content" style="text-align: center; min-width: 140px;">
							<li class="me">
								<a href="javascript:void(0)">View MCQS</a>
								<div class="sub-menu" style="text-align: center; margin-left: 140px;">
									<a href="view_mcqs.php?d_id=1">Civil Engineering</a>
									<a href="view_mcqs.php?d_id=2">Computer Engineering</a>
									<a href="view_mcqs.php?d_id=3">Electrical Engineering</a>
									<a href="view_mcqs.php?d_id=4">Mechanical Engineering</a>
								</li> 
							</div>
						</div>
						<!-- MCQS Ends  -->

						<!-- Questions Starts -->
						<div class="dropdown">
							<ul class="navbar-nav mr-auto dropbtn2 nav-link" >
								<li class="nav-link ml-2" style="margin-right: 3px;"><i class="fas fa-comment" style="color: #56CCF2;"></i>Ask-Questions</li>
							</ul>
							<div class="dropdown-content " style="text-align: center; min-width: 197px;">
							<li class="me">
								<a href="javascript:void(0)">View Question</a>
								<div class="sub-menu" style="text-align: center; margin-left: 197px;">
									<a href="view_ask_question.php?d_id=1">Civil Engineering</a>
									<a href="view_ask_question.php?d_id=2">Computer Engineering</a>
									<a href="view_ask_question.php?d_id=3">Electrical Engineering</a>
									<a href="view_ask_question.php?d_id=4">Mechanical Engineering</a>
								</div>
							</li>
							</div>
						</div>
						<!-- Questions Ends -->

						<!-- Notice Starts -->
						<div class="dropdown">
							<ul class="navbar-nav mr-auto dropbtn2 nav-link">
								<li class="nav-link ml-2" style="margin-right: 3px;"><i class="fas fa-bell" style="color: #56CCF2; margin-left: 4px"></i>Notice</li>			
							</ul>
							<div class="dropdown-content" style="text-align: center; min-width: 140px;">
							<li class="me">
									<a href="javascript:void(0)">View Notice</a>
									<div class="sub-menu" style="text-align: center; margin-left: 140px;">
											<a href="notice.php?d_id=1">Civil Engineering</a>
									<a href="notice.php?d_id=2">Computer Engineering</a>
									<a href="notice.php?d_id=3">Electrical Engineering</a>
									<a href="notice.php?d_id=4">Mechanical Engineering</a>
								</li> 
							</div>
						</div>
						<!-- Notice Ends  -->

						<!-- Group Starts -->
						<div class="dropdown">
							<ul class="navbar-nav mr-auto dropbtn2 nav-link">
								<li class="nav-link ml-2" style="margin-right: 3px;"><i class="fas fa-pen" style="color: #56CCF2; margin-left: 4px"></i>Exam</li>
							</ul>
							<div class="dropdown-content " style="text-align: center;">
								<a href="add_group.php">Add Exam Group</a>
								<li class="me">
									<a href="javascript:void(0)">View Group Details</a>
									<div class="sub-menu" style="text-align: center; margin-left: 140px; margin-top: -72px;">
										<a href="view_groups.php?d_id=1">Civil Engineering</a>
										<a href="view_groups.php?d_id=2">Computer Engineering</a>
										<a href="view_groups.php?d_id=3">Electrical Engineering</a>
										<a href="view_groups.php?d_id=4">Mechanical Engineering</a>
									</div>
								</li>
								<a href="connect_group.php">Connected Groups</a>
								
							</div>
						</div>
						<!-- Group Ends -->

						<!-- Exam Starts -->
						<div class="dropdown">
							<ul class="navbar-nav mr-auto dropbtn2 nav-link">
								<li class="nav-link ml-2" style="margin-right: 4px;"><i class="fas fa-file-alt" style="color: #56CCF2; margin-left: 8px"></i>Result</li>
							</ul>
							<div class="dropdown-content " style="text-align: center;">
							<div class="dropdown-content" style="text-align: center; min-width: 144px;">
							<li class="me">
				 			 <a href="javascript:void(0)">View Result</a>
				  				<div class="sub-menu" style="margin-left: 144px;">
									<a href="view_results.php?d_id=1">Civil Engineering</a>
									<a href="view_results.php?d_id=2">Computer Engineering</a>
									<a href="view_results.php?d_id=3">Electrical Engineering</a>
									<a href="view_results.php?d_id=4">Mechanical Engineering</a>
										
									</div>
								</li> 
							</div>
							</div>
						</div>
						<!-- Exam Ends -->
					</ul>
					</div>
					<!-- Logout starts -->
						<a class="navbar-brand active ml-1" href="../admin/Logout.php"><i class="fas fa-power-off" style="color: #56CCF2;"></i>Logout</a>
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>
					<!-- Logout ends -->
		
				</nav>
			</header>
		</body>