<?php
session_start();
//db include
require '../db/dbcon.php';

error_reporting(0);
?>

<!DOCTYPE html>
  <html>
    <head>
      <meta charset="UTF-8">
	    <title>Faculty Registration</title>
        <link rel="stylesheet" type="text/css" href="css/Registration.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">   
        <link href="https://fonts.googleapis.com/css?family=Poppins&amp;display=swap" 
    rel="stylesheet">
   </head>
    <body>
     <form action="Registration.php" method="post">
	  <div class="box">
	  <h1>Please-Register</h1>
	   <table align="center"> 	
		<tr >
			<td><label for="faculty_id">Id_No: </lable></td>
			<td><input type="numb" id="name" name="faculty_id" autocomplete="off" placeholder="Enter Unique Id"><br/></td>
		</tr>
		<tr>
			<td><label for="username">User_Name: </label></td>
			<td><input type="text" id="name" name="username" autocomplete="off" placeholder="Enter UserName"><br/></td>
		</tr>			
		<tr>
			<td><label for="email">E-mail: </label></td>
			<td><input type="email" id="name" name="email" autocomplete="off" placeholder="Enter Email "><br/></td>
		</tr>
		<tr>
			<td><label for="mobile">Contact_Number: </label></td>
			<td><input type="num" id="name" name="mobile" autocomplete="off" placeholder="Enter ContactNumber"><br/></td>
		</tr>
		<tr>
			<td><label>Department:</label></td>
            <td>
			<select id="name" name="d_id" size="1">
			<?php
			$Select_d_id = "SELECT * FROM department";
			$SelectResult = mysqli_query($con, $Select_d_id);
			$num = mysqli_num_rows($SelectResult);
			while ($row = mysqli_fetch_array($SelectResult)) 
			{
			?>
			<option value="<?php echo $row['d_id'] ?>">
		               <?php echo $row['department'] ?>
			</option>
			<?php
			 }	
			?>
			</select><br/></td>
		</tr>
		<tr >
			<td><label>Password:</label.</td>
			<td><input type="password" id="name" name="password" autocomplete="off" placeholder="Enter Password"><br/></td>
    	</tr>
		<tr >
			<td><label>Confirm Password:</label.</td>
			<td><input type="password" id="name" name="cpassword" placeholder="Confirm Password" require><br/></td>
	 	</table>
        <button class="btn" type="submit" name="btnRegi">
     <span>Register</span>
    </button>
    
        <li><a href="../Admin/Index.php"><i class="fas fa-sign-out-alt"></i></a></li>
        
       </div>
      </form>
	 <div class="heading">
		<h2>Registration</h2>
	 </div>
	 <div class="status">
	    <p>Create New Account To Use Website</p>
	 </div>   
    </body>
</html>

<?php

if (isset($_POST['btnRegi'])) 
{
    $faculty_id=$_POST['faculty_id'];
    $username=$_POST['username'];
    $email=$_POST['email'];
    $mobile=$_POST['mobile'];
    $d_id=$_POST['d_id'];
    $password=$_POST['password'];
    $cpassword = $_POST["cpassword"];

    if($password !== $cpassword){
        $errors['password'] = "Confirm password not matched";
    }

//faculty_id checking
	 $faculty_id_check = "SELECT * FROM `faculty` WHERE faculty_id = '$faculty_id'";
	 $result = mysqli_query($con, $faculty_id_check);
	 $numExistFacultys = mysqli_num_rows($result);
	 if ($numExistFacultys > 0) {
		 echo '<script type="text/javascript">
				 alert("User exists");
			 </script>';
	 }

//code 
    $code=random_int(111111,999999);

// value insert query for registartion
    $q="INSERT INTO faculty (faculty_id, username, email, mobile, d_id, password, code, status) values ('$faculty_id', '$username', '$email', '$mobile', '$d_id', '$password', '$code', 'offline')";

    $status=mysqli_query($con,$q);
    if($status==1)
    {   
// email sending
     $subject= "Email Verification";
     $body= "Hello $username,

         Your's credentials are as below:
        
         [ Faculty-Id:- $faculty_id ]
         [ Username:- $username]
         [ Mobile Number:- $mobile]
         [ Email:- $email ]
         [ Department-Id:- $d_id ]
         [ Password:- $password ]
         [ Verification Code:- $code ]
          Thanks,
         
          Study-Academy 
         
          Note:This is an auto generated mail.
          Please do not reply to this email.";
      $headers= "From: studyacademy11@gmail.com";
      if (mail($email, $subject, $body, $headers)) 
      {
      echo'<script type="text/javascript">alert("Registration Successfully completed "); </script>';     	
     } else 
     {
         echo'<script type="text/javascript">alert("Email sending failed...");</script>';
     }
}
    if($status==0) 
    {
        echo "<script> alert( 'There is a problem' );</script>";
    }

}
?>