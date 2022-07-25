<?php
 session_start();
 
 //unsetting all sesions and destrying them
if(isset($_SESSION['loggedin'])){
    unset($_SESSION['loggedin']);
} 
if(isset($_SESSION['duration'])){
   unset($_SESSION['duration']);
} 

if(isset($_SESSION['group_id'])){
   unset($_SESSION['group_id']);
}  
if(isset($_SESSION['start_time'])){
   unset($_SESSION['start_time']);
}  
if(isset($_SESSION['group_id'])){
   unset($_SESSION['group_id']);
}  
if(isset($_SESSION['end_time'])){
   unset($_SESSION['end_time']);
}  
if(isset($_SESSION['loggedin'])){
   unset($_SESSION['loggedin']);
}  
if(isset($_SESSION['enrollment'])){
   unset($_SESSION['enrollment']);
}   
if(isset($_SESSION['username'])){
   unset($_SESSION['username']);
}   
if(isset($_SESSION['enrollment'])){
   unset($_SESSION['enrollment']);
}   
if(isset($_SESSION['email'])){
   unset($_SESSION['email']);
}   
if(isset($_SESSION['mobile'])){
   unset($_SESSION['mobile']);
}   
if(isset($_SESSION['d_id'])){
   unset($_SESSION['d_id']);
}   
if(isset($_SESSION['semester'])){
   unset($_SESSION['semester']);
}   
if(isset($_SESSION['d_id'])){
   unset($_SESSION['d_id']);
} 
session_unset();
session_destroy();
 
 echo '<script type="text/javascript">
			window.location="../index.php";
		</script>';
           
?>
