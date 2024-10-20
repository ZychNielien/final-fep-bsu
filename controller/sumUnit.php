<?php
session_start();
include "../model/dbconnection.php";
 
$srcode = $_GET['srcode'];
$year = $_GET['year'];

$query = "SELECT COALESCE(SUM(S.unit), 0)  AS TotalUnits FROM `enrolled_student` E INNER JOIN subject S ON E.subject_id = S.subject_id INNER JOIN student_status SS ON E.sr_code = SS.sr_code INNER JOIN year_level YL ON SS.year_level = YL.year_id WHERE E.sr_code = '$srcode' AND YL.year_level = '$year'";
$query_run = mysqli_query($con, $query);

        $data = array();

        if(mysqli_num_rows($query_run) > 0){
            while($row = mysqli_fetch_assoc($query_run)){
                $data[] = $row;
            }
        }
        echo json_encode($data);