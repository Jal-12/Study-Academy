<?php
include '../inc/student.php';
require '../db/dbcon.php';


if (isset($_SESSION['d_id']) && isset($_GET['semester'])) 
{
    $semester=safe_string( $_GET['semester']);
    $d_id=$_SESSION['d_id'];

    if (isset($_GET['sub_id'])) 
    {
        $sub_id=safe_string( $_GET['sub_id']);
    } else {
        $sub_id='';
    }
    echo'<body>
        <div class="container-fluid">
        <center class="bg-info m-1"> ';

    $subjectSQL="SELECT sub_id,subject FROM subject WHERE d_id=$d_id AND semester=$semester";
    $SubSqlResult=mysqli_query($con,$subjectSQL);
    if (mysqli_num_rows($SubSqlResult)==0) 
    {
        $NoSubject="Subjects Not found!";
    }else{
        $no=0;
        while ($subRow=mysqli_fetch_assoc($SubSqlResult)) {
        if ($subRow['sub_id'] == $sub_id) 
        {
            echo '<a class="btn btn-dark  m-2 my-4" href="view_ask_question_other_sem.php?semester='.$semester.'&sub_id='.$subRow['sub_id'].'">' . sub_id($subRow['sub_id']) . '</a>';
        } else {
            echo '<a class="btn btn-light  m-2 my-4" href="view_ask_question_other_sem.php?semester='.$semester.'&sub_id='.$subRow['sub_id'].'">' . sub_id($subRow['sub_id']) . '</a>';
        }
    }
}
echo'</center>';

if ($_SERVER['REQUEST_METHOD']=='POST'  and isset($_POST['ask_question_btn']) and isset($_POST['question']) ) 
{
    $msg='';

    if (empty($_POST['question'])) 
    {
         $msg= '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Question Empty!!</strong>    Empty question can not be added
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>';
    }else{

    if (isset($_GET['unit_id']) or isset($_POST['unit_id']) ) {

        if (isset($_POST['unit_id']) && $_POST['unit_id']!='') {
           $unit_id=safe_string($_POST['unit_id']);
        }
        if (isset($_GET['unit_id']) && $_GET['unit_id']!='') {
            $unit_id=safe_string($_GET['unit_id']);
        } 
        
        $sub_id=safe_string($_GET['sub_id']);
        $department = $_SESSION['d_id'];
        $semester=safe_string( $_GET['semester']);
        $question=safe_string($_POST['question']);
        $stu_id=$_SESSION['stu_id'];

        $sql="INSERT INTO `ask_question` (`sub_id`, `stu_id`, `d_id`, `semester`, `unit_id`, `question`) VALUES('$sub_id', '$stu_id', '$department', '$semester', '$unit_id', '$question')";
        $result=mysqli_query($con,$sql) or die(mysqli_error($con));
        if ($result) {
            $msg= '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Question Added Successfully!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
               ';
        
           }else{
                    $msg= '
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Question Can not added!</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>
                            ';
                }
        }
    }
}

if (isset($_GET['sub_id']) && isset($_SESSION['d_id'])&& isset($_SESSION['semester'])) {
    $unit_id=false;
    $limit=6; // limit of the rows per table ex. 5 item per page

    // if page  on page then it runs
    if (isset($_GET['page'])) 
    {
        $page=safe_string($_GET['page']);
    }else{
        $page=1;
    }

    $offset=($page-1)*$limit;
    $sub_id=safe_string($_GET['sub_id']);
    
    $pageSql="SELECT * FROM ask_question WHERE d_id=$d_id AND semester=$semester AND sub_id=$sub_id";
    $sql="SELECT * FROM ask_question WHERE d_id=$d_id AND semester=$semester AND sub_id=$sub_id LIMIT {$offset},{$limit}";
    $unitSQL="SELECT * FROM `unit` WHERE sub_id=$sub_id";
    
    // unit wise question
        if (isset($_GET['unit_id'])&& $_GET['unit_id'] != '') 
        {
            $unit_id = safe_string($_GET['unit_id']);        
            
            $pageSql="SELECT * FROM `ask_question` WHERE ask_question.d_id=$d_id and ask_question.semester=$semester and sub_id=$sub_id and unit_id=$unit_id ";
            $sql="SELECT * FROM `ask_question` WHERE ask_question.d_id=$d_id and ask_question.semester=$semester and sub_id=$sub_id and unit_id=$unit_id  LIMIT {$offset},{$limit}";
        }
?>
<body>
    <div class="container-fluid mt-3">
        <div class="row m-1">
            <div class="col-sm-2 p-2 ">
            <center>
            <!-- showing units according to unit start -->
            <?php
                if (isset($unitSQL)) 
                {
                    $unitResult = mysqli_query($con, $unitSQL);
                    while ($unitRow = mysqli_fetch_assoc($unitResult)) {
                        $unitArr=unit_id($unitRow['unit_id']);
                        if ($unitRow['unit_id'] == $unit_id) 
                        {
                            echo '<a class="shadow" href="view_ask_question_other_sem.php?semester='.$semester.'&sub_id='.$sub_id.'&unit_id='.$unitRow['unit_id'].'"><div class="col-sm-11 btn btn-sm btn-dark  my-3">'.$unitArr["unit_number"].'.&nbsp;'.$unitArr["unit_name"].'</div></a> ';
                        } else {
                            echo '<a class="shadow-sm" href="view_ask_question_other_sem.php?semester='.$semester.'&sub_id='.$sub_id.'&unit_id='.$unitRow['unit_id'].'"><div class="col-sm-11 btn btn-sm btn-light my-3">'.$unitArr["unit_number"].'.&nbsp;'.$unitArr["unit_name"].'</div></a>';
                        }    
                    }
                }
            ?>
            <!-- showing sujects according to unit ends-->
            </center>
            </div>
            <div class="col-sm-10 my-3  bg-light">
            <hr>
                <div class="card-header">
                    <h3 class="text-center font-weight-bold"><?php echo sub_id($sub_id); ?>:-Ask-Question</h3>
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
                            <?php 
                                if ($unit_id==false) 
                                {
                            ?>
                            <label for="unit_id" class="font-weight-bold p-1 text-dark">Select Unit :</label>

                                <select class='form-control' name='unit_id' id='unit' size='1' required="">
                                    <option value='' selected='' disabled=''>Select Unit</option>
                                    <?php 
                                    if ($unit_id!='') {
                                    
                                    $Select_sub_id = "SELECT * FROM unit WHERE sub_id={$sub_id}";
                                    $SelectResult = mysqli_query($con, $Select_sub_id);

                                    while ($unit_id_row = mysqli_fetch_array($SelectResult)) {
                                        if ($unit_id_row['unit_id']==$unit_id) {
                                            echo "<option value='".$unit_id_row['unit_id']."'selected>".$unit_id_row['unit_number'].".&nbsp;".$unit_id_row['unit_name']."</option>";
                                        }else{
                                            echo "<option value='".$unit_id_row['unit_id']."'>".$unit_id_row['unit_number'].".&nbsp;".$unit_id_row['unit_name']."</option>";
                                        }
                                    }
                                }
        
                                ?> 
                                </select>
                                <?php
                                    } else {
                                }
                                ?>
                        <textarea class="form-control" name="question" placeholder="Enter Question"></textarea>
                        </div>
                        
                        <center>
                            <button type="submit" name="ask_question_btn" class="btn btn-dark">:-Ask Question</button>
                        </center>
                    </form><hr>
                </div>
                
                <div class="card-header">
                    <h3 class="text-center font-weight-bold"><?php echo sub_id($sub_id); ?>:-Questions</h3>
                </div>
                <?php 
                    $result=mysqli_query($con,$sql);
                    $records=mysqli_num_rows($result);
                    if ($records==0){
                        echo "<center><b class='text-danger'>No Question found!</b></center>";

                    }else{ 
                ?>

                <div class="card-body">
                <div class="table-responsive">
                <?php
                            
                    $No = $offset;
                    while ($row = mysqli_fetch_array($result)) {
                    $No = $No + 1;
                    $stu_id_que=$row['stu_id'];
                    $admin_id_que=$row['admin_id'];
                    $faculty_id_que=$row['faculty_id'];

                    if($row["update_time"]==NULL){
                        $que_time=$row["create_time"];
                    }else{
                        $que_time=$row["update_time"];
                    }
                ?>
                <table class="table table-light thover ts table-bordered">
                    <tbody>
                        <tr>
                            <td> 
                            <?php 
                            if ($stu_id_que!=NULL) {
                                $stu_name=stu_id($stu_id_que);
                                echo '<div class="media m-1 text-justify" >
                                        <div class="float-right" style="color: #36D1DC; font-size:16px;">
                                            <div class="media-body">
                                                <h5 class="font-weight-bold">Question:-'.$row["question"].'</h5>
                                                <figcaption class="blockquote-footer">'.DateMinute($que_time).'<cite title="Source Title" class="font-weight-bold"> By <b>Student</b>:-'.$stu_name['username'].'</cite>&nbsp; </figcaption>
                                            </div>
                                        </div>    
                                      </div> '; }
                            ?>
                            </td>
                        </tr>
                    </tbody>
                </table> 
                <table class="table table-dark thover ts table-bordered">   
                    <tbody>    
                        <tr>
                            <td>
                            <?php
                            if ($admin_id_que!=NULL) {
                                $adm_name=admin_id($admin_id_que);
                                echo '<div class="media m-1 text-justify" >
                                        <div class="float-right" style="color: #2F80ED; font-size:16px;">
                                            <div class="media-body">
                                                <h5 class="font-weight-bold">Answer:-'.$row["answer"].'</h5>
                                                <figcaption class="blockquote-footer">'.DateMinute($que_time).'<cite title="Source Title" class="font-weight-bold text-danger"> By <b>ADMIN</b>:-'.$adm_name.'</cite>&nbsp; </figcaption>
                                            </div>
                                        </div>
                                      </div>'; }
                            if ($faculty_id_que!=NULL) {
                                $fac_name=faculty_id($faculty_id_que);
                                    echo '<div class="media m-1 text-justify">
                                            <div class="float-right" style="color: #00c6ff; font-size:16px;">
                                                <div class="media-body">
                                                    <h5 class="font-weight-bold">'.$row["answer"].'</h5>
                                                    <figcaption class="blockquote-footer">'.DateMinute($que_time).'<cite title="Source Title" class="font-weight-bold text-primary"> By <b>Faculty</b>:-'.$fac_name.'</cite>&nbsp; </figcaption>
                                                </div>
                                            </div>    
                                        </div> ';  }
                            ?>
                            </td>
                        </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>            
                </table>
            </div>
            </div>
        </div>
    </div>
</div>
    <?php include 'footer.php'; ?>

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

                
                    if (isset($_GET['unit_id'])&& $_GET['unit_id'] != '') {
                        $PageNo='<li class="page-item '.$active.'"><a class="page-link" href="ask_question.php?sub_id='.$sub_id.'&unit_id='.$unit_id.'&page='.$i.'">'.$i.'</a></li>';
                    
                    }else{

                        $PageNo='<li class="page-item '.$active.'"><a class="page-link" href="ask_question.php?sub_id='.$sub_id.'&page='.$i.'">'.$i.'</a></li>';
                    }

                echo $PageNo;
            }
            echo'</ul>';
            }
        
        // pagination code ends here with department wise
    }
 } else {
        echo "<h2 class='text-danger text-center mt-5'>Invalid ID</h2> ";
    }
    ?>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        var uploadEditsub_id=$("#subject").val();

        var uploadEditsub_id= <?php echo $sub_id; ?>

                    $.ajax({
                        url:"ajax.subject_load.php",
                        type: "POST",
                        data: {uploadEditsub_id:uploadEditsub_id},
                        success:function(udata){
                            console.log(udata);
                            $("#unit").html(udata);
                            }
                        });
                
                
              
    });

     function queDelete(id) {
        // alert(id);
        if (confirm("Do you really want to delete question?")) {
                // var sub_id= $(this).data("did");
                var question_id=id;
                // alert(question_id);

                $.ajax({
                    url:"delete.php",
                    type:"POST",
                    data:{question_id: question_id},
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

    