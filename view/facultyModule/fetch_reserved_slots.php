<?php
// Assume database connection is already established

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

$date = $data->date;
$startTime = $data->startTime;
$endTime = $data->endTime;

// Modify the SQL query according to your actual bookings structure
$query = "SELECT slot FROM bookings WHERE selected_date = ? AND (start_time < ? AND end_time > ?)";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('sii', $date, $endTime, $startTime);
$stmt->execute();
$result = $stmt->get_result();

$bookedSlots = [];
while ($row = $result->fetch_assoc()) {
    $bookedSlots[] = $row['slot']; // Assuming slot_key represents a unique identifier for each time slot
}

echo json_encode($bookedSlots);
?>