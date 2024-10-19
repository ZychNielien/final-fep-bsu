<?php
header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $selectedDate = $_POST['date']; // Get the selected date
    $bookedSlots = [];

    // Fetch bookings for the selected date
    $query = "SELECT start_time, end_time, slot FROM bookings WHERE selected_date = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $selectedDate);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $startTime = $row['start_time'];
        $slot = $row['slot'];

        // Create a unique key for booked slots
        $slotKey = "{$startTime}-{$selectedDate}-{$slot}";
        $bookedSlots[$slotKey] = true;
    }

    echo json_encode($bookedSlots);
}

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