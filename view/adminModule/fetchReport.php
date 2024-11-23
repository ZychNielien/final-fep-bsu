<?php

include "../../model/dbconnection.php";

session_start();

$userId = $_POST['id'];
$userName = $_POST['name'];

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

function sanitizeColumnName($name)
{
    return preg_replace('/[^a-zA-Z0-9_]/', '', trim($name));
}

?>

<div class="d-flex flex-column align-items-start justify-content-md-start bg-white p-2 rounded">
    <?php

    $semesterAcademicYear = "SELECT * FROM `academic_year_semester` WHERE id = 1";
    $semesterAcademicYear_query = mysqli_query($con, $semesterAcademicYear);
    $semesterAcademicYearRow = mysqli_fetch_Assoc($semesterAcademicYear_query);
    $selectedSemester = $semesterAcademicYearRow['semester'];
    $selectedAcademicYear = $semesterAcademicYearRow['academic_year'];

    $peertopeerSQL = "
    SELECT DISTINCT  sf.semester, sf.academic_year 
    FROM peertopeerform sf
    JOIN instructor i ON sf.toFacultyID = i.faculty_Id
    WHERE i.faculty_Id = '$userId'
";

    if (!empty($selectedAcademicYear)) {
        $peertopeerSQL .= " AND sf.academic_year = '$selectedAcademicYear'";
    }
    if (!empty($selectedSemester)) {
        $peertopeerSQL .= " AND sf.semester = '$selectedSemester'";
    }

    $peertopeerSQL .= " GROUP BY sf.semester, sf.academic_year ORDER BY  sf.academic_year DESC, sf.semester DESC ";

    $peertopeerSQL_query = mysqli_query($con, $peertopeerSQL);
    if (!$peertopeerSQL_query) {
        die("Query Failed: " . mysqli_error($con));
    }

    if (mysqli_num_rows($peertopeerSQL_query) > 0) {
        while ($peertopeerRow = mysqli_fetch_assoc($peertopeerSQL_query)) {
            ?>
            <div class="modal-header p-0 bg-danger text-center m-0 w-100">
                <h3 class="text-white p-2 m-0">Faculty Development Plan Report</h3>
                <button type="button" class="btn-close bg-white text-center" data-bs-dismiss="modal" aria-label="Close"
                    style="margin-right: 10px; text-align: center; cursor: pointer;"></button>
            </div>
            <div class="container p-0">
                <div class="d-flex justify-content-between border w-100 p-2">
                    <div class="px-3 text-center" style="border-right: 1px solid #ccc;">Faculty Name</div>
                    <div class="px-3 text-center fw-bold text-uppercase" style="border-right: 1px solid #ccc;">
                        <?php echo $userName; ?>
                    </div>
                    <div class="px-3 text-center" style="border-right: 1px solid #ccc;">Semester</div>
                    <div class="px-3 text-center  fw-bold" style="border-right: 1px solid #ccc;">
                        <?php echo $selectedSemester; ?>
                    </div>
                    <div class="px-3 text-center" style="border-right: 1px solid #ccc;">Academic Year</div>
                    <div class="px-3 text-center  fw-bold"><?php echo $selectedAcademicYear; ?></div>
                </div>
            </div>

            <div class="border border-1 w-100">
                <h4 class="fw-bold text-center p-2">Faculty Peer to Peer Evaluation Instrument for Faculty Development</h4>
                <div class="d-flex justify-content-between w-100">
                    <div class="container">
                        <table class="table table-striped table-bordered text-center align-middle">
                            <thead>
                                <tr style="background: #5bc0de; color: #fff;">
                                    <th>STRENGTH</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $categoryCountAbove2 = 0;

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
                                            $selectedSemester = $peertopeerRow['semester'];
                                            $selectedAcademicYear = $peertopeerRow['academic_year'];

                                            $SQLFaculty = "SELECT * FROM `peertopeerform` WHERE toFacultyID = '$userId' 
                                                AND semester = '$selectedSemester' 
                                                AND academic_year = '$selectedAcademicYear'";

                                            $SQLFaculty_query = mysqli_query($con, $SQLFaculty);

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

                                            $averageRating = 0;
                                            if ($ratingCount > 0) {
                                                for ($i = 0; $i < 5; $i++) {
                                                    $averageRating += ($i + 1) * $totalRatings[$i];
                                                }
                                                $averageRating /= $ratingCount;

                                                if ($averageRating >= 2) {
                                                    $categoryCountAbove2++;

                                                    $interpretationData = peertopeerVerbalandLinks($averageRating, $categories, $con);
                                                    ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($categories); ?></td>

                                                    </tr>
                                                    <?php
                                                }
                                            }
                                        }
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="container">
                        <table class="table table-striped table-bordered text-center">
                            <thead>
                                <tr style="background: #d9534f; color: #fff;">
                                    <th>WEAKNESSES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $categoryCountBelow2 = 0;

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
                                            $selectedSemester = $peertopeerRow['semester'];
                                            $selectedAcademicYear = $peertopeerRow['academic_year'];

                                            $SQLFaculty = "SELECT * FROM `peertopeerform` WHERE toFacultyID = '$userId' 
                        AND semester = '$selectedSemester' 
                        AND academic_year = '$selectedAcademicYear'";

                                            $SQLFaculty_query = mysqli_query($con, $SQLFaculty);

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

                                            $averageRating = 0;
                                            if ($ratingCount > 0) {
                                                for ($i = 0; $i < 5; $i++) {
                                                    $averageRating += ($i + 1) * $totalRatings[$i];
                                                }
                                                $averageRating /= $ratingCount;

                                                if ($averageRating < 2) {
                                                    $categoryCountBelow2++;

                                                    $interpretationData = peertopeerVerbalandLinks($averageRating, $categories, $con);
                                                    ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($categories); ?></td>

                                                    </tr>
                                                    <?php
                                                }
                                            }
                                        }
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="container px-3">
                    <table class="table table-striped table-bordered text-center">
                        <thead>
                            <tr style="background: #d9534f; color: #fff;">
                                <th colspan="2">SUGGESTED TRAINIGS/SEMINARS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $categoryCountBelow2 = 0;

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
                                        $selectedSemester = $peertopeerRow['semester'];
                                        $selectedAcademicYear = $peertopeerRow['academic_year'];

                                        $SQLFaculty = "SELECT * FROM `peertopeerform` WHERE toFacultyID = '$userId' 
                        AND semester = '$selectedSemester' 
                        AND academic_year = '$selectedAcademicYear'";

                                        $SQLFaculty_query = mysqli_query($con, $SQLFaculty);

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

                                        $averageRating = 0;
                                        if ($ratingCount > 0) {
                                            for ($i = 0; $i < 5; $i++) {
                                                $averageRating += ($i + 1) * $totalRatings[$i];
                                            }
                                            $averageRating /= $ratingCount;

                                            if ($averageRating < 2) {
                                                $categoryCountBelow2++;

                                                $interpretationData = peertopeerVerbalandLinks($averageRating, $categories, $con);
                                                ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($categories); ?></td>
                                                    <td>
                                                        <?php
                                                        if ($averageRating < 2) {
                                                            if (is_array($interpretationData['links'])) {
                                                                echo "<ul style='list-style: none; padding: 0; margin: 0;'>";
                                                                foreach ($interpretationData['links'] as $link) {
                                                                    if (!empty($link['url'])) {
                                                                        echo "<li><a href=\"" . htmlspecialchars($link['url']) . "\" target=\"_blank\">" . htmlspecialchars($link['text']) . "</a></li>";
                                                                    } else {
                                                                        echo "<li>" . htmlspecialchars($link['text']) . "</li>";
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
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        <?php }
    } else {
        ?>
        <div class="modal-header p-0 bg-danger text-center m-0 w-100">
            <h3 class="text-white p-2 m-0">Faculty Development Plan Report</h3>
            <button type="button" class="btn-close bg-white text-center" data-bs-dismiss="modal" aria-label="Close"
                style="margin-right: 10px; text-align: center; cursor: pointer;"></button>
        </div>
        <div class="container p-0">
            <div class="d-flex justify-content-between border w-100 p-2">
                <div class="px-3 text-center" style="border-right: 1px solid #ccc;">Faculty Name</div>
                <div class="px-3 text-center fw-bold text-uppercase" style="border-right: 1px solid #ccc;">
                    <?php echo $userName; ?>
                </div>
                <div class="px-3 text-center" style="border-right: 1px solid #ccc;">Semester</div>
                <div class="px-3 text-center  fw-bold" style="border-right: 1px solid #ccc;">
                    <?php echo $selectedSemester; ?>
                </div>
                <div class="px-3 text-center" style="border-right: 1px solid #ccc;">Academic Year</div>
                <div class="px-3 text-center  fw-bold"><?php echo $selectedAcademicYear; ?></div>
            </div>
        </div>
        <div class="border border-1 w-100">
            <h4 class="fw-bold text-center p-2">Faculty Peer to Peer Evaluation Instrument for Faculty Development</h4>
            <div class="d-flex justify-content-between w-100">
                <div class="container">
                    <table class="table table-striped table-bordered text-center align-middle">
                        <thead>
                            <tr style="background: #5bc0de; color: #fff;">
                                <th>STRENGTH</th>

                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="container">
                    <table class="table table-striped table-bordered text-center align-middle">
                        <thead>
                            <tr style="background: #d9534f; color: #fff;">
                                <th>WEAKNESSES</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="container px-3">
                <table class="table table-striped table-bordered text-center">
                    <thead>
                        <tr style="background: #d9534f; color: #fff;">
                            <th colspan="2">SUGGESTED TRAINIGS/SEMINARS</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <?php

    }

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
        WHERE cq.toFacultyID = '$userId'
    ";

    if (!empty($selectedAcademicYear)) {
        $sqlSubject .= " AND cq.academic_year = '$selectedAcademicYear'";
    }
    if (!empty($selectedSemester)) {
        $sqlSubject .= " AND cq.semester = '$selectedSemester'";
    }

    $sqlSubject .= " ORDER BY  cq.academic_year DESC, cq.semester DESC ";

    $sqlSubject_query = mysqli_query($con, $sqlSubject);

    if (!$sqlSubject_query) {
        die("Query Failed: " . mysqli_error($con));
    }
    ?>

    <div class="border border-1 w-100">


        <?php


        if (mysqli_num_rows($sqlSubject_query) > 0) {
            while ($subject = mysqli_fetch_assoc($sqlSubject_query)) {
                ?>
                <h4 class="fw-bold text-center p-2">Performace Evaluation Instrument for Faculty Development</h4>

                <h5 class="text-center p-0 mb-3">
                    <span class="fw-bold"><?php echo htmlspecialchars($subject['subject']) ?></span>
                </h5>
                <div class="d-flex justify-content-between flex-row-reverse w-100">

                    <div class="container w-50">

                        <table class="table table-striped table-bordered text-center align-middle">
                            <thead>
                                <tr style="background: #d9534f; color: #fff;">
                                    <th>WEAKNESSES</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $categoriesBelow2 = [];
                                $categoriesAbove2 = [];

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

                                            $SQLFaculty = "SELECT * FROM `studentsform` WHERE toFacultyID = '$userId' 
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

                                                $interpretationData = getVerbalInterpretationAndLinks($averageRating, $categories, $selectedSubject, $con);

                                                // Separate categories based on average rating
                                                if ($averageRating < 2) {
                                                    $categoriesBelow2[] = [
                                                        'categories' => $categories,
                                                        'averageRating' => $averageRating,
                                                        'interpretation' => $interpretationData['interpretation'],
                                                        'links' => $interpretationData['links']
                                                    ];
                                                } else {
                                                    $categoriesAbove2[] = [
                                                        'categories' => $categories,
                                                        'averageRating' => $averageRating,
                                                        'interpretation' => $interpretationData['interpretation'],
                                                        'links' => $interpretationData['links']
                                                    ];
                                                }
                                            }
                                        }
                                    }
                                }

                                foreach ($categoriesBelow2 as $row) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['categories']); ?></td>

                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="container w-50">
                        <table class="table table-striped table-bordered text-center align-middle mb-5">
                            <thead>
                                <tr style="background: #5bc0de; color: #fff;">
                                    <th>STRENGTH</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($categoriesAbove2 as $row) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['categories']); ?></td>

                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="container">
                    <table class="table table-striped table-bordered text-center align-middle mb-5">
                        <thead>
                            <tr style="background: #d9534f; color: #fff;">
                                <th colspan="2">SUGGESTED TRAINIGS/SEMINARS</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $categoriesBelow2 = []; // Separate collection for below 2 ratings
                            $categoriesAbove2 = []; // Separate collection for above or equal to 2 ratings
                    
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

                                        $SQLFaculty = "SELECT * FROM `studentsform` WHERE toFacultyID = '$userId' 
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

                                            $interpretationData = getVerbalInterpretationAndLinks($averageRating, $categories, $selectedSubject, $con);

                                            // Separate categories based on average rating
                                            if ($averageRating < 2) {
                                                $categoriesBelow2[] = [
                                                    'categories' => $categories,
                                                    'averageRating' => $averageRating,
                                                    'interpretation' => $interpretationData['interpretation'],
                                                    'links' => $interpretationData['links']
                                                ];
                                            } else {
                                                $categoriesAbove2[] = [
                                                    'categories' => $categories,
                                                    'averageRating' => $averageRating,
                                                    'interpretation' => $interpretationData['interpretation'],
                                                    'links' => $interpretationData['links']
                                                ];
                                            }
                                        }
                                    }
                                }
                            }

                            foreach ($categoriesBelow2 as $row) {
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['categories']); ?></td>

                                    <td>
                                        <?php
                                        if (is_array($row['links'])) {
                                            echo "<ul style='list-style: none; padding: 0; margin: 0;'>";
                                            foreach ($row['links'] as $link) {
                                                $text = htmlspecialchars($link['text']);
                                                $url = !empty($link['url']) ? htmlspecialchars($link['url']) : '';
                                                if (!empty($url)) {
                                                    echo "<li><a href=\"$url\" target=\"_blank\">$text</a></li>";
                                                } else {
                                                    echo "<li>$text</li>";
                                                }
                                            }
                                            echo "</ul>";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <?php
            }
        } else {
            ?>
            <div class="border border-1 w-100">
                <h4 class="fw-bold text-center p-2">Performace Evaluation Instrument for Faculty Development</h4>
                <div class="d-flex justify-content-between w-100">
                    <div class="container">
                        <table class="table table-striped table-bordered text-center align-middle">
                            <thead>
                                <tr style="background: #5bc0de; color: #fff;">
                                    <th>STRENGTH</th>

                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="container">
                        <table class="table table-striped table-bordered text-center align-middle">
                            <thead>
                                <tr style="background: #d9534f; color: #fff;">
                                    <th>WEAKNESSES</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="container px-3">
                    <table class="table table-striped table-bordered text-center">
                        <thead>
                            <tr style="background: #d9534f; color: #fff;">
                                <th colspan="2">SUGGESTED TRAINIGS/SEMINARS</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <?php
        }
        ?>
    </div>


    <?php

    function classrooomVerbalAndLinks($averageRating, $categories, $selectedSubject, $con): array
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
            $categoryLinks['CONTENT KNOWLEDGE AND RELEVANCE'] = $contentKnowledgeLinks;
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

    $sqlClassroom = "
        SELECT DISTINCT s.subject, 
            cq.semester, 
            cq.academic_year, 
            cq.courseTitle,
            s.linkOne, 
            s.linkTwo, 
            s.linkThree
        FROM classroomobservation cq
        JOIN instructor i ON cq.toFacultyID = i.faculty_Id
        JOIN subject s ON cq.courseTitle = s.subject_code
        WHERE cq.toFacultyID = '$userId'
    ";

    if (!empty($selectedAcademicYear)) {
        $sqlClassroom .= " AND cq.academic_year = '$selectedAcademicYear'";
    }
    if (!empty($selectedSemester)) {
        $sqlClassroom .= " AND cq.semester = '$selectedSemester'";
    }

    $sqlClassroom .= " ORDER BY  cq.academic_year DESC, cq.semester DESC ";

    $sqlClassroom_query = mysqli_query($con, $sqlClassroom);

    if (!$sqlClassroom_query) {
        die("Query Failed: " . mysqli_error($con));
    }
    ?>

    <div class="border border-1 w-100">

        <?php
        if (mysqli_num_rows($sqlClassroom_query) > 0) {
            while ($subject = mysqli_fetch_assoc($sqlClassroom_query)) {
                ?>
                <h4 class="fw-bold text-center p-2">Classroom Observation</h4>

                <h5 class="text-center p-0 mb-3">
                    <span class="fw-bold"><?php echo htmlspecialchars($subject['subject']) ?></span>
                </h5>
                <div class="d-flex justify-content-between flex-row-reverse w-100">

                    <div class="container w-50">

                        <table class="table table-striped table-bordered text-center align-middle">
                            <thead>
                                <tr style="background: #d9534f; color: #fff;">
                                    <th>WEAKNESSES</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $categoriesBelow2 = [];
                                $categoriesAbove2 = [];

                                $sql = "SELECT * FROM `classroomcategories`";
                                $sql_query = mysqli_query($con, $sql);

                                if (mysqli_num_rows($sql_query) > 0) {
                                    while ($categoriesRow = mysqli_fetch_assoc($sql_query)) {
                                        $categories = $categoriesRow['categories'];

                                        $totalRatings = [0, 0, 0, 0, 0];
                                        $ratingCount = 0;

                                        $sqlcriteria = "SELECT * FROM `classroomcriteria` WHERE classroomCategories = '$categories'";
                                        $resultCriteria = mysqli_query($con, $sqlcriteria);

                                        if (mysqli_num_rows($resultCriteria) > 0) {
                                            $selectedSubject = $subject['courseTitle'];
                                            $selectedSemester = $subject['semester'];
                                            $selectedAcademicYear = $subject['academic_year'];

                                            $SQLFaculty = "SELECT * FROM `classroomobservation` WHERE toFacultyID = '$userId' 
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

                                            $averageRating = 0;
                                            if ($ratingCount > 0) {
                                                for ($i = 0; $i < 5; $i++) {
                                                    $averageRating += ($i + 1) * $totalRatings[$i];
                                                }
                                                $averageRating /= $ratingCount;

                                                $interpretationData = classrooomVerbalAndLinks($averageRating, $categories, $selectedSubject, $con);

                                                // Separate categories based on average rating
                                                if ($averageRating < 2) {
                                                    $categoriesBelow2[] = [
                                                        'categories' => $categories,
                                                        'averageRating' => $averageRating,
                                                        'interpretation' => $interpretationData['interpretation'],
                                                        'links' => $interpretationData['links']
                                                    ];
                                                } else {
                                                    $categoriesAbove2[] = [
                                                        'categories' => $categories,
                                                        'averageRating' => $averageRating,
                                                        'interpretation' => $interpretationData['interpretation'],
                                                        'links' => $interpretationData['links']
                                                    ];
                                                }
                                            }
                                        }
                                    }
                                }

                                foreach ($categoriesBelow2 as $row) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['categories']); ?></td>

                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="container w-50">
                        <table class="table table-striped table-bordered text-center align-middle mb-5">
                            <thead>
                                <tr style="background: #5bc0de; color: #fff;">
                                    <th>STRENGTH</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($categoriesAbove2 as $row) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['categories']); ?></td>

                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="container">
                    <table class="table table-striped table-bordered text-center align-middle mb-5">
                        <thead>
                            <tr style="background: #d9534f; color: #fff;">
                                <th colspan="2">SUGGESTED TRAINIGS/SEMINARS</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $categoriesBelow2 = []; // Separate collection for below 2 ratings
                            $categoriesAbove2 = []; // Separate collection for above or equal to 2 ratings
                    
                            $sql = "SELECT * FROM `classroomcategories`";
                            $sql_query = mysqli_query($con, $sql);

                            if (mysqli_num_rows($sql_query) > 0) {
                                while ($categoriesRow = mysqli_fetch_assoc($sql_query)) {
                                    $categories = $categoriesRow['categories'];

                                    $totalRatings = [0, 0, 0, 0, 0];
                                    $ratingCount = 0;

                                    $sqlcriteria = "SELECT * FROM `classroomcriteria` WHERE classroomCategories = '$categories'";
                                    $resultCriteria = mysqli_query($con, $sqlcriteria);

                                    if (mysqli_num_rows($resultCriteria) > 0) {
                                        $selectedSubject = $subject['courseTitle'];
                                        $selectedSemester = $subject['semester'];
                                        $selectedAcademicYear = $subject['academic_year'];

                                        $SQLFaculty = "SELECT * FROM `classroomobservation` WHERE toFacultyID = '$userId' 
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

                                        $averageRating = 0;
                                        if ($ratingCount > 0) {
                                            for ($i = 0; $i < 5; $i++) {
                                                $averageRating += ($i + 1) * $totalRatings[$i];
                                            }
                                            $averageRating /= $ratingCount;

                                            $interpretationData = classrooomVerbalAndLinks($averageRating, $categories, $selectedSubject, $con);

                                            // Separate categories based on average rating
                                            if ($averageRating < 2) {
                                                $categoriesBelow2[] = [
                                                    'categories' => $categories,
                                                    'averageRating' => $averageRating,
                                                    'interpretation' => $interpretationData['interpretation'],
                                                    'links' => $interpretationData['links']
                                                ];
                                            } else {
                                                $categoriesAbove2[] = [
                                                    'categories' => $categories,
                                                    'averageRating' => $averageRating,
                                                    'interpretation' => $interpretationData['interpretation'],
                                                    'links' => $interpretationData['links']
                                                ];
                                            }
                                        }
                                    }
                                }
                            }

                            foreach ($categoriesBelow2 as $row) {
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['categories']); ?></td>

                                    <td>
                                        <?php
                                        if (is_array($row['links'])) {
                                            echo "<ul style='list-style: none; padding: 0; margin: 0;'>";
                                            foreach ($row['links'] as $link) {
                                                $text = htmlspecialchars($link['text']);
                                                $url = !empty($link['url']) ? htmlspecialchars($link['url']) : '';
                                                if (!empty($url)) {
                                                    echo "<li><a href=\"$url\" target=\"_blank\">$text</a></li>";
                                                } else {
                                                    echo "<li>$text</li>";
                                                }
                                            }
                                            echo "</ul>";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <?php
            }
        }
        ?>
    </div>
</div>