<?php
session_start();
include 'function.php';
	if(!isset($_SESSION['faculty']) OR $_SESSION['faculty']!= true)
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
	}elseif ($current_title=="view_students.php") {
		$page_title="View Students";
	}elseif ($current_title=="view_lectures.php") {
		$page_title="View Lectures";
	}elseif ($current_title=="edit_lectures.php") {
		$page_title="Edit Lectures";
	}elseif ($current_title=="upload_lectures.php") {
		$page_title="Upload Lectures";
	}elseif ($current_title=="view_materials.php") {
		$page_title="View Materials";
	}elseif ($current_title=="edit_materials.php") {
		$page_title="Edit Materials";
	}elseif ($current_title=="upload_materials.php") {
		$page_title="Upload Materials";
	}elseif ($current_title=="add_questions.php"){
		$page_title="Add Questions";
	}elseif ($current_title=="view_questions.php") {
		$page_title="View Questions";
	}elseif ($current_title=="view_groups.php") {
		$page_title="View Groups";
	}elseif ($current_title=="given_exam.php") {
		$page_title="Manage Results";
	}elseif ($current_title=="view_results.php") {
		$page_title="View Results";
	}else{
		$page_title="Home";
	}

include 'constant.php';
include 'links.php';
require '../db/dbcon.php';

if (isset($_SESSION['d_id'])) 
 {
	$d_id =$_SESSION['d_id'];

	$Query="SELECT department FROM department WHERE d_id=$d_id";
	$qResult=mysqli_query($con,$Query);
	if(mysqli_num_rows($qResult)==0) 
	{
		$NoDepartment="";
	}else{
		$no=0;
		while($row=mysqli_fetch_assoc($qResult))
		{
			$department[]=$row['department'];
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
		    background: #00c6ff;  
            background: -webkit-linear-gradient(to right, #0072ff, #00c6ff);  
            background: linear-gradient(to right, #0072ff, #00c5ff); 
 
		}
		.dropdown {
		    position: relative;
		    display: block;
		    min-width: 140px;
			font-weight: bold;
		}
		.dropdown ul li{
		    font-size: 20px;
            color: #04ecfd;
         }
		.dropdown ul li:hover{
		    color: #ECE9E6;
		    text-shadow: 0 0 30px #ECE9E6;
		}
		.dropdown-content {
		    display: none;
		    position: absolute;
		    background-color: #0072ff;
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
			  background-color: #0072ff;
		  }
		.dropdown-content a:hover {
            background-color: #ECE9E6;
            text-shadow: 0 0 20px #ECE9E6;
		    box-shadow: 0 0 20px black;
        }
		.dropdown:hover .dropdown-content{
            display: block;
        }
		.dropdown:hover .dropbtn2 {background-color: #060d0f;}

		</style>
	</head>
	<body>

		<header>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
			<a class="navbar-brand active ml-5" style="margin-right: 30px;" href="../faculty/Index.php"><i class="fas fa-user" style="color: #04ecfd;"></i>User</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto ">
		
		<!-- Students Starts -->
			<div class="dropdown">
				<ul class="navbar-nav mr-auto dropbtn2 nav-link">
				  	<li class="nav-link ml-4" style="text-align: center; margin-right: 12x;"><i class="fas fa-users" style="color: #04ecfd; margin-left: -14px"></i>Students</li>
				</ul>
				<div class="dropdown-content" style="text-align: center; min-width: 150px;">
					    <?php
						if(isset($d_id))
						{
							for ($i=0; $i <$no ; $i++) { 
								echo '<a href="view_students.php?d_id='.$d_id[$i].'">View Student</a>';
						}
					}else{
							echo'Please login again';
						} 
						?>
				  </div>
				</div>
		<!-- Students End -->

		<!-- Material Starts -->
				<div class="dropdown">
				  <ul class="navbar-nav mr-auto dropbtn2 nav-link">
				  	<li class="nav-link ml-4" style="text-align: center; margin-right: 12px;"><i class="fas fa-book" style="color: #04ecfd; margin-left: -8px"></i>Material</li>
				  </ul>
				  <div class="dropdown-content" style="text-align: center; min-width: 156px;">
						<a href="upload_materials.php">Upload Material</a>
						<?php
						if(isset($d_id))
						{
							for ($i=0; $i <$no ; $i++) { 
								echo '<a href="view_materials.php?d_id='.$d_id[$i].'">View Materical</a>';
						}
					}else{
							echo'Please login again';
						} 
						?>
					</div>
				</div>
		<!-- Material End -->

		<!-- Lectures Starts -->
				<div class="dropdown">
				  <ul class="navbar-nav mr-auto dropbtn2 nav-link">
				  	<li class="nav-link ml-4" style="text-align: center; margin-right: 12px;"><i class="fas fa-file-video" style="color: #04ecfd; margin-left: -5px"></i>Lectures</li>
				  </ul>
				  <div class="dropdown-content" style="text-align: center; min-width: 156px;">
				  		<a href="upload_lectures.php">Upload Lectures</a>
						  <?php
						if(isset($d_id))
						{
							for ($i=0; $i <$no ; $i++) { 
								echo '<a href="view_lectures.php?d_id='.$d_id[$i].'">View Lectures</a>';
						}
					}else{
							echo'Please login again';
						} 
						?>
					</div>
				</div>
		<!-- Lectures Ends -->

		<!-- MCQS Starts -->
		<div class="dropdown">
							<ul class="navbar-nav mr-auto dropbtn2 nav-link">
								<li class="nav-link ml-4" style="margin-right: 14px;"><i class="fas fa-chalkboard" style="color: #56CCF2; margin-left: -5px"></i>MCQS</li>			
							</ul>
							<div class="dropdown-content" style="text-align: center; min-width: 148px;">
								<a href="#">Add MCQS</a>	
								<?php
								if(isset($d_id))
								{
									for ($i=0; $i <$no ; $i++) { 
										echo '<a href="#.php?d_id='.$d_id[$i].'">View MCQS</a>';
								}
							}else{
									echo'Please login again';
								} 
								?>
							</div>
						</div>
						<!-- MCQS Ends  -->
		
		<!-- Questions Starts -->
		<div class="dropdown">
				  <ul class="navbar-nav mr-auto dropbtn2 nav-link" >
				  	<li class="nav-link ml-4" style="margin-right: 14px;"><i class="fas fa-comment" style="color: #04ecfd; margin-left: -4px"></i>Ask Questions</li>
				</ul>
				<div class="dropdown-content " style="text-align: center; min-width: 218px;">
				<?php
						if(isset($d_id))
						{
							for ($i=0; $i <$no ; $i++) { 
								echo '<a href="view_ask_question.php?d_id='.$d_id[$i].'">View Question</a>';
						}
					}else{
							echo'Please login again';
						} 
				?>
				</div>
			</div>
        <!-- Questions Ends -->

		<!-- Notice Starts -->
		<div class="dropdown">
				<ul class="navbar-nav mr-auto dropbtn2 nav-link">
				  	<li class="nav-link ml-4" style="text-align: center; margin-right: 12px;"><i class="fas fa-bell" style="color: #04ecfd; margin-left: -7px"></i>Notice</li>
				</ul>
				<div class="dropdown-content" style="text-align: center; min-width: 142px;">
					    <?php
						if(isset($d_id))
						{
							for ($i=0; $i <$no ; $i++) { 
								echo '<a href="notice.php?d_id='.$d_id[$i].'">View Notice</a>';
						}
					}else{
							echo'Please login again';
						} 
						?>
				  </div>
				</div>
		<!-- Notice Ends  -->

		<!-- Exam Starts -->
		<div class="dropdown">
				    <ul class="navbar-nav mr-auto dropbtn2 nav-link">
				  		<li class="nav-link ml-4" style="margin-right: 10px;"><i class="fas fa-pen" style="color: #04ecfd; margin-left: -5px;"></i>Exam</li>
					</ul>
				  <div class="dropdown-content " style="text-align: center;" >
				  <?php
						if(isset($d_id))
						{
							for ($i=0; $i <$no ; $i++) { 
								echo '<a href="view_groups.php?d_id='.$d_id[$i].'">View Group Details</a>';
						}
					}else{
							echo'Please login again';
						} 
						?>
				  </div>
				</div>
		<!-- Exam Ends -->

		<!-- Result Starts -->
		<div class="dropdown">
				  	<ul class="navbar-nav mr-auto dropbtn2 nav-link">
				  		<li class="nav-link ml-4" style="margin-right: 10px;"><i class="fas fa-file-alt" style="color: #04ecfd; margin-left: -4px"></i>Result</li>
					</ul>
				  	<div class="dropdown-content" style="text-align: center;">
					  <?php
						if(isset($d_id))
						{
							for ($i=0; $i <$no ; $i++) { 
								echo '<a href="view_results.php?d_id='.$d_id[$i].'">View Result</a>';
						}
					}else{
							echo'Please login again';
						} 
						?>
				 </div>
				</div>
		<!-- Result Ends -->
	       </ul>
	    </div>
			<!-- Logout starts -->
			<a class="navbar-brand active ml-1" href="../faculty/Logout.php"><i class="fas fa-power-off" style="color: #56CCF2;"></i>Logout</a>
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>
					<!-- Logout ends -->
		
		</nav>
	</header>
</body>
