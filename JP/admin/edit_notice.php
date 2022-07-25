<?php 
include '../inc/top.php';
require '../db/dbcon.php';

if (isset($_GET['notice_id'])) {

	$notice_id=$_GET['notice_id'];
$msg='';

	if ($_SERVER['REQUEST_METHOD']=='POST' and isset($_POST['notice_btn']) and isset($_POST['notice'])) {
        
        if (empty($_POST['notice'])) {
             $msg= '
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Notice Empty!!</strong>    Empty notice can not be added
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    ';
                    }else{


        $notice=safe_string($_POST['notice']);
        $admin_id=$_SESSION['admin_id'];

        $sql="UPDATE `notice` SET  `notice`='$notice', `update_time`=current_timestamp() WHERE notice_id=$notice_id";
        $result=mysqli_query($con,$sql) or die(mysqli_error($con));
        if ($result) {
             echo "<script>  window.history.go(-2); </script>";
            
               }else{
                        $msg= '
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Notice Can not added!</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                </div>
                                ';
                    }
        }
    }

	 $sql="SELECT * FROM notice WHERE notice_id=$notice_id ";
	 $result=mysqli_query($con,$sql);
	 if (mysqli_num_rows($result)>0){
	 	$row=mysqli_fetch_assoc($result);



	?>
<div class="container mt-5 bg-light p-3 ">
	<h3>Edit Notice</h3>
	<h6><?php if (isset($msg)) {
                echo $msg;
            }  ?> </h6>
	<form action="<?php echo htmlentities($_SERVER['REQUEST_URI']) ?>" method="POST">
		<div class="form-group">
			
			<label for="">Notice</label>

			<!-- <input type="text" name="admin" class="form-control"> -->
			<textarea class="form-control" name="notice" rows="5" placeholder="Enter Notice for this lecture"><?php echo $row['notice']; ?></textarea>
			<!-- <input type="text" name="notice" class="form-control" placeholder="Enter Question for this lecture"> -->
			
		</div>
		<button type="submit" name="notice_btn" class="btn btn-primary">Edit</button>

	</form>
	<hr>
</div>
<?php
	 }


} else {

}
include 'footer.php';

 ?>