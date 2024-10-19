<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
include "../../model/dbconnection.php";

session_start();
$userId = $_SESSION["userid"];
$usersql = "SELECT * FROM `instructor` WHERE faculty_Id = '$userId'";
$usersql_query = mysqli_query($con, $usersql);

$userRow = mysqli_fetch_assoc($usersql_query);
$FacultyID = $userRow['faculty_Id'];

// Initialize categoriesData with zero values
$categoriesData = [];

// Fetch all categories
$sql = "SELECT * FROM `facultycategories`";
$sql_query = mysqli_query($con, $sql);

if (mysqli_num_rows($sql_query) > 0) {
    while ($categoriesRow = mysqli_fetch_assoc($sql_query)) {
        $categories = $categoriesRow['categories'];
        $categoriesData[$categories] = 0; // Initialize all categories with 0
    }
}

// Fetch ratings
$sqlSubject = "
    SELECT DISTINCT sf.semester, sf.academic_year 
    FROM peertopeerform sf
    WHERE sf.toFacultyID = '$FacultyID'
    ORDER BY sf.semester DESC, sf.academic_year DESC
    LIMIT 1
";

$sqlSubject_query = mysqli_query($con, $sqlSubject);
if (mysqli_num_rows($sqlSubject_query) > 0) {
    while ($subject = mysqli_fetch_assoc($sqlSubject_query)) {
        $semester = $subject['semester'];
        $academicYear = $subject['academic_year'];

        // Your existing logic for fetching ratings...
        // Update categoriesData with the calculated averages
        // Example:
        // $categoriesData[$categories] = number_format((float) $averageRating, 2, '.', '');
    }
}

echo json_encode($categoriesData); // Return the data as JSON
?>