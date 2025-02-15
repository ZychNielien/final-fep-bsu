<?php
session_start();

$conn = new mysqli("localhost", "root", "", "final-fep-bsu");


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updates'])) {
    $updates = $_POST['updates'];


    foreach ($updates as $update) {
        $timeSlotKey = $update['timeSlotKey'];
        $evaluationStatus = 1;

        $stmt = $conn->prepare("UPDATE bookings SET evaluation_status = ? WHERE timeSlotKey = ?");
        $stmt->bind_param("is", $evaluationStatus, $timeSlotKey);
        $stmt->execute();
    }

    $conn->close();
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>