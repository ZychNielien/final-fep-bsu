<?php
session_start();
include "../model/dbconnection.php";

if(isset($_GET['srcode'])){

    $srcode = $_GET['srcode'];
    $sem = (int)$_GET['sem'];

    $sem2 = $sem + 1;

    $query = "UPDATE student_status SET sem_id = '$sem2' WHERE sr_code = '$srcode' AND sr_code NOT IN (SELECT subject_id FROM enrolled_subject WHERE sr_code = '$srcode')";
    $query_run = mysqli_query($con, $query);

}