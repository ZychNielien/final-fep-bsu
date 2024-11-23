<?php
include "../../model/dbconnection.php";

if (isset($_POST['facultyId']) && isset($_POST['academicYear']) && isset($_POST['semester'])) {
    $facultyId = $_POST['facultyId'];
    $academicYear = $_POST['academicYear'];
    $semester = $_POST['semester'];

    // Prepare and execute the SQL query to check for existing bookings
    $stmt = $con->prepare("SELECT * FROM bookings WHERE faculty_Id = ? AND academic_year = ? AND semester = ?");
    $stmt->bind_param("sss", $facultyId, $academicYear, $semester);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['exists' => true]);
    } else {
        echo json_encode(['exists' => false]);
    }

    $stmt->close();
    $con->close();
}
?>