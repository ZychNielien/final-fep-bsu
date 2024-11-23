<?php

include "../../model/dbconnection.php";

session_start();

$userId = $_SESSION["userid"];
$usersql = "SELECT * FROM `instructor` WHERE faculty_Id = '$userId'";
$usersql_query = mysqli_query($con, $usersql);
$userRow = mysqli_fetch_assoc($usersql_query);

$FacultyID = $userRow['faculty_Id'];

function getVerbalInterpretationAndLinks($averageRating, $categories, $selectedSubject, $con): array
{
    $result = [
        'interpretation' => '',
        'links' => []
    ];

    if ($averageRating < 0 || $averageRating > 5) {
        $result['interpretation'] = 'No description';
    } else {
        $interpretations = ['None', 'Poor', 'Fair', 'Satisfactory', 'Very Satisfactory', 'Outstanding'];
        $result['interpretation'] = $interpretations[(int) $averageRating];
    }

    $categoryLinks = [];
    $sqlCategoryLinks = "SELECT * FROM studentscategories";
    $sqlCategoryLinks_query = mysqli_query($con, $sqlCategoryLinks);

    while ($categoryLinksRow = mysqli_fetch_assoc($sqlCategoryLinks_query)) {
        $dbCategory = $categoryLinksRow['categories'];
        $categoryLinks[$dbCategory] = [
            'linkOne' => $categoryLinksRow['linkOne'],
            'linkTwo' => $categoryLinksRow['linkTwo'],
            'linkThree' => $categoryLinksRow['linkThree'],
        ];
    }

    $sql = "SELECT linkOne, linkTwo, linkThree FROM subject WHERE subject = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 's', $selectedSubject);
    mysqli_stmt_execute($stmt);
    $resultSet = mysqli_stmt_get_result($stmt);

    $contentKnowledgeLinks = [];

    if ($subject = mysqli_fetch_assoc($resultSet)) {
        $contentKnowledgeLinks = [
            'linkOne' => $subject['linkOne'],
            'linkTwo' => $subject['linkTwo'],
            'linkThree' => $subject['linkThree'],
        ];
    }

    if (empty($categoryLinks[$categories]['linkOne']) && empty($categoryLinks[$categories]['linkTwo']) && empty($categoryLinks[$categories]['linkThree'])) {
        $categoryLinks['TEACHING EFFECTIVENESS'] = $contentKnowledgeLinks;
    }

    if ($averageRating < 2 && !empty($categoryLinks[$categories])) {
        foreach (['linkOne', 'linkTwo', 'linkThree'] as $linkKey) {
            if (!empty($categoryLinks[$categories][$linkKey])) {
                $result['links'][] = [
                    'text' => 'Recommendation Link',
                    'url' => htmlspecialchars($categoryLinks[$categories][$linkKey])
                ];
            }
        }
    }

    if (empty($result['links'])) {
        foreach (['linkOne', 'linkTwo', 'linkThree'] as $linkKey) {
            if (!empty($contentKnowledgeLinks[$linkKey])) {
                $result['links'][] = [
                    'text' => 'Recommendation Link',
                    'url' => htmlspecialchars($contentKnowledgeLinks[$linkKey])
                ];
            }
        }

        if (empty($result['links'])) {
            $result['links'][] = ['text' => 'No links available for this category', 'url' => ''];
        }
    }

    return $result;
}



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
        cq.subject,
        s.linkOne, 
        s.linkTwo, 
        s.linkThree
    FROM studentsform cq
    JOIN instructor i ON cq.toFacultyID = i.faculty_Id
    JOIN subject s ON cq.subject = s.subject
    WHERE cq.toFacultyID = '$FacultyID'
";

if (!empty($selectedAcademicYear)) {
    $sqlSubject .= " AND cq.academic_year = '$selectedAcademicYear'";
}
if (!empty($selectedSemester)) {
    $sqlSubject .= " AND cq.semester = '$selectedSemester'";
}

$sqlSubject .= " ORDER BY cq.academic_year DESC, cq.semester DESC ";

$sqlSubject_query = mysqli_query($con, $sqlSubject);
if (!$sqlSubject_query) {
    die("Query Failed: " . mysqli_error($con));
}

if (mysqli_num_rows($sqlSubject_query) > 0) {
    while ($subject = mysqli_fetch_assoc($sqlSubject_query)) {
        ?>

        <div class=" ulo d-flex justify-content-between mx-3">
            <div>
                <h5>Semester:
                    <span class="fw-bold"><?php echo htmlspecialchars($subject['semester']) ?></span>
                </h5>
            </div>
            <div>
                <h5>Subject:
                    <span class="fw-bold"><?php echo htmlspecialchars($subject['subject']) ?></span>
                </h5>
            </div>
            <div>
                <h5> Academic Year :
                    <span class="fw-bold"><?php echo htmlspecialchars($subject['academic_year']) ?></span>
                </h5>
            </div>
        </div>

        <div class="d-flex justify-content-evenly align-items-center my-2">
            <?php
            $subjectPo = $subject['subject'];
            $subjectSemester = $subject['semester'];
            $subjectAcademicYear = $subject['academic_year'];

            $countSQL = "SELECT s.section, COUNT(*) AS count 
             FROM complete_subject cs 
             JOIN section s ON cs.section_Id = s.id 
             JOIN subject sj ON cs.subject_id = sj.subject_id 
             WHERE cs.faculty_id = '$userId' 
             AND cs.semester = '$subjectSemester' 
             AND cs.academic_year = '$subjectAcademicYear'
             AND sj.subject = '$subjectPo'
             GROUP BY s.section";

            $countSQL_query = mysqli_query($con, $countSQL);

            if ($countSQL_query) {
                while ($countSQLRow = mysqli_fetch_assoc($countSQL_query)) {

                    $fromForm = "SELECT COUNT(*) as count 
                     FROM studentsform 
                     WHERE toFacultyID = '$userId' 
                     AND subject = '$subjectPo' 
                     AND semester = '$subjectSemester' 
                     AND academic_year = '$subjectAcademicYear'
                     AND studentSection = '{$countSQLRow['section']}'";
                    $fromForm_query = mysqli_query($con, $fromForm);

                    while ($fromFormRow = mysqli_fetch_assoc(result: $fromForm_query)) {

                        ?>
                        <h5><?php echo $countSQLRow['section'] . ' - ' . $fromFormRow['count']; ?> / <?php echo $countSQLRow['count']; ?>
                        </h5>
                        <?php
                    }
                }
            } else {

                echo "Error: " . mysqli_error($con);
            }
            ?>
        </div>

        <div class="d-flex justify-content-center align-items-center mb-2">
            <?php
            $subjectPo = $subject['subject'];
            $subjectSemester = $subject['semester'];
            $subjectAcademicYear = $subject['academic_year'];

            $countAllSQL = "SELECT COUNT(*) AS count 
             FROM complete_subject cs 
             JOIN section s ON cs.section_Id = s.id 
             JOIN subject sj ON cs.subject_id = sj.subject_id 
             WHERE cs.faculty_id = '$userId' 
             AND cs.semester = '$subjectSemester' 
             AND cs.academic_year = '$subjectAcademicYear'
             AND sj.subject = '$subjectPo'";

            $countAllSQL_query = mysqli_query($con, $countAllSQL);

            if ($countAllSQL_query) {
                while ($countAllSQLRow = mysqli_fetch_assoc($countAllSQL_query)) {

                    $fromForm = "SELECT COUNT(*) as count 
                     FROM studentsform 
                     WHERE toFacultyID = '$userId' 
                     AND subject = '$subjectPo' 
                     AND semester = '$subjectSemester' 
                     AND academic_year = '$subjectAcademicYear'"; // Add section filter here
                    $fromForm_query = mysqli_query($con, $fromForm);

                    while ($fromFormRow = mysqli_fetch_assoc(result: $fromForm_query)) {
                        // Output the section and counts for each section
                        ?>
                        <h5>The total number of students who evaluated the faculty: <span class="fw-bold">
                                <?php echo $fromFormRow['count']; ?> /
                                <?php echo $countAllSQLRow['count']; ?>
                            </span>
                        </h5>
                        <?php
                    }
                }
            } else {
                // Handle case if query fails
                echo "Error: " . mysqli_error($con);
            }
            ?>
        </div>


        <table class="table table-striped table-bordered text-center align-middle mb-5">
            <thead>
                <tr style="background: #d0112b; color: #fff;">
                    <th>Area</th>
                    <th>APS</th>
                    <th>Description</th>
                    <th>Recommendation</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $facultyID = $userRow['faculty_Id'];
                $totalAverage = 0;
                $categoryCount = 0;

                $sql = "SELECT * FROM `studentscategories`";
                $sql_query = mysqli_query($con, $sql);

                if (mysqli_num_rows($sql_query) > 0) {
                    while ($categoriesRow = mysqli_fetch_assoc($sql_query)) {
                        $categories = $categoriesRow['categories'];

                        $totalRatings = [0, 0, 0, 0, 0];
                        $ratingCount = 0;

                        $sqlcriteria = "SELECT * FROM `studentscriteria` WHERE studentsCategories = '$categories'";
                        $resultCriteria = mysqli_query($con, $sqlcriteria);

                        if (mysqli_num_rows($resultCriteria) > 0) {
                            $selectedSubject = $subject['subject'];
                            $selectedSemester = $subject['semester'];
                            $selectedAcademicYear = $subject['academic_year'];

                            $SQLFaculty = "SELECT * FROM `studentsform` WHERE toFacultyID = '$facultyID' 
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
                                mysqli_data_seek($resultCriteria, 0);
                            }

                            $averageRating = 0;
                            if ($ratingCount > 0) {
                                for ($i = 0; $i < 5; $i++) {
                                    $averageRating += ($i + 1) * $totalRatings[$i];
                                }
                                $averageRating /= $ratingCount;

                                $totalAverage += $averageRating;
                                $categoryCount++;

                                $interpretationData = getVerbalInterpretationAndLinks($averageRating, $categories, $selectedSubject, $con);
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($categories); ?></td>
                                    <td><?php echo number_format((float) $averageRating, 2, '.', ''); ?></td>
                                    <td><?php echo htmlspecialchars($interpretationData['interpretation']); ?></td>
                                    <td>
                                        <?php
                                        if ($averageRating < 2) {
                                            if (is_array($interpretationData['links'])) {
                                                echo "<ul style='list-style: none; padding: 0; margin: 0;'>";
                                                foreach ($interpretationData['links'] as $link) {
                                                    if (is_array($link) && !empty($link['text'])) {
                                                        $text = htmlspecialchars($link['text']);
                                                        $url = !empty($link['url']) ? htmlspecialchars($link['url']) : '';

                                                        if (!empty($url)) {
                                                            echo "<li><a href=\"$url\" target=\"_blank\">$text</a></li>";
                                                        } else {
                                                            echo "<li>$text</li>";
                                                        }
                                                    }
                                                }
                                                echo "</ul>";
                                            } else {
                                                echo htmlspecialchars(is_string($interpretationData['links']) ? $interpretationData['links'] : '');
                                            }
                                        } else {
                                            echo "No recommendation needed.";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                    }
                }

                if ($categoryCount > 0) {
                    $finalAverageRating = $totalAverage / $categoryCount;
                    ?>
                    <tr>
                        <td colspan="1" class="fw-bold">Final Average:</td>
                        <td colspan="1" class="fw-bold"><?php echo number_format((float) $finalAverageRating, 2, '.', ''); ?></td>
                        <td colspan="2"></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <?php
    }
} else {
    echo "<h2 style='text-align: center; color: red;'>No record found.</h2>";
}
?>