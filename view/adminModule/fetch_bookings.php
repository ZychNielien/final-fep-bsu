<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "final-fep-bsu");

$sql = "SELECT * FROM bookings";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $bookings = [];
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($bookings);
} else {
    echo json_encode(["error" => "No bookings found."]);
}
$conn->close();

exit;