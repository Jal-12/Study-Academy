<?php
include '../inc/student.php';
require '../db/dbcon.php';

if (isset($_GET['sub_id']) && isset($_SESSION['d_id']) && isset($_SESSION['semester'])) 
{
    $unit_id='';
    // pagination of 5 pages code
        $limit=1;
    
    // if page admin clicks on page then it runs
        if (isset($_GET['page'])) 
        {
            $page=safe_string($_GET['page']);
        }else{
            $page=1;
        }

        $offset=($page-1)*$limit;
        $d_id=$_SESSION['d_id'];
        $sub_id=safe_string($_GET['sub_id']);
        $semester=$_SESSION['semester'];    
        $pageSql="SELECT * FROM study_materials WHERE d_id=$d_id AND semester=$semester AND sub_id=$sub_id";
        $sql="SELECT * FROM study_materials WHERE d_id=$d_id AND semester=$semester AND sub_id=$sub_id LIMIT {$offset},{$limit}";
        $unitSQL="SELECT * FROM `unit` WHERE sub_id=$sub_id";
    
    // unit wise study_materials
        if (isset($_GET['unit_id'])&& $_GET['unit_id'] != '') 
        {
            $unit_id = safe_string($_GET['unit_id']);         
            $pageSql="SELECT * FROM `study_materials` WHERE study_materials.d_id=$d_id and study_materials.semester=$semester and sub_id=$sub_id and unit_id=$unit_id ";
            $sql="SELECT * FROM `study_materials` WHERE study_materials.d_id=$d_id and study_materials.semester=$semester and sub_id=$sub_id and unit_id=$unit_id  LIMIT {$offset},{$limit}";
        }
?>
<body>
    <div class="container-fluid">
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
                        echo '<a class="shadow" href="view_materials.php?sub_id='.$sub_id.'&unit_id='.$unitRow['unit_id'].'"><div class="col-sm-11 btn btn-sm btn-dark  my-3">'.$unitArr["unit_number"].'.&nbsp;'.$unitArr["unit_name"].'</div></a> ';
                    } else {
                        echo '<a class="shadow-sm" href="view_materials.php?sub_id='.$sub_id.'&unit_id='.$unitRow['unit_id'].'"><div class="col-sm-11 btn btn-sm btn-light my-3">'.$unitArr["unit_number"].'.&nbsp;'.$unitArr["unit_name"].'</div></a>';
                    }
                }
            }
            ?>
        <!-- showing sujects according to unit ends-->
            </center>
            </div>
            <div class="col-sm-10 my-3  bg-light">
                <div class="card-header">
                    <h3 class="text-center font-weight-bold"><?php echo sub_id($sub_id); ?> - Materials</h3>
                </div>
                <?php 
                    $result=mysqli_query($con,$sql);
                    $records=mysqli_num_rows($result);
                    if ($records==0){
                        echo "<center><b class='text-danger'>No materials found!</b></center>";
                    }else{ 
                ?>
            <div class="row">
            <?php
                $No = $offset;
                while ($row = mysqli_fetch_array($result)) {
                    $No = $No + 1;
                    $date=$row['create_time'];
                    $time=date("M d, Y h:iA",strtotime($date));
                    $admin_id_que=$row['admin_id'];
                    $faculty_id_que=$row['faculty_id'];

                    if($row["update_time"]==NULL){
                        $que_time=$row["create_time"];
                    }else{
                        $que_time=$row["update_time"];
                    }
            ?>
            <div class="col-sm-6 col-lg-4 p-4">
                <div class="">
                    <embed src="<?php echo $row['file'] ?>" width="1170px" height="700px" ></embed>
                    <div class="b">
                        <?php
                            if ($admin_id_que!=NULL) {
                                $adm_name=admin_id($admin_id_que);
                            echo'<figcaption class="blockquote-footer">'.DateMinute($que_time).'<cite title="Source Title" class="font-weight-bold text-danger"> By <b>ADMIN</b>:-'.$adm_name.'</cite>&nbsp; </figcaption>';
                            }
                            if ($faculty_id_que!=NULL) {
                                $fac_name=faculty_id($faculty_id_que);
                                echo'<figcaption class="blockquote-footer">'.DateMinute($que_time).'<cite title="Source Title" class="font-weight-bold text-danger"> By <b>ADMIN</b>:-'.$adm_name.'</cite>&nbsp; </figcaption>';    
                            }
                            }
                        }
                        }  
                        ?>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
    <div class="container mt-3">
        <?php
        // pagination code starts here with department wise    
        $records=mysqli_num_rows(mysqli_query($con,$pageSql));    
            if ($records>0) 
            { 
                $total_page=ceil($records/$limit); 
                    echo'<ul class="pagination justify-content-center">';
                    for ($i=1; $i<=$total_page; $i++) 
                    {
                        if ($i==$page) 
                        {
                            $active='active';
                        } else{
                            $active="";
                        }
                        if (isset($_GET['unit_id'])&& $_GET['unit_id'] != '') {
                            $PageNo='<li class="page-item '.$active.'"><a class="page-link" href="view_materials.php?sub_id='.$sub_id.'&unit_id='.$unit_id.'&page='.$i.'">'.$i.'</a></li>';    
                        }else{                
                            $PageNo='<li class="page-item '.$active.'"><a class="page-link" href="view_materials.php?sub_id='.$sub_id.'&page='.$i.'">'.$i.'</a></li>';
                        }
                        echo $PageNo;
                    }
                echo'</ul>';
            }
        ?>
    </div>
    <?php include 'footer.php'; ?>
</body>
             