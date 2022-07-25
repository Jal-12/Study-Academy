<?php
include '../inc/student.php';
require '../db/dbcon.php';

if (isset($_GET['sub_id']) && isset($_SESSION['d_id']) && isset($_SESSION['semester'])) 
{
    $unit_id='';
    // pagination of 5 pages code
        $limit=5; 
    // if page admin clicks on page then it runs
        if (isset($_GET['page'])) {
            $page=safe_string($_GET['page']);
        }else{
            $page=1;
        }

        $offset=($page-1)*$limit;
        $d_id=$_SESSION['d_id'];
        $sub_id=safe_string($_GET['sub_id']);
        $semester=$_SESSION['semester'];

        $pageSql="SELECT * FROM mcqs WHERE d_id=$d_id AND semester=$semester AND sub_id=$sub_id";
        $sql="SELECT * FROM mcqs WHERE d_id=$d_id AND semester=$semester AND sub_id=$sub_id LIMIT {$offset},{$limit}";
        $unitSQL="SELECT * FROM `unit` WHERE sub_id=$sub_id";
        // unit wise study_materials
            if (isset($_GET['unit_id'])&& $_GET['unit_id'] != '') 
            {
                $unit_id = safe_string($_GET['unit_id']);
                
                $pageSql="SELECT * FROM `mcqs` WHERE mcqs.d_id=$d_id and mcqs.semester=$semester and sub_id=$sub_id and unit_id=$unit_id ";
                $sql="SELECT * FROM `mcqs` WHERE mcqs.d_id=$d_id and mcqs.semester=$semester and sub_id=$sub_id and unit_id=$unit_id  LIMIT {$offset},{$limit}";
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
                        while ($unitRow = mysqli_fetch_assoc($unitResult)) 
                        {
                            $unitArr=unit_id($unitRow['unit_id']);
                            if ($unitRow['unit_id'] == $unit_id) 
                            {
                                echo ' <a class="shadow" href="view_mcqs.php?sub_id='.$sub_id.'&unit_id='.$unitRow['unit_id'].'"><div class="col-sm-11 btn btn-sm btn-dark  my-3">'.$unitArr["unit_number"].'.&nbsp;'.$unitArr["unit_name"].'</div></a> ';
                            } else {
                                echo '<a class="shadow-sm" href="view_mcqs.php?sub_id='.$sub_id.'&unit_id='.$unitRow['unit_id'].'"><div class="col-sm-11 btn btn-sm btn-light my-3">'.$unitArr["unit_number"].'.&nbsp;'.$unitArr["unit_name"].'</div></a>';
                            }        
                        }
                    }
                    ?>
            <!-- showing sujects according to unit ends-->
                </center>
            </div>
            <div class="col-sm-10 my-4 lg-4 bg-light">
                <div class="card-header">
                    <h3 class="text-center font-weight-bold"><?php echo sub_id($sub_id); ?> - MCQs</h3>
                </div>
                <?php 
                    $result=mysqli_query($con,$sql) or die(mysqli_error($con));
                    $records=mysqli_num_rows($result);
                    if ($records==0)
                    {
                        echo "<center><b class='text-danger'>No mcqs found!</b></center>";
                    }else{ 
                ?>
                <div class="row">
                <?php 
                    $result=mysqli_query($con,$sql) or die(mysqli_error($con));
                    $records=mysqli_num_rows($result);
                    if ($records==0)
                    {
                        echo "<td colspan='9' align='center' class='text-danger'><b>No mcqs!</b></td>";
                    }else{          
                    $No = $offset;
                    while ($row = mysqli_fetch_array($result)) 
                    {
                        $No = $No + 1;
                        $success1=$success2=$success3=$success4='';
                ?>   
                    <div class="container bg-dark p-4 mt-3 rounded-lg ">
                        <table class="p-3 m-1 " style="font-weight: bold;  font-family: 'roboto'; color: deepskyblue;">
                            <thead> 
                                <tr>
                                    <th class="p-1">
                                        <h3 class="font-weight-bold">(<?php echo $row['mcq_no'] ; ?>)&nbsp;</h3>
                                    </th>
                                    <th class="p-1">
                                        <h3 class="font-weight-bold"><?php echo $row['question']; ?> </h3>					
                                    </th>
                                </tr>
                            </thead>
                            <?php 
                                if ($row['answer']=="option_1")
                                {
                                    $success1="table-light";
                                }elseif ($row['answer']=="option_2")
                                {
                                    $success2="table-light";
                                }elseif ($row['answer']=="option_3")
                                {
                                    $success3="table-light";
                                }elseif ($row['answer']=="option_4")
                                {
                                    $success4="table-light";
                                }else{
                                $success1=$success2=$success3=$success4='';
                                }
                            ?>
                            <tbody>				
                                <tr  class="<?php if(isset($success1)){ echo $success1;} ?>">
                                    <td class="p-1"><h5 class="font-weight-bold">(A) </h5></td>
                                    <td  class="p-1 "><h5 class="font-weight-bold"><?php echo $row['option_1']; ?> </h5></td>
                                </tr>
                                <tr  class="<?php if(isset($success2)){ echo $success2;} ?>">
                                    <td class="p-1 "><h5 class="font-weight-bold">(B) </h5></td>
                                    <td class="p-1 "><h5 class="font-weight-bold"><?php echo $row['option_2']; ?> </h5></td>
                                </tr>
                                <tr  class="<?php if(isset($success3)){ echo $success3;} ?>">
                                    <td class="p-1 "><h5 class="font-weight-bold">(C)</h5></td>
                                    <td class="p-1 "><h5 class="font-weight-bold"><?php echo $row['option_3']; ?> </h5></td>
                                </tr>
                                <tr  class="<?php if(isset($success4)){ echo $success4;} ?>">
                                    <td class="p-1 "><h5 class="font-weight-bold">(D)</h5></td>
                                    <td class="p-1 "><h5 class="font-weight-bold"><?php echo $row['option_4']; ?> </h5></td>
                                </tr>
			                </tbody>
                        </table>
                    </div>
                    <?php
                        }
                    } 
                   ?>
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
                if (isset($_GET['unit_id'])&& $_GET['unit_id'] != '') 
                {
                    $PageNo='<li class="page-item '.$active.'"><a class="page-link" href="view_lectures.php?sub_id='.$sub_id.'&unit_id='.$unit_id.'&page='.$i.'">'.$i.'</a></li>';
                }else{
                    $PageNo='<li class="page-item '.$active.'"><a class="page-link" href="view_lectures.php?sub_id='.$sub_id.'&page='.$i.'">'.$i.'</a></li>';
                }
                echo $PageNo;
            }
            echo'</ul>';
        }
    }
    // pagination code ends here with department wise
    } else {
        echo "<h2 class='text-danger text-center mt-5'>Invalid ID</h2> ";
    }
    ?>
</div>
<?php include 'footer.php'; ?>