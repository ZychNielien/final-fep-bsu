<?php

session_start();
include "../model/dbconnection.php";

if (isset($_GET['srcode'])) {

    $srcode = $_GET['srcode'];

    $query = "SELECT SB.sr_code, SB.lastname, SB.firstname, SB.middlename, YL.year_level, SS.course, SM.semester, SS.sem_id, SS.year_level
                            FROM student_basic_info SB 
                            INNER JOIN student_status SS 
                            ON SB.sr_code = SS.sr_code 
                            INNER JOIN semester SM 
                            ON SS.sem_id = SM.sem_id 
                            INNER JOIN year_level YL 
                            ON SS.year_level = YL.year_id WHERE SB.sr_code = '$srcode'";
    $query_run = mysqli_query($con, $query);

    
    $data = array();

    if(mysqli_num_rows($query_run) > 0){
        while($row = mysqli_fetch_assoc($query_run)){
            $data[] = $row;
        }
    }
    echo json_encode($data);

}
