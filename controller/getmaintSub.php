<?php
session_start();
include "../model/dbconnection.php";

if(isset($_GET['subject_id'])){
    
    $id = $_GET['subject_id'];
    
    $query = "SELECT S.subject_id, S.subject, S.unit, S.year, YL.year_level, S.semester AS sem, SM.semester, S.subject_code 
                    FROM `subject` S INNER JOIN year_level YL ON S.year = YL.year_id INNER JOIN semester SM ON S.semester = SM.sem_id WHERE S.subject_id = '$id'";
    $query_run = mysqli_query($con, $query);

    $data = array();

    if(mysqli_num_rows($query_run) > 0){
        while($row = mysqli_fetch_assoc($query_run)){
            $data[] = $row;
        }
    }
    echo json_encode($data);
}
