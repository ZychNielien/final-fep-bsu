<?php
include "model/dbconnection.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch the current status and semester/academic_year
    $statusSql = "SELECT semester, academic_year FROM academic_year_semester WHERE id = 3";
    $result = $con->query($statusSql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (!empty($row['semester']) && !empty($row['academic_year'])) {
            echo json_encode(["status" => "success", "toggleStatus" => 1]);
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
            $sql = "SELECT id FROM academic_year_semester WHERE id = 3";
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                // Update existing record
                $updateSql = "UPDATE academic_year_semester SET status = 1, semester = ?, academic_year = ? WHERE id = 3";
                $stmt = $con->prepare($updateSql);
                $stmt->bind_param("ss", $semester, $academicYear);

                if ($stmt->execute()) {
                    // Perform random assignments
                    $sql = "SELECT faculty_Id FROM instructor WHERE status = 1";
                    $result = $con->query($sql);

                    if ($result->num_rows > 0) {
                        $userIds = [];
                        while ($row = $result->fetch_assoc()) {
                            $userIds[] = $row['faculty_Id'];
                        }

                        $totalUsers = count($userIds);
                        $totalRandomIds = $totalUsers * 5;
                        $randomAssignmentsCount = floor($totalRandomIds / $totalUsers);

                        $randomCount = array_fill_keys($userIds, 0);
                        shuffle($userIds);
                        $assignments = [];

                        foreach ($userIds as $userId) {
                            $filteredIds = array_filter($userIds, function ($id) use ($userId) {
                                return $id != $userId;
                            });

                            shuffle($filteredIds);

                            $assignedRandomIds = [];
                            foreach ($filteredIds as $randomId) {
                                if ($randomCount[$randomId] < $randomAssignmentsCount) {
                                    $assignedRandomIds[] = $randomId;
                                    $randomCount[$randomId]++;
                                }

                                if (count($assignedRandomIds) == 5) {
                                    break;
                                }
                            }

                            foreach ($assignedRandomIds as $randomId) {
                                $insertStmt = $con->prepare("INSERT INTO randomfaculty (faculty_Id, random_Id, semester, academic_year) VALUES (?, ?, ?, ?)");
                                if ($insertStmt === false) {
                                    echo json_encode(["status" => "error", "message" => "Error in prepare: " . $con->error]);
                                    exit;
                                }
                                $insertStmt->bind_param("iiss", $userId, $randomId, $semester, $academicYear);
                                if (!$insertStmt->execute()) {
                                    echo json_encode(["status" => "error", "message" => "Execute failed: " . $insertStmt->error]);
                                    exit;
                                }
                            }

                            $assignments[$userId] = $assignedRandomIds;
                        }

                        $minAssignments = min($randomCount);
                        $maxAssignments = max($randomCount);

                        if ($maxAssignments - $minAssignments > 1) {
                            echo json_encode(["status" => "error", "message" => "The Peer to Peer evaluation for the academic year: " . $academicYear . " and semester: " . $semester . " is now open."]);
                            exit;
                        }

                        echo json_encode([
                            "status" => "success",
                            "message" => "The Peer to Peer evaluation for the academic year: " . $academicYear . " and semester: " . $semester . " is now open."
                        ]);
                    } else {
                        echo json_encode(["status" => "error", "message" => "No faculty members found."]);
                    }
                } else {
                    echo json_encode(["status" => "error", "message" => "Error in saving data: " . $stmt->error]);
                }

            } else {
                $insertSql = "INSERT INTO academic_year_semester (id, status, semester, academic_year) VALUES (3, 1, ?, ?)";
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
        $clearSql = "UPDATE academic_year_semester SET status = 0, semester = NULL, academic_year = NULL WHERE id = 3";
        if ($con->query($clearSql) === TRUE) {
            $clearSql = "DELETE FROM randomfaculty";
            if ($con->query($clearSql) === TRUE) {
                echo json_encode(["status" => "success", "message" => "All random faculty IDs and the selected Academic Year and Semester have been cleared."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Error in clearing data: " . $con->error]);
        }
    }

    exit;
}
?>