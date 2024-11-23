<?php
include "components/navBar.php";

$FacultyID = $userRow['faculty_Id'];

// Query to get the selected_date from the database (assuming id = 1)
$sql = "SELECT classdate FROM classroomdate WHERE id = 1";
$result = $con->query($sql);

// Fetch the result
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $startDate = $row['classdate'];
    $selectedDate = $row['classdate'];  // Get the selected date value from the database
} else {
    $selectedDate = ''; // Default to empty if no data found
}

?>

<head>
    <title>Classroom Observation</title>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../public/css/style.css">
    <link rel="stylesheet" href="../../public/css/sweetalert.min.css">
    <script src="../../public/js/sweetalert2@11.js"></script>
    <script src="../../public/js/jquery-3.7.1.min.js"></script>
    <script src="../../bootstrap/js/bootstrap.bundle.min.js"></script>
</head>

<section class="contentContainer px-3">

    <h3 class="fw-bold text-danger text-center">Classroom Observation</h3>

    <?php
    $preferredScheduleQuery = "SELECT * FROM preferredschedule WHERE faculty_Id = ?";
    $stmt = $con->prepare($preferredScheduleQuery);
    $stmt->bind_param("s", $userRow['faculty_Id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $preferredSchedule = $result->fetch_assoc();
    ?>

    <div class="modal fade" id="preferredSchedule" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="preferredScheduleLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title text-center text-white" id="preferredScheduleLabel">Preferred Schedule</h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="../../controller/facultyQuery.php">
                        <div hidden>
                            <input type="text" name="faculty_Id" value="<?php echo $userRow['faculty_Id'] ?>">
                            <input type="text" name="first_name" value="<?php echo $userRow['first_name'] ?>">
                            <input type="text" name="last_name" value="<?php echo $userRow['last_name'] ?>">
                        </div>

                        <?php
                        $facultyID = $userRow['faculty_Id'];
                        $courseSQL = "SELECT DISTINCT s.subject, s.subject_code
                                  FROM instructor i
                                  JOIN assigned_subject a ON i.faculty_Id = a.faculty_Id
                                  JOIN subject s ON a.subject_id = s.subject_id
                                  WHERE i.faculty_Id = ?";
                        $courseStmt = $con->prepare($courseSQL);
                        $courseStmt->bind_param("s", $facultyID);
                        $courseStmt->execute();
                        $courseSQL_query = $courseStmt->get_result();
                        ?>

                        <h5 class="mt-3 fw-bold text-center">Please select subject</h5>
                        <div class="d-flex justify-content-center flex-column">
                            <select id="courseClassroom" name="courseClassroom" class="form-select" required>
                                <option value="" disabled selected>Select Course</option>
                                <?php while ($courseRow = $courseSQL_query->fetch_assoc()): ?>
                                    <option value="<?php echo htmlspecialchars($courseRow['subject_code']); ?>" <?php echo (isset($preferredSchedule['courseClassroom']) && $preferredSchedule['courseClassroom'] == htmlspecialchars($courseRow['subject_code'])) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($courseRow['subject_code']); ?> -
                                        <?php echo htmlspecialchars($courseRow['subject']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <h5 class="mt-3 fw-bold text-center">Please select your primary preferred schedule.</h5>
                        <div class="d-flex justify-content-between">
                            <div class="mb-3">
                                <select class="form-select" id="dayOfWeek" name="dayOfWeek" required>
                                    <option selected disabled value="">Select Day</option>
                                    <?php
                                    $daysOfWeek = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
                                    foreach ($daysOfWeek as $day) {
                                        $selected = (isset($preferredSchedule['dayOfWeek']) && $preferredSchedule['dayOfWeek'] == $day) ? 'selected' : '';
                                        echo "<option value=\"$day\" $selected>$day</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <select class="form-select" id="startTimePreferred" name="startTimePreferred" required>
                                    <option selected disabled value="">Select Start Time</option>
                                    <?php for ($i = 7; $i <= 19; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php echo (isset($preferredSchedule['startTimePreferred']) && $preferredSchedule['startTimePreferred'] == $i) ? 'selected' : ''; ?>>
                                            <?php echo date("g:i A", strtotime("$i:00")); ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <select class="form-select" id="endTimePreferred" name="endTimePreferred" required>
                                    <option selected disabled value="">Select End Time</option>
                                    <?php for ($i = 7; $i <= 19; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php echo (isset($preferredSchedule['endTimePreferred']) && $preferredSchedule['endTimePreferred'] == $i) ? 'selected' : ''; ?>>
                                            <?php echo date("g:i A", strtotime("$i:00")); ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>

                        <h5 class="mt-3 fw-bold text-center">Please select your secondary preferred schedule.</h5>
                        <div class="d-flex justify-content-between">
                            <div class="mb-3">
                                <select class="form-select" id="dayOfWeekTwo" name="dayOfWeekTwo" required>
                                    <option selected disabled value="">Select Day</option>
                                    <?php
                                    foreach ($daysOfWeek as $day) {
                                        $selected = (isset($preferredSchedule['dayOfWeekTwo']) && $preferredSchedule['dayOfWeekTwo'] == $day) ? 'selected' : '';
                                        echo "<option value=\"$day\" $selected>$day</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <select class="form-select" id="startTimeSecondary" name="startTimeSecondary" required>
                                    <option selected disabled value="">Select Start Time</option>
                                    <?php for ($i = 7; $i <= 19; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php echo (isset($preferredSchedule['startTimeSecondary']) && $preferredSchedule['startTimeSecondary'] == $i) ? 'selected' : ''; ?>>
                                            <?php echo date("g:i A", strtotime("$i:00")); ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <select class="form-select" id="endTimeSecondary" name="endTimeSecondary" required>
                                    <option selected disabled value="">Select End Time</option>
                                    <?php for ($i = 7; $i <= 19; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php echo (isset($preferredSchedule['endTimeSecondary']) && $preferredSchedule['endTimeSecondary'] == $i) ? 'selected' : ''; ?>>
                                            <?php echo date("g:i A", strtotime("$i:00")); ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" name="preferredSched">Submit</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="evaluationResults" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="evaluationResultsLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title text-center text-white" id="evaluationResultsleLabel">Classroom Observation
                        Results
                    </h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php

                    function sanitizeColumnName($name)
                    {
                        return preg_replace('/[^a-zA-Z0-9_]/', '', trim($name));
                    }

                    $FacultyID = $userRow['faculty_Id'];

                    $sqlSAY = "
                        SELECT DISTINCT sf.semester, sf.academic_year 
                        FROM classroomobservation sf
                        JOIN instructor i ON sf.toFacultyID = i.faculty_Id
                        WHERE sf.toFacultyID = '$FacultyID'
                          AND sf.semester IS NOT NULL AND sf.semester != ''
                          AND sf.academic_year IS NOT NULL AND sf.academic_year != ''
                    ";

                    $sqlSAY_query = mysqli_query($con, $sqlSAY);

                    $semesters = [];
                    $academicYears = [];

                    while ($academicYearSemester = mysqli_fetch_assoc($sqlSAY_query)) {
                        $semesters[] = $academicYearSemester['semester'];
                        $academicYears[] = $academicYearSemester['academic_year'];
                    }

                    $selectedSemester = isset($_POST['semester']) ? $_POST['semester'] : '';
                    $selectedAcademicYear = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';


                    ?>

                    <!-- FILTER FOR SEMESTER AND ACADEMIC YEAR -->
                    <form method="POST" action=""
                        class="mb-4 d-flex justify-content-evenly align-items-center text-center">
                        <div class="mb-3">
                            <label for="academic_year" class="form-label">Academic Year:</label>
                            <select id="academic_year" name="academic_year" class="form-select">
                                <option value="">Select Academic Year</option>
                                <?php foreach (array_unique($academicYears) as $year): ?>
                                    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="semester" class="form-label">Semester:</label>
                            <select id="semester" name="semester" class="form-select">
                                <option value="">Select Semester</option>
                                <?php foreach (array_unique($semesters) as $semester): ?>
                                    <option value="<?php echo $semester; ?>"><?php echo $semester; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-success"
                                onclick="printPartOfPage('classroomResult')">Print
                                Content</button>
                        </div>
                    </form>

                    <div class="overflow-auto" style="max-height: 500px">
                        <!-- RESULT OF DATA FROM THE STUDENTS EVALUATION -->
                        <div id="classroomResult"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="preferredSched">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-evenly align-items-center">
        <div class="form-group" style="display:none;">
            <label for="date-select">Select Date:</label>
            <input type="date" class="form-control" id="date-select">
        </div>

        <div class="form-group">
            <label for="date_dropdown" class="form-label">Select Date:</label>
            <select name="date_dropdown" id="date_dropdown" class="form-select">
                <?php
                // Convert the start date to a DateTime object
                $startDateObj = new DateTime($startDate);

                // Get today's date
                $currentDate = new DateTime();

                // Loop to create 5 options, one day apart
                for ($i = 0; $i < 5; $i++) {
                    // Format the date for value (Y-m-d) and for display (e.g., Nov 4, 2024)
                    $dateValue = $startDateObj->format('Y-m-d');
                    $dateDisplay = $startDateObj->format('F j, Y');

                    // Check if the current date is in the past
                    $isDisabled = $startDateObj < $currentDate ? 'disabled' : '';

                    // Echo the option with the disabled attribute if it's a past date
                    echo '<option value="' . $dateValue . '" ' . $isDisabled . '>' . $dateDisplay . '</option>';

                    // Add 1 day to the current date for the next option
                    $startDateObj->modify('+1 day');
                }
                ?>
            </select>

        </div>

        <div class="form-group">
            <label for="start-time-select" class="form-label">Start Time:</label>
            <select class="form-select" id="start-time-select">
                <option value="">Select Start Time</option>
            </select>
        </div>

        <div class="form-group">
            <label for="end-time-select" class="form-label">End Time:</label>
            <select class="form-select" id="end-time-select" disabled>
                <option value="">Select End Time</option>
            </select>
        </div>

        <div class="form-group">
            <label for="slot-select" class="form-label">Select Slot:</label>
            <select class="form-select" id="slot-select" disabled>
                <option value="">Select Slot</option>
                <option value="1">Slot 1</option>
                <!-- <option value="2">Slot 2</option> -->
            </select>
        </div>


        <button class="btn btn-success" id="book-btn" disabled>Book</button>

    </div>

    <div class="my-3 d-flex justify-content-between">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#evaluationResults">Classroom Observation Results</button>
        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#preferredSchedule">Preffered
            Schedule for Autobooking</button> -->
    </div>

    <table id="reservation-table" class="table table-bordered mt-2 "
        style="text-align: center; vertical-align: middle;"></table>

    <!-- Booking Modal -->
    <div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reservationModalLabel">Reservation Form</h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <?php
                    $facultyID = $userRow['faculty_Id'];
                    $courseSQL = "SELECT DISTINCT s.subject, s.subject_code
              FROM instructor i
              JOIN assigned_subject a ON i.faculty_Id = a.faculty_Id
              JOIN subject s ON a.subject_id = s.subject_id
              WHERE i.faculty_Id = '$facultyID'";

                    $courseSQL_query = mysqli_query($con, $courseSQL);
                    ?>
                    <form id="form" method="POST">
                        <div class="form-group my-2">
                            <label for="course">Course Title:</label>
                            <select id="course" name="course" class="form-select" required>
                                <option value="" disabled selected>Select Course</option>
                                <?php while ($courseRow = mysqli_fetch_assoc($courseSQL_query)): ?>
                                    <option value="<?php echo htmlspecialchars($courseRow['subject_code']); ?>">
                                        <?php echo htmlspecialchars($courseRow['subject_code']); ?> -
                                        <?php echo htmlspecialchars($courseRow['subject']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group my-2">
                            <label for="name">Instructor:</label>
                            <input type="text" class="form-control" id="name"
                                value="<?php echo $userRow["first_name"] . ' ' . $userRow["last_name"]; ?>" required>
                            <input type="text" class="form-control" id="fromFacultyID"
                                value="<?php echo $userRow["faculty_Id"]; ?>" required hidden>
                        </div>
                        <div class="form-group my-2">
                            <label for="room">Room:</label>
                            <input type="text" class="form-control" id="room" required>
                        </div>
                        <div class="form-group" style="display:none;">
                            <input type="text" value="0" id="evaluationStatus">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Cancel Booking Modal -->

</section>
<?php
// Fetching the academic year and semester from the database
$sqlSAYSelect = "SELECT * FROM academic_year_semester WHERE id = 2";
$result = mysqli_query($con, $sqlSAYSelect);
$selectSAY = mysqli_fetch_assoc($result);

$semester = $selectSAY['semester'];
$academic_year = $selectSAY['academic_year'];
?>

<script>

    function printPartOfPage(elementId) {
        var printContent = document.getElementById(elementId);
        var windowUrl = 'about:blank';
        var uniqueName = new Date();
        var windowName = 'Print' + uniqueName.getTime();
        var printWindow = window.open(windowUrl, windowName, 'width=1000,height=1000');

        printWindow.document.write(`
        <!DOCTYPE html>
        <html>
            <head>
                <title>Print</title>
                <style>
                    table {
                        width:100% !important;
                        border-collapse: collapse !important;
                        text-align: center !important;
                    }
                    table tr {
                        background-color: white !important;
                        color: black !important;
                    }
                    th, td  {
                        border: 1px solid black !important;
                    }
                    th:last-child,
                    td:last-child {
                        display: none !important;
                    }
                    .ulo {
                        width: 100% !important;
                        display: flex !important;
                        justify-content:  space-evenly !important;
                    }
                    .ulo h5 {
                        font-size: 18px !important;
                        text-align: center !important;   
                    }
                </style>
            </head>
            <body>
                <h2 style="text-align: center;">Classroom Observation Results</h2>
                <h3 >Faculty : <?php echo $userRow['first_name'] . ' ' . $userRow['last_name'] ?></h3>
                ${printContent.innerHTML}
            </body>
        </html>
    `);
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();

        // Close the print window after printing
        printWindow.close();
    }

    $(document).ready(function () {

        fetchFilteredResults();

        $('#academic_year, #semester').change(function () {
            fetchFilteredResults();
        });

        $('#startTimePreffered').change(function () {
            var selectedStartTime = parseInt($(this).val());
            var endTimeSelect = $('#endTimePreffered');

            endTimeSelect.find('option').not(':first').remove();

            for (var i = selectedStartTime + 1; i <= 19; i++) {
                endTimeSelect.append('<option value="' + i + '">' + (i === 12 ? '12:00 PM' : (i <= 12 ? i + ':00 AM' : (i - 12) + ':00 PM')) + '</option>');
            }
        });

    });

    // FILTER FOR SEMESTER AND ACADEMIC YEAR
    function fetchFilteredResults() {
        var semester = $('#semester').val();
        var academicYear = $('#academic_year').val();

        if (semester === '' && academicYear === '') {
            $.ajax({
                type: 'POST',
                url: 'filterclassroom.php',
                data: {
                    fetchAll: true
                },
                success: function (data) {

                    $('#classroomResult').html(data);
                },

            });
        } else {
            $.ajax({
                type: 'POST',
                url: 'filterclassroom.php',
                data: {
                    semester: semester,
                    academic_year: academicYear
                },
                success: function (data) {

                    $('#classroomResult').html(data);
                },
            });
        }
    }
</script>

<script>
    let bookedSlots = {};
    let slotToCancel = null;
    let currentBookings = []; // Add this line to store the current bookings

    $(document).ready(function () {
        var selectedClassDate = "<?php echo $selectedDate; ?>";
        $('#date-select').val(selectedClassDate);

        // Check if start-time-select should be disabled when the page loads
        checkStartTimeAvailabilityOnLoad();

        loadBookings();
        createReservationTable(); // Pass currentBookings here for the first time
        updateStartTimeOptions();

        // When the date is changed, update everything accordingly
        $('#date-select').change(function () {
            createReservationTable(currentBookings); // Pass the current bookings on date change
            updateStartTimeOptions();
            updateSlotOptions();
            checkStartTimeAvailability(); // Re-check if start-time-select should be enabled/disabled
        });

        $('#start-time-select').change(function () {
            updateEndTimeOptions();
            checkStartTimeAvailability();
            updateSlotOptions();
        });

        // When the date input changes (e.g. manually typed in), check if start-time-select should be disabled
        $('#date-select').on('input', function () {
            const selectedDate = $(this).val();

            // Disable start-time-select if the selected date is "1970-01-01" or empty
            $('#start-time-select').prop('disabled', selectedDate === "1970-01-01" || selectedDate === "");
        });

        // Call this function after the relevant inputs are changed
        $('#date-select, #start-time-select, #end-time-select').on('change', checkSlotAvailability);

        $('#end-time-select').change(checkSlotAvailability);
        $('#slot-select').change(checkSlotAvailability);
        $('#book-btn').click(openForm);
        $('#form').submit(submitForm);
        $(document).on('click', '#confirm-cancel-btn', confirmCancelBooking);
    });

    function checkStartTimeAvailabilityOnLoad() {
        const selectedDate = $('#date-select').val();

        // Disable start-time-select if the date is "1970-01-01" or empty
        if (selectedDate === "1970-01-01" || selectedDate === "") {
            $('#start-time-select').prop('disabled', true);
        } else {
            $('#start-time-select').prop('disabled', false);
        }
    }


    function loadBookings() {
        $.ajax({
            url: 'fetch_bookings.php',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                console.log('Raw Response:', response); // Check the raw response

                // Ensure the response is an array and has data
                if (!Array.isArray(response)) {
                    console.error('Error: Response is not an array. Received:', response);
                    return;
                }

                // Process bookings data
                if (response.length === 0) {
                    console.warn('No bookings found.'); // Warn if no bookings are present
                }
                currentBookings = response; // Store the bookings in the currentBookings variable
                createReservationTable(currentBookings); // Pass bookings to the reservation table
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('AJAX error:', textStatus, errorThrown); // Print the error
                alert('An error occurred while fetching bookings.');
            }
        });
    }

    function createReservationTable(bookings = []) {
        const selectedDate = new Date($('#date-select').val());
        const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        const headerRow = $('<tr>').addClass('bg-danger text-white py-3').css('border', '2px solid white')
            .append($('<th rowspan="2" style="vertical-align: middle">DATE / TIME</th>'));

        for (let i = 0; i < 5; i++) {
            const day = new Date(selectedDate);
            day.setDate(selectedDate.getDate() + i);
            const dateHeader = `${day.toLocaleString('default', { month: 'long' })} ${day.getDate()}, ${day.getFullYear()}`;
            const dayHeader = days[day.getDay()];

            const dateCell = $('<th>').attr('colspan', 2).html(`${dateHeader}<br>${dayHeader}`).addClass('py-3').css({
                'border': '2px solid white',
                'letter-spacing': '2px'
            });
            headerRow.append(dateCell);
        }

        const slotHeaderRow = $('<tr>').append($('<th style="display: none;"></th>'));
        for (let i = 0; i < 5; i++) {
            slotHeaderRow.append($('<th style="display: none;">').addClass('bg-danger text-white py-3').attr('colspan', 2).css('border', '2px solid white').text('Slot 1'));
            // .append($('<th>').addClass('bg-danger text-white py-3').css('border', '2px solid white').text('Slot 2'));
        }

        $('#reservation-table').empty().append(headerRow).append(slotHeaderRow);

        // Create booked slots object if not already defined globally
        if (!bookedSlots) {
            bookedSlots = {};
        }

        bookings.forEach(booking => {
            const startHour = parseInt(booking.start_time);
            const endHour = parseInt(booking.end_time);
            const date = new Date(booking.selected_date).getTime();
            const slotNumber = booking.slot;

            for (let hour = startHour; hour < endHour; hour++) {
                const slotKey = `${hour}-${date}-${slotNumber}`;
                bookedSlots[slotKey] = booking; // Store booking information in the global bookedSlots object
            }
        });

        for (let hour = 7; hour < 19; hour++) {
            const row = $('<tr>').addClass('bg-danger text-white').css('border', '2px solid white').append($('<td>').text(`${hour > 12 ? hour - 12 : hour}:00 to ${hour + 1 > 12 ? hour + 1 - 12 : hour + 1}:00 ${hour >= 12 ? 'PM' : 'AM'}`));

            for (let i = 0; i < 5; i++) {
                const dayOffset = new Date(selectedDate);
                dayOffset.setDate(selectedDate.getDate() + i);
                const slotKey1 = `${hour}-${dayOffset.getTime()}-1`;
                // const slotKey2 = `${hour}-${dayOffset.getTime()}-2`;

                const cell1 = $('<td>').attr('colspan', 2).css({
                    'border': '2px solid #fff',
                    'color': '#000',
                    'background': '#c1d7b5'
                }).text('Available');

                // const cell2 = $('<td>').css({
                //     'border': '2px solid #fff',
                //     'color': '#000',
                //     'background': '#c1d7b5'
                // }).text('Available');

                if (bookedSlots[slotKey1]) {
                    const booking = bookedSlots[slotKey1];
                    if (booking.evaluation_status == 1) {
                        cell1.addClass('py-3 evaluated-slot').css({
                            'border': '2px solid #fff',
                            'color': '#000',
                            'background-color': '#80deea'
                        }).html(`${booking.name}<br> Evaluated`)
                    } else {
                        cell1.addClass('py-3 booked-slot').css({
                            'border': '2px solid #fff',
                            'color': '#000',
                            'background': '#f2b2b2', // Color for regular booked slots
                            'cursor': 'pointer'
                        }).html(`${booking.name}<br>${booking.room}`);
                        cell1.on('click', function () {
                            // Directly call cancelBooking without confirm prompt
                            cancelBooking(booking.id, booking.name);
                        });
                    }
                    // Add click event listener for cell1

                } else {
                    cell1.addClass('py-3').css({
                        'border': '2px solid #fff',
                        'color': '#000',
                        'background': '#c1d7b5'
                    }).text('Available');
                }

                // if (bookedSlots[slotKey2]) {
                //     const booking = bookedSlots[slotKey2];
                //     if (booking.evaluation_status == 1) {
                //         cell2.addClass('py-3 evaluated-slot').css({
                //             'border': '2px solid #fff',
                //             'color': '#000',
                //             'background-color': '#80deea'
                //         }).html(`${booking.name}<br> Evaluated`)
                //     } else {
                //         cell2.addClass('py-3 booked-slot').css({
                //             'border': '2px solid #fff',
                //             'color': '#000',
                //             'background': '#f2b2b2', // Color for regular booked slots
                //             'cursor': 'pointer'
                //         }).html(`${booking.name}<br>${booking.room}`);
                //         cell2.on('click', function () {
                //             // Directly call cancelBooking without confirm prompt
                //             cancelBooking(booking.id, booking.name);
                //         });
                //     }
                // } else {
                //     cell2.addClass('py-3').css({
                //         'border': '2px solid #fff',
                //         'color': '#000',
                //         'background': '#c1d7b5'
                //     }).text('Available');
                // }

                row.append(cell1);
                // .append(cell2)
            }
            $('#reservation-table').append(row);
        }
    }


    function updateStartTimeOptions() {
        const startTimeSelect = $('#start-time-select');
        startTimeSelect.empty().append('<option value>Select Start Time</option>');
        for (let hour = 7; hour < 19; hour++) {
            startTimeSelect.append(`<option value="${hour}">${hour > 12 ? hour - 12 : hour}:00 ${hour >= 12 ? 'PM' : 'AM'}</option>`);
        }
    }

    function updateEndTimeOptions() {
        const endTimeSelect = $('#end-time-select');
        const startTime = parseInt($('#start-time-select').val());
        endTimeSelect.empty().append('<option value>Select End Time</option>');


        for (let hour = startTime + 1; hour <= startTime + 5 && hour <= 19; hour++) {
            endTimeSelect.append(`<option value="${hour}">${hour > 12 ? hour - 12 : hour}:00 ${hour >= 12 ? 'PM' : 'AM'}</option>`);
        }

        endTimeSelect.prop('disabled', endTimeSelect.children().length === 1);
    }
    function updateSlotOptions() {
        const slotSelect = $('#slot-select');
        const endTime = parseInt($('#end-time-select').val());
        slotSelect.prop('disabled', endTime <= parseInt($('#start-time-select').val()));
    }

    function checkStartTimeAvailability() {
        const selectedDate = new Date($('#date-select').val());
        const startTime = parseInt($('#start-time-select').val());

        if (isNaN(startTime)) {
            $('#book-btn').prop('disabled', true);
            $('#slot-select').prop('disabled', true);
            return;
        }

        const slotKey1 = `${startTime}-${selectedDate.getTime()}-1`;
        const slotKey2 = `${startTime}-${selectedDate.getTime()}-2`;

        const isSlot1Booked = bookedSlots[slotKey1];
        const isSlot2Booked = bookedSlots[slotKey2];

        checkSlotAvailability();
    }

    function checkSlotAvailability() {
        const selectedDate = new Date($('#date-select').val());
        const startTime = parseInt($('#start-time-select').val());
        const endTime = parseInt($('#end-time-select').val());

        if (isNaN(startTime) || isNaN(endTime) || endTime <= startTime) {
            $('#book-btn').prop('disabled', true);
            $('#slot-select').prop('disabled', true);
            return;
        }

        const slotKey1 = `${startTime}-${selectedDate.getTime()}-1`;
        const slotKey2 = `${startTime}-${selectedDate.getTime()}-2`;

        const isSlot1Booked = bookedSlots[slotKey1];
        const isSlot2Booked = bookedSlots[slotKey2];

        if (isSlot1Booked && isSlot2Booked) {
            $('#slot-select').prop('disabled', true);
            $('#book-btn').prop('disabled', true);
            Swal.fire("Error!", "Both slots are already booked.", "error");
        } else {
            $('#slot-select').prop('disabled', false);
            $('#book-btn').prop('disabled', false);
        }
    }




    function openForm() {
        $('#reservationModal').modal('show');
    }

    function submitForm(event) {
        event.preventDefault();

        const course = $('#course').val();
        const name = $('#name').val();
        const room = $('#room').val();
        const fromFacultyID = $('#fromFacultyID').val();
        const selectedDate = new Date($('#date_dropdown').val());
        const startTime = parseInt($('#start-time-select').val());
        const endTime = parseInt($('#end-time-select').val());
        const selectedSlot = $('#slot-select').val();
        const evaluationStatus = $('#evaluationStatus').val();
        const academicYear = "<?php echo $academic_year; ?>";  // PHP to JS injection
        const semester = "<?php echo $semester; ?>";    // Make sure this ID matches your form's field

        if (isNaN(endTime) || endTime <= startTime) {
            Swal.fire("Error!", "Please select a valid end time.", "error");
            return;
        }

        let allAvailable = true;

        for (let hour = startTime; hour < endTime; hour++) {
            const slotKey = `${hour}-${selectedDate.getTime()}-${selectedSlot}`;
            if (bookedSlots[slotKey]) {
                allAvailable = false;
                break;
            }
        }

        if (!allAvailable) {
            Swal.fire("Error!", "This slot is already booked.", "error");
            return;
        }

        console.log({
            facultyId: fromFacultyID,
            academicYear: academicYear,
            semester: semester
        });

        // Check if the faculty member already has a booking for the selected academic year and semester
        $.ajax({
            url: 'check_faculty_booking.php',
            method: 'POST',
            dataType: 'json',
            data: {
                facultyId: fromFacultyID,
                academicYear: academicYear,
                semester: semester

            },
            success: function (response) {
                if (response.exists) {
                    Swal.fire("Error!", "You have an active booking for the current academic year and semester.", "error");
                } else {
                    // Proceed with the booking submission if no existing booking is found
                    const bookingData = {
                        course: course,
                        name: name,
                        room: room,
                        fromFacultyID: fromFacultyID,
                        selected_date: selectedDate.toISOString().split('T')[0],
                        start_time: startTime,
                        end_time: endTime,
                        selected_slot: selectedSlot,
                        evaluation_status: evaluationStatus,
                        academic_year: academicYear,
                        semester: semester
                    };

                    console.log("Booking Data:", bookingData);

                    $.ajax({
                        type: "POST",
                        url: "saveClassroom.php",
                        data: bookingData,
                        dataType: "json",
                        contentType: "application/x-www-form-urlencoded",
                        success: function (response) {
                            const updatedBooking = response;
                            const slotKey = `${updatedBooking.startTime}-${updatedBooking.selectedDate}-${updatedBooking.slot}`;
                            bookedSlots[slotKey] = {
                                name: updatedBooking.name,
                                room: updatedBooking.room,
                            };

                            createReservationTable();
                            $('#reservationModal').modal('hide');

                            Swal.fire({
                                icon: 'success',
                                title: 'Booking Successful!',
                                text: 'Your booking has been saved successfully.',
                                timer: 2000,
                                timerProgressBar: true,
                                willClose: () => {
                                    location.reload();
                                }
                            });
                        },
                        error: function (xhr, status, error) {
                            console.error("AJAX Error:", {
                                status: status,
                                error: error,
                                responseText: xhr.responseText,
                                statusCode: xhr.status
                            });

                            Swal.fire({
                                icon: "error",
                                title: "Error!",
                                text: `An error occurred while saving the booking. Status: ${status} (${xhr.status})`,
                                footer: `<pre>${xhr.responseText}</pre>`
                            });
                        }
                    });
                }
            },
            error: function () {
                Swal.fire("Error!", "An error occurred while checking for existing bookings.", "error");
            }
        });
    }

    var facultyId = "<?php echo $userRow['faculty_Id']; ?>";

    function cancelBooking(bookingId) {
        // Show confirmation before deleting
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "cancelBooking.php", // Your server-side script to handle the cancellation
                    data: {
                        id: bookingId,
                        facultyId: facultyId // Send Faculty ID along with Booking ID
                    },
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('Deleted!', 'Your booking has been deleted.', 'success').then(() => {
                                location.reload(); // Refresh the bookings after successful deletion
                            });
                        } else {
                            Swal.fire('Error!', 'You are not authorized to delete this booking.', 'error');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error('Error deleting booking:', textStatus, errorThrown);
                        Swal.fire('Error!', 'An error occurred while deleting the booking.', 'error');
                    }
                });
            }
        });
    }</script>