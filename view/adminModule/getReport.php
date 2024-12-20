<?php
include "../../model/dbconnection.php";

session_start();

function peertopeerVerbalandLinks($averageRating, $category, $con)
{
    $result = [
        'interpretation' => '',
        'links' => []
    ];

    if ($averageRating >= 0 && $averageRating < 1) {
        $result['interpretation'] = 'None';
    } elseif ($averageRating >= 1 && $averageRating < 2) {
        $result['interpretation'] = 'Poor';
    } elseif ($averageRating >= 2 && $averageRating < 3) {
        $result['interpretation'] = 'Fair';
    } elseif ($averageRating >= 3 && $averageRating < 4) {
        $result['interpretation'] = 'Satisfactory';
    } elseif ($averageRating >= 4 && $averageRating < 5) {
        $result['interpretation'] = 'Very Satisfactory';
    } elseif ($averageRating == 5) {
        $result['interpretation'] = 'Outstanding';
    } else {
        $result['interpretation'] = 'No description';
    }

    $sqlCategoryLinks = "SELECT * FROM facultycategories";
    $sqlCategoryLinks_query = mysqli_query($con, $sqlCategoryLinks);

    $categoryLinks = [];

    while ($categoryLinksRow = mysqli_fetch_assoc($sqlCategoryLinks_query)) {
        $dbCategory = $categoryLinksRow['categories'];

        $categoryLinks[$dbCategory] = [
            'linkOne' => $categoryLinksRow['linkOne'],
            'linkTwo' => $categoryLinksRow['linkTwo'],
            'linkThree' => $categoryLinksRow['linkThree'],
        ];
    }

    if ($averageRating < 2) {
        if (!empty($categoryLinks[$category])) {

            if (!empty($categoryLinks[$category]['linkOne'])) {
                $result['links'][] = [
                    'text' => 'Recommendation Link',
                    'url' => htmlspecialchars($categoryLinks[$category]['linkOne'])
                ];
            }

            if (!empty($categoryLinks[$category]['linkTwo'])) {
                $result['links'][] = [
                    'text' => 'Recommendation Link',
                    'url' => htmlspecialchars($categoryLinks[$category]['linkTwo'])
                ];
            }
            if (!empty($categoryLinks[$category]['linkThree'])) {
                $result['links'][] = [
                    'text' => 'Recommendation Link',
                    'url' => htmlspecialchars($categoryLinks[$category]['linkThree'])
                ];
            }

        }

    }

    if (empty($result['links'])) {
        $result['links'][] = ['text' => 'No links available for this category', 'url' => ''];
    }

    return $result;
}

function getVerbalInterpretationAndLinks($averageRating, $category, $selectedSubject, $con): array
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

    $sql = "SELECT linkOne, linkTwo, linkThree FROM subject WHERE subject_code = ?";
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

    if (empty($categoryLinks[$category]['linkOne']) && empty($categoryLinks[$category]['linkTwo']) && empty($categoryLinks[$category]['linkThree'])) {
        $categoryLinks['TEACHING EFFECTIVENESS'] = $contentKnowledgeLinks;
    }

    if ($averageRating < 2 && !empty($categoryLinks[$category])) {
        foreach (['linkOne', 'linkTwo', 'linkThree'] as $linkKey) {
            if (!empty($categoryLinks[$category][$linkKey])) {
                $result['links'][] = [
                    'text' => 'Recommendation Link',
                    'url' => htmlspecialchars($categoryLinks[$category][$linkKey])
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

function classrooomVerbalAndLinks($averageRating, $category, $selectedSubjectCode, $con): array
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
    $sqlCategoryLinks = "SELECT * FROM classroomcategories";
    $sqlCategoryLinks_query = mysqli_query($con, $sqlCategoryLinks);

    while ($categoryLinksRow = mysqli_fetch_assoc($sqlCategoryLinks_query)) {
        $dbCategory = $categoryLinksRow['categories'];
        $categoryLinks[$dbCategory] = [
            'linkOne' => $categoryLinksRow['linkOne'],
            'linkTwo' => $categoryLinksRow['linkTwo'],
            'linkThree' => $categoryLinksRow['linkThree'],
        ];
    }

    $sql = "SELECT linkOne, linkTwo, linkThree FROM subject WHERE subject_code = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 's', $selectedSubjectCode);
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

    if (empty($categoryLinks[$category]['linkOne']) && empty($categoryLinks[$category]['linkTwo']) && empty($categoryLinks[$category]['linkThree'])) {
        $categoryLinks['CONTENT KNOWLEDGE AND RELEVANCE'] = $contentKnowledgeLinks;
    }

    if ($averageRating < 2 && !empty($categoryLinks[$category])) {
        foreach (['linkOne', 'linkTwo', 'linkThree'] as $linkKey) {
            if (!empty($categoryLinks[$category][$linkKey])) {
                $result['links'][] = [
                    'text' => 'Recommendation Link',
                    'url' => htmlspecialchars($categoryLinks[$category][$linkKey])
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

?>
<style>
    ul {
        list-style: none;
        padding: 0px;
        margin: 0;
    }

    table tr td {
        vertical-align: middle;
    }
</style>
<?php
// Fetch active faculty IDs from the database
$facultyIdsQuery = "SELECT faculty_Id FROM instructor WHERE status = 1";
$facultyIdsResult = mysqli_query($con, $facultyIdsQuery);

// Initialize an empty array to store faculty IDs
$facultyIds = [];

if (mysqli_num_rows($facultyIdsResult) > 0) {
    // Loop through the results and collect faculty IDs
    while ($facultyRow = mysqli_fetch_assoc($facultyIdsResult)) {
        $facultyIds[] = $facultyRow['faculty_Id'];
    }
}
?>

<table class="table table-striped table-bordered text-center " style="font-size: 13px;">
    <thead>
        <tr style="background: #d9534f; color: #fff;">
            <th colspan="4" class="text-uppercase">FACULTY EVALUATIONS AND SUGGESTED TRAININGS</th>
        </tr>
        <tr class="bg-danger">
            <th class="text-uppercase">Faculty Name</th>
            <th class="text-uppercase">Strengths</th>
            <th class="text-uppercase">Weaknesses</th>
            <th class="text-uppercase">Suggested Trainings</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Fetch selected semester and academic year
        $semesterAcademicYearQuery = "SELECT * FROM `academic_year_semester` WHERE id = 1";
        $semesterAcademicYearResult = mysqli_query($con, $semesterAcademicYearQuery);
        $semesterAcademicYearRow = mysqli_fetch_assoc($semesterAcademicYearResult);
        $selectedSemester = $semesterAcademicYearRow['semester'];
        $selectedAcademicYear = $semesterAcademicYearRow['academic_year'];

        // Loop through each facultyId (userId)
        foreach ($facultyIds as $userId) {
            // Initialize variables to store strengths, weaknesses, and suggested trainings
            $strengths = [];
            $weaknesses = [];
            $suggestedTrainings = [];

            // Fetch faculty name (replace with actual query to get the name)
            $facultyNameQuery = "SELECT first_name, last_name FROM instructor WHERE faculty_Id = '$userId'";
            $facultyNameResult = mysqli_query($con, $facultyNameQuery);
            $facultyNameRow = mysqli_fetch_assoc($facultyNameResult);
            $facultyName = htmlspecialchars($facultyNameRow['first_name'] . ' ' . $facultyNameRow['last_name']);

            // Fetch distinct peer-to-peer evaluations for the current faculty
            $peertopeerSQL = "
                SELECT DISTINCT sf.semester, sf.academic_year 
                FROM peertopeerform sf
                JOIN instructor i ON sf.toFacultyID = i.faculty_Id
                WHERE i.faculty_Id = '$userId'
                AND (sf.academic_year = '$selectedAcademicYear' OR '$selectedAcademicYear' IS NULL)
                AND (sf.semester = '$selectedSemester' OR '$selectedSemester' IS NULL)
                ORDER BY sf.academic_year DESC, sf.semester DESC";

            $peertopeerResult = mysqli_query($con, $peertopeerSQL);
            if (mysqli_num_rows($peertopeerResult) > 0) {
                while ($peertopeerRow = mysqli_fetch_assoc($peertopeerResult)) {
                    // Fetch categories and criteria for evaluation
                    $categoriesQuery = "SELECT * FROM `facultycategories`";
                    $categoriesResult = mysqli_query($con, $categoriesQuery);

                    while ($categoryRow = mysqli_fetch_assoc($categoriesResult)) {
                        $category = $categoryRow['categories'];
                        $criteriaQuery = "SELECT * FROM `facultycriteria` WHERE facultyCategories = '$category'";
                        $criteriaResult = mysqli_query($con, $criteriaQuery);

                        if (mysqli_num_rows($criteriaResult) > 0) {
                            $totalRatings = [0, 0, 0, 0, 0];
                            $ratingCount = 0;
                            $SQLFaculty = "SELECT * FROM `peertopeerform` WHERE toFacultyID = '$userId' 
                                                AND semester = '{$peertopeerRow['semester']}' 
                                                AND academic_year = '{$peertopeerRow['academic_year']}'";
                            $SQLFacultyResult = mysqli_query($con, $SQLFaculty);

                            while ($ratingRow = mysqli_fetch_assoc($SQLFacultyResult)) {
                                while ($criteriaRow = mysqli_fetch_assoc($criteriaResult)) {
                                    $columnName = sanitizeColumnName($criteriaRow['facultyCategories']);
                                    $finalColumnName = $columnName . $criteriaRow['id'];
                                    $criteriaRating = $ratingRow[$finalColumnName] ?? null;

                                    if ($criteriaRating >= 1 && $criteriaRating <= 5) {
                                        $totalRatings[$criteriaRating - 1]++;
                                        $ratingCount++;
                                    }
                                }
                                mysqli_data_seek($criteriaResult, 0);
                            }

                            $averageRating = ($ratingCount > 0) ? array_sum(array_map(function ($rating, $index) {
                                return ($index + 1) * $rating;
                            }, $totalRatings, array_keys($totalRatings))) / $ratingCount : 0;

                            // Classify as strengths or weaknesses based on average rating
                            if ($averageRating >= 2) {
                                $strengths[] = $category;
                            } else {
                                $weaknesses[] = $category;
                                $suggestedTrainings[] = peertopeerVerbalandLinks($averageRating, $category, $con)['links'];
                            }
                        }
                    }
                }
            }

            $strengthsStudents = [];
            $strengthsStudentsTitle = [];
            $weaknessesStudents = [];
            $weaknessesStudentsTitle = [];
            $suggestedTrainingsStudents = [];

            $studentSQL = "
                SELECT DISTINCT sf.semester, 
                            sf.academic_year,
                            sf.subject,
                            s.linkOne, 
                            s.linkTwo, 
                            s.linkThree,
                            s.subject_code
                FROM studentsform sf
                JOIN instructor i ON sf.toFacultyID = i.faculty_Id
                JOIN subject s ON sf.subject = s.subject
                WHERE i.faculty_Id = '$userId'
                AND (sf.academic_year = '$selectedAcademicYear' OR '$selectedAcademicYear' IS NULL)
                AND (sf.semester = '$selectedSemester' OR '$selectedSemester' IS NULL)
                ORDER BY sf.academic_year DESC, sf.semester DESC";

            $studentResult = mysqli_query($con, $studentSQL);
            if (mysqli_num_rows($studentResult) > 0) {
                while ($studentRow = mysqli_fetch_assoc($studentResult)) {
                    // Fetch categories and criteria for evaluation
                    $categoriesQuery = "SELECT * FROM `studentscategories`";
                    $categoriesResult = mysqli_query($con, $categoriesQuery);

                    while ($categoryRow = mysqli_fetch_assoc($categoriesResult)) {
                        $category = $categoryRow['categories'];
                        $selectedSubject = $studentRow['subject'];
                        $selectedSubjectCode = $studentRow['subject_code'];
                        $criteriaQuery = "SELECT * FROM `studentscriteria` WHERE studentsCategories = '$category'";
                        $criteriaResult = mysqli_query($con, $criteriaQuery);

                        if (mysqli_num_rows($criteriaResult) > 0) {
                            $totalRatings = [0, 0, 0, 0, 0];
                            $ratingCount = 0;
                            $SQLFaculty = "SELECT * FROM `studentsform` WHERE toFacultyID = '$userId' 
                                                    AND subject = '$selectedSubject' 
                                                    AND semester = '{$studentRow['semester']}' 
                                                    AND academic_year = '{$studentRow['academic_year']}'";
                            $SQLFacultyResult = mysqli_query($con, $SQLFaculty);

                            while ($ratingRow = mysqli_fetch_assoc($SQLFacultyResult)) {
                                while ($criteriaRow = mysqli_fetch_assoc($criteriaResult)) {
                                    $columnName = sanitizeColumnName($criteriaRow['studentsCategories']);
                                    $finalColumnName = $columnName . $criteriaRow['id'];
                                    $criteriaRating = $ratingRow[$finalColumnName] ?? null;

                                    if ($criteriaRating >= 1 && $criteriaRating <= 5) {
                                        $totalRatings[$criteriaRating - 1]++;
                                        $ratingCount++;
                                    }
                                }
                                mysqli_data_seek($criteriaResult, 0);
                            }

                            $averageRating = ($ratingCount > 0) ? array_sum(array_map(function ($rating, $index) {
                                return ($index + 1) * $rating;
                            }, $totalRatings, array_keys($totalRatings))) / $ratingCount : 0;

                            // Classify as strengths or weaknesses based on average rating
                            if ($averageRating >= 2) {
                                $strengthsStudents[] = $category . ' (' . $selectedSubjectCode . ')';
                                $strengthsStudentsTitle[] = $selectedSubjectCode;
                            } else {
                                $weaknessesStudents[] = $category . ' (' . $selectedSubjectCode . ')';
                                $weaknessesStudentsTitle[] = $selectedSubjectCode;
                                $suggestedTrainingsStudents[] = getVerbalInterpretationAndLinks($averageRating, $category, $selectedSubject, $con)['links'];
                            }
                        }
                    }
                }
            }

            $strengthsClassroom = [];
            $weaknessesClassroom = [];
            $suggestedTrainingsClassroom = [];
            $strengthsClassroomTitle = [];
            $weaknessesClassroomTitle = [];
            $suggestedTrainingsClassroomTitle = [];

            $sqlClassroom = "
            SELECT DISTINCT cq.semester, 
                        cq.academic_year,
                        cq.courseTitle,
                        s.subject,
                        s.linkOne, 
                        s.linkTwo, 
                        s.linkThree,
                        s.subject_code
            FROM classroomobservation cq
            JOIN instructor i ON cq.toFacultyID = i.faculty_Id
            JOIN subject s ON cq.courseTitle = s.subject_code
            WHERE i.faculty_Id = '$userId'
            AND (cq.academic_year = '$selectedAcademicYear' OR '$selectedAcademicYear' IS NULL)
            AND (cq.semester = '$selectedSemester' OR '$selectedSemester' IS NULL)
            ORDER BY cq.academic_year DESC, cq.semester DESC";

            $ClassroomResult = mysqli_query($con, $sqlClassroom);
            if (mysqli_num_rows($ClassroomResult) > 0) {
                while ($studentRow = mysqli_fetch_assoc($ClassroomResult)) {
                    // Fetch categories and criteria for evaluation
                    $categoriesQuery = "SELECT * FROM `classroomcategories`";
                    $categoriesResult = mysqli_query($con, $categoriesQuery);

                    while ($categoryRow = mysqli_fetch_assoc($categoriesResult)) {
                        $category = $categoryRow['categories'];
                        $selectedSubject = $studentRow['subject'];
                        $selectedSubjectCode = $studentRow['subject_code'];
                        $criteriaQuery = "SELECT * FROM `classroomcriteria` WHERE classroomCategories = '$category'";
                        $criteriaResult = mysqli_query($con, $criteriaQuery);

                        if (mysqli_num_rows($criteriaResult) > 0) {
                            $totalRatings = [0, 0, 0, 0, 0];
                            $ratingCount = 0;
                            $SQLFaculty = "SELECT * FROM `classroomobservation` WHERE toFacultyID = '$userId' 
                                                    AND courseTitle = '$selectedSubjectCode' 
                                                    AND semester = '{$studentRow['semester']}' 
                                                    AND academic_year = '{$studentRow['academic_year']}'";
                            $SQLFacultyResult = mysqli_query($con, $SQLFaculty);

                            while ($ratingRow = mysqli_fetch_assoc($SQLFacultyResult)) {
                                while ($criteriaRow = mysqli_fetch_assoc($criteriaResult)) {
                                    $columnName = sanitizeColumnName($criteriaRow['classroomCategories']);
                                    $finalColumnName = $columnName . $criteriaRow['id'];
                                    $criteriaRating = $ratingRow[$finalColumnName] ?? null;

                                    if ($criteriaRating >= 1 && $criteriaRating <= 5) {
                                        $totalRatings[$criteriaRating - 1]++;
                                        $ratingCount++;
                                    }
                                }
                                mysqli_data_seek($criteriaResult, 0);
                            }

                            $averageRating = ($ratingCount > 0) ? array_sum(array_map(function ($rating, $index) {
                                return ($index + 1) * $rating;
                            }, $totalRatings, array_keys($totalRatings))) / $ratingCount : 0;

                            // Classify as strengths or weaknesses based on average rating
                            if ($averageRating >= 2) {
                                $strengthsClassroom[] = $category . ' (' . $selectedSubjectCode . ')';
                                $strengthsClassroomTitle[] = $selectedSubjectCode;
                            } else {
                                $weaknessesClassroom[] = $category . ' (' . $selectedSubjectCode . ')';
                                $weaknessesClassroomTitle[] = $selectedSubjectCode;

                                $suggestedTrainingsClassroom[] = classrooomVerbalAndLinks($averageRating, $category, $selectedSubjectCode, $con)['links'];
                            }
                        }
                    }
                }
            }
            // Output the results for the current faculty
            ?>
            <tr>
                <td><?php echo $facultyName; ?></td>
                <td>
                    <?php
                    // Output strengths as a list
                    if (!empty($strengths) || !empty($strengthsStudents) || !empty($strengthsClassroom)) {
                        echo "<ul>";
                        foreach ($strengths as $strength) {
                            echo "<li>" . htmlspecialchars($strength) . "</li> ";
                        }

                        foreach ($strengthsStudents as $strengthStudents) {
                            echo "<li>" . htmlspecialchars($strengthStudents) . "</li> ";

                        }
                        foreach ($strengthsClassroom as $strengthClassroom) {
                            echo "<li>" . htmlspecialchars($strengthClassroom) . "</li> ";
                        }


                        echo "</ul>";
                    } else {
                        echo "No strengths identified";
                    }

                    ?>
                </td>
                <td>
                    <?php
                    // Output weaknesses as a list
                    if (!empty($weaknesses) || !empty($weaknessesStudents) || !empty($weaknessesClassroom)) {
                        echo "<ul>";
                        foreach ($weaknesses as $weakness) {
                            echo "<li>" . htmlspecialchars($weakness) . "</li>";
                        }


                        foreach ($weaknessesStudents as $weaknessStudents) {
                            echo "<li>" . htmlspecialchars($weaknessStudents) . "</li>";
                        }
                        foreach ($weaknessesClassroom as $weaknessClassroom) {
                            echo "<li>" . htmlspecialchars($weaknessClassroom) . "</li>";
                        }


                        echo "</ul>";
                    } else {
                        echo "No weaknesses identified";
                    }
                    ?>
                </td>
                <td>
                    <?php
                    // Output suggested training links as a list
                    if (!empty($suggestedTrainings) || !empty($suggestedTrainingsStudents) || !empty($suggestedTrainingsClassroom)) {
                        echo "<ul>";
                        foreach ($suggestedTrainings as $training) {
                            // Check if there are any links in $training
                            if (empty($training)) {
                                echo "<li>No recommendation links</li>";
                            } else {
                                // Loop through each link in the $training
                                foreach ($training as $link) {
                                    // Check if the URL is not empty before displaying the link
                                    if (!empty($link['url'])) {
                                        echo "<li><a href='" . $link['url'] . "' target='_blank'>" . htmlspecialchars($link['text']) . "</a></li>";
                                    } else {
                                        // If URL is empty, display the text only
                                        echo "<li>No recommendation links</li>";
                                    }
                                }
                            }
                        }
                        foreach ($suggestedTrainingsStudents as $trainingStudents) {
                            // Check if there are any links to display
                            if (empty($trainingStudents)) {
                                echo "<li>No recommendation links</li>";
                            } else {
                                // Loop through each training and link
                                foreach ($trainingStudents as $linkStudents) {
                                    // Check if URL is not empty before displaying the link
                                    if (!empty($linkStudents['url'])) {
                                        echo "<li><a href='" . $linkStudents['url'] . "' target='_blank'>" . htmlspecialchars($linkStudents['text']) . "</a></li>";
                                    } else {
                                        // If URL is empty, display the text only
                                        echo "<li>No recommendation links</li>";
                                    }
                                }
                            }
                        }
                        foreach ($suggestedTrainingsClassroom as $trainingClassroom) {
                            // Check if there are any links in $trainingClassroom
                            if (empty($trainingClassroom)) {
                                echo "<li>No recommendation links</li>";
                            } else {
                                // Loop through each training and link
                                foreach ($trainingClassroom as $linkClassroom) {
                                    // Check if the URL is not empty before displaying the link
                                    if (!empty($linkClassroom['url'])) {
                                        echo "<li><a href='" . $linkClassroom['url'] . "' target='_blank'>" . htmlspecialchars($linkClassroom['text']) . "</a></li>";
                                    } else {
                                        // If URL is empty, display the text only
                                        echo "<li>No recommendation links</li>";
                                    }
                                }
                            }
                        }
                        echo "</ul>";
                    } else {
                        echo "No suggested training available";
                    }
                    ?>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>