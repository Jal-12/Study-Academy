<?php
include '../inc/top.php';
require '../db/dbcon.php';
if (isset($_GET['d_id'])>0 && $_GET['d_id']<5 && $_GET['d_id']!='')  {
    //pagination of 5 pages code
        $limit=5; // limit of the rows per table ex. 5 item per page

        // if page admin clicks on page then it runs
        if (isset($_GET['page'])) {
            $page=$_GET['page'];
        }else{
            $page=1;
        }

        $offset=($page-1)*$limit;
        $d_id=$_GET['d_id'];

    $msg='';

    $d_id=safe_string($_GET['d_id']);
    if ($_SERVER['REQUEST_METHOD']=='POST'  and isset($_POST['notice_btn']) and isset($_POST['notice'])) {
        
        if (empty($_POST['notice'])) {
             $msg= '
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Notice Empty! </strong>Empty notice can not be added
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    ';
                    }else{


        $notice=safe_string($_POST['notice']);
        $admin_id=$_SESSION['admin_id'];

        $sql="INSERT INTO `notice` (`d_id`,`admin_id`,`notice`) VALUES('$d_id', '$admin_id', '$notice')";
        $result=mysqli_query($con,$sql) or die(mysqli_error($con));
        if ($result) {
            $msg= '
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Notice Added Successfully!</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                   ';
            
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

?>

<body>   
<div class="container mt-5 bg-light p-3">
    <div class="card-header">
		<div class="row">
	        <div class="col-md-12">
				<h3 class="text-center font-weight-bold">Notices</h3>
           </div>
        </div>
    </div>
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
            <td>
            <textarea class="form-control" name="notice" placeholder="Write Notice"></textarea>
            </td>
            <!-- <td colspan="2" colspan="center"> -->
                <!-- <input style="padding-bottom:28px;" type="file" name="file" class="form-control " id="file" required> -->
					<!-- <span style="font-size: 12px; color: red;">(Maximum size limit= 40MB)</span> <span class="text-danger"></span> -->
			<!-- </td> -->
        </div>
        <center>
            <button type="submit" name="notice_btn" class="btn btn-primary">Add Notice</button>
        </center>
        </form><hr>
            <div class="m-2 p-3">
                    
                            <?php 
                $pageSql="SELECT * FROM notice WHERE d_id=$d_id";
                $sql1="SELECT * FROM notice WHERE d_id=$d_id ORDER BY create_time DESC LIMIT {$offset},{$limit}";
                // echo $sql;
                    $result1=mysqli_query($con,$sql1);
                    while ($row=mysqli_fetch_assoc($result1))
                    {
                        $admin_id_com=$row['admin_id'];
                        $adm_name=admin_id($admin_id_com);
                            
                            if($row["update_time"] == NULL){
	                            $notice_time=$row["create_time"];

	                        }else{
	                            $notice_time=$row["update_time"];

	                        }
                            // fa-universal-access 

                            echo '<hr>
                            <div class="float-right" style="color: #2F80ED; font-size:16px;">
                                    <div class="mb-3 ml-3 mr-2" style="cursor:pointer;" id="">
                                        <a href="edit_notice.php?notice_id='.$row['notice_id'].'"><i class="fas fa-edit"></i></a>
                                    </div>
                                    <div class="mt-3 ml-3 mr-2" style="cursor:pointer;" onclick="noticeDelete(this.id)" id="'.$row['notice_id'].'">
                                        <i class="fas fa-trash-alt"></i>
                                    </div>
                                </div>
                                <div class="media m-2 text-justify" >
                                     <i class="mt-2 fas fa-user-lock fa-2x" style="color: #2F80ED;">&nbsp;</i>
                                    <div class="media-body">
                                        <h5 >'.$row["notice"].'</h5><br>
                                        <figcaption class="blockquote-footer">'.DateMinute($notice_time).'<cite title="Source Title" class="font-weight-bold text-danger"> By <b>ADMIN</b>:-'.$adm_name.'</cite>
                                        </figcaption>
                                    </div>
                                </div><hr>
                                ';                        
                        
                    }
                ?> 
                </div>
        </div>
        <div class="container mt-3">    

    <?php

    // pagination code starts here with department wise     
        
            $total_page=ceil(mysqli_num_rows(mysqli_query($con,"SELECT * FROM notice WHERE notice.d_id=$d_id"))/$limit); 

            echo'<ul class="pagination justify-content-center">';
            for ($i=1; $i<=$total_page; $i++) {

                if ($i==$page) {
                    $active='active';
                } else{
                    $active="";
                }
                $PageNo='<li class="page-item '.$active.'"><a class="page-link" href="notice.php?d_id='.$d_id.'&page='.$i.'">'.$i.'</a></li>';
                
                echo $PageNo;
            }
            echo'</ul>';
            }
        
        // pagination code ends here with department wise
     else {
        echo "<h2 class='text-danger text-center mt-5'>Invalid ID</h2> ";
    }
    ?>
</div>

<script type="text/javascript">
    function noticeDelete(id) {
        // alert(id);
        if (confirm("Do you really want to delete notice?")) {
                // var sub_id= $(this).data("did");
                var notice_id=id;
                // alert(comment_id);

                $.ajax({
                    url:"delete.php",
                    type:"POST",
                    data:{notice_id: notice_id},
                    success: function(data){
                        if(data==1){
                            window.location.href=window.location.href;
                        } else{
                            alert("Notice not delete");
                        }
                    }
                });
         }
     }
</script>
    <?php include 'footer.php'; ?>