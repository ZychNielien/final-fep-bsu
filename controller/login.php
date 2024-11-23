<?php

include "../model/dbconnection.php";

session_start();


// STUDENT LOGIN
if (isset($_POST['studentLogin'])) {
    $studentSRCode = $_POST['studentSRCode'];
    $studentPass = $_POST['studentpass'];

    $sql = "SELECT * FROM studentlogin WHERE srcode = '$studentSRCode' AND password = '$studentPass'";

    $sql_query = mysqli_query($con, $sql);

    if ($sql_query) {

        $numrows = mysqli_num_rows($sql_query);
        if ($numrows == 1) {
            while ($row = mysqli_fetch_assoc($sql_query)) {

                if ($row['status'] == 1) {
                    $_SESSION['status'] = "Login Successfully";
                    $_SESSION['status_code'] = "success";


                    $_SESSION["studentSRCode"] = $row["srcode"];
                    $_SESSION["user"] = $row["usertype"];


                    header("location: ../view/student_view.php");
                } else if ($row['status'] == 2) {
                    $_SESSION['status'] = "Your account has been rejected by the administrator.";
                    $_SESSION['status_code'] = "error";
                    header("location: ../index.php");
                } else {
                    $_SESSION['status'] = "Your account is currently under review by the admin. Please wait.";
                    $_SESSION['status_code'] = "error";
                    header("location: ../index.php");
                }

            }
        } else {
            $_SESSION['status'] = "Authentication Failed";
            $_SESSION['status_code'] = "error";
            header("location: ../index.php");
        }
    } else {
        die(mysqli_error($con));
    }
}


// ADMIN AND LECTURER LOGIN
if (isset($_POST['facultyadmin'])) {
    $gsuite = $_POST['gsuite'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM instructor WHERE  gsuite = '$gsuite' AND password ='$password'";

    $sql_query = mysqli_query($con, $sql);
    if ($sql_query) {
        $numrows = mysqli_num_rows($sql_query);
        if ($numrows == 1) {
            while ($row = mysqli_fetch_assoc($sql_query)) {
                if ($row['status'] == 1) {
                    $_SESSION['status'] = "Login Successfully";
                    $_SESSION['status-code'] = "success";


                    if ($row['usertype'] === "faculty") {
                        $_SESSION["user"] = $row["usertype"];
                        $_SESSION["userid"] = $row["faculty_Id"];
                        header("location: ../view/facultyModule/dashboard.php");
                    } else if ($row['usertype'] === "admin") {
                        $_SESSION["user"] = $row["usertype"];
                        $_SESSION["userid"] = $row["faculty_Id"];
                        header("location: ../view/adminModule/admindashboard.php");
                    }
                } else if ($row['status'] == 2) {
                    $_SESSION['status'] = "Your account has been rejected by the administrator.";
                    $_SESSION['status_code'] = "error";
                    header("location: ../index.php");
                } else {
                    $_SESSION['status'] = "Your account is currently under review by the admin. Please wait.";
                    $_SESSION['status_code'] = "error";
                    header("location: ../index.php");
                }

            }
        } else {
            $_SESSION['status'] = "Authentication Failed";
            $_SESSION['status-code'] = "error";
            header("location: ../index.php");
        }
    } else {
        die(mysqli_error($con));
    }

}

?>