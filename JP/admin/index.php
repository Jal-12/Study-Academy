<?php
include '../inc/top.php';
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
            height: 500px;
            width: 700px;
            transition: bottom 0.4s, opacity 0.4s;
            box-shadow: 0px 0px 15px rgba(0,0,0,0.3);
            border: 2px solid gold;
            border-radius: 10px;
        }
        .container .fa-user-lock{
            font-size: 90px;
            color: #FAFFD1;
            margin-left: 40%;
            margin-top: 5%;
        }
        .container .text{
            margin-left: 15%;
            color: #FAFFD1;
        }
        .container .close-btn button{
            padding: 9px 13px;
            font-size: 18px;
            margin-left: 40%;
            text-transform: uppercase;
            border-radius: 3px;
            font-weight: 600;
            cursor: pointer;
            border: 2px solid gold;
            border-radius: 5px;
        }

        </style>
</head>
<body>
    
<div class="container">
<div class="fas fa-user-lock">
    <h1>Hello</h1>
</div>
<div class="text">
<h2>
<?php echo"Welcome  Admin";
      echo"<br>";
      echo"Admin-Id:-  "; echo $_SESSION['admin_id'];
      echo"<br>";
      echo"Username:-  "; echo $_SESSION['username'];
      echo"<br>";
      echo"Email-Id:-  "; echo $_SESSION['email'];
      echo"<br>";
      echo"Account Status:-  "; echo $_SESSION['status'];
      ?>
</h2>
</div>
</br>
<div class="close-btn">
<button><a href="Update.php?admin_id=<?php echo $_SESSION['admin_id'];?>">UPDATE</a></button>
</div>
</div><!--container div -->

</body>
</html>