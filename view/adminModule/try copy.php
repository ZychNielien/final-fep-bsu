<?php

include "../../model/dbconnection.php";

session_start();

$userId = 4;
$userName = 'maan';



function sanitizeColumnName($name)
{
    return preg_replace('/[^a-zA-Z0-9_]/', '', trim($name));
}

function classroomVerbalAndLinks($averageRating, $categories, $selectedSubject, $con): array
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

    if (
        empty($categoryLinks[$categories]['linkOne']) && empty($categoryLinks[$categories]['linkTwo']) &&
        empty($categoryLinks[$categories]['linkThree'])
    ) {
        $categoryLinks['TEACHING EFFECTIVENESS'] = $contentKnowledgeLinks;
    }

    if ($averageRating < 2 && !empty($categoryLinks[$categories])) {
        foreach (['linkOne', 'linkTwo', 'linkThree'] as $linkKey) {
            if (!empty($categoryLinks[$categories][$linkKey])) {
                $result['links'][] = [
                    'text' => 'Recommendation
        Link',
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
?>

<div class="border border-1 w-100">


    <?php


    if ($sqlSubject_query) {
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

                                            $interpretationData = classroomVerbalAndLinks($averageRating, $categories, $selectedSubject, $con);

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

                                        $interpretationData = classroomVerbalAndLinks($averageRating, $categories, $selectedSubject, $con);

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