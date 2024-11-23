<?php
session_start();
include "../model/dbconnection.php";

if (isset($_POST['id']) && ($_POST['srcode'])) {
    $id = $_POST['id'];
    $srcode = $_POST['srcode'];

    $yearsemester = "SELECT * FROM `academic_year_semester` WHERE id= 1 ";
    $yearsemester_query = mysqli_query($con, $yearsemester);
    $yearsemesterRow = mysqli_fetch_Assoc($yearsemester_query);
    $semester = $yearsemesterRow['semester'];
    $year = $yearsemesterRow['academic_year'];

    $query = "INSERT INTO enrolled_student (subject_id, sr_code, section_id, semester, academic_year) VALUES ((SELECT subject_id FROM assigned_subject WHERE id = '$id'), '$srcode', (SELECT section_id FROM assigned_subject WHERE id = '$id'),'$semester','$year')";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $query2 = "INSERT INTO enrolled_subject (`subject_id`, `sr_code`, `section_id`, `faculty_id`, `semester`, `academic_year`) 
                        VALUES 
                    ((SELECT S.subject FROM assigned_subject A INNER JOIN subject S ON A.subject_id = S.subject_id WHERE A.id = '$id'),
                     '$srcode', 
                     (SELECT S.section FROM assigned_subject A INNER JOIN section S ON A.section_id = S.id WHERE A.id = '$id'), 
                     (SELECT faculty_id FROM assigned_subject WHERE id = '$id'),'$semester','$year')";

        $query_run2 = mysqli_query($con, $query2);
    }
}