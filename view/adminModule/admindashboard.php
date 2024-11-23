<?php
include "components/navBar.php";

include "../../model/dbconnection.php";


$sqlSAY = "SELECT * FROM `academic_year_semester`";
$sqlSAY_query = mysqli_query($con, $sqlSAY);
$SAY = mysqli_fetch_assoc($sqlSAY_query);

$nowSemester = $SAY['semester'];
$nowAcademicYear = $SAY['academic_year'];

$userId = $userRow['faculty_Id'];
$result = $con->query("SELECT cell_value FROM vcaaexcel WHERE faculty_Id = '$userId' AND semester = '$nowSemester' AND academic_year = '$nowAcademicYear' LIMIT 1");

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $average = (float) $row['cell_value'];
} else {
    $average = 0;
}

function getFinalAverageRating($facultyID, $semester, $academic_year, $selectedSubject, $con)
{
    $totalAverage = 0;
    $categoryCount = 0;

    $sql = "SELECT * FROM `studentscategories`";
    $sql_query = mysqli_query($con, $sql);

    while ($categoriesRow = mysqli_fetch_assoc($sql_query)) {
        $categories = $categoriesRow['categories'];
        $totalRatings = [0, 0, 0, 0, 0];
        $ratingCount = 0;

        $sqlcriteria = "SELECT * FROM `studentscriteria` WHERE studentsCategories = '$categories'";
        $resultCriteria = mysqli_query($con, $sqlcriteria);

        $SQLFaculty = "SELECT * FROM `studentsform` WHERE toFacultyID = '$facultyID' AND semester = '$semester' AND academic_year = '$academic_year' AND subject = '$selectedSubject' ";
        $SQLFaculty_query = mysqli_query($con, $SQLFaculty);

        while ($ratingRow = mysqli_fetch_assoc($SQLFaculty_query)) {
            while ($criteriaRow = mysqli_fetch_assoc($resultCriteria)) {
                $columnName = sanitizeColumnName($criteriaRow['studentsCategories']);
                $finalColumnName = $columnName . $criteriaRow['id'];
                $criteriaRating = $ratingRow[$finalColumnName] ?? null;

                if ($criteriaRating >= 1 && $criteriaRating <= 5) {
                    $totalRatings[$criteriaRating - 1]++;
                    $ratingCount++;
                }
            }
            mysqli_data_seek($resultCriteria, 0);
        }

        if ($ratingCount > 0) {
            $averageRating = array_sum(array_map(function ($count, $index) {
                return ($index + 1) * $count;
            }, $totalRatings, array_keys($totalRatings))) / $ratingCount;

            $totalAverage += $averageRating;
            $categoryCount++;
        }
    }

    return $categoryCount > 0 ? round($totalAverage / $categoryCount, 2) : 0;
}

$sqlSubject = "SELECT i.faculty_Id, s.subject 
                FROM instructor i
                JOIN assigned_subject a ON i.faculty_Id = a.faculty_Id
                JOIN subject s ON a.subject_id = s.subject_id
                WHERE i.faculty_Id = " . $userRow['faculty_Id'];

$sqlSubject_query = mysqli_query($con, $sqlSubject);
$subjectsData = [];
$averagesData = [];

while ($subject = mysqli_fetch_assoc($sqlSubject_query)) {
    $selectedSubject = $subject['subject'];

    $sqlSAY = "SELECT * FROM `academic_year_semester`";
    $sqlSAY_query = mysqli_query($con, $sqlSAY);
    if ($SQY = mysqli_fetch_assoc($sqlSAY_query)) {
        $semester = $SQY['semester'];
        $academic_year = $SQY['academic_year'];
        $finalAverageRating = getFinalAverageRating($userRow['faculty_Id'], $semester, $academic_year, $selectedSubject, $con);

        if (is_numeric($finalAverageRating)) {
            $finalAverageRating = $finalAverageRating ?? 0;
            $average = $average ?? 0;

            $combinedAverage = ($finalAverageRating + $average) / 2;

            $stmt = $con->prepare("SELECT * FROM faculty_averages WHERE semester = ? AND academic_year = ? AND faculty_Id = ? AND subject = ? LIMIT 1");
            $stmt->bind_param("ssis", $semester, $academic_year, $userRow['faculty_Id'], $selectedSubject);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                $updateSql = "UPDATE faculty_averages SET combined_average = ? WHERE id = ?";
                $updateStmt = $con->prepare($updateSql);
                $updateStmt->bind_param("di", $combinedAverage, $row['id']);
                $updateStmt->execute();
                $updateStmt->close();
            } else {
                $insertSql = "INSERT INTO faculty_averages (faculty_Id, subject, combined_average, semester, academic_year) VALUES (?, ?, ?, ?, ?)";
                $insertStmt = $con->prepare($insertSql);
                $insertStmt->bind_param("issss", $userRow['faculty_Id'], $selectedSubject, $combinedAverage, $semester, $academic_year);
                $insertStmt->execute();
                $insertStmt->close();
            }

            $subjectsData[] = $selectedSubject;
            $averagesData[] = $combinedAverage;
        }
    }
}

$faculty_Id = mysqli_real_escape_string($con, $_SESSION["userid"]);
$sql = "SELECT subject, combined_average, semester, academic_year FROM faculty_averages WHERE faculty_Id = '$faculty_Id' ORDER BY academic_year, semester ";
$result = mysqli_query($con, $sql);

$semesters = [];
$subjectData = [];

while ($row = mysqli_fetch_assoc($result)) {
    $subject = $row['subject'];
    $semesterYear = $row['semester'] . ' ' . $row['academic_year'];

    // Skip rows where 'combined_average' is null or empty
    if (empty($row['combined_average'])) {
        continue;
    }

    // Add semesterYear to semesters array if not already present
    if (!in_array($semesterYear, $semesters)) {
        $semesters[] = $semesterYear;
    }

    // Initialize subjectData for the current subject if not already set
    if (!isset($subjectData[$subject])) {
        $subjectData[$subject] = array_fill(0, count($semesters), null);
    }

    // Ensure subjectData arrays align with the length of the semesters array
    foreach ($subjectData as $subj => $data) {
        if (count($data) < count($semesters)) {
            $subjectData[$subj] = array_pad($subjectData[$subj], count($semesters), null);
        }
    }

    // Find the index of the current semesterYear and assign the combined_average
    $index = array_search($semesterYear, $semesters);
    if ($index !== false) {
        $subjectData[$subject][$index] = (float) $row['combined_average'];
    }
}


$subjectsJson = json_encode(array_keys($subjectData));
$subjectDataJson = json_encode($subjectData);
$semestersJson = json_encode($semesters);

?>
<?php

include "../../model/dbconnection.php";

$usersqlStudentsForm = "SELECT * FROM `instructor`";
$usersql_queryStudentsForm = mysqli_query($con, $usersqlStudentsForm);
if (!$usersql_queryStudentsForm) {
    echo "Query failed: " . mysqli_error($con);
    exit;
}

function sanitizeColumnName($name)
{
    return preg_replace('/[^a-zA-Z0-9_]/', '', trim($name));
}

function getVerbalInterpretation($averageRatingStudentsForm): string
{
    if ($averageRatingStudentsForm < 0 || $averageRatingStudentsForm > 5) {
        return 'No description';
    }

    $interpretations = ['None', 'Poor', 'Fair', 'Satisfactory', 'Very Satisfactory', 'Outstanding'];
    return $interpretations[(int) $averageRatingStudentsForm];
}

$sqlCategoriesStudentsForm = "SELECT * FROM `studentscategories`";
$sqlCategories_queryStudentsForm = mysqli_query($con, $sqlCategoriesStudentsForm);
if (!$sqlCategories_queryStudentsForm) {
    echo "Query failed: " . mysqli_error($con);
    exit;
}

$categoryAveragesStudentsForm = [];

if (mysqli_num_rows($usersql_queryStudentsForm) > 0) {
    while ($userRow = mysqli_fetch_assoc($usersql_queryStudentsForm)) {
        $FacultyID = $userRow['faculty_Id'];

        mysqli_data_seek($sqlCategories_queryStudentsForm, 0);

        while ($categoriesRow = mysqli_fetch_assoc($sqlCategories_queryStudentsForm)) {
            $category = $categoriesRow['categories'];

            $sqlRatingsStudentsForm = "
                SELECT semester, academic_year, studentsform.* 
                FROM `studentsform`
                WHERE toFacultyID = '$FacultyID' 
                ORDER BY academic_year ASC
            ";
            $ratingsQuery = mysqli_query($con, $sqlRatingsStudentsForm);

            if (mysqli_num_rows($ratingsQuery) > 0) {
                while ($ratingRow = mysqli_fetch_assoc($ratingsQuery)) {
                    $semesterStudentsForm = $ratingRow['semester'];
                    $academicYearStudentsForm = $ratingRow['academic_year'];

                    if (!isset($categoryAveragesStudentsForm[$category][$academicYearStudentsForm][$semesterStudentsForm])) {
                        $categoryAveragesStudentsForm[$category][$academicYearStudentsForm][$semesterStudentsForm] = [
                            'totalRating' => 0,
                            'ratingCount' => 0
                        ];
                    }

                    $sqlcriteria = "SELECT * FROM `studentscriteria` WHERE studentsCategories = '$category'";
                    $resultCriteria = mysqli_query($con, $sqlcriteria);

                    if (mysqli_num_rows($resultCriteria) > 0) {
                        while ($criteriaRow = mysqli_fetch_assoc($resultCriteria)) {
                            $columnName = sanitizeColumnName($criteriaRow['studentsCategories']);
                            $finalColumnName = $columnName . $criteriaRow['id'];

                            $criteriaRating = $ratingRow[$finalColumnName] ?? null;

                            if ($criteriaRating !== null && $criteriaRating >= 1 && $criteriaRating <= 5) {
                                $categoryAveragesStudentsForm[$category][$academicYearStudentsForm][$semesterStudentsForm]['totalRating'] += $criteriaRating;
                                $categoryAveragesStudentsForm[$category][$academicYearStudentsForm][$semesterStudentsForm]['ratingCount']++;
                            }
                        }
                    }
                }
            }
        }
    }
}

$graphDataStudentsForm = [];
foreach ($categoryAveragesStudentsForm as $category => $academicYears) {
    foreach ($academicYears as $academicYearStudentsForm => $semestersStudentsForm) {
        foreach ($semestersStudentsForm as $semesterStudentsForm => $data) {
            $averageRatingStudentsForm = ($data['ratingCount'] > 0) ? ($data['totalRating'] / $data['ratingCount']) : 0;
            $graphDataStudentsForm[$category][$academicYearStudentsForm][$semesterStudentsForm] = number_format($averageRatingStudentsForm, 2, '.', '');
        }
    }
}

$distinctYearsAndSemestersSqlStudentsForm = "
    SELECT DISTINCT academic_year, semester 
    FROM studentsform 
    WHERE academic_year IS NOT NULL AND academic_year != ''
      AND semester IS NOT NULL AND semester != ''
    ORDER BY academic_year ASC, semester ASC
";

$distinctYearsAndSemestersQueryStudentsForm = mysqli_query($con, $distinctYearsAndSemestersSqlStudentsForm);

$distinctYearsAndSemestersStudentsForm = [];
while ($rowStudentsForm = mysqli_fetch_assoc($distinctYearsAndSemestersQueryStudentsForm)) {
    $distinctYearsAndSemestersStudentsForm[] = $rowStudentsForm['semester'] . ' ' . $rowStudentsForm['academic_year'];
}


?>

<?php

include "../../model/dbconnection.php";

$usersqlPeertoPeerForm = "SELECT * FROM `instructor`";
$usersql_queryPeertoPeerForm = mysqli_query($con, $usersqlPeertoPeerForm);
if (!$usersql_queryPeertoPeerForm) {
    echo "Query failed: " . mysqli_error($con);
    exit;
}

$sqlCategoriesPeertoPeerForm = "SELECT * FROM `facultycategories`";
$sqlCategories_queryPeertoPeerForm = mysqli_query($con, $sqlCategoriesPeertoPeerForm);
if (!$sqlCategories_queryPeertoPeerForm) {
    echo "Query failed: " . mysqli_error($con);
    exit;
}

$categoryAveragesPeertoPeerForm = [];

if (mysqli_num_rows($usersql_queryPeertoPeerForm) > 0) {
    while ($userRow = mysqli_fetch_assoc($usersql_queryPeertoPeerForm)) {
        $FacultyID = $userRow['faculty_Id'];

        mysqli_data_seek($sqlCategories_queryPeertoPeerForm, 0);

        while ($categoriesRow = mysqli_fetch_assoc($sqlCategories_queryPeertoPeerForm)) {
            $category = $categoriesRow['categories'];

            $sqlRatingsPeertoPeerForm = "
                SELECT semester, academic_year, peertopeerform.* 
                FROM `peertopeerform`
                WHERE toFacultyID = '$FacultyID' 
                ORDER BY academic_year ASC
            ";
            $ratingsQuery = mysqli_query($con, $sqlRatingsPeertoPeerForm);

            if (mysqli_num_rows($ratingsQuery) > 0) {
                while ($ratingRow = mysqli_fetch_assoc($ratingsQuery)) {
                    $semesterPeertoPeerForm = $ratingRow['semester'];
                    $academicYearPeertoPeerForm = $ratingRow['academic_year'];

                    if (!isset($categoryAveragesPeertoPeerForm[$category][$academicYearPeertoPeerForm][$semesterPeertoPeerForm])) {
                        $categoryAveragesPeertoPeerForm[$category][$academicYearPeertoPeerForm][$semesterPeertoPeerForm] = [
                            'totalRating' => 0,
                            'ratingCount' => 0
                        ];
                    }

                    $sqlcriteria = "SELECT * FROM `facultycriteria` WHERE facultyCategories = '$category'";
                    $resultCriteria = mysqli_query($con, $sqlcriteria);

                    if (mysqli_num_rows($resultCriteria) > 0) {
                        while ($criteriaRow = mysqli_fetch_assoc($resultCriteria)) {
                            $columnName = sanitizeColumnName($criteriaRow['facultyCategories']);
                            $finalColumnName = $columnName . $criteriaRow['id'];

                            $criteriaRating = $ratingRow[$finalColumnName] ?? null;

                            if ($criteriaRating !== null && $criteriaRating >= 1 && $criteriaRating <= 5) {
                                $categoryAveragesPeertoPeerForm[$category][$academicYearPeertoPeerForm][$semesterPeertoPeerForm]['totalRating'] += $criteriaRating;
                                $categoryAveragesPeertoPeerForm[$category][$academicYearPeertoPeerForm][$semesterPeertoPeerForm]['ratingCount']++;
                            }
                        }
                    }
                }
            }
        }
    }
}

$graphDataPeertoPeerForm = [];
foreach ($categoryAveragesPeertoPeerForm as $category => $academicYears) {
    foreach ($academicYears as $academicYearPeertoPeerForm => $semestersPeertoPeerForm) {
        foreach ($semestersPeertoPeerForm as $semesterPeertoPeerForm => $data) {
            $averageRatingPeertoPeerForm = ($data['ratingCount'] > 0) ? ($data['totalRating'] / $data['ratingCount']) : 0;
            $graphDataPeertoPeerForm[$category][$academicYearPeertoPeerForm][$semesterPeertoPeerForm] = number_format($averageRatingPeertoPeerForm, 2, '.', '');
        }
    }
}

$distinctYearsAndSemestersSqlPeertoPeerForm = "
    SELECT DISTINCT academic_year, semester 
    FROM peertopeerform 
        WHERE academic_year IS NOT NULL AND academic_year != ''
      AND semester IS NOT NULL AND semester != ''
    ORDER BY academic_year ASC, semester ASC
";
$distinctYearsAndSemestersQueryPeertoPeerForm = mysqli_query($con, $distinctYearsAndSemestersSqlPeertoPeerForm);

$distinctYearsAndSemestersPeertoPeerForm = [];
while ($rowPeertoPeerForm = mysqli_fetch_assoc($distinctYearsAndSemestersQueryPeertoPeerForm)) {
    $distinctYearsAndSemestersPeertoPeerForm[] = $rowPeertoPeerForm['semester'] . ' ' . $rowPeertoPeerForm['academic_year'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../public/css/style.css">
    <link rel="stylesheet" href="../../public/sweetalert.min.css.css">
    <style>
        .graphContainer {
            width: 100%;
            display: flex;
            align-items: stretch;
        }

        .currentRating {
            max-width: 400px;
            flex-shrink: 0;
        }

        .allRating {
            flex-grow: 1;
            padding: 0 50px;
            max-height: 400px;
        }

        .file-drop-area {
            position: relative;
            display: flex;
            align-items: center;
            width: 300px;
            max-width: 100%;
            padding: 10px;
            border: 1px dashed black;
            border-radius: 3px;
            transition: 0.2s;
        }

        .choose-file-button {
            flex-shrink: 0;
            background-color: rgba(255, 255, 255, 0.04);
            border: 1px solid black;
            border-radius: 3px;
            padding: 8px 5px;
            margin-right: 10px;
            font-size: 12px;
            text-transform: uppercase;
        }

        .file-message {
            font-size: small;
            font-weight: 300;
            line-height: 1.4;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .file-input {
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
            cursor: pointer;
            opacity: 0;
        }
    </style>

</head>

<body>

    <section class="contentContainer">

        <div class="d-flex justify-content-evenly mb-5">
            <div class="container mt-5">
                <h4 class="text-center">Consolidated Faculty Development Evaluatation of the CICS Department</h4>
                <div class="d-flex justify-content-evenly px-5 mx-5 mb-3">
                    <div class="mx-3">
                        <label for="fromSemesterStudentsForm" class="form-label">From:</label>
                        <select id="fromSemesterStudentsForm" class="form-select">
                            <?php foreach ($distinctYearsAndSemestersStudentsForm as $yearSemesterStudentsForm): ?>
                                <option value="<?php echo $yearSemesterStudentsForm; ?>">
                                    <?php echo $yearSemesterStudentsForm; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mx-3">
                        <label for="toSemesterStudentsForm" class="form-label">To:</label>
                        <select id="toSemesterStudentsForm" class="form-select">
                            <?php foreach ($distinctYearsAndSemestersStudentsForm as $yearSemesterStudentsForm): ?>
                                <option value="<?php echo $yearSemesterStudentsForm; ?>">
                                    <?php echo $yearSemesterStudentsForm; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-success" id="printBtnConsolidatedFaculty">Print</button>
                    </div>
                </div>

                <canvas id="ratingGraphStudentsForm" width="800" height="400"></canvas>

            </div>
            <div class="container mt-5">
                <h4 class="text-center">Consolidated Peer-to-Peer Faculty Evaluation of the CICS Department</h4>
                <div class="d-flex justify-content-evenly px-5 mx-5 mb-3">
                    <div class="mx-3">
                        <label for="fromSemesterPeertoPeerForm" class="form-label">From:</label>
                        <select id="fromSemesterPeertoPeerForm" class="form-select">
                            <?php foreach ($distinctYearsAndSemestersPeertoPeerForm as $yearSemesterPeertoPeerForm): ?>
                                <option value="<?php echo $yearSemesterPeertoPeerForm; ?>">
                                    <?php echo $yearSemesterPeertoPeerForm; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mx-3">
                        <label for="toSemesterPeertoPeerForm" class="form-label">To:</label>
                        <select id="toSemesterPeertoPeerForm" class="form-select">
                            <?php foreach ($distinctYearsAndSemestersPeertoPeerForm as $yearSemesterPeertoPeerForm): ?>
                                <option value="<?php echo $yearSemesterPeertoPeerForm; ?>">
                                    <?php echo $yearSemesterPeertoPeerForm; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-success" id="printBtnConsolidatedPeertoPeer">Print</button>
                    </div>
                </div>

                <canvas id="ratingGraphPeertoPeerForm" width="800" height="400"></canvas>

            </div>
        </div>


        <div class="d-flex justify-content-evenly mb-5">
            <div class="chart-container  justify-content-center  ">

                <div class="d-flex justify-content-center my-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#vcaaResults">
                        VCAA Results
                    </button>
                </div>

                <h3 class="text-center">Your VCAA Rating</h3>

                <canvas id="averageChart" style="max-width: 250px;"></canvas>

            </div>
            <div class="chart-container  justify-content-center">
                <h3 class="text-center">Latest Peer to Peer Evaluation Result</h3>
                <canvas id="averageRatingChart" style="min-height: 300px;"></canvas>
            </div>
        </div>


        <div class=" d-flex flex-column justify-content-center align-items-center mb-5">

            <h3 class="text-center my-2">Evaluation of VCAA Ratings Across Semesters and Academic Years</h3>

            <div class="container my-3 d-flex justify-content-evenly">

                <div class="form-group">

                    <label for="startSemesterFilter">Select Start Semester:</label>
                    <select id="startSemesterFilter" class="form-control">
                        <option value="">Select Start Semester</option>
                        <?php foreach ($semesters as $semester): ?>
                            <option value="<?php echo $semester; ?>"><?php echo $semester; ?></option>
                        <?php endforeach; ?>
                    </select>

                </div>

                <div class="form-group">

                    <label for="endSemesterFilter">Select End Semester:</label>
                    <select id="endSemesterFilter" class="form-control">
                        <option value="">Select End Semester</option>
                    </select>

                </div>

                <div class="form-group">

                    <label for="subjectFilter">Select Subject:</label>
                    <select id="subjectFilter" class="form-control">
                        <option value="all">All Subjects</option>
                        <?php foreach (array_keys($subjectData) as $subject): ?>
                            <option value="<?php echo $subject; ?>"><?php echo $subject; ?></option>
                        <?php endforeach; ?>
                    </select>

                </div>

                <div class="form-group">

                    <button class="btn btn-success" id="printBtn">Print</button>

                </div>

            </div>

            <canvas id="barChart" style="max-height: 400px; max-width: 70%"></canvas>

        </div>







    </section>

    <div class="modal fade" id="vcaaResults" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="vcaaResultsLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title " id="vcaaResultsLabel">VCAA Results</h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php

                    $FacultyID = $userRow['faculty_Id'];
                    $sqlSAY = "SELECT DISTINCT  sf.semester, sf.academic_year 
        FROM vcaaexcel sf
        JOIN instructor i ON sf.faculty_Id = i.faculty_Id
        WHERE sf.faculty_Id = '$FacultyID'";

                    $sqlSAY_query = mysqli_query($con, $sqlSAY);

                    $semesters = [];
                    $academicYears = [];

                    while ($academicYearSemester = mysqli_fetch_assoc($sqlSAY_query)) {
                        $semesters[] = $academicYearSemester['semester'];
                        $academicYears[] = $academicYearSemester['academic_year'];
                    }

                    $selectedSemester = isset($_POST['semester']) ? $_POST['semester'] : '';
                    $selectedAcademicYear = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';

                    ?>

                    <!-- FILTER FOR SEMESTER AND ACADEMIC YEAR -->
                    <form method="POST" action=""
                        class="mb-4 d-flex justify-content-evenly align-items-center text-center">
                        <div class="mb-3">
                            <label for="academic_year" class="form-label">Academic Year:</label>
                            <select id="academic_year" name="academic_year" class="form-select">
                                <option value="">Select Academic Year</option>
                                <?php foreach (array_unique($academicYears) as $year): ?>
                                    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="semester" class="form-label">Semester:</label>
                            <select id="semester" name="semester" class="form-select">
                                <option value="">Select Semester</option>
                                <?php foreach (array_unique($semesters) as $semester): ?>
                                    <option value="<?php echo $semester; ?>"><?php echo $semester; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-success" onclick="printPartOfPage('result')">Print
                                Content</button>
                        </div>
                    </form>

                    <div class="vcaaRecommendation mt-2">
                        <div id="result"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../../public/js/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <script>

        const graphDataStudentsForm = <?php echo json_encode($graphDataStudentsForm); ?>;

        const datasetsStudentsForm = [];
        const labelsStudentsForm = [];

        Object.keys(graphDataStudentsForm).forEach((category, index) => {
            let semesterLabelsStudentsForm = [];
            let ratingsStudentsForm = [];

            Object.keys(graphDataStudentsForm[category]).forEach((academicYearStudentsForm) => {
                Object.keys(graphDataStudentsForm[category][academicYearStudentsForm]).forEach((semesterStudentsForm) => {
                    const semesterLabelStudentsForm = `${semesterStudentsForm} ${academicYearStudentsForm}`;
                    if (!labelsStudentsForm.includes(semesterLabelStudentsForm)) {
                        labelsStudentsForm.push(semesterLabelStudentsForm);
                    }
                    semesterLabelsStudentsForm.push(semesterLabelStudentsForm);
                    ratingsStudentsForm.push(graphDataStudentsForm[category][academicYearStudentsForm][semesterStudentsForm]);
                });
            });

            datasetsStudentsForm.push({
                label: category,
                data: ratingsStudentsForm,
                borderColor: `hsl(${index * 60}, 100%, 50%)`,
                backgroundColor: `hsl(${index * 60}, 100%, 50%)`,
                fill: false,
                tension: 0.1
            });
        });

        const ctxStudentsForm = document.getElementById('ratingGraphStudentsForm').getContext('2d');
        const chartStudentsForm = new Chart(ctxStudentsForm, {
            type: 'line',
            data: {
                labels: labelsStudentsForm,
                datasets: datasetsStudentsForm
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Semester & Academic Year'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Average Rating'
                        },
                        min: 0,
                        max: 5
                    }
                }
            }
        });

        const fromSemesterSelectStudentsForm = document.getElementById('fromSemesterStudentsForm');
        const toSemesterSelectStudentsForm = document.getElementById('toSemesterStudentsForm');

        toSemesterSelectStudentsForm.value = toSemesterSelectStudentsForm.options[toSemesterSelectStudentsForm.options.length - 1].value;

        fromSemesterSelectStudentsForm.addEventListener('change', updateGraphStudentsForm);
        toSemesterSelectStudentsForm.addEventListener('change', updateGraphStudentsForm);

        function updateGraphStudentsForm() {
            const fromSemesterStudentsForm = fromSemesterSelectStudentsForm.value;
            const toSemesterStudentsForm = toSemesterSelectStudentsForm.value;

            filterToSelectOptionsStudentsForm(fromSemesterStudentsForm);

            const filteredDataStudentsForm = filterGraphDataStudentsForm(fromSemesterStudentsForm, toSemesterStudentsForm);

            chartStudentsForm.data.labels = filteredDataStudentsForm.labels;
            chartStudentsForm.data.datasets = filteredDataStudentsForm.datasets;
            chartStudentsForm.update();
        }

        function filterGraphDataStudentsForm(fromSemesterStudentsForm, toSemesterStudentsForm) {
            let filteredLabels = [];
            let filteredDatasets = [];

            Object.keys(graphDataStudentsForm).forEach((category, index) => {
                let semesterLabelsStudentsForm = [];
                let ratingsStudentsForm = [];

                Object.keys(graphDataStudentsForm[category]).forEach((academicYearStudentsForm) => {
                    Object.keys(graphDataStudentsForm[category][academicYearStudentsForm]).forEach((semesterStudentsForm) => {
                        const semesterLabelStudentsForm = `${semesterStudentsForm} ${academicYearStudentsForm}`;
                        if (isSemesterInRangeStudentsForm(semesterLabelStudentsForm, fromSemesterStudentsForm, toSemesterStudentsForm)) {
                            if (!filteredLabels.includes(semesterLabelStudentsForm)) {
                                filteredLabels.push(semesterLabelStudentsForm);
                            }
                            semesterLabelsStudentsForm.push(semesterLabelStudentsForm);
                            ratingsStudentsForm.push(graphDataStudentsForm[category][academicYearStudentsForm][semesterStudentsForm]);
                        }
                    });
                });

                filteredDatasets.push({
                    label: category,
                    data: ratingsStudentsForm,
                    borderColor: `hsl(${index * 60}, 100%, 50%)`,
                    backgroundColor: `hsl(${index * 60}, 100%, 50%)`,
                    fill: false,
                    tension: 0.1
                });
            });

            return { labels: filteredLabels, datasets: filteredDatasets };
        }

        function filterToSelectOptionsStudentsForm(fromSemesterStudentsForm) {
            const toSelectStudentsForm = document.getElementById('toSemesterStudentsForm');

            const [fromSemester, fromYear] = fromSemesterStudentsForm.split(' ');

            Array.from(toSelectStudentsForm.options).forEach((option) => {
                const [optionSemester, optionYear] = option.value.split(' ');

                if (optionYear < fromYear || (optionYear === fromYear && optionSemester < fromSemester)) {
                    option.disabled = true;
                } else {
                    option.disabled = false;
                }
            });
        }

        function isSemesterInRangeStudentsForm(semesterLabelStudentsForm, fromSemesterStudentsForm, toSemesterStudentsForm) {
            const [semester, academicYear] = semesterLabelStudentsForm.split(' ');
            const [fromSemester, fromYear] = fromSemesterStudentsForm.split(' ');
            const [toSemester, toYear] = toSemesterStudentsForm.split(' ');

            const isAfterFrom = (academicYear > fromYear) || (academicYear === fromYear && semester >= fromSemester);
            const isBeforeTo = (academicYear < toYear) || (academicYear === toYear && semester <= toSemester);

            return isAfterFrom && isBeforeTo;
        }

    </script>

    <script>
        const graphDataPeertoPeerForm = <?php echo json_encode($graphDataPeertoPeerForm); ?>;

        const datasetsPeertoPeerForm = [];
        const labelsPeertoPeerForm = [];

        Object.keys(graphDataPeertoPeerForm).forEach((category, index) => {
            let semesterLabelsPeertoPeerForm = [];
            let ratingsPeertoPeerForm = [];

            Object.keys(graphDataPeertoPeerForm[category]).forEach((academicYearPeertoPeerForm) => {
                Object.keys(graphDataPeertoPeerForm[category][academicYearPeertoPeerForm]).forEach((semesterPeertoPeerForm) => {
                    const semesterLabelPeertoPeerForm = `${semesterPeertoPeerForm} ${academicYearPeertoPeerForm}`;
                    if (!labelsPeertoPeerForm.includes(semesterLabelPeertoPeerForm)) {
                        labelsPeertoPeerForm.push(semesterLabelPeertoPeerForm);
                    }
                    semesterLabelsPeertoPeerForm.push(semesterLabelPeertoPeerForm);
                    ratingsPeertoPeerForm.push(graphDataPeertoPeerForm[category][academicYearPeertoPeerForm][semesterPeertoPeerForm]);
                });
            });

            datasetsPeertoPeerForm.push({
                label: category,
                data: ratingsPeertoPeerForm,
                borderColor: `hsl(${index * 60}, 100%, 50%)`,
                backgroundColor: `hsl(${index * 60}, 100%, 50%)`,
                fill: false,
                tension: 0.1
            });
        });

        const ctxPeertoPeerForm = document.getElementById('ratingGraphPeertoPeerForm').getContext('2d');
        const chartPeertoPeerForm = new Chart(ctxPeertoPeerForm, {
            type: 'line',
            data: {
                labels: labelsPeertoPeerForm,  // Fixed: 'labels' instead of 'labelsPeertoPeerForm'
                datasets: datasetsPeertoPeerForm  // Fixed: 'datasets' instead of 'datasetsPeertoPeerForm'
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Semester & Academic Year'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Average Rating'
                        },
                        min: 0,
                        max: 5
                    }
                }
            }
        });

        // Event listeners
        const fromSemesterSelectPeertoPeerForm = document.getElementById('fromSemesterPeertoPeerForm');
        const toSemesterSelectPeertoPeerForm = document.getElementById('toSemesterPeertoPeerForm');

        toSemesterSelectPeertoPeerForm.value = toSemesterSelectPeertoPeerForm.options[toSemesterSelectPeertoPeerForm.options.length - 1].value;

        fromSemesterSelectPeertoPeerForm.addEventListener('change', updateGraphPeertoPeerForm);
        toSemesterSelectPeertoPeerForm.addEventListener('change', updateGraphPeertoPeerForm);

        function updateGraphPeertoPeerForm() {
            const fromSemesterPeertoPeerForm = fromSemesterSelectPeertoPeerForm.value;
            const toSemesterPeertoPeerForm = toSemesterSelectPeertoPeerForm.value;

            filterToSelectOptionsPeertoPeerForm(fromSemesterPeertoPeerForm);

            const filteredDataPeertoPeerForm = filterGraphDataPeertoPeerForm(fromSemesterPeertoPeerForm, toSemesterPeertoPeerForm);

            chartPeertoPeerForm.data.labels = filteredDataPeertoPeerForm.labels;   // Fixed: 'labels' instead of 'labelsPeertoPeerForm'
            chartPeertoPeerForm.data.datasets = filteredDataPeertoPeerForm.datasets;  // Fixed: 'datasets' instead of 'datasetsPeertoPeerForm'
            chartPeertoPeerForm.update();
        }

        function filterGraphDataPeertoPeerForm(fromSemesterPeertoPeerForm, toSemesterPeertoPeerForm) {
            let filteredLabels = [];
            let filteredDatasets = [];

            Object.keys(graphDataPeertoPeerForm).forEach((category, index) => {
                let semesterLabelsPeertoPeerForm = [];
                let ratingsPeertoPeerForm = [];

                Object.keys(graphDataPeertoPeerForm[category]).forEach((academicYearPeertoPeerForm) => {
                    Object.keys(graphDataPeertoPeerForm[category][academicYearPeertoPeerForm]).forEach((semesterPeertoPeerForm) => {
                        const semesterLabelPeertoPeerForm = `${semesterPeertoPeerForm} ${academicYearPeertoPeerForm}`;
                        if (isSemesterInRangePeertoPeerForm(semesterLabelPeertoPeerForm, fromSemesterPeertoPeerForm, toSemesterPeertoPeerForm)) {
                            if (!filteredLabels.includes(semesterLabelPeertoPeerForm)) {
                                filteredLabels.push(semesterLabelPeertoPeerForm);
                            }
                            semesterLabelsPeertoPeerForm.push(semesterLabelPeertoPeerForm);
                            ratingsPeertoPeerForm.push(graphDataPeertoPeerForm[category][academicYearPeertoPeerForm][semesterPeertoPeerForm]);
                        }
                    });
                });

                filteredDatasets.push({
                    label: category,
                    data: ratingsPeertoPeerForm,
                    borderColor: `hsl(${index * 60}, 100%, 50%)`,
                    backgroundColor: `hsl(${index * 60}, 100%, 50%)`,
                    fill: false,
                    tension: 0.1
                });
            });

            return { labels: filteredLabels, datasets: filteredDatasets };  // Fixed: 'labels' and 'datasets' instead of 'labelsPeertoPeerForm' and 'datasetsPeertoPeerForm'
        }


        function filterToSelectOptionsPeertoPeerForm(fromSemesterPeertoPeerForm) {
            const toSelectPeertoPeerForm = document.getElementById('toSemesterPeertoPeerForm');

            const [fromSemesterPeertoPeerForms, fromYear] = fromSemesterPeertoPeerForm.split(' ');

            Array.from(toSelectPeertoPeerForm.options).forEach((option) => {
                const [optionSemester, optionYear] = option.value.split(' ');

                if (optionYear < fromYear || (optionYear === fromYear && optionSemester < fromSemesterPeertoPeerForms)) {
                    option.disabled = true;
                } else {
                    option.disabled = false;
                }
            });
        }


        function isSemesterInRangePeertoPeerForm(semesterLabelPeertoPeerForm, fromSemesterPeertoPeerForm, toSemesterPeertoPeerForm) {
            const [semesterPeertoPeerForm, academicYearPeertoPeerForm] = semesterLabelPeertoPeerForm.split(' ');
            const [fromSemesterPeertoPeerForms, fromAcademicYearPeertoPeerForms] = fromSemesterPeertoPeerForm.split(' ');
            const [toSemesterPeertoPeerForms, toAcademicYearPeertoPeerForms] = toSemesterPeertoPeerForm.split(' ');

            const isAfterFromPeertoPeerForms = (academicYearPeertoPeerForm > fromAcademicYearPeertoPeerForms) || (academicYearPeertoPeerForm === fromAcademicYearPeertoPeerForms && semesterPeertoPeerForm >= fromSemesterPeertoPeerForms);
            const isBeforeToPeertoPeerForms = (academicYearPeertoPeerForm < toAcademicYearPeertoPeerForms) || (academicYearPeertoPeerForm === toAcademicYearPeertoPeerForms && semesterPeertoPeerForm <= toSemesterPeertoPeerForms);

            return isAfterFromPeertoPeerForms && isBeforeToPeertoPeerForms;
        }
    </script>

    <script>
        function printPartOfPage(elementId) {
            var printContent = document.getElementById(elementId);
            var windowUrl = 'about:blank';
            var uniqueName = new Date();
            var windowName = 'Print' + uniqueName.getTime();
            var printWindow = window.open(windowUrl, windowName, 'width=1000,height=1000');

            printWindow.document.write(`
        <!DOCTYPE html>
        <html>
            <head>
                <title>Print</title>
                <style>
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
                    }
                    th:last-child,
                    td:last-child {
                        display: none !important;
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
                <h2 style="text-align: center;">VCAA Evaluation Results</h2>
                <h3 >Faculty : <?php echo $userRow['first_name'] . ' ' . $userRow['last_name'] ?></h3>
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

    <script>
        $(document).ready(function () {
            // Show loading indicator
            $('#loading').show();

            $.ajax({
                url: 'peerToPeerGraph.php',
                type: 'GET',
                dataType: 'json',
                success: function (categoriesData) {
                    // Hide loading indicator
                    $('#loading').hide();

                    const peerToPeerctx = document.getElementById('averageRatingChart').getContext('2d');
                    const colors = Object.keys(categoriesData).map(() => {
                        // Generate random colors for each bar
                        return `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() *
                            255)}, 0.6)`;
                    });

                    const chart = new Chart(peerToPeerctx, {
                        type: 'bar',
                        data: {
                            labels: Object.keys(categoriesData), // Category names
                            datasets: [{
                                label: 'Average Ratings',
                                data: Object.values(categoriesData), // Average ratings
                                backgroundColor: colors,
                                borderColor: colors.map(color => color.replace('0.6', '1')), // Use darker colors for borders
                                borderWidth: 1
                            }]
                        },

                    });
                },
                error: function (xhr, status, error) {
                    // Hide loading indicator and show error message
                    $('#loading').hide();
                    console.error("AJAX Error: ", status, error);
                    alert("An error occurred while fetching data. Please try again later.");
                }
            });
        });
    </script>

    <script>

        var averageRating = <?php echo json_encode($average); ?>;

        if (typeof averageRating !== 'number' || isNaN(averageRating)) {
            averageRating = 0;
        }

        var remainingRating = 5 - averageRating;

        var ctx = document.getElementById('averageChart').getContext('2d');
        var averageChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Average Rating', 'Remaining Rating'],
                datasets: [{
                    data: [averageRating, remainingRating],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(255, 99, 132, 0.6)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ' + context.raw.toFixed(2);
                                }
                                return label;
                            }
                        }
                    }
                }
            },


            plugins: [{
                afterDraw: function (chart) {
                    var ctx = chart.ctx;
                    var fontSize = 24;
                    ctx.font = fontSize + "px Arial";
                    ctx.textBaseline = "middle";
                    ctx.textAlign = "center";

                    var centerX = (chart.chartArea.left + chart.chartArea.right) / 2;
                    var centerY = (chart.chartArea.top + chart.chartArea.bottom) / 2;

                    if (typeof averageRating === 'number') {
                        ctx.fillStyle = "black";
                        ctx.fillText(averageRating.toFixed(2), centerX, centerY);
                    } else {
                        console.error("averageRating is not a number:", averageRating);
                    }
                }
            }]

        });

    </script>

    <script>

        const subjects = <?php echo $subjectsJson; ?>;
        const subjectData = <?php echo $subjectDataJson; ?>;
        const semesters = <?php echo $semestersJson; ?>;

        const colorPalette = [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
        ];

        function filterEndSemesters() {
            const startSemester = document.getElementById('startSemesterFilter').value;
            const endSemesterFilter = document.getElementById('endSemesterFilter');

            endSemesterFilter.innerHTML = '<option value="">Select End Semester</option>';

            if (!startSemester) return;

            const endSemesters = semesters.filter(semester => semesters.indexOf(semester) > semesters.indexOf(startSemester));

            endSemesters.forEach(semester => {
                const option = document.createElement('option');
                option.value = semester;
                option.text = semester;
                endSemesterFilter.appendChild(option);
            });
        }

        function createFilteredDatasets(selectedSubject) {
            const startSemester = document.getElementById('startSemesterFilter').value;
            const endSemester = document.getElementById('endSemesterFilter').value;

            const startIndex = semesters.indexOf(startSemester);
            const endIndex = endSemester ? semesters.indexOf(endSemester) : semesters.length - 1;

            return subjects
                .filter(subject => selectedSubject === 'all' || subject === selectedSubject)
                .map((subject, index) => {
                    let data = subjectData[subject];

                    if (!Array.isArray(data)) {
                        data = Array(semesters.length).fill(0);
                    }

                    const cleanData = data.slice(startIndex, endIndex + 1).map((value) => {
                        return value !== null ? value : 0;
                    });

                    return {
                        label: subject,
                        data: cleanData,
                        backgroundColor: colorPalette[index % colorPalette.length],
                        borderColor: colorPalette[index % colorPalette.length],
                        borderWidth: 1
                    };
                });
        }

        function updateCharts() {
            const selectedSubject = document.getElementById('subjectFilter').value;

            const startSemester = document.getElementById('startSemesterFilter').value;
            const endSemester = document.getElementById('endSemesterFilter').value;

            const startIndex = semesters.indexOf(startSemester);
            const endIndex = endSemester ? semesters.indexOf(endSemester) : semesters.length - 1;

            const filteredLabels = semesters.slice(startIndex, endIndex + 1);

            const datasets = createFilteredDatasets(selectedSubject);

            // Update Bar Chart
            barChart.data.labels = filteredLabels;
            barChart.data.datasets = datasets.map(dataset => ({
                ...dataset,
                type: 'bar', // Set type to 'bar' for the bar chart
            }));
            barChart.update();
        }

        document.getElementById('startSemesterFilter').addEventListener('change', () => {
            filterEndSemesters();
            updateCharts();
        });

        document.getElementById('subjectFilter').addEventListener('change', updateCharts);
        document.getElementById('endSemesterFilter').addEventListener('change', updateCharts);

        const ctxBar = document.getElementById('barChart').getContext('2d');
        const barChart = new Chart(ctxBar, {
            type: 'bar', // Specify the chart type as 'bar'
            data: {
                labels: semesters,
                datasets: createFilteredDatasets('all').map(dataset => ({
                    ...dataset,
                    type: 'bar', // Set type to 'bar' for the bar chart
                }))
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

        document.getElementById('startSemesterFilter').value = semesters[0];
        filterEndSemesters();
        document.getElementById('endSemesterFilter').value = semesters[semesters.length - 1];
        updateCharts();

    </script>

    <script src="../../bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="../../public/js/sweetalert2@11.js"></script>

    <script>

        $(document).ready(function () {

            fetchFilteredResults();

            $('#academic_year, #semester').change(function () {
                fetchFilteredResults();
            });

            <?php if (isset($_SESSION['status'])): ?>
                Swal.fire({
                    title: '<?php echo $_SESSION['status']; ?>',
                    icon: '<?php echo ($_SESSION['status-code'] == 'success' ? 'success' : 'error'); ?>',
                    confirmButtonText: 'OK'
                });
                <?php unset($_SESSION['status']); ?>
            <?php endif; ?>

            <?php if (!empty($message)): ?>
                Swal.fire({
                    icon: <?php echo strpos($message, 'Error') === 0 || strpos($message, 'Invalid') === 0 ? "'error'" : "'success'"; ?>,
                    title: '<?= htmlspecialchars($message) ?>',
                    showConfirmButton: true,
                    timer: 5000
                });
            <?php endif; ?>

            $(document).on('change', '.file-input', function () {
                var filesCount = $(this)[0].files.length;
                var textbox = $(this).prev();

                if (filesCount === 1) {
                    var fileName = $(this).val().split('\\').pop();
                    textbox.text(fileName);
                } else {
                    textbox.text(filesCount + ' files selected');
                }
            });

            function printPartOfPage(elementId) {
                var originalCanvas = document.getElementById(elementId);

                var windowUrl = 'about:blank';
                var uniqueName = new Date();
                var windowName = 'Print' + uniqueName.getTime();
                var printWindow = window.open(windowUrl, windowName, 'width=800,height=600');

                printWindow.document.write('<html><head><title>Print Canvas</title></head><body>');
                printWindow.document.write('<canvas id="printCanvas" width="500" height="300" style="border:1px solid #ccc;"></canvas>');
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.focus();

                var printCanvas = printWindow.document.getElementById('printCanvas');
                var printCtx = printCanvas.getContext('2d');

                const scaleFactor = 0.9;
                printCanvas.width = originalCanvas.width * scaleFactor;
                printCanvas.height = originalCanvas.height * scaleFactor;

                printCtx.scale(scaleFactor, scaleFactor);
                printCtx.drawImage(originalCanvas, 0, 0);

                setTimeout(function () {
                    printWindow.print();
                    printWindow.close();
                }, 100);
            }

            $('#printBtn').click(function () {
                printPartOfPage('barChart');
            });
            $('#printBtnConsolidatedFaculty').click(function () {
                printPartOfPage('ratingGraphStudentsForm');
            });
            $('#printBtnConsolidatedPeertoPeer').click(function () {
                printPartOfPage('ratingGraphPeertoPeerForm');
            });
        });

        function fetchFilteredResults() {
            var semester = $('#semester').val();
            var academicYear = $('#academic_year').val();

            if (semester === '' && academicYear === '') {
                $.ajax({
                    type: 'POST',
                    url: 'filtervcaa.php',
                    data: {
                        fetchAll: true
                    },
                    success: function (data) {
                        $('#result').html(data);
                    },

                });
            } else {
                $.ajax({
                    type: 'POST',
                    url: 'filtervcaa.php',
                    data: {
                        semester: semester,
                        academic_year: academicYear
                    },
                    success: function (data) {
                        $('#result').html(data);
                    },
                });
            }
        }

    </script>

</body>

</html>