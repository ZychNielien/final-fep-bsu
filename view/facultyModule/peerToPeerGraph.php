<?php
include "../../model/dbconnection.php";
session_start();

$userId = $_SESSION["userid"];
$usersql = "SELECT * FROM `instructor` WHERE faculty_Id = '$userId'";
$usersql_query = mysqli_query($con, $usersql);
$userRow = mysqli_fetch_assoc($usersql_query);

$FacultyID = $userRow['faculty_Id'];

$sqlSubject = "
    SELECT DISTINCT sf.semester, sf.academic_year 
    FROM peertopeerform sf
    WHERE sf.toFacultyID = '$FacultyID'
    ORDER BY sf.semester DESC, sf.academic_year DESC
    LIMIT 1
";

$sqlSubject_query = mysqli_query($con, $sqlSubject);
$categoriesData = [];

if (mysqli_num_rows($sqlSubject_query) > 0) {
    while ($subject = mysqli_fetch_assoc($sqlSubject_query)) {
        $semester = $subject['semester'];
        $academicYear = $subject['academic_year'];

        $sql = "SELECT * FROM `facultycategories`";
        $sql_query = mysqli_query($con, $sql);

        if (mysqli_num_rows($sql_query) > 0) {
            while ($categoriesRow = mysqli_fetch_assoc($sql_query)) {
                $categories = $categoriesRow['categories'];

                $totalRatings = [0, 0, 0, 0, 0];
                $ratingCount = 0;

                $sqlcriteria = "SELECT * FROM `facultycriteria` WHERE facultyCategories = '$categories'";
                $resultCriteria = mysqli_query($con, $sqlcriteria);

                if (mysqli_num_rows($resultCriteria) > 0) {
                    $SQLFaculty = "SELECT * FROM `peertopeerform` WHERE toFacultyID = '$FacultyID' 
                    AND semester = '$semester' 
                    AND academic_year = '$academicYear'";

                    $SQLFaculty_query = mysqli_query($con, $SQLFaculty);

                    while ($ratingRow = mysqli_fetch_assoc($SQLFaculty_query)) {
                        while ($criteriaRow = mysqli_fetch_assoc($resultCriteria)) {
                            $columnName = preg_replace('/[^a-zA-Z0-9_]/', '', trim($criteriaRow['facultyCategories']));
                            $finalColumnName = $columnName . $criteriaRow['id'];

                            $criteriaRating = $ratingRow[$finalColumnName] ?? null;

                            if ($criteriaRating !== null && $criteriaRating >= 1 && $criteriaRating <= 5) {
                                $totalRatings[$criteriaRating - 1]++;
                                $ratingCount++;
                            }
                        }
                        mysqli_data_seek($resultCriteria, 0);
                    }

                    if ($ratingCount > 0) {
                        $averageRating = 0;
                        for ($i = 0; $i < 5; $i++) {
                            $averageRating += ($i + 1) * $totalRatings[$i];
                        }
                        $averageRating /= $ratingCount;
                        $categoriesData[$categories] = number_format((float) $averageRating, 2, '.', '');
                    }
                }
            }
        }
    }
}

header('Content-Type: application/json');
echo json_encode($categoriesData);
?>