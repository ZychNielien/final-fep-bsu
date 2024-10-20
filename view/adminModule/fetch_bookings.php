<?php
header('Content-Type: application/json');

include "../../model/dbconnection.php";

$sql = "SELECT * FROM bookings";
$result = $con->query($sql);

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
$con->close();

exit;