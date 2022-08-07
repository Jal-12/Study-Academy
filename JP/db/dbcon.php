<?php
$server="localhost";
$user="root";
$password="";
$database="saa";

$con=mysqli_connect($server, $user, $password, $database);

// function DepartmentSelect($d)
// {
// 	$Select_d_id = "SELECT * FROM department WHERE d_id=$d";
//                     $SelectResult = mysqli_query($con, $Select_d_id);
// 					$dep = mysqli_fetch_array($SelectResult);
// 					$dep= $dep['department'];
// 					return $dep;
// }
?>