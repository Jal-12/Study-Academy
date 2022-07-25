<?php
include '../inc/top.php';
require '../db/dbcon.php';
		
if (isset($_POST['update']) && $_SERVER["REQUEST_METHOD"] == "POST")
{
    
$flag = 'true';
			
	if ($flag==true)
	 {
        require '../db/dbcon.php';
        $admin_id = safe_string($_POST["admin_id"]);
        $username = safe_string($_POST["username"]);
        $email = safe_string($_POST["email"]);
        $password = safe_string($_POST["password"]);
       
// inserting data into db
	  $sql = "UPDATE `admin` SET username='$username', email='$email', password='$password' WHERE admin_id=$admin_id" ;

//instert data query
	  $status = mysqli_query($con, $sql);
	  if ($status==1)
       {
// email sending
        $subject= "Update Profile";
        $body= "Hello, $username,

        Your's credentials are as below:
        [ Admin-Id:- $admin_id ]
        [ Username:- $username ]
        [ Email:- $email ]
        [ Password:- $password ]
	    Thanks,

        Study-Academy 

        Note:This is an auto generated mail.
        Please do not reply to this email.";

        $headers= "From: studyacademy11@gmail.com";
        if (mail($email, $subject, $body, $headers)) 
        {
        echo'<script type="text/javascript">alert("Update Successfully completed We have send your details to your email"); </script>';     	
        } else 
        {
        echo'<script type="text/javascript">alert("Email sending failed...");</script>';
        }
        }
    if($status==0)
    {
        echo'<script type="text/javascript">alert("There is a problem");</script>';
    }
}
}

// getting edit data id
if (isset($_GET['admin_id'])) {
	$admin_id=$_GET['admin_id'];
	$sql="SELECT * FROM `admin` WHERE admin_id=$admin_id";
	$result = mysqli_query($con, $sql);
		if (mysqli_num_rows($result)) {
			$row=mysqli_fetch_array($result);

?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <title>Update Profile</title>
	</head>
	<body>
		<div class="container bg-white">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-12">
			            <h2  style="color: darkblue;">Update Profile</h2>
                    </div>
                </div>  
            </div>
            <div class="card-body">
                <div class="table-responsive">
			        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>" method="POST" enctype="multipart/form-data">
					<table class="table table-hover table-striped  ">

					<tr>
						<td><label for="admin_id">Admin-Id:</label></td>
						<td><?php echo $row['admin_id']; ?>
							<input type="hidden" name="admin_id" >
						</td>
					</tr>
					<tr>
						<td id="label"><label for="username">Full Name:</label></td>
						<td>
							<input type="Text" name="username" value="<?php echo $row['username']; ?>" placeholder="Enter your username">
						</td>
					</tr>
					<tr>
						<td id="label"><label for="email">E-mail:</label></td>
						<td>
							<input type="text" name="email" value="<?php echo $row['email']; ?>" placeholder="Enter your email address"></td>
						</tr>
					<tr>
						<td id="label"><label for="password">Password:</label></td>
						<td>
							<input type="text" name="password" value="<?php echo $row['password']; ?>" autocomplete="off" placeholder="Enter your password"></td>
						</tr>
						<tr>
						<td id="label"><label for="code">Verification Code:</label></td>
						<td><?php echo $row['code']; ?>
							<input type="hidden" name="code">
						</td>
					</tr>
					<tr>
						<td style="text-align: center;">
							<a style="color: #0052D4; font-size: 20px; margin:2px2px; padding: 2px 2px;" href="index.php">View Profile</a>
						</td>
						<td>
							<button class="btn btn-outline-primary" type="submit" name="update">Update</button>
                            <span style="font-size: 15px; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">(RE-login after update profile)</span>
						</td>
					</tr>
				</table>
			</form>
		</div>
        </div>
        <?php 
	}
}
?>
	</body>
</html>