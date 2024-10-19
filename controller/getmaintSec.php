<?php
session_start();
include "../model/dbconnection.php";

if(isset($_GET['id'])){
    
    $id = $_GET['id'];
    
    $query = "SELECT S.id, S.section, S.year_id, YL.year_level, S.sem_id, SM.semester
                              FROM section S INNER JOIN year_level YL ON S.year_id = YL.year_id INNER JOIN semester SM ON S.sem_id = SM.sem_id WHERE S.id = '$id'";
    $query_run = mysqli_query($con, $query);

    $data = array();

    if(mysqli_num_rows($query_run) > 0){
        while($row = mysqli_fetch_assoc($query_run)){
            $data[] = $row;
        }
    }
    echo json_encode($data);
}
