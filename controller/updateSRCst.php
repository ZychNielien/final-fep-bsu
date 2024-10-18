<?php

session_start();
include "../model/dbconnection.php";

if(isset($_POST['update_student'])){

    $srcode = $_POST['srcode'];
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $year = $_POST['year'];
    $course = $_POST['course'];
    $sem = $_POST['sem'];

    $query = "UPDATE student_basic_info SET sr_code = '$srcode', lastname = '$lastname', firstname = '$firstname', middlename = '$middlename' WHERE sr_code = '$srcode'";
    $query_run = mysqli_query($con, $query);

    if($query_run){
        $query2 = "UPDATE student_status SET sr_code = '$srcode', year_level = '$year', course = '$course', sem_id = '$sem' WHERE sr_code = '$srcode'";
        $query_run2 = mysqli_query($con, $query2);

        if($query_run2){
            $_SESSION['status'] = "Updated successfully!";
            $_SESSION['status_code'] = "success";
            header("Location: ../view/adminModule/maintenance.php");
        }
    }

    else{
        $_SESSION['status'] = "Something is wrong";
        $_SESSION['status-code'] = "error";
        header("location: ../view/adminModule/maintenance.php");
    }

}
