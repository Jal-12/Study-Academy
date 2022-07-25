<?php
include '../inc/faculty.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        <style type="text/css">
        .container{
            margin-left: 10%;
            margin-top: 3%;
            height: 480px;
            width: 500px;
            transition: bottom 0.4s, opacity 0.4s;
            box-shadow: 0px 0px 15px rgba(0,0,0,0.3);
            border-radius: 10px;
        }
        .container .fa-user-graduate{
            font-size: 80px;
            color: #FAFFD1;
            margin-left: 40%;
            margin-top: 5% ;
        }
        .container .text{
            font-size: 28px;
            font-weight: 600;
            color: #FAFFD1;
        }
        .container .close-btn button{
            padding: 9px 13px;
            font-size: 18px;
            margin-left: 37%;
            text-transform: uppercase;
            border-radius: 3px;
            font-weight: 600;
            cursor: pointer;
            border: 2px solid wheat;
            border-radius: 5px;
        }

        </style>
</head>
<body>

<div class="container">
<div class="fas fa-user-graduate">
    <h1>Hello</h1>
</div>
<div class="text">
<h3>
<?php echo"Welcome Faculty";
      echo"<br>";
      echo"Faculty-Id:- "; echo $_SESSION['faculty_id'];
      echo"<br>";
      echo"Username:- ";echo $_SESSION['username'];
      echo"<br>";
      echo"Email-Id:- ";echo $_SESSION['email'];
      echo"<br>";
      echo"Mobile-No:- ";echo $_SESSION['mobile'];
      echo"<br>";
      echo"Department:- ";echo d_id($_SESSION['d_id']);
      echo"<br>";
      echo"Account Status:- ";echo $_SESSION['status'];
  ?>
</h3>
</div>
<div class="close-btn">
<button><a href="#">UPDATE</a></button>
</div>
</div><!--container div -->

    
</body>
</html>