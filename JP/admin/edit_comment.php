<?php 
include '../inc/top.php';
require '../db/dbcon.php';

if (isset($_GET['comment_id'])) {

	$comment_id=$_GET['comment_id'];
$msg='';

	if ($_SERVER['REQUEST_METHOD']=='POST' and isset($_POST['comment_btn']) and isset($_POST['comment'])) {
        
        if (empty($_POST['comment'])) {
             $msg= '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Comment Empty!!</strong>    Empty comment can not be added
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div> ';
        }else{

        $comment=safe_string($_POST['comment']);
        $admin_id=$_SESSION['admin_id'];

        $sql="UPDATE `comments` SET  `comment`='$comment', `update_time`=current_timestamp() WHERE comment_id=$comment_id";
        $result=mysqli_query($con,$sql) or die(mysqli_error($con));
        if ($result)
         {
            echo "<script>  window.history.go(-2); </script>";    
        }else{
             $msg= '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Comment Can not added!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div> ';
        }
      }
    }

	 $sql="SELECT * FROM comments WHERE comment_id=$comment_id ";
	 $result=mysqli_query($con,$sql);
	 if (mysqli_num_rows($result)>0){
	 	$row=mysqli_fetch_assoc($result);
?>
<div class="container mt-5 bg-light p-3 ">
	<h3>Edit Comment</h3>
	<h6>
    <?php 
        if (isset($msg))
         {
            echo $msg;
            }
    ?>
    </h6>
	<form action="<?php echo htmlentities($_SERVER['REQUEST_URI']) ?>" method="POST">
		<div class="form-group">
			<label for="">Comment</label>
			<textarea class="form-control" name="comment" rows="5" placeholder="Enter Comment for this lecture"><?php echo $row['comment']; ?></textarea>
		</div>
		<button type="submit" name="comment_btn" class="btn btn-primary">Edit</button>
	</form>
	<hr>
</div>
    <?php
	    }
    } else{}
include 'footer.php';
 ?>