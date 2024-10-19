<?php
$conn = new mysqli("localhost", "root", "", "final-fep-bsu");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the AJAX request
    $date = $_POST['date'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];
    $slot = $_POST['slot'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO bookings (selected_date, start_time, end_time, slot) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $date, $startTime, $endTime, $slot);

    // Execute the query
    if ($stmt->execute()) {
        echo "Booking successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
    exit; // Stop further execution
}

// Fetch existing bookings for today and the next two days
$bookings = [];
$today = date('Y-m-d');
for ($i = 0; $i < 3; $i++) {
    $dateToCheck = date('Y-m-d', strtotime("+$i days", strtotime($today)));
    $result = $conn->query("SELECT start_time, end_time, slot FROM bookings WHERE selected_date = '$dateToCheck'");
    while ($row = $result->fetch_assoc()) {
        $bookings[$dateToCheck][] = $row;
    }
}

// Define the time slots
$timeSlots = [
    "7:00 AM",
    "8:00 AM",
    "9:00 AM",
    "10:00 AM",
    "11:00 AM",
    "12:00 PM",
    "1:00 PM",
    "2:00 PM",
    "3:00 PM",
    "4:00 PM",
    "5:00 PM",
    "6:00 PM",
    "7:00 PM"
];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Schedule</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            /* Light background for contrast */
        }

        h2 {
            color: #333;
            /* Darker text color for the header */
        }

        .table {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Add shadow for depth */
        }

        th {
            background-color: #007bff;
            /* Primary Bootstrap color for headers */
            color: white;
            /* White text color for headers */
        }

        td {
            background-color: #fff;
            /* White background for cells */
        }

        td:hover {
            background-color: #f1f1f1;
            /* Light gray on hover */
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Booking Schedule</h2>

        <!-- Date Selector -->
        <form method="get" action="">
            <label for="date">Select Date:</label>
            <input type="date" name="date" id="date" value="<?php echo $selectedDate; ?>">
            <input type="submit" value="Submit">
        </form>

        <?php
        $conn = new mysqli("localhost", "root", "", "final-fep-bsu");

        // Get the selected date from the query parameter or default to today's date
        $selectedDate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

        // Generate the next three dates based on the selected date
        $dates = [];
        for ($i = 0; $i < 3; $i++) {
            $dates[] = date('Y-m-d', strtotime("+$i days", strtotime($selectedDate)));
        }

        // Sample time slots for two slots each day
        $timeSlots = ['08:00', '09:00']; // Define your actual time slots
        
        // Prepare the SQL statement
        $sql = "SELECT selected_date, start_time, slot FROM bookings WHERE selected_date IN ('" . implode("','", $dates) . "')";

        // Execute the query
        // Get the selected date from the query parameter or default to today's date
        $selectedDate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

        // Generate the next three dates based on the selected date
        $dates = [];
        for ($i = 0; $i < 3; $i++) {
            $dates[] = date('Y-m-d', strtotime("+$i days", strtotime($selectedDate)));
        }

        // Define your time slots for each day
        $timeSlots = [
            'slot1' => '08:00', // Slot 1 time
            'slot2' => '09:00'  // Slot 2 time
        ];

        // Prepare the SQL statement to fetch bookings
        $sql = "SELECT selected_date, start_time, slot FROM bookings WHERE selected_date IN ('" . implode("','", $dates) . "')";
        $result = $conn->query($sql);

        // Store the bookings in an associative array
        $bookings = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $bookings[$row['selected_date']][$row['slot']] = $row['start_time'];
            }
        }

        // Start of the HTML table
        echo "<table border='1'>";
        echo "<tr><th>Date</th><th>Slot 1</th><th>Slot 2</th></tr>";

        // Loop through each date
        foreach ($dates as $date) {
            echo "<tr>";
            echo "<td>$date</td>"; // Display the date
        
            // Loop through each defined slot
            foreach ($timeSlots as $slotName => $time) {
                $slotStatus = "Available"; // Default status for each slot
        
                // Check if there are bookings for the current date and slot
                if (isset($bookings[$date][$slotName])) {
                    $slotStatus = "Booked"; // Change status if booked
                }

                echo "<td>$slotStatus</td>"; // Display the slot status
            }

            echo "</tr>";
        }

        echo "</table>";

        // Close the database connection
        $conn->close();
        ?>
        <div class="mt-4">
            <h4 class="text-center">Book a Slot</h4>
            <div class="mb-3">
                <label for="startTime" class="form-label">Start Time:</label>
                <select class="form-select" id="startTime">
                    <option value="" disabled selected>Select Start Time</option>
                    <?php foreach ($timeSlots as $time): ?>
                        <option value="<?= $time ?>"><?= $time ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="endTime" class="form-label">End Time:</label>
                <select class="form-select" id="endTime" disabled>
                    <option value="" disabled selected>Select End Time</option>
                    <?php foreach ($timeSlots as $time): ?>
                        <option value="<?= $time ?>"><?= $time ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="slotSelect" class="form-label">Select Slot:</label>
                <select class="form-select" id="slotSelect" disabled>
                    <option value="" disabled selected>Select Slot</option>
                    <option value="slot1">Slot 1</option>
                    <option value="slot2">Slot 2</option>
                </select>
            </div>
            <div class="text-center">
                <button class="btn btn-primary" id="bookButton" disabled>Book Slot</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#dateSelect').change(updateSchedule);

            $('#startTime').change(function () {
                const startTime = $(this).val();
                updateEndTimeOptions(startTime);
                updateInputs();
            });

            $('#endTime').change(updateInputs);
            $('#slotSelect').change(updateInputs);

            // Initialize the schedule when the page loads
            updateSchedule();
        });

        function updateSchedule() {
            const dateInput = $('#dateSelect').val();
            const selectedDate = new Date(dateInput);

            // Update day headers
            $('#day0').text(selectedDate.toLocaleDateString()); // Selected date
            const day1 = new Date(selectedDate);
            day1.setDate(day1.getDate() + 1);
            $('#day1').text(day1.toLocaleDateString()); // Next day
            const day2 = new Date(day1);
            day2.setDate(day1.getDate() + 1);
            $('#day2').text(day2.toLocaleDateString()); // Day after next

            // Show only the selected date and the next two days, hide others
            const rows = $("#scheduleTable tbody tr");
            rows.each(function () {
                const cells = $(this).children();
                for (let i = 1; i < cells.length; i++) {
                    cells.eq(i).text("Available"); // Set to Available or some status
                }
            });
        }

        function updateEndTimeOptions(startTime) {
            const endTimeSelect = $('#endTime');
            endTimeSelect.empty().append('<option value="" disabled selected>Select End Time</option>');
            const times = ["7:00 AM", "8:00 AM", "9:00 AM", "10:00 AM", "11:00 AM", "12:00 PM", "1:00 PM", "2:00 PM", "3:00 PM", "4:00 PM", "5:00 PM", "6:00 PM", "7:00 PM"];

            // Add options based on the selected start time
            let startIndex = times.indexOf(startTime);
            for (let i = startIndex + 1; i < times.length; i++) {
                endTimeSelect.append(`<option value="${times[i]}">${times[i]}</option>`);
            }
            endTimeSelect.prop("disabled", false);
        }

        function updateInputs() {
            const startTime = $('#startTime').val();
            const endTime = $('#endTime').val();
            const slot = $('#slotSelect').val();
            $('#bookButton').prop("disabled", !(startTime && endTime && slot));
        }

        $('#bookButton').click(function () {
            const date = $('#dateSelect').val();
            const startTime = $('#startTime').val();
            const endTime = $('#endTime').val();
            const slot = $('#slotSelect').val();

            $.post("path_to_your_php_file.php", { date, start_time: startTime, end_time: endTime, slot }, function (response) {
                alert(response);
                updateSchedule(); // Refresh the schedule after booking
            });
        });
    </script>
</body>

</html>