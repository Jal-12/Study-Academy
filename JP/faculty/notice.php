<?php
include '../inc/faculty.php';
require '../db/dbcon.php';
if (isset($_SESSION['d_id']))  {
    //pagination of 5 pages code
        $limit=5; // limit of the rows per table ex. 5 item per page

        // if page admin clicks on page then it runs
        if (isset($_GET['page'])) {
            $page=safe_string($_GET['page']);
        }else{
            $page=1;
        }

        $offset=($page-1)*$limit;
        $d_id=$_SESSION['d_id'];
?>

<body>   
<div class="container mt-5 bg-light p-3">
    
                <div class="m-2 p-3">
                    
                            <?php 
                $pageSql="SELECT * FROM notice WHERE d_id=$d_id";
                $sql1="SELECT * FROM notice WHERE d_id=$d_id LIMIT {$offset},{$limit}";
                // echo $sql;
                    $result1=mysqli_query($con,$sql1);
                    while ($row=mysqli_fetch_assoc($result1)) {
                        // $stu_id_com=$row['stu_id'];
                        $admin_id_com=$row['admin_id'];
                        // $faculty_id_com=$row['faculty_id'];

                            $adm_name=admin_id($admin_id_com);
                            // fa-universal-access 

                            echo '<hr>
                                <div class="media m-2 text-justify" >
                                     <i class="mt-2 fas fa-user-lock fa-2x" style="color: #2F80ED;">&nbsp;</i>
                                    <div class="media-body">
                                        <h5 >'.$row["notice"].'</h5>
                                        <figcaption class="blockquote-footer">'.DateMinute($row["create_time"]).'<cite title="Source Title" class="font-weight-bold text-danger"> By <b>ADMIN</b>:-'.$adm_name.'</cite>
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

                

                    
                    $PageNo='<li class="page-item '.$active.'"><a class="page-link" href="notices.php?d_id='.$d_id.'&page='.$i.'">'.$i.'</a></li>';
                
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


<?php

// }else{
//      echo "hello";

// }
?>

    <?php include 'footer.php'; ?>