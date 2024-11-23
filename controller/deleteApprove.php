<?php
session_start();
include "../model/dbconnection.php";
if (isset($_POST['srcode'])) {
    $srcode = $_POST['srcode'];

    // SQL query to delete the student
    $deleteSQL = "DELETE FROM studentlogin WHERE srcode = ?";

    // Prepare and execute the query
    if ($stmt = mysqli_prepare($con, $deleteSQL)) {
        mysqli_stmt_bind_param($stmt, 's', $srcode);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $_SESSION['status'] = "Student removed successfully!";
        $_SESSION['status_code'] = "success";
        header("Location: ../view/adminModule/maintenance.php"); // Change this to your page URL
        exit();
    } else {
        echo "Error: " . mysqli_error($con);
    }
} else {
    echo "No student ID provided.";
}


if (isset($_POST['faculty'])) {
    $faculty = $_POST['faculty'];

    // SQL query to delete the student
    $deleteSQL = "DELETE FROM instructor WHERE faculty_Id = ?";

    // Prepare and execute the query
    if ($stmt = mysqli_prepare($con, $deleteSQL)) {
        mysqli_stmt_bind_param($stmt, 's', $faculty);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $_SESSION['status'] = "Faculty member removed successfully!";
        $_SESSION['status_code'] = "success";
        header("Location: ../view/adminModule/maintenance.php"); // Change this to your page URL
        exit();
    } else {
        echo "Error: " . mysqli_error($con);
    }
} else {
    echo "No faculty ID provided.";
}
?>