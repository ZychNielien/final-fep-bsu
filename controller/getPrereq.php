<?php
session_start();
include "../model/dbconnection.php";

if(isset($_GET['id'])){
    
    $id = $_GET['id'];
    
    $query = "SELECT * FROM prereq_subject WHERE id = '$id'";
    
    $query_run = mysqli_query($con, $query);

    $data = array();

    if(mysqli_num_rows($query_run) > 0){
        while($row = mysqli_fetch_assoc($query_run)){
            $data[] = $row;
        }
    }
    echo json_encode($data);
}
