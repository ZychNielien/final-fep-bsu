<?php

session_start();
include "../model/dbconnection.php";

if(isset($_POST['srcode'])){

    $srcode = $_POST['srcode'];

    $query = "DELETE FROM student_basic_info WHERE sr_code='$srcode'";
    $query_run = mysqli_query($con, $query);

    if($query_run){
        $query2 = "DELETE FROM student_status WHERE sr_code = '$srcode'";
        $query_run2 = mysqli_query($con, $query2);

        if($query_run2){
            $query3 = "DELETE FROM studentlogin WHERE srcode = '$srcode'";
            $query_run3 = mysqli_query($con, $query3);
        }
    }

}