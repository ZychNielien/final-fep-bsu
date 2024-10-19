<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

$conn = new mysqli("localhost", "root", "", "final-fep-bsu");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $idPO = $_POST['idPO'];
    $room = $_POST['room'];
    $slot = $_POST['slot'];
    $selectedDate = $_POST['selectedDate'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];
    $evaluationStatus = 0;
    $isEvaluated = false;

    $stmt = $conn->prepare("INSERT INTO bookings (name, course, room, selected_date, start_time, end_time, evaluation_status,slot,faculty_Id) VALUES (?, ?, ?, ?, ?, ?,?, ?,?)");
    $stmt->bind_param("ssssssssi", $name, $subject, $room, $selectedDate, $startTime, $endTime, $evaluationStatus, $slot, $idPO);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>