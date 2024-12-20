<?php
include "../../model/dbconnection.php";

// Fetch the current semester and academic year
$selectSemYearPeer = "SELECT semester, academic_year FROM academic_year_semester WHERE id = 3";
$selectSemYearPeer_query = mysqli_query($con, $selectSemYearPeer);
$selectPeerRow = mysqli_fetch_assoc($selectSemYearPeer_query);

// Return the semester and academic year as JSON
if ($selectPeerRow) {
    echo json_encode([
        'semester' => $selectPeerRow['semester'],
        'academic_year' => $selectPeerRow['academic_year']
    ]);
} else {
    echo json_encode(['error' => 'No data found']);
}
?>
