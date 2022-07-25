<?php
include '../inc/student.php';
require '../db/dbcon.php';

if (isset($_GET['sub_id']) && isset($_SESSION['d_id'])&& isset($_SESSION['semester'])) 
{
    $sub_id=safe_string($_GET['sub_id']);
    $d_id=$_SESSION['d_id'];
    $semester=$_SESSION['semester'];
    $pageSql="SELECT * FROM lectures WHERE d_id=$d_id AND semester=$semester AND sub_id=$sub_id";
    $unit_id='';
    $limit=9; // limit of the rows per table ex. 5 item per page

    // if page  on page then it runs
        if (isset($_GET['page'])) 
        {
            $page=safe_string($_GET['page']);
        }else{
            $page=1;
        }

        $offset=($page-1)*$limit;
        $offset=($page-1)*$limit;
        $unitSQL="SELECT * FROM `unit` WHERE sub_id=$sub_id";
        $sql="SELECT * FROM lectures WHERE d_id=$d_id AND semester=$semester AND sub_id=$sub_id LIMIT {$offset},{$limit}";

    // unit wise lectures
        if (isset($_GET['unit_id'])&& $_GET['unit_id'] != '') 
        {
            $unit_id = safe_string($_GET['unit_id']);
        
            $pageSql="SELECT * FROM `lectures` WHERE lectures.d_id=$d_id and lectures.semester=$semester and sub_id=$sub_id and unit_id=$unit_id ";
            $sql="SELECT * FROM `lectures` WHERE lectures.d_id=$d_id and lectures.semester=$semester and sub_id=$sub_id and unit_id=$unit_id  LIMIT {$offset},{$limit}";
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
                        echo '<a class="shadow" href="view_lectures.php?sub_id='.$sub_id.'&unit_id='.$unitRow['unit_id'].'"><div class="col-sm-11 btn btn-sm btn-dark  my-3"><h6>'.$unitArr["unit_number"].'.&nbsp;'.$unitArr["unit_name"].'</h6></div></a> ';
                    }else{
                        echo '<a class="shadow-sm" href="view_lectures.php?sub_id='.$sub_id.'&unit_id='.$unitRow['unit_id'].'"><div class="col-sm-11 btn btn-sm btn-light my-3"><h6>'.$unitArr["unit_number"].'.&nbsp;'.$unitArr["unit_name"].'</h6></div></a>';
                    }
                }
            }
        ?>
        <!-- showing sujects according to unit ends-->
        </center>
        </div>
        <div class="col-sm-10 my-4  bg-light">
            <div class="card-header">
                <h3 class="text-center font-weight-bold"><?php echo sub_id($sub_id); ?> - Lectures</h3>
            </div>
            <?php 
                $result=mysqli_query($con,$sql);
                $records=mysqli_num_rows($result);
                if ($records==0){
                    echo "<center><b class='text-danger'>No lectures found!</b></center>";

                }else{ 
        	?>
            <div class="row">
            <?php   
                $No = $offset;
                while ($row=mysqli_fetch_array($result)) {
                    $No = $No + 1;
                    $l=$row['lecture_path'];
                    $date=$row['create_time'];
                    $time=date("M d, Y h:iA",strtotime($date));
            ?>    
            <div class="col-sm-6 my-4 col-lg-4 p-4">
                <div class="">
                    <div class="">
                    <?php
                        if ($row['lecture_link']==NULL) {
                    ?> 
                    <div class="embed-responsive embed-responsive-16by9">
                    <video controls>
                        <source class="embed-responsive-item" src="<?php echo $row['lecture_path']; ?>" type="video/mp4">
                    </video>
                    </div>
                    <h4><?php echo $row['topic']; ?></h4>
                    <?php
                    }else{
                        $yt=explode('/', $row['lecture_link'] );
                        $yt3=$yt[3];
                        $ytid1=explode('?',$yt3);

                    if ($ytid1[0]=="watch") {
                        $ytid2=explode('&',$ytid1[1]);
                        $ytid3=explode('=',$ytid2[0]);
                        $ytId=$ytid3[1];
                    }else{
                        $ytId=$ytid1[0];
                    }
                    ?>
                    <td>
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $ytId; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </td>
                        <h4><?php echo 'Topic('.$No.'):-'.$row['topic']; ?></h4>
                    <?php
                        }
                    if ($row['admin_id']==NULL){
                        $by="Faculty: ".faculty_id($row['faculty_id']);
                    }else{
                        $by="ADMIN: ".admin_id($row['admin_id']);
                    }
                    ?>
                    </div>
                    <div class="">
                        <span class="text-black-50"><b>By</b>:&nbsp;<em class="text-primary"><?php echo $by; ?></em></span>
                    <div class="pull-right">
                        <span><?php echo $time; ?></span>
                        <?php 
                        $num=mysqli_num_rows(mysqli_query($con,"SELECT * from comments WHERE lec_id={$row['lec_id']}"))
                        ?>
                        <span class="" style="font-size: 15px;"><a href="comments.php?lec_id=<?php echo $row['lec_id']; ?>"><i class="fa fa-comments"></i> <?php echo $num; ?></a></span>
                    </div>
                </div>
            </div>
        </div>
        <?php
		        }
	        }
        }
        ?>
    </div>
    </div>
</div>
</div>

    <div class="container mt-3">    
<?php 
$res=mysqli_query($con,$pageSql);
$records=mysqli_num_rows($res);
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
                        $PageNo='<li class="page-item '.$active.'"><a class="page-link" href="view_lectures.php?sub_id='.$sub_id.'&unit_id='.$unit_id.'&page='.$i.'">'.$i.'</a></li>';
                    
                    }else{

                        $PageNo='<li class="page-item '.$active.'"><a class="page-link" href="view_lectures.php?sub_id='.$sub_id.'&page='.$i.'">'.$i.'</a></li>';
                    }
                

                echo $PageNo;
            }
            echo'</ul>';
            }
            
        // pagination code ends here with department wise

    ?>
</div>
    <?php include 'footer.php'; ?>
