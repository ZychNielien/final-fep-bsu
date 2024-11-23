<?php
session_start();
include "../model/dbconnection.php";

// Pag-proseso ng form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Loop through all POST data
    foreach ($_POST as $key => $value) {
        // Check kung ang key ay nag-uumpisa sa 'approval_'
        if (strpos($key, 'approval_') === 0) {
            // Extract student SR Code mula sa key
            $sr_code = str_replace('approval_', '', $key);

            // Kung ang value ay 1 (Approve), update ang status sa 1 (approved)
            if ($value == 1) {
                $updateSQL = "UPDATE studentlogin SET status = 1 WHERE srcode = ?";
                $stmt = mysqli_prepare($con, $updateSQL);
                mysqli_stmt_bind_param($stmt, 's', $sr_code);
                mysqli_stmt_execute($stmt);
                $_SESSION['status'] = "Student approved successfully!";
                $_SESSION['status_code'] = "success";
                header("location:../view/adminModule/maintenance.php");
                mysqli_stmt_close($stmt);
            }
            // Kung ang value ay 2 (Reject), update ang status sa 2 (rejected)
            elseif ($value == 2) {
                $updateSQL = "UPDATE studentlogin SET status = 2 WHERE srcode = ?";
                $stmt = mysqli_prepare($con, $updateSQL);
                mysqli_stmt_bind_param($stmt, 's', $sr_code); // 's' denotes string type
                mysqli_stmt_execute($stmt);
                $_SESSION['status'] = "Student rejected successfully!";
                $_SESSION['status_code'] = "success";
                header("location:../view/adminModule/maintenance.php");
                mysqli_stmt_close($stmt);
            }
        }

        if (strpos($key, 'approveFaculty_') === 0) {
            // Extract faculty ID mula sa key
            $faculty_id = str_replace('approveFaculty_', '', $key);

            // Kung ang value ay 1 (Approve), update ang status sa 1 (approved)
            if ($value == 1) {
                $updateSQL = "UPDATE instructor SET status = 1 WHERE faculty_Id = ?";
                $stmt = mysqli_prepare($con, $updateSQL);
                mysqli_stmt_bind_param($stmt, 's', $faculty_id);
                mysqli_stmt_execute($stmt);
                $_SESSION['status'] = "Faculty approved successfully!";
                $_SESSION['status_code'] = "success";
                header("location:../view/adminModule/maintenance.php");
                mysqli_stmt_close($stmt);
            }
            // Kung ang value ay 2 (Reject), update ang status sa 2 (rejected)
            elseif ($value == 2) {
                $updateSQL = "UPDATE instructor SET status = 2 WHERE faculty_Id = ?";
                $stmt = mysqli_prepare($con, $updateSQL);
                mysqli_stmt_bind_param($stmt, 's', $faculty_id);
                mysqli_stmt_execute($stmt);
                $_SESSION['status'] = "Faculty rejected successfully!";
                $_SESSION['status_code'] = "success";
                header("location:../view/adminModule/maintenance.php");
                mysqli_stmt_close($stmt);
            }
        }
    }
}


// Redirect or provide feedback after processing
header('location:../view/adminModule/maintenance.php');
exit;
?>