<?php

include "../../model/dbconnection.php";

$o_id = $_POST['faculty_Id']; // Ensure faculty_Id is set
$query = "SELECT * FROM studentsform WHERE toFacultyID='$o_id' ORDER BY academic_year DESC , semester DESC";
$query_run = mysqli_query($con, $query);
function sanitizeColumnName($name)
{
    return preg_replace('/[^a-zA-Z0-9_]/', '', trim($name));
}
$ratings = [];
while ($ratingRow = mysqli_fetch_assoc($query_run)) {
    $ratings[] = $ratingRow;
}
if (mysqli_num_rows($query_run) > 0) {

    $sql = "SELECT * FROM studentscategories";
    $sql_query = mysqli_query($con, $sql);

    $semesters_query = "SELECT DISTINCT semester FROM studentsform WHERE toFacultyID='$o_id'";
    $semesters_result = mysqli_query($con, $semesters_query);

    $academic_years_query = "SELECT DISTINCT academic_year FROM studentsform WHERE toFacultyID='$o_id'";
    $academic_years_result = mysqli_query($con, $academic_years_query);

    if (mysqli_num_rows($sql_query)) {
        ?>

        <div id="ratings-container">
            <?php
            foreach ($ratings as $ratingRow) {
                $totalAverage = 0;
                $categoryCount = 0;

                while ($categoryRow = mysqli_fetch_assoc($sql_query)) {
                    $categories = $categoryRow['categories'];
                    $totalRatings = [0, 0, 0, 0, 0];
                    $ratingCount = 0;

                    $sqlcriteria = "SELECT * FROM studentscriteria WHERE studentsCategories = '$categories'";
                    $resultCriteria = mysqli_query($con, $sqlcriteria);

                    if (mysqli_num_rows($resultCriteria) > 0) {
                        while ($criteriaRow = mysqli_fetch_array($resultCriteria)) {
                            $columnName = sanitizeColumnName($criteriaRow['studentsCategories']);
                            $finalColumnName = $columnName . $criteriaRow['id'];

                            $criteriaRating = $ratingRow[$finalColumnName] ?? null;

                            if ($criteriaRating !== null) {
                                $totalRatings[$criteriaRating - 1]++;
                                $ratingCount++;
                            }
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

                $finalAverageRating = ($categoryCount > 0) ? round($totalAverage / $categoryCount, 2) : 0;

                // VERBAL INTERPRETATION NG FINAL AVERAGE RATING
                $verbalInterpretation = '';
                switch (true) {
                    case ($finalAverageRating >= 0 && $finalAverageRating < 1):
                        $verbalInterpretation = '';
                        break;
                    case ($finalAverageRating >= 1 && $finalAverageRating < 2):
                        $verbalInterpretation = '<span class="star">⭐</span>';
                        break;
                    case ($finalAverageRating >= 2 && $finalAverageRating < 3):
                        $verbalInterpretation = '<span class="star">⭐⭐</span>';
                        break;
                    case ($finalAverageRating >= 3 && $finalAverageRating < 4):
                        $verbalInterpretation = '⭐⭐⭐';
                        break;
                    case ($finalAverageRating >= 4 && $finalAverageRating < 5):
                        $verbalInterpretation = '⭐⭐⭐⭐';
                        break;
                    case ($finalAverageRating == 5):
                        $verbalInterpretation = '⭐⭐⭐⭐⭐';
                        break;
                    default:
                        $verbalInterpretation = 'Invalid Rating';
                        break;
                }

                $datetoString = $ratingRow['date'];
                $date = new DateTime($datetoString);
                $formattedDate = $date->format('F j, Y');

                echo '
<div class="rating-row" 
     data-average="' . $finalAverageRating . '" 
     data-semester="' . $ratingRow['semester'] . '" 
     data-academic-year="' . $ratingRow['academic_year'] . '" 
     style="display:flex; justify-content: center;">
    <div class="border rounded-3 m-5 p-2 border-danger flex-column" style="width: 700px;">
        <div class="d-flex justify-content-center align-items-center">
            <span style="font-size: 30px;">Anonymous</span>
        </div>
        <div class="d-flex justify-content-evenly align-items-center m-2">
            <span>Semester: ' . $ratingRow['semester'] . ' </span>
            <span>Academic Year: ' . $ratingRow['academic_year'] . '</span>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <span style="font-size: 30px;">' . $verbalInterpretation . '</span>
            <span class="text-secondary">' . $formattedDate . '</span>
        </div>
        <p class="mx-5 my-3 py-0 text-center">' . $ratingRow['comment'] . '</p>
    </div>
</div>
';
                mysqli_data_seek($sql_query, 0);
            }
            ?>

        </div>
    <?php }

} else {
    echo "  <h1 style='color: red; text-align:center; margin-top: 10px;'>No results found for the selected filter.</h1>";
}
?>