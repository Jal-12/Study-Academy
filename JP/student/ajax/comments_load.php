<div class="mt-5 bg-light p-3">
                    
                            <?php
// include '../../inc/function.php';
require '../../db/dbcon.php'; 

$limit=5; // limit of the rows per table ex. 5 item per page

        // if page admin clicks on page then it runs
        $lec_id=$_GET['lec_id'];
        if (isset($_GET['page'])) {
            $page=$_GET['page'];
        }else{
            $page=1;
        }

        $offset=($page-1)*$limit;

    $msg='';

                $pageSql="SELECT * FROM comments WHERE lec_id=$lec_id";
                $sql1="SELECT * FROM comments WHERE lec_id=$lec_id LIMIT {$offset},{$limit}";
                // echo $sql;
                    $result1=mysqli_query($con,$sql1);
                    while ($row=mysqli_fetch_assoc($result1)) {
                        $stu_id_com=$row['stu_id'];
                        $admin_id_com=$row['admin_id'];
                        $faculty_id_com=$row['faculty_id'];

                        
                        
                        
                        if ($stu_id_com!=NULL) {
                            $stu_name=stu_id($stu_id_com);

                            echo'<figure>
                                  <blockquote class="blockquote">
                                    <p>'.$row["comment"].'</p>
                                  </blockquote>
                                    <figcaption class="blockquote-footer">'.DateMinute($row["create_time"]).'<cite title="Source Title" class="font-weight-bold"> By Student:-'.$stu_name["username"].'</cite>
                                  </figcaption>
                                </figure>';
                        } 
                        if ($admin_id_com!=NULL) {
                            $adm_name=admin_id($admin_id_com);

                            echo '<figure class="text-center">
                                      <blockquote class="blockquote">
                                        <p>'.$row["comment"].'</p>
                                      </blockquote>
                                      <figcaption class="blockquote-footer">'.DateMinute($row["create_time"]).'<cite title="Source Title" class="font-weight-bold text-danger"> By <b>ADMIN</b>:-'.$adm_name.'</cite>

                                      </figcaption>
                                    </figure>';
                        } 
                        if ($faculty_id_com!=NULL) {
                            $fac_name=faculty_id($faculty_id_com);

                            echo '<figure class="text-end">
                                      <blockquote class="blockquote">
                                        <p>'.$row["comment"].'</p>
                                      </blockquote>
                                      <figcaption class="blockquote-footer">'.DateMinute($row["create_time"]).'<cite title="Source Title" class="font-weight-bold"> By <b>FACULTY</b>:-'.$fac_name.'</cite>
                                      </figcaption>
                                    </figure>';
                            
                        }
                        
                        
                    }
                ?> 
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

                

                    
                    $PageNo='<li class="page-item '.$active.'"><a class="page-link" href="comments.php?lec_id='.$lec_id.'&page='.$i.'">'.$i.'</a></li>';
                
                echo $PageNo;
            }
            echo'</ul>';
            }
            
        // pagination code ends here with department wise
    
    ?>
        </div>