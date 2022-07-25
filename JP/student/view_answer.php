<?php
include '../inc/student.php';
require '../db/dbcon.php';
if (isset($_GET['que_id']) && $_GET['que_id']!='' ) {
	 $que_id=safe_string($_GET['que_id']);

    $msg='';
if ($_SERVER['REQUEST_METHOD']=='POST'  and isset($_POST['answer_btn']) and isset($_POST['answer'])){

        if (empty($_POST['answer'])) {
             $msg= '
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Answer Empty!!</strong>    Empty answer can not be added
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    ';
                    }else{
        


        $answer=safe_string($_POST['answer']);
        $stu_id=$_SESSION['stu_id'];

        $sql="INSERT INTO `answers` (`que_id`,`stu_id`,`answer`) VALUES('$que_id', '$stu_id', '$answer')";
        $result=mysqli_query($con,$sql) or die(mysqli_error($con));
        if ($result) {
            $msg= '
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Answer Added Successfully!</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                   ';
            
               }else{
                        $msg= '
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Answer Can not added!</strong>
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
    <?php $question=mysqli_fetch_assoc(mysqli_query($con,"SELECT question FROM ask_question WHERE que_id=$que_id")) ?>
            <h3 class="text-center font-weight-bold"><?php echo $question['question'] ?></h3>
            <h6><?php if (isset($msg)) {
                echo $msg;
            }  ?> </h6>
            <form action="<?php echo htmlentities($_SERVER['REQUEST_URI']) ?>" method="POST">
                <div class="form-group">
                    
                    <!-- <input type="text" name="admin" class="form-control"> -->
                    <textarea class="form-control" name="answer" placeholder="Enter answer"></textarea>
                    <!-- <input type="text" name="comment" class="form-control" placeholder="Enter Question for this lecture"> -->
                    
                </div>
                <button type="submit" name="answer_btn" class="btn btn-primary">Give Answer</button>
                
            </form><hr>
                <div class="m-2 p-3">
                    
                            <?php 
                            $unit_id=false;
        $limit=20; // limit of the rows per table ex. 5 item per page

        if (isset($_GET['page'])) {
            $page=safe_string($_GET['page']);
        }else{
            $page=1;
        }

        $offset=($page-1)*$limit;
                $pageSql="SELECT * FROM answers WHERE que_id=$que_id";
                $sql1="SELECT * FROM answers WHERE que_id=$que_id";
                // echo $sql;
                    $result1=mysqli_query($con,$sql1);
                    $records=mysqli_num_rows($result1);
if ($records==0){
    echo "<center><b class='text-danger'>No Answers found!</b></center>";

}else{ 
           
                    while ($row=mysqli_fetch_assoc($result1)) {
                        $stu_id_ans=$row['stu_id'];
                        $admin_id_ans=$row['admin_id'];
                        $faculty_id_ans=$row['faculty_id']; 
                        
                        if($row["update_time"]==NULL){
                            $ans_time=$row["create_time"];

                        }else{
                            $ans_time=$row["update_time"];

                        }

                        
                        
                        
                        if ($stu_id_ans!=NULL) {
                            $stu_name=stu_id($stu_id_ans);

                            echo '<hr>
                            <div class="float-right" style="color: #2F80ED; font-size:16px;">
                           <div class="mb-3 ml-3 mr-2" style="cursor:pointer;" id="">
                               <a href="edit_answer.php?ans_id='.$row['ans_id'].'"><i class="fas fa-edit"></i></a>
                           </div>
                           <div class="mt-3 ml-3 mr-2" style="cursor:pointer;" onclick="ansDelete(this.id)" id="'.$row['ans_id'].'">
                               <i class="fas fa-trash-alt"></i>
                           </div> 
                           </div> 
                                <div class="media m-2 text-justify" >
                                     <i class="mt-2 fas fa-user-graduate fa-2x" style="color: #2F80ED;">&nbsp;</i>
                                    <div class="media-body">
                                        <p>'.$row["answer"].'</p>
                                        <figcaption class="blockquote-footer">'.DateMinute($ans_time).'<cite title="Source Title" class="font-weight-bold "> By <b>Student</b>:-'.$stu_name['username'].'</cite>
                                        </figcaption>
                                    </div>
                                </div><hr>
                                ';
                        } 
                        if ($admin_id_ans!=NULL) {
                            $adm_name=admin_id($admin_id_ans);
                            // fa-universal-access 

                            echo '<hr>
                                <div class="media m-2 text-justify" >
                                     <i class="mt-2 fas fa-university fa-3x" style="color: #2F80ED;">&nbsp;</i>
                                    <div class="media-body">
                                        <h5 >'.$row["answer"].'</h5>
                                        <figcaption class="blockquote-footer">'.DateMinute($ans_time).'<cite title="Source Title" class="font-weight-bold text-danger"> By <b>ADMIN</b>:-'.$adm_name.'</cite>
                                        </figcaption>
                                    </div>
                                </div><hr>
                                ';
                        } 
                        if ($faculty_id_ans!=NULL) {
                            $fac_name=faculty_id($faculty_id_ans);

                            echo '<hr>
                                <div class="media m-2 text-justify">
                                    <i class="mt-2 fas fa-chalkboard-teacher fa-3x" style="color: #2F80ED;">&nbsp;</i>
                                    <div class="media-body">
                                        <h5 >'.$row["answer"].'</h5>
                                        <figcaption class="blockquote-footer">'.DateMinute($ans_time).'<cite title="Source Title" class="font-weight-bold text-primary"> By <b>Faculty</b>:-'.$fac_name.'</cite>
                                        </figcaption>
                                    </div>
                                </div><hr>
                                ';
                            }    
    
}
}

?>
</div>
</div>
 <div class="container mt-3">    

    <?php

    // pagination code starts here with department wise    
   
$records=mysqli_num_rows(mysqli_query($con,$pageSql));    
        if ($records>0) {
        
            $total_page=ceil($records/$limit); 

            echo'<ul class="pagination justify-content-center">';
            for ($i=1; $i<=$total_page; $i++) {

                if ($i==$page) {
                    $active='active';
                } else{
                    $active="";
                }

                
                    
                        $PageNo='<li class="page-item '.$active.'"><a class="page-link" href="view_answer.php?que_id='.$que_id.'&page='.$i.'">'.$i.'</a></li>';
                    

                echo $PageNo;
            }
            echo'</ul>';
            }
        
        // pagination code ends here with department wise
    } else {
        echo "<h2 class='text-danger text-center mt-5'>Invalid ID</h2> ";
    }
    ?>
</div>

<script type="text/javascript">
   
     function ansDelete(id) {
        // alert(id);
        if (confirm("Do you really want to delete question?")) {
                // var sub_id= $(this).data("did");
                var ans_id=id;
                // alert(ans_id);

                $.ajax({
                    url:"delete.php",
                    type:"POST",
                    data:{ans_id: ans_id},
                    success: function(data){
                        if(data==1){
                            window.location.href=window.location.href;
                        } else{
                            alert("Question not delete");
                        }
                    }
                });
         }
     }

        


</script>

    <?php include 'footer.php'; ?>
