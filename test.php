<?php

include "model/dbconnection.php";

session_start();

$userId = $_SESSION["userid"];
$usersql = "SELECT * FROM `instructor` WHERE faculty_Id = '$userId'";
$usersql_query = mysqli_query($con, $usersql);
$userRow = mysqli_fetch_assoc($usersql_query);

$FacultyID = $userRow['faculty_Id'];

function sanitizeColumnName($name)
{
    return preg_replace('/[^a-zA-Z0-9_]/', '', trim($name));
}

$selectedSemester = isset($_POST['semester']) ? $_POST['semester'] : '';
$selectedAcademicYear = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';

$sqlSubject = "
    SELECT DISTINCT s.subject, 
        cq.semester, 
        cq.academic_year, 
        cq.courseTitle
    FROM classroomobservation cq
    JOIN instructor i ON cq.toFacultyID = i.faculty_Id
    JOIN subject s ON cq.courseTitle = s.subject_code
    WHERE cq.toFacultyID = '$FacultyID'
";

if (!empty($selectedAcademicYear)) {
    $sqlSubject .= " AND cq.academic_year = '$selectedAcademicYear'";
}
if (!empty($selectedSemester)) {
    $sqlSubject .= " AND cq.semester = '$selectedSemester'";
}

$sqlSubject .= " ORDER BY cq.semester DESC, cq.academic_year DESC, cq.courseTitle";

$sqlSubject_query = mysqli_query($con, $sqlSubject);
if (!$sqlSubject_query) {
    die("Query Failed: " . mysqli_error($con));
}

$finalAveragesPerSemester = [];
$semesterLabels = [];
$finalAverageRatings = [];

if (mysqli_num_rows($sqlSubject_query) > 0) {
    while ($subject = mysqli_fetch_assoc($sqlSubject_query)) {
        $totalAverage = 0;
        $categoryCount = 0;

        $facultyID = $userRow['faculty_Id'];
        $selectedSubject = $subject['courseTitle'];
        $selectedSemester = $subject['semester'];
        $selectedAcademicYear = $subject['academic_year'];

        $sqlCategories = "SELECT * FROM `classroomcategories`";
        $sqlCategories_query = mysqli_query($con, $sqlCategories);

        while ($categoriesRow = mysqli_fetch_assoc($sqlCategories_query)) {
            $categories = $categoriesRow['categories'];

            $totalRatings = [0, 0, 0, 0, 0];
            $ratingCount = 0;

            $sqlCriteria = "SELECT * FROM `classroomcriteria` WHERE classroomCategories = '$categories'";
            $resultCriteria = mysqli_query($con, $sqlCriteria);

            $SQLFaculty = "SELECT * FROM `classroomobservation` WHERE toFacultyID = '$facultyID' 
                            AND courseTitle = '$selectedSubject' 
                            AND semester = '$selectedSemester' 
                            AND academic_year = '$selectedAcademicYear'";

            $SQLFaculty_query = mysqli_query($con, $SQLFaculty);

            while ($ratingRow = mysqli_fetch_assoc($SQLFaculty_query)) {
                while ($criteriaRow = mysqli_fetch_assoc($resultCriteria)) {
                    $columnName = sanitizeColumnName($criteriaRow['classroomCategories']);
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

                $totalAverage += $averageRating;
                $categoryCount++;
            }
        }

        if ($categoryCount > 0) {
            $finalAverageRating = $totalAverage / $categoryCount;

            // Store the final average per semester and academic year
            $finalAveragesPerSemester[] = [
                'semester' => $selectedSemester,
                'academic_year' => $selectedAcademicYear,
                'finalAverageRating' => $finalAverageRating
            ];

            // Push data for chart
            $semesterLabels[] = $selectedSemester . ' ' . $selectedAcademicYear;
            $finalAverageRatings[] = $finalAverageRating;
        }
    }

} else {
    echo "<h2 style='text-align: center; color: red;'>No record found.</h2>";
}
?>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Create a canvas element for the chart -->
<canvas id="finalAverageChart" width="400" height="200"></canvas>

<script>
    // Data from PHP
    var labels = <?php echo json_encode($semesterLabels); ?>;
    var data = <?php echo json_encode($finalAverageRatings); ?>;

    // Chart.js configuration
    var ctx = document.getElementById('finalAverageChart').getContext('2d');
    var finalAverageChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Final Average Rating',
                data: data,
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: false
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    max: 5
                }
            }
        }
    });
</script>