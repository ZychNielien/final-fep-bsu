<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include "../../model/dbconnection.php";

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

    $sqlSAYSelect = "SELECT * FROM academic_year_semester WHERE id =2";
    $result = mysqli_query($con, $sqlSAYSelect);
    $selectSAY = mysqli_fetch_assoc($result);

    $semester = $selectSAY['semester'];
    $academic_year = $selectSAY['academic_year'];

    // Validate inputs (additional validation may be necessary)
    if (empty($course) || empty($name) || empty($room)) {
        echo json_encode(['success' => false, 'message' => 'Required fields are missing.']);
        exit;
    }
    // Prepare and execute the SQL statement
    $stmt = $con->prepare("INSERT INTO bookings (course, name, room, selected_date, start_time, end_time, slot, evaluation_status, faculty_Id, semester, academic_year) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssiiisiss", $course, $name, $room, $selected_date, $start_time, $end_time, $selected_slot, $evaluation_status, $facultyID, $semester, $academic_year);

    if ($stmt->execute()) {
        $course = $_POST['course'];
        $name = $_POST['name'];
        $room = $_POST['room'];
        $selectedDate = new DateTime($_POST['selected_date']);
        $startTime = intval($_POST['start_time']);
        $endTime = intval($_POST['end_time']);
        $selectedSlot = $_POST['selected_slot'];
        $evaluationStatus = $_POST['evaluation_status'];

        $formattedDate = $selectedDate->format('F d, Y');
        $formattedStartTime = date('g:i A', strtotime("$startTime:00"));
        $formattedEndTime = date('g:i A', strtotime("$endTime:00"));

        $url = "https://script.google.com/macros/s/AKfycbyxelEgiJLf-a-EuL6qdg5QZOaZC6L-EzYNQ4akLi2lImaPvVtavLbgNotMVijqv-g9wA/exec";
        $recipient = 'cicsmalvarevaluation@gmail.com';
        $subject = 'New Classroom Observation Booking';
        $body = "
        Dear Admin,
    
        We are pleased to inform you that a new classroom observation has been successfully booked by $name for the course titled $course. The observation is scheduled to take place in room $room on $formattedDate from $formattedStartTime to $formattedEndTime.
    
        Please review the Classroom Observation for more information.
    
        Best regards,
        Your Booking System
        ";

        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                "recipient" => $recipient,
                "subject" => $subject,
                "body" => $body
            ])
        ]);

        $result = curl_exec($ch);

        if ($result === false) {
            echo 'cURL Error: ' . curl_error($ch);
            exit;
        }

        curl_close($ch);

        echo json_encode(['success' => true, 'message' => 'Booking saved successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
    }

    $stmt->close();
    $con->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>