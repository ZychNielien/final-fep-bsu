<?php
include "model/dbconnection.php";
session_start();

$userId = $_SESSION["userid"];
$usersql = "SELECT * FROM `instructor` WHERE faculty_Id = '$userId'";
$usersql_query = mysqli_query($con, $usersql);
$userRow = mysqli_fetch_assoc($usersql_query);

$FacultyID = $userRow['faculty_Id'];

$selectedSemester = isset($_POST['semester']) ? $_POST['semester'] : '';
$selectedAcademicYear = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';

function sanitizeColumnName($name)
{
    return preg_replace('/[^a-zA-Z0-9_]/', '', trim($name));
}

// Fetch the last two distinct semesters and academic years
$recentSemestersQuery = "
    SELECT DISTINCT cq.semester, cq.academic_year
    FROM studentsform cq
    JOIN instructor i ON cq.toFacultyID = i.faculty_Id
    WHERE cq.toFacultyID = '$FacultyID'
    ORDER BY cq.academic_year DESC, cq.semester DESC
    LIMIT 2
";

$recentSemestersResult = mysqli_query($con, $recentSemestersQuery);
$recentSemesters = mysqli_fetch_all($recentSemestersResult, MYSQLI_ASSOC);

$conditions = [];
foreach ($recentSemesters as $semester) {
    $conditions[] = " (cq.semester = '" . mysqli_real_escape_string($con, $semester['semester']) . "' 
                     AND cq.academic_year = '" . mysqli_real_escape_string($con, $semester['academic_year']) . "') ";
}

// Construct the subject query
$sqlSubject = "
    SELECT DISTINCT s.subject, cq.semester, cq.academic_year
    FROM studentsform cq
    JOIN instructor i ON cq.toFacultyID = i.faculty_Id
    JOIN subject s ON cq.subject = s.subject
    WHERE cq.toFacultyID = '$FacultyID' 
    AND (" . implode(' OR ', $conditions) . ")
";

if (!empty($selectedAcademicYear)) {
    $sqlSubject .= " AND cq.academic_year = '" . mysqli_real_escape_string($con, $selectedAcademicYear) . "'";
}
if (!empty($selectedSemester)) {
    $sqlSubject .= " AND cq.semester = '" . mysqli_real_escape_string($con, $selectedSemester) . "'";
}

$sqlSubject .= " ORDER BY cq.semester DESC, cq.academic_year DESC, cq.subject";

$sqlSubject_query = mysqli_query($con, $sqlSubject);
$subjects = [];
$averageRatings = [];

if (mysqli_num_rows($sqlSubject_query) > 0) {
    while ($subject = mysqli_fetch_assoc($sqlSubject_query)) {
        $subjects[] = $subject['subject']; // Collect subjects
        $totalAverage = 0;
        $categoryCount = 0;

        $sql = "SELECT * FROM `studentscategories`";
        $sql_query = mysqli_query($con, $sql);

        if (mysqli_num_rows($sql_query) > 0) {
            while ($categoriesRow = mysqli_fetch_assoc($sql_query)) {
                $categories = $categoriesRow['categories'];
                $totalRatings = [0, 0, 0, 0, 0]; // Initialize total ratings for 5 categories
                $ratingCount = 0;

                $sqlcriteria = "SELECT * FROM `studentscriteria` WHERE studentsCategories = '$categories'";
                $resultCriteria = mysqli_query($con, $sqlcriteria);

                if (mysqli_num_rows($resultCriteria) > 0) {
                    $selectedSubject = $subject['subject'];
                    $selectedSemester = $subject['semester'];
                    $selectedAcademicYear = $subject['academic_year'];

                    $SQLFaculty = "SELECT * FROM `studentsform` WHERE toFacultyID = '$FacultyID' 
                    AND subject = '$selectedSubject' 
                    AND semester = '$selectedSemester' 
                    AND academic_year = '$selectedAcademicYear'";

                    $SQLFaculty_query = mysqli_query($con, $SQLFaculty);

                    while ($ratingRow = mysqli_fetch_assoc($SQLFaculty_query)) {
                        while ($criteriaRow = mysqli_fetch_assoc($resultCriteria)) {
                            $columnName = sanitizeColumnName($criteriaRow['studentsCategories']);
                            $finalColumnName = $columnName . $criteriaRow['id'];
                            $criteriaRating = $ratingRow[$finalColumnName] ?? null;

                            if ($criteriaRating !== null && $criteriaRating >= 1 && $criteriaRating <= 5) {
                                $totalRatings[$criteriaRating - 1]++;
                                $ratingCount++;
                            }
                        }
                        mysqli_data_seek($resultCriteria, 0); // Reset criteria result set
                    }

                    if ($ratingCount > 0) {
                        $averageRating = 0;
                        for ($i = 0; $i < 5; $i++) {
                            $averageRating += ($i + 1) * $totalRatings[$i];
                        }
                        $averageRating /= $ratingCount;

                        $totalAverage += $averageRating;
                        $categoryCount++;
                    }
                }
            }
        }

        // Calculate final average rating
        if ($categoryCount > 0) {
            $finalAverageRating = $totalAverage / $categoryCount;
            $averageRatings[] = number_format((float) $finalAverageRating, 2, '.', '');
        } else {
            $averageRatings[] = 0; // Default to 0 if no ratings
        }
    }
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode(['subjects' => $subjects, 'averageRatings' => $averageRatings]);
?>