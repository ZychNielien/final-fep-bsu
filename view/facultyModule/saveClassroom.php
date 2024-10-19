<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

$conn = new mysqli("localhost", "root", "", "final-fep-bsu");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course = $_POST['course'] ?? '';
    $name = $_POST['name'] ?? '';
    $room = $_POST['room'] ?? '';
    $selected_date = $_POST['selected_date'] ?? '';
    $start_time = $_POST['start_time'] ?? 0; // Default to 0 if not set
    $end_time = $_POST['end_time'] ?? 0; // Default to 0 if not set
    $selected_slot = $_POST['selected_slot'] ?? '';
    $evaluation_status = $_POST['evaluation_status'] ?? '';
    $facultyID = $_SESSION["userid"] ?? '';

    // Validate inputs (additional validation may be necessary)
    if (empty($course) || empty($name) || empty($room)) {
        echo json_encode(['success' => false, 'message' => 'Required fields are missing.']);
        exit;
    }

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("INSERT INTO bookings (course, name, room, selected_date, start_time, end_time, slot, evaluation_status,faculty_Id) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?)");
    $stmt->bind_param("ssssisisi", $course, $name, $room, $selected_date, $start_time, $end_time, $selected_slot, $evaluation_status, $facultyID);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Booking saved successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>