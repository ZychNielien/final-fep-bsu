<?php
// DATABASE CONNECTION
include "../../model/dbconnection.php";
// NAVIGATION BAR
include "components/navBar.php";


// Get the list of all instructors
$usersql = "SELECT * FROM `instructor`  WHERE status = 1";
$usersql_query = mysqli_query($con, $usersql);
if (!$usersql_query) {
    echo "Query failed: " . mysqli_error($con); // Debugging DB connection issues
    exit;
}

function sanitizeColumnName($name)
{
    return preg_replace('/[^a-zA-Z0-9_]/', '', trim($name));
}

function getVerbalInterpretation($averageRating): string
{
    if ($averageRating < 0 || $averageRating > 5) {
        return 'No description';
    }

    // Verbal interpretation based on rating
    $interpretations = ['None', 'Poor', 'Fair', 'Satisfactory', 'Very Satisfactory', 'Outstanding'];
    return $interpretations[(int) $averageRating];
}

$sqlSAYSelect = "SELECT * FROM academic_year_semester WHERE id =4";
$result = mysqli_query($con, $sqlSAYSelect);
$selectSAY = mysqli_fetch_assoc($result);


$selectedSemester = $selectSAY['semester'];
$selectedAcademicYear = $selectSAY['academic_year'];

$sqlSAYSelectclass = "SELECT * FROM academic_year_semester WHERE id =4";
$resultclass = mysqli_query($con, $sqlSAYSelectclass);
$selectSAYclass = mysqli_fetch_assoc($resultclass);


$selectedSemesterclass = $selectSAYclass['semester'];
$selectedAcademicYearclass = $selectSAYclass['academic_year'];

$FDP = "SELECT * FROM `academic_year_semester` WHERE id = 4";
$FDP_query = mysqli_query($con, $FDP);
$FDPRow = mysqli_fetch_assoc($FDP_query);

?>

<head>

    <!-- PAGE TITLE -->
    <title>Faculty Member</title>

    <!-- STYLESHEETS OR CSS FILES -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../public/css/style.css">
    <link rel="stylesheet" href="../../public/css/sweetalert.min.css">

    <!-- SCRIPT -->
    <script src="../../public/js/sweetalert2@11.js"></script>
    <script src="../../public/js/jquery-3.7.1.min.js"></script>
    <script src="../../bootstrap/js/bootstrap.bundle.min.js"></script>

</head>

<!-- CONTENT CONTAINER -->
<section class="contentContainer ">

    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-facultyDevelopment-tab" data-bs-toggle="tab"
                data-bs-target="#nav-facultyDevelopment" type="button" role="tab" aria-controls="nav-facultyDevelopment"
                aria-selected="true">Faculty Development</button>
            <button class="nav-link" id="nav-peerToPeer-tab" data-bs-toggle="tab" data-bs-target="#nav-peerToPeer"
                type="button" role="tab" aria-controls="nav-peerToPeer" aria-selected="false">Peer to Peer</button>
            <button class="nav-link" id="nav-classObservation-tab" data-bs-toggle="tab"
                data-bs-target="#nav-classObservation" type="button" role="tab" aria-controls="nav-classObservation"
                aria-selected="false">Classroom
                Observation</button>
        </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">

        <!-- Faculty Development -->
        <div class="tab-pane fade show active" id="nav-facultyDevelopment" role="tabpanel"
            aria-labelledby="nav-facultyDevelopment-tab">

            <h2 class="text-center m-3">Faculty Development Overall Ranking by Category</h2>

            <div class="container my-2">

                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-OverallLahat-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-OverallLahat" type="button" role="tab" aria-controls="nav-OverallLahat"
                            aria-selected="true">
                            OVERALL</button>

                        <button class="nav-link" id="nav-teachingEffectiveness-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-teachingEffectiveness" type="button" role="tab"
                            aria-controls="nav-teachingEffectiveness" aria-selected="true">TEACHING
                            EFFECTIVENESS</button>
                        <button class="nav-link" id="nav-classManagement-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-classManagement" type="button" role="tab"
                            aria-controls="nav-classManagement" aria-selected="false">CLASSROOM
                            MANAGEMENT</button>
                        <button class="nav-link" id="nav-studentEngagement-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-studentEngagement" type="button" role="tab"
                            aria-controls="nav-studentEngagement" aria-selected="false">STUDENT
                            ENGAGEMENT</button>
                        <button class="nav-link" id="nav-communication-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-communication" type="button" role="tab"
                            aria-controls="nav-communication" aria-selected="false">COMMUNICATION</button>
                        <button class="nav-link" id="nav-emotionalCompetence-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-emotionalCompetence" type="button" role="tab"
                            aria-controls="nav-emotionalCompetence" aria-selected="false">EMOTIONAL
                            COMPETENCE</button>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">

                    <div class="tab-pane fade show active" id="nav-OverallLahat" role="tabpanel"
                        aria-labelledby="nav-OverallLahat-tab">
                        <div class="d-flex justify-content-center my-2">
                            <button class="btn btn-success" onclick="printPartOfPage('overallStudent')">Print</button>
                        </div>
                        <div class="container my-3 d-flex justify-content-center align-items-center flex-column"
                            id="overallStudent">
                            <h3 style="text-align: center;">Faculty Development Overall Ranking Academic Year
                                <?php echo $FDPRow['academic_year'] ?>,
                                <?php echo $FDPRow['semester'] ?> Semester
                            </h3>

                            <?php
                            // Query to fetch all categories
                            $categoriesQuery = "SELECT * FROM `studentscategories`";
                            $categoriesResult = mysqli_query($con, $categoriesQuery);

                            if (!$categoriesResult) {
                                echo "Query failed for fetching categories: " . mysqli_error($con);
                                exit;
                            }

                            $instructorData = [];
                            $totalRatingSum = 0; // Initialize total rating sum
                            $totalRatingCount = 0; // Initialize total rating count
                            
                            // Query to fetch all instructors (even those with no ratings)
                            $instructorQuery = mysqli_query($con, "SELECT * FROM `instructor` WHERE status = 1");
                            if (mysqli_num_rows($instructorQuery) > 0) {
                                while ($instructorRow = mysqli_fetch_assoc($instructorQuery)) {
                                    $facultyId = $instructorRow['faculty_Id'];
                                    $facultyFullName = $instructorRow['first_name'] . ' ' . $instructorRow['last_name'];

                                    // Initialize an array for this instructor's ratings
                                    $instructorRatings = [
                                        'facultyFullName' => $facultyFullName,
                                        'facultyId' => $facultyId,
                                        'totalRatingSum' => 0,
                                        'totalRatingCount' => 0
                                    ];

                                    // Reset categories result set using mysqli_data_seek
                                    mysqli_data_seek($categoriesResult, 0); // Make sure $categoriesResult is used after the query has been executed
                            
                                    while ($categoryRow = mysqli_fetch_assoc($categoriesResult)) {
                                        $category = $categoryRow['categories'];

                                        // Initialize variables for category rating calculations
                                        $categoryRatingSum = 0;
                                        $categoryRatingCount = 0;

                                        // Get criteria for this category
                                        $criteriaQuery = "SELECT * FROM `studentscriteria` WHERE studentsCategories = '$category'";
                                        $criteriaResult = mysqli_query($con, $criteriaQuery);

                                        if (mysqli_num_rows($criteriaResult) > 0) {
                                            $facultyRatingsQuery = "
                            SELECT * FROM `studentsform`
                            WHERE toFacultyID = '$facultyId' 
                            AND semester = '$selectedSemester' 
                            AND academic_year = '$selectedAcademicYear'
                        ";

                                            $facultyRatingsResult = mysqli_query($con, $facultyRatingsQuery);

                                            if (mysqli_num_rows($facultyRatingsResult) > 0) {
                                                // Process ratings for this instructor
                                                while ($ratingRow = mysqli_fetch_assoc($facultyRatingsResult)) {
                                                    while ($criteriaRow = mysqli_fetch_assoc($criteriaResult)) {
                                                        $columnName = sanitizeColumnName($criteriaRow['studentsCategories']);
                                                        $finalColumnName = $columnName . $criteriaRow['id'];

                                                        $rating = $ratingRow[$finalColumnName] ?? null;

                                                        if ($rating !== null && $rating >= 1 && $rating <= 5) {
                                                            $categoryRatingCount++;
                                                            $categoryRatingSum += $rating;
                                                        }
                                                    }
                                                    // Reset criteria result set
                                                    mysqli_data_seek($criteriaResult, 0);
                                                }

                                                // Calculate category average if ratings exist
                                                if ($categoryRatingCount > 0) {
                                                    $categoryAverage = $categoryRatingSum / $categoryRatingCount;

                                                    // Accumulate the instructor's total ratings and count
                                                    $instructorRatings['totalRatingSum'] += $categoryRatingSum;
                                                    $instructorRatings['totalRatingCount'] += $categoryRatingCount;
                                                }
                                            }
                                        }
                                    }

                                    // Calculate the average rating for the instructor (if there are ratings)
                                    if ($instructorRatings['totalRatingCount'] > 0) {
                                        $instructorRatings['averageRating'] = $instructorRatings['totalRatingSum'] / $instructorRatings['totalRatingCount'];
                                    } else {
                                        // If no ratings, set the average to 0
                                        $instructorRatings['averageRating'] = 0;
                                    }

                                    // Determine the verbal interpretation based on the average rating
                                    $ratingInterpretation = getVerbalInterpretation($instructorRatings['averageRating']);
                                    $instructorRatings['ratingInterpretation'] = $ratingInterpretation;

                                    // Add the aggregated data for this instructor to the instructorData array
                                    $instructorData[] = $instructorRatings;
                                }
                            } else {
                                echo "<tr><td colspan='4' style='text-align: center; color: red;'>No instructors found.</td></tr>";
                            }

                            // Sort the array by averageRating in descending order
                            usort($instructorData, function ($a, $b) {
                                return $b['averageRating'] <=> $a['averageRating'];  // Descending order
                            });

                            // Calculate the global average across all categories and instructors
                            $globalAverage = 0;
                            if ($totalRatingCount > 0) {
                                $globalAverage = $totalRatingSum / $totalRatingCount;
                            }
                            ?>
                            <!-- Render the instructor data table -->
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
                                    if (empty($instructorData)) {
                                        echo "<tr><td colspan='4' style='text-align: center; color: red;'>No data to display.</td></tr>";
                                    } else {
                                        $ranking = 1;
                                        foreach ($instructorData as $data) {
                                            echo '<tr>';
                                            echo '<td>' . $ranking . '</td>';  // Display the current rank
                                            echo '<td>' . htmlspecialchars($data['facultyFullName']) . '</td>';
                                            echo '<td>' . number_format((float) $data['averageRating'], 2, '.', '') . '</td>';
                                            echo '<td>' . htmlspecialchars($data['ratingInterpretation']) . '</td>';
                                            echo '</tr>';
                                            $ranking++;  // Increment the ranking
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-teachingEffectiveness" role="tabpanel"
                        aria-labelledby="nav-teachingEffectiveness-tab">
                        <div class="container my-3 d-flex justify-content-center align-items-center ">

                            <?php
                            $sqlCategories_TE = "SELECT * FROM `studentscategories` WHERE categories = 'TEACHING EFFECTIVENESS'";
                            $sqlCategories_query_TE = mysqli_query($con, $sqlCategories_TE);
                            if (!$sqlCategories_query_TE) {
                                echo "Query failed for Teaching Effectiveness: " . mysqli_error($con);
                                exit;
                            }

                            $instructorsData_TE = [];

                            if (mysqli_num_rows($usersql_query) > 0) {

                                while ($userRow = mysqli_fetch_assoc($usersql_query)) {
                                    $FacultyID = $userRow['faculty_Id'];
                                    $facultyName = $userRow['first_name'] . ' ' . $userRow['last_name'];

                                    mysqli_data_seek($sqlCategories_query_TE, 0);

                                    while ($categoriesRow = mysqli_fetch_assoc($sqlCategories_query_TE)) {
                                        $categories = $categoriesRow['categories'];

                                        $totalRatings = [0, 0, 0, 0, 0];
                                        $ratingCount = 0;
                                        $averageRating = 0;
                                        $interpretation = 'None';

                                        $sqlcriteria = "SELECT * FROM `studentscriteria` WHERE studentsCategories = '$categories'";
                                        $resultCriteria = mysqli_query($con, $sqlcriteria);

                                        if (mysqli_num_rows($resultCriteria) > 0) {
                                            $SQLFaculty = "
                                                SELECT * FROM `studentsform` 
                                                WHERE toFacultyID = '$FacultyID' 
                                                AND semester = '$selectedSemester' 
                                                AND academic_year = '$selectedAcademicYear'";

                                            $SQLFaculty_query = mysqli_query($con, $SQLFaculty);

                                            if (mysqli_num_rows($SQLFaculty_query) > 0) {
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
                                                    mysqli_data_seek($resultCriteria, 0);
                                                }

                                                if ($ratingCount > 0) {
                                                    for ($i = 0; $i < 5; $i++) {
                                                        $averageRating += ($i + 1) * $totalRatings[$i];
                                                    }
                                                    $averageRating /= $ratingCount;
                                                    $interpretation = getVerbalInterpretation($averageRating);
                                                } else {
                                                    $averageRating = 0;
                                                    $interpretation = 'None';
                                                }
                                            } else {
                                                $averageRating = 0;
                                                $interpretation = 'None';
                                            }
                                        }

                                        $instructorsData_TE[] = [
                                            'facultyName' => $facultyName,
                                            'category' => $categories,
                                            'averageRating' => $averageRating,
                                            'interpretation' => $interpretation,
                                        ];
                                    }
                                }
                            } else {
                                echo "<tr><td colspan='4' style='text-align: center; color: red;'>No instructors found for Teaching Effectiveness.</td></tr>";
                            }

                            usort($instructorsData_TE, function ($a, $b) {
                                return $b['averageRating'] <=> $a['averageRating'];
                            });
                            ?>

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
                                    $rank = 1;
                                    foreach ($instructorsData_TE as $data) {
                                        echo '<tr>';
                                        echo '<td>' . $rank . '</td>';
                                        echo '<td>' . htmlspecialchars($data['facultyName']) . '</td>';
                                        echo '<td>' . number_format((float) $data['averageRating'], 2, '.', '') . '</td>';
                                        echo '<td>' . htmlspecialchars($data['interpretation']) . '</td>';
                                        echo '</tr>';
                                        $rank++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-classManagement" role="tabpanel"
                        aria-labelledby="nav-classManagement-tab">
                        <div class="container my-3 d-flex justify-content-center align-items-center ">

                            <?php
                            $sqlCategories_CM = "SELECT * FROM `studentscategories` WHERE categories = 'CLASSROOM MANAGEMENT'";
                            $sqlCategories_query_CM = mysqli_query($con, $sqlCategories_CM);

                            if (!$sqlCategories_query_CM) {
                                echo "Query failed for Classroom Management: " . mysqli_error($con);
                                exit;
                            }

                            $instructorsData_CM = [];

                            $usersql_query = mysqli_query($con, "SELECT * FROM `instructor` WHERE status = 1");
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

                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-studentEngagement" role="tabpanel"
                        aria-labelledby="nav-studentEngagement-tab">
                        <div class="container my-3 d-flex justify-content-center align-items-center ">
                            <?php
                            // Categories Query: Student Engagement
                            $sqlCategories_SE = "SELECT * FROM `studentscategories` WHERE categories = 'STUDENT ENGAGEMENT'";
                            $sqlCategories_query_SE = mysqli_query($con, $sqlCategories_SE);

                            if (!$sqlCategories_query_SE) {
                                echo "Query failed for Student Engagement: " . mysqli_error($con); // Debugging query issues
                                exit;
                            }

                            // Initialize an array to hold all instructor data for Student Engagement
                            $instructorsData_SE = [];

                            // Ensure $usersql_query is properly initialized and contains faculty data
                            $usersql_query = mysqli_query($con, "SELECT * FROM `instructor`  WHERE status = 1"); // Adjust table name as needed
                            if (mysqli_num_rows($usersql_query) > 0) {
                                // Loop through all instructors
                                while ($userRow = mysqli_fetch_assoc($usersql_query)) {
                                    $FacultyID = $userRow['faculty_Id'];
                                    $facultyName = $userRow['first_name'] . ' ' . $userRow['last_name'];  // Assuming 'first_name' and 'last_name' exist
                            
                                    // Reset categories query pointer
                                    mysqli_data_seek($sqlCategories_query_SE, 0);

                                    // Loop through categories to get ratings for 'Student Engagement'
                                    while ($categoriesRow = mysqli_fetch_assoc($sqlCategories_query_SE)) {
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

                                        // Add the data for this instructor to the array for Student Engagement
                                        $instructorsData_SE[] = [
                                            'facultyName' => $facultyName,
                                            'category' => $categories,
                                            'averageRating' => $averageRating,
                                            'interpretation' => $interpretation,
                                        ];
                                    }
                                }
                            } else {
                                echo "<tr><td colspan='4' style='text-align: center; color: red;'>No instructors found for Student Engagement.</td></tr>";
                            }

                            // Sort the array for Student Engagement by averageRating in descending order
                            usort($instructorsData_SE, function ($a, $b) {
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
                                    if (empty($instructorsData_SE)) {
                                        echo "<tr><td colspan='4' style='text-align: center; color: red;'>No data to display for Student Engagement.</td></tr>";
                                    } else {
                                        $rank = 1;
                                        foreach ($instructorsData_SE as $data) {
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

                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-communication" role="tabpanel"
                        aria-labelledby="nav-communication-tab">
                        <div class="container my-3 d-flex justify-content-center align-items-center ">
                            <?php
                            // Categories Query: Communication
                            $sqlCategories_Comm = "SELECT * FROM `studentscategories` WHERE categories = 'COMMUNICATION'";
                            $sqlCategories_query_Comm = mysqli_query($con, $sqlCategories_Comm);

                            if (!$sqlCategories_query_Comm) {
                                echo "Query failed for Communication: " . mysqli_error($con); // Debugging query issues
                                exit;
                            }

                            // Initialize an array to hold all instructor data for Communication
                            $instructorsData_Comm = [];

                            // Ensure $usersql_query is properly initialized and contains faculty data
                            $usersql_query = mysqli_query($con, "SELECT * FROM `instructor`  WHERE status = 1"); // Adjust table name as needed
                            if (mysqli_num_rows($usersql_query) > 0) {
                                // Loop through all instructors
                                while ($userRow = mysqli_fetch_assoc($usersql_query)) {
                                    $FacultyID = $userRow['faculty_Id'];
                                    $facultyName = $userRow['first_name'] . ' ' . $userRow['last_name'];  // Assuming 'first_name' and 'last_name' exist
                            
                                    // Reset categories query pointer
                                    mysqli_data_seek($sqlCategories_query_Comm, 0);

                                    // Loop through categories to get ratings for 'COMMUNICATION'
                                    while ($categoriesRow = mysqli_fetch_assoc($sqlCategories_query_Comm)) {
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

                                        // Add the data for this instructor to the array for Communication
                                        $instructorsData_Comm[] = [
                                            'facultyName' => $facultyName,
                                            'category' => $categories,
                                            'averageRating' => $averageRating,
                                            'interpretation' => $interpretation,
                                        ];
                                    }
                                }
                            } else {
                                echo "<tr><td colspan='4' style='text-align: center; color: red;'>No instructors found for Communication.</td></tr>";
                            }

                            // Sort the array for Communication by averageRating in descending order
                            usort($instructorsData_Comm, function ($a, $b) {
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
                                    if (empty($instructorsData_Comm)) {
                                        echo "<tr><td colspan='4' style='text-align: center; color: red;'>No data to display for Communication.</td></tr>";
                                    } else {
                                        $rank = 1;
                                        foreach ($instructorsData_Comm as $data) {
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

                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-emotionalCompetence" role="tabpanel"
                        aria-labelledby="nav-emotionalCompetence-tab">
                        <div class="container my-3 d-flex justify-content-center align-items-center ">
                            <?php
                            // Categories Query: Emotional Competence
                            $sqlCategories_EC = "SELECT * FROM `studentscategories` WHERE categories = 'EMOTIONAL COMPETENCE'";
                            $sqlCategories_query_EC = mysqli_query($con, $sqlCategories_EC);

                            if (!$sqlCategories_query_EC) {
                                echo "Query failed for Emotional Competence: " . mysqli_error($con); // Debugging query issues
                                exit;
                            }

                            // Initialize an array to hold all instructor data for Emotional Competence
                            $instructorsData_EC = [];

                            // Ensure $usersql_query is properly initialized and contains faculty data
                            $usersql_query = mysqli_query($con, "SELECT * FROM `instructor`  WHERE status = 1"); // Adjust table name as needed
                            if (mysqli_num_rows($usersql_query) > 0) {
                                // Loop through all instructors
                                while ($userRow = mysqli_fetch_assoc($usersql_query)) {
                                    $FacultyID = $userRow['faculty_Id'];
                                    $facultyName = $userRow['first_name'] . ' ' . $userRow['last_name'];  // Assuming 'first_name' and 'last_name' exist
                            
                                    // Reset categories query pointer
                                    mysqli_data_seek($sqlCategories_query_EC, 0);

                                    // Loop through categories to get ratings for 'EMOTIONAL COMPETENCE'
                                    while ($categoriesRow = mysqli_fetch_assoc($sqlCategories_query_EC)) {
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

                                        // Add the data for this instructor to the array for Emotional Competence
                                        $instructorsData_EC[] = [
                                            'facultyName' => $facultyName,
                                            'category' => $categories,
                                            'averageRating' => $averageRating,
                                            'interpretation' => $interpretation,
                                        ];
                                    }
                                }
                            } else {
                                echo "<tr><td colspan='4' style='text-align: center; color: red;'>No instructors found for Emotional Competence.</td></tr>";
                            }

                            // Sort the array for Emotional Competence by averageRating in descending order
                            usort($instructorsData_EC, function ($a, $b) {
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
                                    if (empty($instructorsData_EC)) {
                                        echo "<tr><td colspan='4' style='text-align: center; color: red;'>No data to display for Emotional Competence.</td></tr>";
                                    } else {
                                        $rank = 1;
                                        foreach ($instructorsData_EC as $data) {
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

                        </div>
                    </div>

                </div>

            </div>

        </div>

        <!-- Peer to Peer  -->
        <div class="tab-pane fade" id="nav-peerToPeer" role="tabpanel" aria-labelledby="nav-peerToPeer-tab">

            <h2 class="text-center m-3">Peer to Peer Overall Ranking by Category</h2>

            <div class="container my-2">

                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-OverallLahatPeer-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-OverallLahatPeer" type="button" role="tab"
                            aria-controls="nav-OverallLahatPeer" aria-selected="true">
                            OVERALL</button>
                        <button class="nav-link " id="nav-professionalism-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-professionalism" type="button" role="tab"
                            aria-controls="nav-professionalism" aria-selected="true">PROFESSIONALISM</button>
                        <button class="nav-link" id="nav-interpersonalBehavior-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-interpersonalBehavior" type="button" role="tab"
                            aria-controls="nav-interpersonalBehavior" aria-selected="false">INTERPERSONAL
                            BEHAVIOR</button>
                        <button class="nav-link" id="nav-workHabits-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-workHabits" type="button" role="tab" aria-controls="nav-workHabits"
                            aria-selected="false">WORK HABITS</button>
                        <button class="nav-link" id="nav-teamwork-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-teamwork" type="button" role="tab" aria-controls="nav-teamwork"
                            aria-selected="false">TEAMWORK</button>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">

                    <div class="tab-pane fade show active" id="nav-OverallLahatPeer" role="tabpanel"
                        aria-labelledby="nav-OverallLahatPeer-tab">
                        <div class="d-flex justify-content-center my-2">
                            <button class="btn btn-success" onclick="printPartOfPage('overallPeer')">Print</button>
                        </div>
                        <div class="container my-3 d-flex justify-content-center align-items-center flex-column"
                            id="overallPeer">
                            <h3 style="text-align: center;">Peer to Peer Overall Ranking Academic Year
                                <?php echo $FDPRow['academic_year'] ?>,
                                <?php echo $FDPRow['semester'] ?> Semester
                            </h3>

                            <?php
                            // Query to fetch all categories
                            $categoriesQuery = "SELECT * FROM `facultycategories`";
                            $categoriesResult = mysqli_query($con, $categoriesQuery);

                            if (!$categoriesResult) {
                                echo "Query failed for fetching categories: " . mysqli_error($con);
                                exit;
                            }

                            $instructorData = [];
                            $totalRatingSum = 0; // Initialize total rating sum
                            $totalRatingCount = 0; // Initialize total rating count
                            
                            // Query to fetch all instructors (even those with no ratings)
                            $instructorQuery = mysqli_query($con, "SELECT * FROM `instructor` WHERE status = 1");
                            if (mysqli_num_rows($instructorQuery) > 0) {
                                while ($instructorRow = mysqli_fetch_assoc($instructorQuery)) {
                                    $facultyId = $instructorRow['faculty_Id'];
                                    $facultyFullName = $instructorRow['first_name'] . ' ' . $instructorRow['last_name'];

                                    // Initialize an array for this instructor's ratings
                                    $instructorRatings = [
                                        'facultyFullName' => $facultyFullName,
                                        'facultyId' => $facultyId,
                                        'totalRatingSum' => 0,
                                        'totalRatingCount' => 0
                                    ];

                                    // Reset categories result set using mysqli_data_seek
                                    mysqli_data_seek($categoriesResult, 0); // Make sure $categoriesResult is used after the query has been executed
                            
                                    while ($categoryRow = mysqli_fetch_assoc($categoriesResult)) {
                                        $category = $categoryRow['categories'];

                                        // Initialize variables for category rating calculations
                                        $categoryRatingSum = 0;
                                        $categoryRatingCount = 0;

                                        // Get criteria for this category
                                        $criteriaQuery = "SELECT * FROM `facultycriteria` WHERE facultyCategories = '$category'";
                                        $criteriaResult = mysqli_query($con, $criteriaQuery);

                                        if (mysqli_num_rows($criteriaResult) > 0) {
                                            $facultyRatingsQuery = "
                            SELECT * FROM `peertopeerform`
                            WHERE toFacultyID = '$facultyId' 
                            AND semester = '$selectedSemester' 
                            AND academic_year = '$selectedAcademicYear'
                        ";

                                            $facultyRatingsResult = mysqli_query($con, $facultyRatingsQuery);

                                            if (mysqli_num_rows($facultyRatingsResult) > 0) {
                                                // Process ratings for this instructor
                                                while ($ratingRow = mysqli_fetch_assoc($facultyRatingsResult)) {
                                                    while ($criteriaRow = mysqli_fetch_assoc($criteriaResult)) {
                                                        $columnName = sanitizeColumnName($criteriaRow['facultyCategories']);
                                                        $finalColumnName = $columnName . $criteriaRow['id'];

                                                        $rating = $ratingRow[$finalColumnName] ?? null;

                                                        if ($rating !== null && $rating >= 1 && $rating <= 5) {
                                                            $categoryRatingCount++;
                                                            $categoryRatingSum += $rating;
                                                        }
                                                    }
                                                    // Reset criteria result set
                                                    mysqli_data_seek($criteriaResult, 0);
                                                }

                                                // Calculate category average if ratings exist
                                                if ($categoryRatingCount > 0) {
                                                    $categoryAverage = $categoryRatingSum / $categoryRatingCount;

                                                    // Accumulate the instructor's total ratings and count
                                                    $instructorRatings['totalRatingSum'] += $categoryRatingSum;
                                                    $instructorRatings['totalRatingCount'] += $categoryRatingCount;
                                                }
                                            }
                                        }
                                    }

                                    // Calculate the average rating for the instructor (if there are ratings)
                                    if ($instructorRatings['totalRatingCount'] > 0) {
                                        $instructorRatings['averageRating'] = $instructorRatings['totalRatingSum'] / $instructorRatings['totalRatingCount'];
                                    } else {
                                        // If no ratings, set the average to 0
                                        $instructorRatings['averageRating'] = 0;
                                    }

                                    // Determine the verbal interpretation based on the average rating
                                    $ratingInterpretation = getVerbalInterpretation($instructorRatings['averageRating']);
                                    $instructorRatings['ratingInterpretation'] = $ratingInterpretation;

                                    // Add the aggregated data for this instructor to the instructorData array
                                    $instructorData[] = $instructorRatings;
                                }
                            } else {
                                echo "<tr><td colspan='4' style='text-align: center; color: red;'>No instructors found.</td></tr>";
                            }

                            // Sort the array by averageRating in descending order
                            usort($instructorData, function ($a, $b) {
                                return $b['averageRating'] <=> $a['averageRating'];  // Descending order
                            });

                            // Calculate the global average across all categories and instructors
                            $globalAverage = 0;
                            if ($totalRatingCount > 0) {
                                $globalAverage = $totalRatingSum / $totalRatingCount;
                            }
                            ?>
                            <!-- Render the instructor data table -->
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
                                    if (empty($instructorData)) {
                                        echo "<tr><td colspan='4' style='text-align: center; color: red;'>No data to display.</td></tr>";
                                    } else {
                                        $ranking = 1;
                                        foreach ($instructorData as $data) {
                                            echo '<tr>';
                                            echo '<td>' . $ranking . '</td>';  // Display the current rank
                                            echo '<td>' . htmlspecialchars($data['facultyFullName']) . '</td>';
                                            echo '<td>' . number_format((float) $data['averageRating'], 2, '.', '') . '</td>';
                                            echo '<td>' . htmlspecialchars($data['ratingInterpretation']) . '</td>';
                                            echo '</tr>';
                                            $ranking++;  // Increment the ranking
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>


                    <div class="tab-pane fade " id="nav-professionalism" role="tabpanel"
                        aria-labelledby="nav-professionalism-tab">
                        <div class="container my-3 d-flex justify-content-center align-items-center ">
                            <?php
                            // Categories Query: Professionalism
                            $sqlCategories_Pro = "SELECT * FROM `facultycategories` WHERE categories = 'PROFESSIONALISM'";
                            $sqlCategories_query_Pro = mysqli_query($con, $sqlCategories_Pro);

                            if (!$sqlCategories_query_Pro) {
                                echo "Query failed for Professionalism: " . mysqli_error($con); // Debugging query issues
                                exit;
                            }

                            // Initialize an array to hold all instructor data for Professionalism
                            $instructorsData_Pro = [];

                            // Ensure $usersql_query is properly initialized and contains faculty data
                            $usersql_query = mysqli_query($con, "SELECT * FROM `instructor`  WHERE status = 1"); // Adjust table name as needed
                            if (mysqli_num_rows($usersql_query) > 0) {
                                // Loop through all instructors
                                while ($userRow = mysqli_fetch_assoc($usersql_query)) {
                                    $FacultyID = $userRow['faculty_Id'];
                                    $facultyName = $userRow['first_name'] . ' ' . $userRow['last_name'];  // Assuming 'first_name' and 'last_name' exist
                            
                                    // Reset the query pointer for categories
                                    mysqli_data_seek($sqlCategories_query_Pro, 0);

                                    // Loop through categories to get ratings for 'Professionalism'
                                    while ($categoriesRow = mysqli_fetch_assoc($sqlCategories_query_Pro)) {
                                        $categories = $categoriesRow['categories'];

                                        // Initialize variables for rating calculations
                                        $totalRatings = [0, 0, 0, 0, 0]; // [1, 2, 3, 4, 5]
                                        $ratingCount = 0;
                                        $averageRating = 0;
                                        $interpretation = 'None';

                                        $sqlcriteria = "SELECT * FROM `facultycriteria` WHERE facultyCategories = '$categories'";
                                        $resultCriteria = mysqli_query($con, $sqlcriteria);

                                        if (mysqli_num_rows($resultCriteria) > 0) {
                                            // Get ratings for the current faculty, semester, and academic year from studentsform
                                            $SQLFaculty = "
                    SELECT * FROM `peertopeerform`
                    WHERE toFacultyID = '$FacultyID' 
                    AND semester = '$selectedSemester' 
                    AND academic_year = '$selectedAcademicYear'
                ";

                                            $SQLFaculty_query = mysqli_query($con, $SQLFaculty);

                                            if (mysqli_num_rows($SQLFaculty_query) > 0) {
                                                // Iterate through form results and process ratings
                                                while ($ratingRow = mysqli_fetch_assoc($SQLFaculty_query)) {
                                                    while ($criteriaRow = mysqli_fetch_assoc($resultCriteria)) {
                                                        $columnName = sanitizeColumnName($criteriaRow['facultyCategories']);
                                                        $finalColumnName = $columnName . $criteriaRow['id'];

                                                        $criteriaRating = $ratingRow[$finalColumnName] ?? null;

                                                        if ($criteriaRating !== null && $criteriaRating >= 1 && $criteriaRating <= 5) {
                                                            $totalRatings[$criteriaRating - 1]++;
                                                            $ratingCount++;
                                                        }
                                                    }
                                                    mysqli_data_seek($resultCriteria, 0);
                                                }

                                                // Only calculate the average if we have ratings
                                                if ($ratingCount > 0) {
                                                    for ($i = 0; $i < 5; $i++) {
                                                        $averageRating += ($i + 1) * $totalRatings[$i];
                                                    }
                                                    $averageRating /= $ratingCount;
                                                    $interpretation = getVerbalInterpretation($averageRating);
                                                } else {
                                                    // No ratings found for this instructor, APS is 0.00 and description is None
                                                    $averageRating = 0;
                                                    $interpretation = 'None';
                                                }
                                            } else {
                                                // If no records in `studentsform` for this instructor, set default values
                                                $averageRating = 0;
                                                $interpretation = 'None';
                                            }
                                        }

                                        // Add the data for this instructor to the array for Professionalism
                                        $instructorsData_Pro[] = [
                                            'facultyName' => $facultyName,
                                            'category' => $categories,
                                            'averageRating' => $averageRating,
                                            'interpretation' => $interpretation,
                                        ];
                                    }
                                }
                            } else {
                                echo "<tr><td colspan='4' style='text-align: center; color: red;'>No instructors found for Professionalism.</td></tr>";
                            }

                            // Sort the array for Professionalism by averageRating in descending order
                            usort($instructorsData_Pro, function ($a, $b) {
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
                                    // Add a counter for ranking
                                    $rank = 1;
                                    foreach ($instructorsData_Pro as $data) {
                                        echo '<tr>';
                                        echo '<td>' . $rank . '</td>';  // Display the current rank
                                        echo '<td>' . htmlspecialchars($data['facultyName']) . '</td>';
                                        echo '<td>' . number_format((float) $data['averageRating'], 2, '.', '') . '</td>';
                                        echo '<td>' . htmlspecialchars($data['interpretation']) . '</td>';
                                        echo '</tr>';
                                        $rank++;  // Increment the rank
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-interpersonalBehavior" role="tabpanel"
                        aria-labelledby="nav-interpersonalBehavior-tab">
                        <div class="container my-3 d-flex justify-content-center align-items-center ">
                            <?php
                            // Categories Query: Interpersonal Behavior
                            $sqlCategories_IB = "SELECT * FROM `facultycategories` WHERE categories = 'INTERPERSONAL BEHAVIOR'";
                            $sqlCategories_query_IB = mysqli_query($con, $sqlCategories_IB);

                            if (!$sqlCategories_query_IB) {
                                echo "Query failed for Interpersonal Behavior: " . mysqli_error($con); // Debugging query issues
                                exit;
                            }

                            // Initialize an array to hold all instructor data for Interpersonal Behavior
                            $instructorsData_IB = [];

                            // Ensure $usersql_query is properly initialized and contains faculty data
                            $usersql_query = mysqli_query($con, "SELECT * FROM `instructor`  WHERE status = 1"); // Adjust table name as needed
                            if (mysqli_num_rows($usersql_query) > 0) {
                                // Loop through all instructors
                                while ($userRow = mysqli_fetch_assoc($usersql_query)) {
                                    $FacultyID = $userRow['faculty_Id'];
                                    $facultyName = $userRow['first_name'] . ' ' . $userRow['last_name'];  // Assuming 'first_name' and 'last_name' exist
                            
                                    // Reset the query pointer for categories
                                    mysqli_data_seek($sqlCategories_query_IB, 0);

                                    // Loop through categories to get ratings for 'Interpersonal Behavior'
                                    while ($categoriesRow = mysqli_fetch_assoc($sqlCategories_query_IB)) {
                                        $categories = $categoriesRow['categories'];

                                        // Initialize variables for rating calculations
                                        $totalRatings = [0, 0, 0, 0, 0]; // [1, 2, 3, 4, 5]
                                        $ratingCount = 0;
                                        $averageRating = 0;
                                        $interpretation = 'None';

                                        $sqlcriteria = "SELECT * FROM `facultycriteria` WHERE facultyCategories = '$categories'";
                                        $resultCriteria = mysqli_query($con, $sqlcriteria);

                                        if (mysqli_num_rows($resultCriteria) > 0) {
                                            // Get ratings for the current faculty, semester, and academic year from peer-to-peer forms
                                            $SQLFaculty = "
                    SELECT * FROM `peertopeerform`
                    WHERE toFacultyID = '$FacultyID' 
                    AND semester = '$selectedSemester' 
                    AND academic_year = '$selectedAcademicYear'
                ";

                                            $SQLFaculty_query = mysqli_query($con, $SQLFaculty);

                                            if (mysqli_num_rows($SQLFaculty_query) > 0) {
                                                // Iterate through form results and process ratings
                                                while ($ratingRow = mysqli_fetch_assoc($SQLFaculty_query)) {
                                                    while ($criteriaRow = mysqli_fetch_assoc($resultCriteria)) {
                                                        $columnName = sanitizeColumnName($criteriaRow['facultyCategories']);
                                                        $finalColumnName = $columnName . $criteriaRow['id'];

                                                        $criteriaRating = $ratingRow[$finalColumnName] ?? null;

                                                        if ($criteriaRating !== null && $criteriaRating >= 1 && $criteriaRating <= 5) {
                                                            $totalRatings[$criteriaRating - 1]++;
                                                            $ratingCount++;
                                                        }
                                                    }
                                                    mysqli_data_seek($resultCriteria, 0);
                                                }

                                                // Only calculate the average if we have ratings
                                                if ($ratingCount > 0) {
                                                    for ($i = 0; $i < 5; $i++) {
                                                        $averageRating += ($i + 1) * $totalRatings[$i];
                                                    }
                                                    $averageRating /= $ratingCount;
                                                    $interpretation = getVerbalInterpretation($averageRating);
                                                } else {
                                                    // No ratings found for this instructor, APS is 0.00 and description is None
                                                    $averageRating = 0;
                                                    $interpretation = 'None';
                                                }
                                            } else {
                                                // If no records in `peertopeerform` for this instructor, set default values
                                                $averageRating = 0;
                                                $interpretation = 'None';
                                            }
                                        }

                                        // Add the data for this instructor to the array for Interpersonal Behavior
                                        $instructorsData_IB[] = [
                                            'facultyName' => $facultyName,
                                            'category' => $categories,
                                            'averageRating' => $averageRating,
                                            'interpretation' => $interpretation,
                                        ];
                                    }
                                }
                            } else {
                                echo "<tr><td colspan='4' style='text-align: center; color: red;'>No instructors found for Interpersonal Behavior.</td></tr>";
                            }

                            // Sort the array for Interpersonal Behavior by averageRating in descending order
                            usort($instructorsData_IB, function ($a, $b) {
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
                                    // Add a counter for ranking
                                    $rank = 1;
                                    foreach ($instructorsData_IB as $data) {
                                        echo '<tr>';
                                        echo '<td>' . $rank . '</td>';  // Display the current rank
                                        echo '<td>' . htmlspecialchars($data['facultyName']) . '</td>';
                                        echo '<td>' . number_format((float) $data['averageRating'], 2, '.', '') . '</td>';
                                        echo '<td>' . htmlspecialchars($data['interpretation']) . '</td>';
                                        echo '</tr>';
                                        $rank++;  // Increment the rank
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-workHabits" role="tabpanel" aria-labelledby="nav-workHabits-tab">
                        <div class="container my-3 d-flex justify-content-center align-items-center ">
                            <?php
                            // Categories Query: Work Habits
                            $sqlCategories_WH = "SELECT * FROM `facultycategories` WHERE categories = 'WORK HABITS'";
                            $sqlCategories_query_WH = mysqli_query($con, $sqlCategories_WH);

                            if (!$sqlCategories_query_WH) {
                                echo "Query failed for Work Habits: " . mysqli_error($con); // Debugging query issues
                                exit;
                            }

                            // Initialize an array to hold all instructor data for Work Habits
                            $instructorsData_WH = [];

                            // Ensure $usersql_query is properly initialized and contains faculty data
                            $usersql_query = mysqli_query($con, "SELECT * FROM `instructor`  WHERE status = 1"); // Adjust table name as needed
                            if (mysqli_num_rows($usersql_query) > 0) {
                                // Loop through all instructors
                                while ($userRow = mysqli_fetch_assoc($usersql_query)) {
                                    $FacultyID = $userRow['faculty_Id'];
                                    $facultyName = $userRow['first_name'] . ' ' . $userRow['last_name'];  // Assuming 'first_name' and 'last_name' exist
                            
                                    // Reset the query pointer for categories
                                    mysqli_data_seek($sqlCategories_query_WH, 0);

                                    // Loop through categories to get ratings for 'Work Habits'
                                    while ($categoriesRow = mysqli_fetch_assoc($sqlCategories_query_WH)) {
                                        $categories = $categoriesRow['categories'];

                                        // Initialize variables for rating calculations
                                        $totalRatings = [0, 0, 0, 0, 0]; // [1, 2, 3, 4, 5]
                                        $ratingCount = 0;
                                        $averageRating = 0;
                                        $interpretation = 'None';

                                        $sqlcriteria = "SELECT * FROM `facultycriteria` WHERE facultyCategories = '$categories'";
                                        $resultCriteria = mysqli_query($con, $sqlcriteria);

                                        if (mysqli_num_rows($resultCriteria) > 0) {
                                            // Get ratings for the current faculty, semester, and academic year from peer-to-peer forms
                                            $SQLFaculty = "
                    SELECT * FROM `peertopeerform`
                    WHERE toFacultyID = '$FacultyID' 
                    AND semester = '$selectedSemester' 
                    AND academic_year = '$selectedAcademicYear'
                ";

                                            $SQLFaculty_query = mysqli_query($con, $SQLFaculty);

                                            if (mysqli_num_rows($SQLFaculty_query) > 0) {
                                                // Iterate through form results and process ratings
                                                while ($ratingRow = mysqli_fetch_assoc($SQLFaculty_query)) {
                                                    while ($criteriaRow = mysqli_fetch_assoc($resultCriteria)) {
                                                        $columnName = sanitizeColumnName($criteriaRow['facultyCategories']);
                                                        $finalColumnName = $columnName . $criteriaRow['id'];

                                                        $criteriaRating = $ratingRow[$finalColumnName] ?? null;

                                                        if ($criteriaRating !== null && $criteriaRating >= 1 && $criteriaRating <= 5) {
                                                            $totalRatings[$criteriaRating - 1]++;
                                                            $ratingCount++;
                                                        }
                                                    }
                                                    mysqli_data_seek($resultCriteria, 0);
                                                }

                                                // Only calculate the average if we have ratings
                                                if ($ratingCount > 0) {
                                                    for ($i = 0; $i < 5; $i++) {
                                                        $averageRating += ($i + 1) * $totalRatings[$i];
                                                    }
                                                    $averageRating /= $ratingCount;
                                                    $interpretation = getVerbalInterpretation($averageRating);
                                                } else {
                                                    // No ratings found for this instructor, APS is 0.00 and description is None
                                                    $averageRating = 0;
                                                    $interpretation = 'None';
                                                }
                                            } else {
                                                // If no records in `peertopeerform` for this instructor, set default values
                                                $averageRating = 0;
                                                $interpretation = 'None';
                                            }
                                        }

                                        // Add the data for this instructor to the array for Work Habits
                                        $instructorsData_WH[] = [
                                            'facultyName' => $facultyName,
                                            'category' => $categories,
                                            'averageRating' => $averageRating,
                                            'interpretation' => $interpretation,
                                        ];
                                    }
                                }
                            } else {
                                echo "<tr><td colspan='4' style='text-align: center; color: red;'>No instructors found for Work Habits.</td></tr>";
                            }

                            // Sort the array for Work Habits by averageRating in descending order
                            usort($instructorsData_WH, function ($a, $b) {
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
                                    // Add a counter for ranking
                                    $rank = 1;
                                    foreach ($instructorsData_WH as $data) {
                                        echo '<tr>';
                                        echo '<td>' . $rank . '</td>';  // Display the current rank
                                        echo '<td>' . htmlspecialchars($data['facultyName']) . '</td>';
                                        echo '<td>' . number_format((float) $data['averageRating'], 2, '.', '') . '</td>';
                                        echo '<td>' . htmlspecialchars($data['interpretation']) . '</td>';
                                        echo '</tr>';
                                        $rank++;  // Increment the rank
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-teamwork" role="tabpanel" aria-labelledby="nav-teamwork-tab">
                        <div class="container my-3 d-flex justify-content-center align-items-center ">
                            <?php
                            // Categories Query: Teamwork
                            $sqlCategories_Teamwork = "SELECT * FROM `facultycategories` WHERE categories = 'TEAMWORK'";
                            $sqlCategories_query_Teamwork = mysqli_query($con, $sqlCategories_Teamwork);

                            if (!$sqlCategories_query_Teamwork) {
                                echo "Query failed for Teamwork: " . mysqli_error($con); // Debugging query issues
                                exit;
                            }

                            // Initialize an array to hold all instructor data for Teamwork
                            $instructorsData_Teamwork = [];

                            // Ensure $usersql_query is properly initialized and contains faculty data
                            $usersql_query = mysqli_query($con, "SELECT * FROM `instructor`  WHERE status = 1"); // Adjust table name as needed
                            if (mysqli_num_rows($usersql_query) > 0) {
                                // Loop through all instructors
                                while ($userRow = mysqli_fetch_assoc($usersql_query)) {
                                    $FacultyID = $userRow['faculty_Id'];
                                    $facultyName = $userRow['first_name'] . ' ' . $userRow['last_name'];  // Assuming 'first_name' and 'last_name' exist
                            
                                    // Reset the query pointer for categories
                                    mysqli_data_seek($sqlCategories_query_Teamwork, 0);

                                    // Loop through categories to get ratings for 'Teamwork'
                                    while ($categoriesRow = mysqli_fetch_assoc($sqlCategories_query_Teamwork)) {
                                        $categories = $categoriesRow['categories'];

                                        // Initialize variables for rating calculations
                                        $totalRatings = [0, 0, 0, 0, 0]; // [1, 2, 3, 4, 5]
                                        $ratingCount = 0;
                                        $averageRating = 0;
                                        $interpretation = 'None';

                                        $sqlcriteria = "SELECT * FROM `facultycriteria` WHERE facultyCategories = '$categories'";
                                        $resultCriteria = mysqli_query($con, $sqlcriteria);

                                        if (mysqli_num_rows($resultCriteria) > 0) {
                                            // Get ratings for the current faculty, semester, and academic year from peer-to-peer forms
                                            $SQLFaculty = "
                    SELECT * FROM `peertopeerform`
                    WHERE toFacultyID = '$FacultyID' 
                    AND semester = '$selectedSemester' 
                    AND academic_year = '$selectedAcademicYear'
                ";

                                            $SQLFaculty_query = mysqli_query($con, $SQLFaculty);

                                            if (mysqli_num_rows($SQLFaculty_query) > 0) {
                                                // Iterate through form results and process ratings
                                                while ($ratingRow = mysqli_fetch_assoc($SQLFaculty_query)) {
                                                    while ($criteriaRow = mysqli_fetch_assoc($resultCriteria)) {
                                                        $columnName = sanitizeColumnName($criteriaRow['facultyCategories']);
                                                        $finalColumnName = $columnName . $criteriaRow['id'];

                                                        $criteriaRating = $ratingRow[$finalColumnName] ?? null;

                                                        if ($criteriaRating !== null && $criteriaRating >= 1 && $criteriaRating <= 5) {
                                                            $totalRatings[$criteriaRating - 1]++;
                                                            $ratingCount++;
                                                        }
                                                    }
                                                    mysqli_data_seek($resultCriteria, 0);
                                                }

                                                // Only calculate the average if we have ratings
                                                if ($ratingCount > 0) {
                                                    for ($i = 0; $i < 5; $i++) {
                                                        $averageRating += ($i + 1) * $totalRatings[$i];
                                                    }
                                                    $averageRating /= $ratingCount;
                                                    $interpretation = getVerbalInterpretation($averageRating);
                                                } else {
                                                    // No ratings found for this instructor, APS is 0.00 and description is None
                                                    $averageRating = 0;
                                                    $interpretation = 'None';
                                                }
                                            } else {
                                                // If no records in `peertopeerform` for this instructor, set default values
                                                $averageRating = 0;
                                                $interpretation = 'None';
                                            }
                                        }

                                        // Add the data for this instructor to the array for Teamwork
                                        $instructorsData_Teamwork[] = [
                                            'facultyName' => $facultyName,
                                            'category' => $categories,
                                            'averageRating' => $averageRating,
                                            'interpretation' => $interpretation,
                                        ];
                                    }
                                }
                            } else {
                                echo "<tr><td colspan='4' style='text-align: center; color: red;'>No instructors found for Teamwork.</td></tr>";
                            }

                            // Sort the array for Teamwork by averageRating in descending order
                            usort($instructorsData_Teamwork, function ($a, $b) {
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
                                    // Add a counter for ranking
                                    $rank = 1;
                                    foreach ($instructorsData_Teamwork as $data) {
                                        echo '<tr>';
                                        echo '<td>' . $rank . '</td>';  // Display the current rank
                                        echo '<td>' . htmlspecialchars($data['facultyName']) . '</td>';
                                        echo '<td>' . number_format((float) $data['averageRating'], 2, '.', '') . '</td>';
                                        echo '<td>' . htmlspecialchars($data['interpretation']) . '</td>';
                                        echo '</tr>';
                                        $rank++;  // Increment the rank
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>

            </div>

        </div>

        <!-- Classroom Observation -->
        <div class="tab-pane fade" id="nav-classObservation" role="tabpanel" aria-labelledby="nav-classObservation-tab">

            <h2 class="text-center m-3">Classroom Observation Overall Ranking by Category</h2>

            <div class="container my-2">

                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-OverallLahatClass-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-OverallLahatClass" type="button" role="tab"
                            aria-controls="nav-OverallLahatClass" aria-selected="true">
                            OVERALL</button>
                        <button class="nav-link" id="nav-contentOrganization-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-contentOrganization" type="button" role="tab"
                            aria-controls="nav-contentOrganization" aria-selected="true">CONTENT ORGANIZATION</button>
                        <button class="nav-link" id="nav-presentation-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-presentation" type="button" role="tab" aria-controls="nav-presentation"
                            aria-selected="false">PRESENTATION</button>
                        <button class="nav-link" id="nav-isInteraction-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-isInteraction" type="button" role="tab"
                            aria-controls="nav-isInteraction" aria-selected="false">INSTRUCTIONS/STUDENT
                            INTERACTIONS</button>
                        <button class="nav-link" id="nav-ime-tab" data-bs-toggle="tab" data-bs-target="#nav-ime"
                            type="button" role="tab" aria-controls="nav-ime" aria-selected="false">INSTRUCTIONAL
                            MATERIALS AND
                            ENVIRONMENT</button>
                        <button class="nav-link" id="nav-ckr-tab" data-bs-toggle="tab" data-bs-target="#nav-ckr"
                            type="button" role="tab" aria-controls="nav-ckr" aria-selected="false">CONTENT KNOWLEDGE AND
                            RELEVANCE</button>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">

                    <div class="tab-pane fade show active" id="nav-OverallLahatClass" role="tabpanel"
                        aria-labelledby="nav-OverallLahatClass-tab">
                        <div class="d-flex justify-content-center my-2">
                            <button class="btn btn-success" onclick="printPartOfPage('overallClassroom')">Print</button>
                        </div>
                        <div class="container my-3 d-flex justify-content-center align-items-center flex-column"
                            id="overallClassroom">
                            <h3 style="text-align: center;">Classroom Observation Overall Ranking Academic Year
                                <?php echo $FDPRow['academic_year'] ?>,
                                <?php echo $FDPRow['semester'] ?> Semester
                            </h3>

                            <?php
                            // Query to fetch all categories
                            $categoriesQuery = "SELECT * FROM `classroomcategories`";
                            $categoriesResult = mysqli_query($con, $categoriesQuery);

                            if (!$categoriesResult) {
                                echo "Query failed for fetching categories: " . mysqli_error($con);
                                exit;
                            }

                            $instructorData = [];
                            $totalRatingSum = 0; // Initialize total rating sum
                            $totalRatingCount = 0; // Initialize total rating count
                            
                            // Query to fetch all instructors (even those with no ratings)
                            $instructorQuery = mysqli_query($con, "SELECT * FROM `instructor` WHERE status = 1");
                            if (mysqli_num_rows($instructorQuery) > 0) {
                                while ($instructorRow = mysqli_fetch_assoc($instructorQuery)) {
                                    $facultyId = $instructorRow['faculty_Id'];
                                    $facultyFullName = $instructorRow['first_name'] . ' ' . $instructorRow['last_name'];

                                    // Initialize an array for this instructor's ratings
                                    $instructorRatings = [
                                        'facultyFullName' => $facultyFullName,
                                        'facultyId' => $facultyId,
                                        'totalRatingSum' => 0,
                                        'totalRatingCount' => 0
                                    ];

                                    // Reset categories result set using mysqli_data_seek
                                    mysqli_data_seek($categoriesResult, 0); // Make sure $categoriesResult is used after the query has been executed
                            
                                    while ($categoryRow = mysqli_fetch_assoc($categoriesResult)) {
                                        $category = $categoryRow['categories'];

                                        // Initialize variables for category rating calculations
                                        $categoryRatingSum = 0;
                                        $categoryRatingCount = 0;

                                        // Get criteria for this category
                                        $criteriaQuery = "SELECT * FROM `classroomcriteria` WHERE classroomCategories = '$category'";
                                        $criteriaResult = mysqli_query($con, $criteriaQuery);

                                        if (mysqli_num_rows($criteriaResult) > 0) {
                                            $facultyRatingsQuery = "
                            SELECT * FROM `classroomobservation`
                            WHERE toFacultyID = '$facultyId' 
                            AND semester = '$selectedSemester' 
                            AND academic_year = '$selectedAcademicYear'
                        ";

                                            $facultyRatingsResult = mysqli_query($con, $facultyRatingsQuery);

                                            if (mysqli_num_rows($facultyRatingsResult) > 0) {
                                                // Process ratings for this instructor
                                                while ($ratingRow = mysqli_fetch_assoc($facultyRatingsResult)) {
                                                    while ($criteriaRow = mysqli_fetch_assoc($criteriaResult)) {
                                                        $columnName = sanitizeColumnName($criteriaRow['classroomCategories']);
                                                        $finalColumnName = $columnName . $criteriaRow['id'];

                                                        $rating = $ratingRow[$finalColumnName] ?? null;

                                                        if ($rating !== null && $rating >= 1 && $rating <= 5) {
                                                            $categoryRatingCount++;
                                                            $categoryRatingSum += $rating;
                                                        }
                                                    }
                                                    // Reset criteria result set
                                                    mysqli_data_seek($criteriaResult, 0);
                                                }

                                                // Calculate category average if ratings exist
                                                if ($categoryRatingCount > 0) {
                                                    $categoryAverage = $categoryRatingSum / $categoryRatingCount;

                                                    // Accumulate the instructor's total ratings and count
                                                    $instructorRatings['totalRatingSum'] += $categoryRatingSum;
                                                    $instructorRatings['totalRatingCount'] += $categoryRatingCount;
                                                }
                                            }
                                        }
                                    }

                                    // Calculate the average rating for the instructor (if there are ratings)
                                    if ($instructorRatings['totalRatingCount'] > 0) {
                                        $instructorRatings['averageRating'] = $instructorRatings['totalRatingSum'] / $instructorRatings['totalRatingCount'];
                                    } else {
                                        // If no ratings, set the average to 0
                                        $instructorRatings['averageRating'] = 0;
                                    }

                                    // Determine the verbal interpretation based on the average rating
                                    $ratingInterpretation = getVerbalInterpretation($instructorRatings['averageRating']);
                                    $instructorRatings['ratingInterpretation'] = $ratingInterpretation;

                                    // Add the aggregated data for this instructor to the instructorData array
                                    $instructorData[] = $instructorRatings;
                                }
                            } else {
                                echo "<tr><td colspan='4' style='text-align: center; color: red;'>No instructors found.</td></tr>";
                            }

                            // Sort the array by averageRating in descending order
                            usort($instructorData, function ($a, $b) {
                                return $b['averageRating'] <=> $a['averageRating'];  // Descending order
                            });

                            // Calculate the global average across all categories and instructors
                            $globalAverage = 0;
                            if ($totalRatingCount > 0) {
                                $globalAverage = $totalRatingSum / $totalRatingCount;
                            }
                            ?>
                            <!-- Render the instructor data table -->
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
                                    if (empty($instructorData)) {
                                        echo "<tr><td colspan='4' style='text-align: center; color: red;'>No data to display.</td></tr>";
                                    } else {
                                        $ranking = 1;
                                        foreach ($instructorData as $data) {
                                            echo '<tr>';
                                            echo '<td>' . $ranking . '</td>';  // Display the current rank
                                            echo '<td>' . htmlspecialchars($data['facultyFullName']) . '</td>';
                                            echo '<td>' . number_format((float) $data['averageRating'], 2, '.', '') . '</td>';
                                            echo '<td>' . htmlspecialchars($data['ratingInterpretation']) . '</td>';
                                            echo '</tr>';
                                            $ranking++;  // Increment the ranking
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>

                    <div class="tab-pane fade " id="nav-contentOrganization" role="tabpanel"
                        aria-labelledby="nav-contentOrganization-tab">
                        <div class="container my-3 d-flex justify-content-center align-items-center ">
                            <?php
                            // Categories Query: Content Organization
                            $sqlCategories_Content = "SELECT * FROM `classroomcategories` WHERE categories = 'CONTENT ORGANIZATION'";
                            $sqlCategories_query_Content = mysqli_query($con, $sqlCategories_Content);

                            if (!$sqlCategories_query_Content) {
                                echo "Query failed for Content Organization: " . mysqli_error($con); // Debugging query issues
                                exit;
                            }

                            // Initialize an array to hold all instructor data for Content Organization
                            $instructorsData_Content = [];

                            // Ensure $usersql_query is properly initialized and contains faculty data
                            $usersql_query = mysqli_query($con, "SELECT * FROM `instructor` WHERE userType = 'faculty' AND status = 1"); // Adjust table name as needed
                            if (mysqli_num_rows($usersql_query) > 0) {
                                // Loop through all instructors
                                while ($userRow = mysqli_fetch_assoc($usersql_query)) {
                                    $FacultyID = $userRow['faculty_Id'];
                                    $facultyName = $userRow['first_name'] . ' ' . $userRow['last_name'];

                                    // Reset the query pointer for categories
                                    mysqli_data_seek($sqlCategories_query_Content, 0);

                                    // Loop through categories to get ratings for 'Content Organization'
                                    while ($categoriesRow = mysqli_fetch_assoc($sqlCategories_query_Content)) {
                                        $categories = $categoriesRow['categories'];

                                        // Initialize variables for rating calculations
                                        $totalRatings = [0, 0, 0, 0, 0];
                                        $ratingCount = 0;
                                        $averageRating = 0;
                                        $interpretation = 'None';

                                        $sqlcriteria = "SELECT * FROM `classroomcriteria` WHERE classroomCategories = '$categories'";
                                        $resultCriteria = mysqli_query($con, $sqlcriteria);

                                        if (mysqli_num_rows($resultCriteria) > 0) {
                                            // Get ratings for the current faculty, semester, and academic year from peertopeerform
                                            $SQLFaculty = "
                                                SELECT * FROM `classroomobservation`
                                                WHERE toFacultyID = '$FacultyID' 
                                                AND semester = '$selectedSemesterclass' 
                                                AND academic_year = '$selectedAcademicYearclass'
                                            ";

                                            $SQLFaculty_query = mysqli_query($con, $SQLFaculty);

                                            if (mysqli_num_rows($SQLFaculty_query) > 0) {
                                                // Iterate through form results and process ratings
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

                                                // Only calculate the average if we have ratings
                                                if ($ratingCount > 0) {
                                                    for ($i = 0; $i < 5; $i++) {
                                                        $averageRating += ($i + 1) * $totalRatings[$i];
                                                    }
                                                    $averageRating /= $ratingCount;
                                                    $interpretation = getVerbalInterpretation($averageRating);
                                                } else {
                                                    $averageRating = 0;
                                                    $interpretation = 'None';
                                                }
                                            } else {
                                                $averageRating = 0;
                                                $interpretation = 'None';
                                            }
                                        }

                                        // Add the data for this instructor to the array for Content Organization
                                        $instructorsData_Content[] = [
                                            'facultyName' => $facultyName,
                                            'category' => $categories,
                                            'averageRating' => $averageRating,
                                            'interpretation' => $interpretation,
                                        ];
                                    }
                                }
                            } else {
                                echo "<tr><td colspan='4' style='text-align: center; color: red;'>No instructors found for Content Organization.</td></tr>";
                            }

                            // Sort the array for Content Organization by averageRating in descending order
                            usort($instructorsData_Content, function ($a, $b) {
                                return $b['averageRating'] <=> $a['averageRating'];  // Descending order
                            });
                            ?>

                            <!-- Render the results in a table for Content Organization -->
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
                                    // Add a counter for ranking
                                    $rank = 1;
                                    foreach ($instructorsData_Content as $data) {
                                        echo '<tr>';
                                        echo '<td>' . $rank . '</td>';  // Display the current rank
                                        echo '<td>' . htmlspecialchars($data['facultyName']) . '</td>';
                                        echo '<td>' . number_format((float) $data['averageRating'], 2, '.', '') . '</td>';
                                        echo '<td>' . htmlspecialchars($data['interpretation']) . '</td>';
                                        echo '</tr>';
                                        $rank++;  // Increment the rank
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-presentation" role="tabpanel"
                        aria-labelledby="nav-presentation-tab">
                        <div class="container my-3 d-flex justify-content-center align-items-center ">
                            <?php
                            // Categories Query: Presentation
                            $sqlCategories_Presentation = "SELECT * FROM `classroomcategories` WHERE categories = 'PRESENTATION'";
                            $sqlCategories_query_Presentation = mysqli_query($con, $sqlCategories_Presentation);

                            if (!$sqlCategories_query_Presentation) {
                                echo "Query failed for Presentation: " . mysqli_error($con);
                                exit;
                            }

                            // Initialize an array to hold all instructor data for Presentation
                            $instructorsData_Presentation = [];

                            // Ensure $usersql_query is properly initialized and contains faculty data
                            $usersql_query = mysqli_query($con, "SELECT * FROM `instructor` WHERE userType = 'faculty'  AND status = 1");
                            if (mysqli_num_rows($usersql_query) > 0) {
                                // Loop through all instructors
                                while ($userRow = mysqli_fetch_assoc($usersql_query)) {
                                    $FacultyID = $userRow['faculty_Id'];
                                    $facultyName = $userRow['first_name'] . ' ' . $userRow['last_name'];

                                    // Reset the query pointer for categories
                                    mysqli_data_seek($sqlCategories_query_Presentation, 0);

                                    // Loop through categories to get ratings for 'Presentation'
                                    while ($categoriesRow = mysqli_fetch_assoc($sqlCategories_query_Presentation)) {
                                        $categories = $categoriesRow['categories'];

                                        // Initialize variables for rating calculations
                                        $totalRatings = [0, 0, 0, 0, 0];
                                        $ratingCount = 0;
                                        $averageRating = 0;
                                        $interpretation = 'None';

                                        $sqlcriteria = "SELECT * FROM `classroomcriteria` WHERE classroomCategories = '$categories'";
                                        $resultCriteria = mysqli_query($con, $sqlcriteria);

                                        if (mysqli_num_rows($resultCriteria) > 0) {
                                            // Get ratings for the current faculty, semester, and academic year from classroomobservation
                                            $SQLFaculty = "
                                                SELECT * FROM `classroomobservation`
                                                WHERE toFacultyID = '$FacultyID' 
                                                AND semester = '$selectedSemesterclass' 
                                                AND academic_year = '$selectedAcademicYearclass'
                                            ";

                                            $SQLFaculty_query = mysqli_query($con, $SQLFaculty);

                                            if (mysqli_num_rows($SQLFaculty_query) > 0) {
                                                // Iterate through form results and process ratings
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

                                                // Only calculate the average if we have ratings
                                                if ($ratingCount > 0) {
                                                    for ($i = 0; $i < 5; $i++) {
                                                        $averageRating += ($i + 1) * $totalRatings[$i];
                                                    }
                                                    $averageRating /= $ratingCount;
                                                    $interpretation = getVerbalInterpretation($averageRating);
                                                } else {
                                                    $averageRating = 0;
                                                    $interpretation = 'None';
                                                }
                                            } else {
                                                $averageRating = 0;
                                                $interpretation = 'None';
                                            }
                                        }

                                        // Add the data for this instructor to the array for Presentation
                                        $instructorsData_Presentation[] = [
                                            'facultyName' => $facultyName,
                                            'category' => $categories,
                                            'averageRating' => $averageRating,
                                            'interpretation' => $interpretation,
                                        ];
                                    }
                                }
                            } else {
                                echo "<tr><td colspan='4' style='text-align: center; color: red;'>No instructors found for Presentation.</td></tr>";
                            }

                            // Sort the array for Presentation by averageRating in descending order
                            usort($instructorsData_Presentation, function ($a, $b) {
                                return $b['averageRating'] <=> $a['averageRating'];
                            });
                            ?>

                            <!-- Render the results in a table for Presentation -->
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
                                    // Add a counter for ranking
                                    $rank = 1;
                                    foreach ($instructorsData_Presentation as $data) {
                                        echo '<tr>';
                                        echo '<td>' . $rank . '</td>';
                                        echo '<td>' . htmlspecialchars($data['facultyName']) . '</td>';
                                        echo '<td>' . number_format((float) $data['averageRating'], 2, '.', '') . '</td>';
                                        echo '<td>' . htmlspecialchars($data['interpretation']) . '</td>';
                                        echo '</tr>';
                                        $rank++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-isInteraction" role="tabpanel"
                        aria-labelledby="nav-isInteraction-tab">
                        <div class="container my-3 d-flex justify-content-center align-items-center ">
                            <?php
                            // Categories Query: Instructions/Student Interactions
                            $sqlCategories_Instructions = "SELECT * FROM `classroomcategories` WHERE categories = 'INSTRUCTIONS/STUDENT INTERACTIONS'";
                            $sqlCategories_query_Instructions = mysqli_query($con, $sqlCategories_Instructions);

                            if (!$sqlCategories_query_Instructions) {
                                echo "Query failed for Instructions/Student Interactions: " . mysqli_error($con);
                                exit;
                            }

                            // Initialize an array to hold all instructor data for Instructions/Student Interactions
                            $instructorsData_Instructions = [];

                            // Ensure $usersql_query is properly initialized and contains faculty data
                            $usersql_query = mysqli_query($con, "SELECT * FROM `instructor` WHERE userType = 'faculty'  AND status = 1");
                            if (mysqli_num_rows($usersql_query) > 0) {
                                // Loop through all instructors
                                while ($userRow = mysqli_fetch_assoc($usersql_query)) {
                                    $FacultyID = $userRow['faculty_Id'];
                                    $facultyName = $userRow['first_name'] . ' ' . $userRow['last_name'];

                                    // Reset the query pointer for categories
                                    mysqli_data_seek($sqlCategories_query_Instructions, 0);

                                    // Loop through categories to get ratings for 'Instructions/Student Interactions'
                                    while ($categoriesRow = mysqli_fetch_assoc($sqlCategories_query_Instructions)) {
                                        $categories = $categoriesRow['categories'];

                                        // Initialize variables for rating calculations
                                        $totalRatings = [0, 0, 0, 0, 0];
                                        $ratingCount = 0;
                                        $averageRating = 0;
                                        $interpretation = 'None';

                                        $sqlcriteria = "SELECT * FROM `classroomcriteria` WHERE classroomCategories = '$categories'";
                                        $resultCriteria = mysqli_query($con, $sqlcriteria);

                                        if (mysqli_num_rows($resultCriteria) > 0) {
                                            // Get ratings for the current faculty, semester, and academic year from classroomobservation
                                            $SQLFaculty = "
                SELECT * FROM `classroomobservation`
                WHERE toFacultyID = '$FacultyID' 
                AND semester = '$selectedSemesterclass' 
                AND academic_year = '$selectedAcademicYearclass'
            ";

                                            $SQLFaculty_query = mysqli_query($con, $SQLFaculty);

                                            if (mysqli_num_rows($SQLFaculty_query) > 0) {
                                                // Iterate through form results and process ratings
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

                                                // Only calculate the average if we have ratings
                                                if ($ratingCount > 0) {
                                                    for ($i = 0; $i < 5; $i++) {
                                                        $averageRating += ($i + 1) * $totalRatings[$i];
                                                    }
                                                    $averageRating /= $ratingCount;
                                                    $interpretation = getVerbalInterpretation($averageRating);
                                                } else {
                                                    $averageRating = 0;
                                                    $interpretation = 'None';
                                                }
                                            } else {
                                                $averageRating = 0;
                                                $interpretation = 'None';
                                            }
                                        }

                                        // Add the data for this instructor to the array for Instructions/Student Interactions
                                        $instructorsData_Instructions[] = [
                                            'facultyName' => $facultyName,
                                            'category' => $categories,
                                            'averageRating' => $averageRating,
                                            'interpretation' => $interpretation,
                                        ];
                                    }
                                }
                            } else {
                                echo "<tr><td colspan='4' style='text-align: center; color: red;'>No instructors found for Instructions/Student Interactions.</td></tr>";
                            }

                            // Sort the array for Instructions/Student Interactions by averageRating in descending order
                            usort($instructorsData_Instructions, function ($a, $b) {
                                return $b['averageRating'] <=> $a['averageRating'];
                            });
                            ?>

                            <!-- Render the results in a table for Instructions/Student Interactions -->
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
                                    // Add a counter for ranking
                                    $rank = 1;
                                    foreach ($instructorsData_Instructions as $data) {
                                        echo '<tr>';
                                        echo '<td>' . $rank . '</td>';
                                        echo '<td>' . htmlspecialchars($data['facultyName']) . '</td>';
                                        echo '<td>' . number_format((float) $data['averageRating'], 2, '.', '') . '</td>';
                                        echo '<td>' . htmlspecialchars($data['interpretation']) . '</td>';
                                        echo '</tr>';
                                        $rank++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-ime" role="tabpanel" aria-labelledby="nav-ime-tab">
                        <div class="container my-3 d-flex justify-content-center align-items-center ">
                            <?php
                            // Categories Query: Instructional Materials and Environment
                            $sqlCategories_Materials = "SELECT * FROM `classroomcategories` WHERE categories = 'INSTRUCTIONAL MATERIALS AND ENVIRONMENT'";
                            $sqlCategories_query_Materials = mysqli_query($con, $sqlCategories_Materials);

                            if (!$sqlCategories_query_Materials) {
                                echo "Query failed for Instructional Materials and Environment: " . mysqli_error($con);
                                exit;
                            }

                            // Initialize an array to hold all instructor data for Instructional Materials and Environment
                            $instructorsData_Materials = [];

                            // Ensure $usersql_query is properly initialized and contains faculty data
                            $usersql_query = mysqli_query($con, "SELECT * FROM `instructor` WHERE userType = 'faculty'  AND status = 1");
                            if (mysqli_num_rows($usersql_query) > 0) {
                                // Loop through all instructors
                                while ($userRow = mysqli_fetch_assoc($usersql_query)) {
                                    $FacultyID = $userRow['faculty_Id'];
                                    $facultyName = $userRow['first_name'] . ' ' . $userRow['last_name'];

                                    // Reset the query pointer for categories
                                    mysqli_data_seek($sqlCategories_query_Materials, 0);

                                    // Loop through categories to get ratings for 'Instructional Materials and Environment'
                                    while ($categoriesRow = mysqli_fetch_assoc($sqlCategories_query_Materials)) {
                                        $categories = $categoriesRow['categories'];

                                        // Initialize variables for rating calculations
                                        $totalRatings = [0, 0, 0, 0, 0];
                                        $ratingCount = 0;
                                        $averageRating = 0;
                                        $interpretation = 'None';

                                        $sqlcriteria = "SELECT * FROM `classroomcriteria` WHERE classroomCategories = '$categories'";
                                        $resultCriteria = mysqli_query($con, $sqlcriteria);

                                        if (mysqli_num_rows($resultCriteria) > 0) {
                                            // Get ratings for the current faculty, semester, and academic year from classroomobservation
                                            $SQLFaculty = "
                                                SELECT * FROM `classroomobservation`
                                                WHERE toFacultyID = '$FacultyID' 
                                                AND semester = '$selectedSemesterclass' 
                                                AND academic_year = '$selectedAcademicYearclass'
                                            ";

                                            $SQLFaculty_query = mysqli_query($con, $SQLFaculty);

                                            if (mysqli_num_rows($SQLFaculty_query) > 0) {
                                                // Iterate through form results and process ratings
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

                                                // Only calculate the average if we have ratings
                                                if ($ratingCount > 0) {
                                                    for ($i = 0; $i < 5; $i++) {
                                                        $averageRating += ($i + 1) * $totalRatings[$i];
                                                    }
                                                    $averageRating /= $ratingCount;
                                                    $interpretation = getVerbalInterpretation($averageRating);
                                                } else {
                                                    $averageRating = 0;
                                                    $interpretation = 'None';
                                                }
                                            } else {
                                                $averageRating = 0;
                                                $interpretation = 'None';
                                            }
                                        }

                                        // Add the data for this instructor to the array for Instructional Materials and Environment
                                        $instructorsData_Materials[] = [
                                            'facultyName' => $facultyName,
                                            'category' => $categories,
                                            'averageRating' => $averageRating,
                                            'interpretation' => $interpretation,
                                        ];
                                    }
                                }
                            } else {
                                echo "<tr><td colspan='4' style='text-align: center; color: red;'>No instructors found for Instructional Materials and Environment.</td></tr>";
                            }

                            // Sort the array for Instructional Materials and Environment by averageRating in descending order
                            usort($instructorsData_Materials, function ($a, $b) {
                                return $b['averageRating'] <=> $a['averageRating'];
                            });
                            ?>

                            <!-- Render the results in a table for Instructional Materials and Environment -->
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
                                    // Add a counter for ranking
                                    $rank = 1;
                                    foreach ($instructorsData_Materials as $data) {
                                        echo '<tr>';
                                        echo '<td>' . $rank . '</td>';
                                        echo '<td>' . htmlspecialchars($data['facultyName']) . '</td>';
                                        echo '<td>' . number_format((float) $data['averageRating'], 2, '.', '') . '</td>';
                                        echo '<td>' . htmlspecialchars($data['interpretation']) . '</td>';
                                        echo '</tr>';
                                        $rank++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-ckr" role="tabpanel" aria-labelledby="nav-ckr-tab">
                        <div class="container my-3 d-flex justify-content-center align-items-center ">
                            <?php
                            // Categories Query: Content Knowledge and Relevance
                            $sqlCategories_Knowledge = "SELECT * FROM `classroomcategories` WHERE categories = 'CONTENT KNOWLEDGE AND RELEVANCE'";
                            $sqlCategories_query_Knowledge = mysqli_query($con, $sqlCategories_Knowledge);

                            if (!$sqlCategories_query_Knowledge) {
                                echo "Query failed for Content Knowledge and Relevance: " . mysqli_error($con);
                                exit;
                            }

                            // Initialize an array to hold all instructor data for Content Knowledge and Relevance
                            $instructorsData_Knowledge = [];

                            // Ensure $usersql_query is properly initialized and contains faculty data
                            $usersql_query = mysqli_query($con, "SELECT * FROM `instructor` WHERE userType = 'faculty'  AND status = 1");
                            if (mysqli_num_rows($usersql_query) > 0) {
                                // Loop through all instructors
                                while ($userRow = mysqli_fetch_assoc($usersql_query)) {
                                    $FacultyID = $userRow['faculty_Id'];
                                    $facultyName = $userRow['first_name'] . ' ' . $userRow['last_name'];

                                    // Reset the query pointer for categories
                                    mysqli_data_seek($sqlCategories_query_Knowledge, 0);

                                    // Loop through categories to get ratings for 'Content Knowledge and Relevance'
                                    while ($categoriesRow = mysqli_fetch_assoc($sqlCategories_query_Knowledge)) {
                                        $categories = $categoriesRow['categories'];

                                        // Initialize variables for rating calculations
                                        $totalRatings = [0, 0, 0, 0, 0];
                                        $ratingCount = 0;
                                        $averageRating = 0;
                                        $interpretation = 'None';

                                        $sqlcriteria = "SELECT * FROM `classroomcriteria` WHERE classroomCategories = '$categories'";
                                        $resultCriteria = mysqli_query($con, $sqlcriteria);

                                        if (mysqli_num_rows($resultCriteria) > 0) {
                                            // Get ratings for the current faculty, semester, and academic year from classroomobservation
                                            $SQLFaculty = "
                                                SELECT * FROM `classroomobservation`
                                                WHERE toFacultyID = '$FacultyID' 
                                                AND semester = '$selectedSemesterclass' 
                                                AND academic_year = '$selectedAcademicYearclass'
                                            ";

                                            $SQLFaculty_query = mysqli_query($con, $SQLFaculty);

                                            if (mysqli_num_rows($SQLFaculty_query) > 0) {
                                                // Iterate through form results and process ratings
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

                                                // Only calculate the average if we have ratings
                                                if ($ratingCount > 0) {
                                                    for ($i = 0; $i < 5; $i++) {
                                                        $averageRating += ($i + 1) * $totalRatings[$i];
                                                    }
                                                    $averageRating /= $ratingCount;
                                                    $interpretation = getVerbalInterpretation($averageRating);
                                                } else {
                                                    $averageRating = 0;
                                                    $interpretation = 'None';
                                                }
                                            } else {
                                                $averageRating = 0;
                                                $interpretation = 'None';
                                            }
                                        }

                                        // Add the data for this instructor to the array for Content Knowledge and Relevance
                                        $instructorsData_Knowledge[] = [
                                            'facultyName' => $facultyName,
                                            'category' => $categories,
                                            'averageRating' => $averageRating,
                                            'interpretation' => $interpretation,
                                        ];
                                    }
                                }
                            } else {
                                echo "<tr><td colspan='4' style='text-align: center; color: red;'>No instructors found for Content Knowledge and Relevance.</td></tr>";
                            }

                            // Sort the array for Content Knowledge and Relevance by averageRating in descending order
                            usort($instructorsData_Knowledge, function ($a, $b) {
                                return $b['averageRating'] <=> $a['averageRating'];
                            });
                            ?>

                            <!-- Render the results in a table for Content Knowledge and Relevance -->
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
                                    // Add a counter for ranking
                                    $rank = 1;
                                    foreach ($instructorsData_Knowledge as $data) {
                                        echo '<tr>';
                                        echo '<td>' . $rank . '</td>';
                                        echo '<td>' . htmlspecialchars($data['facultyName']) . '</td>';
                                        echo '<td>' . number_format((float) $data['averageRating'], 2, '.', '') . '</td>';
                                        echo '<td>' . htmlspecialchars($data['interpretation']) . '</td>';
                                        echo '</tr>';
                                        $rank++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- SWEETALERT -->
<?php if (isset($_SESSION['success'])): ?>
    <script>
        Swal.fire({
            title: 'Success!',
            text: '<?php echo $_SESSION['success']; ?>',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.reload();
        });
    </script>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<script>
    function printPartOfPage(elementId) {
        var printContent = document.getElementById(elementId);
        var windowUrl = 'about:blank';
        var uniqueName = new Date();
        var windowName = 'Print' + uniqueName.getTime();
        var printWindow = window.open(windowUrl, windowName, 'width=1000,height=1000');
        // th:last-child,
        // td:last-child {
        //     display: none !important;
        // }
        printWindow.document.write(`
        <!DOCTYPE html>
        <html>
            <head>
                <title>Print</title>
                <style>
                .headerPrint {
                    display: flex;
                    justify-content: space-evenly;
                }
                    table {
                        width:100% !important;
                        border-collapse: collapse !important;
                        text-align: center !important;
                    }
                    table tr {
                        background-color: white !important;
                        color: black !important;
                    }
                    th, td  {
                        border: 1px solid black !important;
                        padding: 5px;
                    }
                    .ulo {
                        width: 100% !important;
                        display: flex !important;
                        justify-content:  space-evenly !important;
                    }
                    .ulo h5 {
                        font-size: 18px !important;
                        text-align: center !important;   
                    }
                </style>
            </head>
            <body>
            <div class="headerPrint" style="margin-bottom: 10px;">
                <div>
                    <img src="../../public/picture/cics.png" style="width: 65px; height: 65px;">
                </div>
                <div>
                    <img src="../../public/picture/bsu.png" style="width: 70px; height: 70px;">
                </div>
            </div>

                ${printContent.innerHTML}
                          
            </body>
        </html>
    `);
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();

        printWindow.close();
    }
</script>