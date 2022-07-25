<?php
include '../inc/faculty.php';
require '../db/dbcon.php';

if (isset($_GET['d_id'])>0 && $_GET['d_id']<5 && $_GET['d_id']!='') 
    {
    // pagination of 5 pages code
        $limit=5; // limit of the rows per table ex. 5 item per page

    // if page admin clicks on page then it runs
        if (isset($_GET['page'])) {
            $page=$_GET['page'];
        }else{
            $page=1;
        }
        $offset=($page-1)*$limit;
        $d_id=$_GET['d_id'];
?>

<body>
    <div class="container-fluid">
        <center>

        <?php 
        $dark = $semActive = $semEcho = $sub = $subActive = $sub_id1='';
        $flag=false;

    // data fetching through department wise
       $sql="SELECT  exam_group.*, department.department FROM exam_group,department WHERE exam_group.d_id=$d_id && department.d_id=$d_id LIMIT {$offset},{$limit}";

    //pagination query through department wise
           $pageSql="SELECT * FROM `exam_group` WHERE exam_group.d_id=$d_id";
    
    // this condition checks get variable of sem_id  if admin click on semester 1 then sem_id available and records will view as semester wise
               if (isset($_GET['sem_id']) && $_GET['sem_id']!='' ) 
               {
                   if ($_GET['d_id']>0 && $_GET['sem_id']<=8) {
    
                   $semActive=$_GET['sem_id'];
                   $semEcho='Semester&nbsp;'.$semActive.'&nbsp;in';
                   
                    $sem_id=$_GET['sem_id'];
    
        //pagination query through semester wise
                       $pageSql="SELECT * FROM `exam_group` WHERE exam_group.d_id=$d_id and exam_group.semester=$sem_id";
                       $subSql = "SELECT * FROM `subject` WHERE subject.d_id=$d_id and subject.semester=$sem_id";
    
        // data fetching through semester wise with row limit
                       $sql="SELECT exam_group.*, department.department FROM exam_group,department WHERE exam_group.d_id=$d_id && department.d_id=$d_id && exam_group.semester=$sem_id LIMIT {$offset},{$limit}";
                       // die($sql);
                           if (isset($_GET['sub_id']) && $_GET['sub_id'] != '') {
                               $sub_id1 = $_GET['sub_id'];
                               $flag=true;
                               
                               $pageSql="SELECT * FROM `exam_group` WHERE exam_group.d_id=$d_id and exam_group.semester=$sem_id and sub_id=$sub_id1 ";
                               $sql="SELECT * FROM `exam_group` WHERE exam_group.d_id=$d_id and exam_group.semester=$sem_id and sub_id=$sub_id1 LIMIT {$offset},{$limit}";
                            }
                   }else{
                       echo "<td class='text-center text-danger font-weight-bold' colspan='9'> sem_id must between 1 to 8. Data is shown according to department wise </td>"; 
                   }
               }
        for ($sem=1; $sem<=8; $sem++) {

                if ($sem==$semActive) {
                    $dark='btn-success';
                } else{
                    $dark="btn-info";
                }
                    echo '<a class="btn '.$dark.' m-2 my-4" href="view_results.php?d_id='.$d_id.'&sem_id='.$sem.'">Semester '.$sem.'</a>';
            }
            ?>
    </center>
        <div class="card">
            <div class="card-header">
                <h3 class="text-center font-weight-bold"><?php echo $semEcho.d_id($d_id); ?>- Exam Groups</h3>
            </div>
            <center>
            <!-- showing sujects according to semester start -->
                    <?php
                    if (isset($subSql)) {
                        
                        $subResult = mysqli_query($con, $subSql);
                        while ($subRow = mysqli_fetch_assoc($subResult)) {

                            if ($subRow['sub_id'] == $sub_id1) {
                                echo '<a class="btn btn-success  m-2 my-4" href="view_results.php?d_id=' . $d_id . '&sem_id=' . $sem_id . '&sub_id=' . $subRow['sub_id'] . '">' . sub_id($subRow['sub_id']) . '</a>';
                            } else {
                                echo '<a class="btn btn-info  m-2 my-4" href="view_results.php?d_id=' . $d_id . '&sem_id=' . $sem_id . '&sub_id=' . $subRow['sub_id'] . '">' . sub_id($subRow['sub_id']) . '</a>';
                            }    
                        }
                    }
                    ?>
            <!-- showing sujects according to semester ends-->
            </center>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table thover ts table-bordered ">
                        <thead class="table-success">
                            <tr>
                                <th  width="1%" style="text-align: center">No</th>
                                <?php
                                    if (!isset($subSql)) 
                                    {
                                        echo "<th width='1%' style='text-align: center'>Semester</th>";
                                    }
                                ?>
                                <?php
                                    if ($flag==false) 
                                    {
                                        echo "<th width='10%' style='text-align: center'>Subject</th>";
                                    }
                                ?>
                                <th  width="5%" style="text-align: center">Total Questions</th>
                                <th  width="6%" style="text-align: center">Date</th>
                                <th  width="4%" style="text-align: center">Group Token</th>
                                <th  width="6%" style="text-align: center">View Result</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
            
        //fetch the student data from databse
        $result=mysqli_query($con,$sql) or die(mysqli_error($con));
        $records=mysqli_num_rows($result);
        if ($records==0){
            echo "<td colspan='15' align='center' class='text-danger'><b>No records!</td></b>";

        }else{          
         
            $No = $offset;
        while ($row = mysqli_fetch_array($result)) {
            $No = $No + 1;
             // time added
             $date=$row['date'];
             $time=$row['time'];
             $group_id=$row['group_id'];
             $start_time = date('Y-m-d H:i:s', strtotime("$date $time"));
             $now=date("Y-m-d H:i:s");                    
             $total_time_minutes=$row['total_time_minutes'];
             $end_time=date('Y-m-d H:i:s', strtotime("$date"));
             // time added ends
        ?>
                            
            <tr>
                <td style="text-align: center"><?php echo "<b>".$No."</b>"; ?></td>
                <?php
                    if (!isset($subSql))
                        {
                        echo "<td style='text-align: center'><h6>" . $row['semester'] . "</h6></td>";
                        }
                ?> 
                 <?php
                    if ($flag==false)
                    {
                    echo "<td style='text-align: center'><h6>" . sub_id($row['sub_id']) . "</h6></td>";
                    }
                ?>              
                <td style="text-align: center"><h6><?php echo $row['total_questions']; ?> </h6></td>
                <td style="text-align: center"><h6><?php echo DateWeek($row['date']); ?> </h6></td>
                <td style="text-align: center">
                <?php
                $admin_id_que=$row['admin_id'];
                if ($admin_id_que!=NULL) {
                    $adm_name=admin_id($admin_id_que);
                    echo '<div class="float-center" style="color: #2F80ED;  font-size:16px;">
                            <div class="media-body" style="text-align: center;" >
                                <h6 class="font-weight-bold">'.$row["group_token"].'</h6>
                                <figcaption class="blockquote-footer">'.'<cite title="Source Title" class="font-weight-bold text-danger"> By <b>ADMIN</b>:-'.$adm_name.'</cite>&nbsp; </figcaption>
                            </div>
                          </div>'; }
                
                ?>
                </td>
                <?php 
                // die($combinedDT);
                if ($now<$start_time) 
                {
                    echo '<td style="text-align: center">
                            <p class="btn btn-sm btn-info " name="">Exam not Started</p>
                          </td>';
                }elseif($now>$start_time && $now<$end_time){
                    echo '<td style="text-align: center">
                            <p class="btn btn-sm btn-warning " name="">Exam Running</p>
                          </td>';
                }else{
                    echo '<td style="text-align: center">
                            <a href="given_exam.php?group_id='.$group_id.'" class="btn btn-success">View Result</a>
                          </td>';
                }
                ?>
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
        <?php include 'footer.php'; ?>
    </div>
    <div class="container mt-3">    

    <?php

    // pagination code starts here with department wise     
        $records1=mysqli_num_rows(mysqli_query($con,$pageSql));
    
        if ($records1>0) {
        
            $total_page=ceil($records1/$limit); 

            echo'<ul class="pagination justify-content-center">';
            for ($i=1; $i<=$total_page; $i++) {

                if ($i==$page) {
                    $active='active';
                } else{
                    $active="";
                }
                if (isset($_GET['sem_id']) && $_GET['d_id']>0 && $_GET['sem_id']<=8 && $_GET['sem_id']!='') 
                {
                    if (isset($_GET['sem_id']) && $_GET['d_id']>0 && $_GET['sem_id']<=8 && $_GET['sem_id']!=''&& isset($_GET['sub_id']) && $_GET['sub_id']!='' ) 
                    {
                        $PageNo='<li class="page-item '.$active.'"><a class="page-link" href="view_groups.php?d_id='.$d_id.'&sem_id='.$sem_id.'&page='.$i.'">'.$i.'</a></li>';
                    }else{

                        $PageNo='<li class="page-item '.$active.'"><a class="page-link" href="view_groups.php?d_id='.$d_id.'&sem_id='.$sem_id.'&page='.$i.'">'.$i.'</a></li>';
                        }
                    
                    }else{
                    $PageNo='<li class="page-item '.$active.'"><a class="page-link" href="view_groups.php?d_id='.$d_id.'&page='.$i.'">'.$i.'</a></li>';
                    }
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
</body>
</html>
