<?php
// Include your database connection
include "../../model/dbconnection.php";

// Get the filter parameters sent via AJAX
$fromSemester = $_POST['fromSemester'];
$toSemester = $_POST['toSemester'];

// Sanitize the column names to avoid SQL injection
function sanitizeColumnName($name)
{
    return preg_replace('/[^a-zA-Z0-9_]/', '', trim($name));
}

// Array to hold the processed data for the graph
$categoryAverages = [];

// Query to get the ratings data filtered by semester and academic year
$sqlRatings = "
    SELECT semester, academic_year, studentsform.*, instructor.faculty_Id 
    FROM studentsform 
    JOIN instructor ON studentsform.toFacultyID = instructor.faculty_Id 
    WHERE CONCAT(semester, ' ', academic_year) BETWEEN '$fromSemester' AND '$toSemester'
    ORDER BY academic_year ASC, semester ASC
";

// Execute the query
$ratingsQuery = mysqli_query($con, $sqlRatings);
if (!$ratingsQuery) {
    echo json_encode(["error" => "Query failed: " . mysqli_error($con)]);
    exit;
}

// Query to get the categories from the database
$sqlCategories = "SELECT * FROM studentscategories";
$sqlCategories_query = mysqli_query($con, $sqlCategories);
if (!$sqlCategories_query) {
    echo json_encode(["error" => "Query failed: " . mysqli_error($con)]);
    exit;
}

// Loop through all categories to process the ratings
while ($categoriesRow = mysqli_fetch_assoc($sqlCategories_query)) {
    $category = $categoriesRow['categories']; // Get category as the subject

    // Loop through the ratings data for each semester
    mysqli_data_seek($ratingsQuery, 0); // Reset pointer for each category
    while ($ratingRow = mysqli_fetch_assoc($ratingsQuery)) {
        $semester = $ratingRow['semester'];
        $academicYear = $ratingRow['academic_year'];

        // Initialize the structure if not yet set
        if (!isset($categoryAverages[$category][$academicYear][$semester])) {
            $categoryAverages[$category][$academicYear][$semester] = [
                'totalRating' => 0,
                'ratingCount' => 0
            ];
        }

        // Process each criteria for the category
        $sqlcriteria = "SELECT * FROM studentscriteria WHERE studentsCategories = '$category'";
        $resultCriteria = mysqli_query($con, $sqlcriteria);

        if (mysqli_num_rows($resultCriteria) > 0) {
            while ($criteriaRow = mysqli_fetch_assoc($resultCriteria)) {
                $columnName = sanitizeColumnName($criteriaRow['studentsCategories']);
                $finalColumnName = $columnName . $criteriaRow['id'];

                // Get the rating for this criteria from the student's form
                $criteriaRating = $ratingRow[$finalColumnName] ?? null;

                // Validate rating (1 to 5 scale)
                if ($criteriaRating !== null && $criteriaRating >= 1 && $criteriaRating <= 5) {
                    // Accumulate ratings
                    $categoryAverages[$category][$academicYear][$semester]['totalRating'] += $criteriaRating;
                    $categoryAverages[$category][$academicYear][$semester]['ratingCount']++;
                }
            }
        }
    }
}

// Prepare the data for graph
$graphData = [];
foreach ($categoryAverages as $category => $academicYears) {
    foreach ($academicYears as $academicYear => $semesters) {
        foreach ($semesters as $semester => $data) {
            // Calculate the average for each semester/category
            $averageRating = ($data['ratingCount'] > 0) ? ($data['totalRating'] / $data['ratingCount']) : 0;
            $graphData[$category][$academicYear][$semester] = number_format($averageRating, 2, '.', '');
        }
    }
}

// Return the data as a JSON response to the AJAX call
echo json_encode($graphData);
?>