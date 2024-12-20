<?php
include "../../model/dbconnection.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch the current status and semester/academic_year
    $statusSql = "SELECT semester, academic_year FROM academic_year_semester WHERE id = 1";
    $result = $con->query($statusSql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (!empty($row['semester']) && !empty($row['academic_year'])) {
            echo json_encode(["status" => "successStudent", "toggleStatus" => 1]);
        } else {
            echo json_encode(["status" => "success", "toggleStatus" => 0]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "No record found."]);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'assign') {
        $semester = $_POST['semester'] ?? null;
        $academicYear = $_POST['academicYear'] ?? null;

        if ($semester && $academicYear) {
            $sql = "SELECT id FROM academic_year_semester WHERE id = 1";
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                // Update existing record (id = 1)
                $updateSql = "UPDATE academic_year_semester SET status = 1, semester = ?, academic_year = ? WHERE id = 1";
                $stmt = $con->prepare($updateSql);
                $stmt->bind_param("ss", $semester, $academicYear);

                if ($stmt->execute()) {
                    // Now update the record with id = 4
                    $updateSqlFour = "UPDATE academic_year_semester SET status = 1, semester = ?, academic_year = ? WHERE id = 4";
                    $stmt = $con->prepare($updateSqlFour);
                    $stmt->bind_param("ss", $semester, $academicYear);
                    if ($stmt->execute()) {
                        echo json_encode(["status" => "success", "message" => "The Student evaluation for the academic year: " . $academicYear . " and semester: " . $semester . " is now open."]);
                    } else {
                        echo json_encode(["status" => "error", "message" => "Error in updating record with id 4: " . $stmt->error]);
                    }
                } else {
                    echo json_encode(["status" => "error", "message" => "Error in updating record with id 1: " . $stmt->error]);
                }
            } else {
                // If no record with id = 1, insert a new record
                $insertSql = "INSERT INTO academic_year_semester (id, status, semester, academic_year) VALUES (1, 1, ?, ?)";
                $stmt = $con->prepare($insertSql);
                $stmt->bind_param("ss", $semester, $academicYear);

                if ($stmt->execute()) {
                    echo json_encode(["status" => "success", "message" => "Toggle ON and data saved."]);
                } else {
                    echo json_encode(["status" => "error", "message" => "Error in saving data: " . $stmt->error]);
                }
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid semester or academic year."]);
        }
    } elseif ($action === 'clear') {
        // Confirmation has already been asked on the frontend (SweetAlert)
        $clearSql = "UPDATE academic_year_semester SET status = 0, semester = NULL, academic_year = NULL WHERE id = 1";
        if ($con->query($clearSql) === TRUE) {

            echo json_encode(["status" => "success", "message" => "Student Evaluation is Closed."]);

        } else {
            echo json_encode(["status" => "error", "message" => "Error in clearing data: " . $con->error]);
        }
    }

    exit;
}
?>