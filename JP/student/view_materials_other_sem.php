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
    if (mysqli_num_rows($SubSqlResult)==0) {
        $NoSubject="Subjects Not found!";
    }else{
        $no=0;
        while ($subRow=mysqli_fetch_assoc($SubSqlResult)) 
        {
        if ($subRow['sub_id'] == $sub_id) {
            echo '<a class="btn btn-dark  m-2 my-4" href="view_materials_other_sem.php?semester='.$semester.'&sub_id='.$subRow['sub_id'].'">' . sub_id($subRow['sub_id']) . '</a>';
        } else {
            echo '<a class="btn btn-light  m-2 my-4" href="view_materials_other_sem.php?semester='.$semester.'&sub_id='.$subRow['sub_id'].'">' . sub_id($subRow['sub_id']) . '</a>';
        }
    }
}
echo'</center>';

if (isset($_GET['sub_id']) && isset($_SESSION['d_id']) && isset($_GET['semester'])) {
    $unit_id='';
        // pagination of 5 pages code
        $limit=10; // limit of the rows per table ex. 5 item per page

        // if page admin clicks on page then it runs
        if (isset($_GET['page'])) {
            $page=safe_string($_GET['page']);
        }else{
            $page=1;
        }

        $offset=($page-1)*$limit;
        $d_id=$_SESSION['d_id'];
        $sub_id=safe_string($_GET['sub_id']);


         $pageSql="SELECT * FROM study_materials WHERE d_id=$d_id AND semester=$semester AND sub_id=$sub_id";

        $sql="SELECT * FROM study_materials WHERE d_id=$d_id AND semester=$semester AND sub_id=$sub_id LIMIT {$offset},{$limit}";
        $unitSQL="SELECT * FROM `unit` WHERE sub_id=$sub_id";
        // unit wise study_materials
            if (isset($_GET['unit_id'])&& $_GET['unit_id'] != '') {
                $unit_id = safe_string($_GET['unit_id']);
                    
                $pageSql="SELECT * FROM `study_materials` WHERE study_materials.d_id=$d_id and study_materials.semester=$semester and sub_id=$sub_id and unit_id=$unit_id ";
                $sql="SELECT * FROM `study_materials` WHERE study_materials.d_id=$d_id and study_materials.semester=$semester and sub_id=$sub_id and unit_id=$unit_id  LIMIT {$offset},{$limit}";
            }
?>
<body>
 <div class="container-fluid mt-3">
    <div class="card">
        <div class="card-header">
            <h3 class="text-center font-weight-bold"><?php echo sub_id($sub_id); ?> - Materials</h3>
        </div>
        <div class="card-body">
            <div class="row grid_box">
                <div class="table-responsive">
                    <table class="table table-light thover ts table-bordered">
                        <thead class="thead-dark">
                        <tr>
                            <th width="3%" style="text-align: center">No</th>
                            <?php 
                                if (!isset($_GET['unit_id'])) 
                                {
                                    echo "<th width='14%' style='text-align: center'>Unit </th> ";
                                }
                            ?>
                            <th width="10%" style="text-align: center">Files</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
        
                    //fetch the student data from databse
                            $result=mysqli_query($con,$sql);
                            $records=mysqli_num_rows($result);
                            if ($records==0)
                            {
                                echo "<td colspan='9' align='center' class='text-danger'><b>No study materials!</td></b>";
                            }else{ 
                            
                            $No = $offset;
                            while ($row = mysqli_fetch_array($result)) {
                            $No = $No + 1;
                            ?>
                        <tr>
                            <td style="text-align: center"><?php echo "<b>".$No."</b>"; ?></td>
                            <?php
                                $unitArr=unit_id($row['unit_id']);                        
                                if (!isset($_GET['unit_id'])) 
                                {
                                    echo "<td style='text-align: center'><h6>" . $unitArr['unit_number']. ". " . $unitArr['unit_name'] . "</h6></td>";
                                }                    
                            ?>
                            <td style="text-align: center"><a href="<?php echo $row['file']; ?>" target="_blank"><h6>View Material</h6></a></td>
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
                    $PageNo='<li class="page-item '.$active.'"><a class="page-link" href="view_materials_other_sem.php?semester='.$semester.'&sub_id='.$sub_id.'&unit_id='.$unit_id.'&page='.$i.'">'.$i.'</a></li>';
                    
                }else{
                    
                    $PageNo='<li class="page-item '.$active.'"><a class="page-link" href="view_materials_other_sem.php?semester='.$semester.'&sub_id='.$sub_id.'&page='.$i.'">'.$i.'</a></li>';
                }

                echo $PageNo;
            }
            echo'</ul>';
            }
        } 
    ?>
</div>
</div>
<?php

    include 'footer.php';
} else {
    echo "Error 404 page not found! ";
}
 ?>