<?php


$sqlCategories_CM = "SELECT * FROM `studentscategories` WHERE categories = 'CLASSROOM MANAGEMENT'";
$sqlCategories_query_CM = mysqli_query($con, $sqlCategories_CM);

if (!$sqlCategories_query_CM) {
    echo "Query failed for Classroom Management: " . mysqli_error($con);
    exit;
}

$instructorsData_CM = [];

$usersql_query = mysqli_query($con, "SELECT * FROM `INSTRUCTOR` WHERE status = 1");
if (mysqli_num_rows($usersql_query) > 0) {
    while ($userRow = mysqli_fetch_assoc($usersql_query)) {
        $FacultyID = $userRow['faculty_Id'];
        $facultyName = $userRow['first_name'] . ' ' . $userRow['last_name'];

        // Reset categories query pointer
        mysqli_data_seek($sqlCategories_query_CM, 0);

        // Loop through categories to get ratings for 'Classroom Management'
        while ($categoriesRow = mysqli_fetch_assoc($sqlCategories_query_CM)) {
            $categories = $categoriesRow['categories'];

            // Initialize variables for rating calculations
            $totalRatings = [0, 0, 0, 0, 0]; // [1, 2, 3, 4, 5]
            $ratingCount = 0;
            $averageRating = 0;
            $interpretation = 'None';

            // Get criteria for this category
            $sqlcriteria = "SELECT * FROM `studentscriteria` WHERE studentsCategories = '$categories'";
            $resultCriteria = mysqli_query($con, $sqlcriteria);

            if (mysqli_num_rows($resultCriteria) > 0) {
                // Query ratings for the current faculty, semester, and academic year
                $SQLFaculty = "
                    SELECT * FROM `studentsform`
                    WHERE toFacultyID = '$FacultyID' 
                    AND semester = '$selectedSemester' 
                    AND academic_year = '$selectedAcademicYear'
                ";

                $SQLFaculty_query = mysqli_query($con, $SQLFaculty);

                if (mysqli_num_rows($SQLFaculty_query) > 0) {
                    // Process ratings for this instructor
                    while ($ratingRow = mysqli_fetch_assoc($SQLFaculty_query)) {
                        // Loop through the criteria to get ratings
                        while ($criteriaRow = mysqli_fetch_assoc($resultCriteria)) {
                            $columnName = sanitizeColumnName($criteriaRow['studentsCategories']);
                            $finalColumnName = $columnName . $criteriaRow['id'];

                            $criteriaRating = $ratingRow[$finalColumnName] ?? null;

                            if ($criteriaRating !== null && $criteriaRating >= 1 && $criteriaRating <= 5) {
                                $totalRatings[$criteriaRating - 1]++;
                                $ratingCount++;
                            }
                        }
                        // Reset criteria result set
                        mysqli_data_seek($resultCriteria, 0);
                    }

                    // Calculate average if we have ratings
                    if ($ratingCount > 0) {
                        for ($i = 0; $i < 5; $i++) {
                            $averageRating += ($i + 1) * $totalRatings[$i];
                        }
                        $averageRating /= $ratingCount;
                        $interpretation = getVerbalInterpretation($averageRating);
                    } else {
                        // No ratings found for this instructor
                        $averageRating = 0;
                        $interpretation = 'None';
                    }
                } else {
                    // No form records found for this instructor
                    $averageRating = 0;
                    $interpretation = 'None';
                }
            }

            // Add the data for this instructor to the array for Classroom Management
            $instructorsData_CM[] = [
                'facultyName' => $facultyName,
                'category' => $categories,
                'averageRating' => $averageRating,
                'interpretation' => $interpretation,
            ];
        }
    }
} else {
    echo "<tr><td colspan='4' style='text-align: center; color: red;'>No instructors found for Classroom Management.</td></tr>";
}

// Sort the array for Classroom Management by averageRating in descending order
usort($instructorsData_CM, function ($a, $b) {
    return $b['averageRating'] <=> $a['averageRating'];  // Descending order
});
?>

<!-- Render the results in a table -->
<table class="table table-bordered mt-2 text-center">
    <thead>
        <tr class="bg-danger">
            <th>Ranking</th>
            <th>Faculty</th>
            <th>Average</th>
            <th>Verbal Interpretation</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (empty($instructorsData_CM)) {
            echo "<tr><td colspan='4' style='text-align: center; color: red;'>No data to display for Classroom Management.</td></tr>";
        } else {
            $rank = 1;
            foreach ($instructorsData_CM as $data) {
                echo '<tr>';
                echo '<td>' . $rank . '</td>';  // Display the current rank
                echo '<td>' . htmlspecialchars($data['facultyName']) . '</td>';
                echo '<td>' . number_format((float) $data['averageRating'], 2, '.', '') . '</td>';
                echo '<td>' . htmlspecialchars($data['interpretation']) . '</td>';
                echo '</tr>';
                $rank++;  // Increment the rank
            }
        }
        ?>
    </tbody>
</table>