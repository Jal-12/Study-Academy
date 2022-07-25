<?php 
session_start();
date_default_timezone_set("Asia/Kolkata");
$exam_id=$_GET['exam_id'];
$value=$_GET['value'];
$_SESSION['answer'][$exam_id]=$value;
echo $exam_id.$value;


?>