<?php

session_start();
include "../model/dbconnection.php";

if(isset($_POST['update_student'])){

    $srcode = $_POST['srcode2'];
    $NEWsrcode = $_POST['srcode3'];
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $year = $_POST['year'];
    $course = $_POST['course'];
    $sem = $_POST['sem'];

    $query = "UPDATE student_basic_info SET sr_code = '$NEWsrcode', lastname = '$lastname', firstname = '$firstname', middlename = '$middlename' WHERE sr_code = '$srcode'";
    $query_run = mysqli_query($con, $query);

    if($query_run){
        $query2 = "UPDATE student_status SET sr_code = '$NEWsrcode', year_level = '$year', course = '$course', sem_id = '$sem' WHERE sr_code = '$srcode'";
        $query_run2 = mysqli_query($con, $query2);

        if($query_run2){
            $query3 = "UPDATE studentlogin SET srcode = '$NEWsrcode' WHERE srcode = '$srcode'";
            $query_run3 = mysqli_query($con, $query3);
            if($query_run3){
                $_SESSION['status'] = "Updated successfully!";
                $_SESSION['status_code'] = "success";
                header("Location: ../view/adminModule/maintenance.php");
            }
        }
    }
}
