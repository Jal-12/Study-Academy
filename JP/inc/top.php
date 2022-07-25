<?php
session_start();
include 'function.php';
	if(!isset($_SESSION['admin']) OR $_SESSION['admin']!= true)
	{
		session_abort();
		redirect("login.php");
	} 

include 'header.php';

include 'constant.php';
date_default_timezone_set("Asia/Kolkata");
?>