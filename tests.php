<?php
include "model/dbconnection.php";


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toggle Assignment with SweetAlert</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.2/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        /* Enlarge the switch */
        .form-check-input {
            width: 4rem;
            /* Adjust width */
            height: 2rem;
            /* Adjust height */
        }

        .form-check-label {
            font-size: 1.5rem;
            /* Enlarge text size */
        }

        /* Optional: Adjust the padding and size of the label for better visibility */
        .form-check {
            font-size: 1.5rem;
            /* Adjust the overall font size */
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2>Toggle Example for Assigning Data</h2>

        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="customSwitch1Peer" style="width: 2.5em;">
            <label class="form-check-label" for="customSwitch1Peer">Off</label>
        </div>

        <div id="formFieldsPeer" class="d-none mt-3">
            <!-- The form fields for selecting semester and academic year will be added here dynamically -->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.2/dist/sweetalert2.all.min.js"></script>
    <script>
        const toggleSwitchPeer = document.getElementById('customSwitch1Peer');
        const labelPeer = toggleSwitchPeer.nextElementSibling;
        const formFieldsPeer = document.getElementById('formFieldsPeer');

        function checkToggleStatusPeer() {
            fetch('update_toggle_status.php', {
                method: 'GET'
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Response from server:', data);

                    if (data.status === 'success') {
                        if (data.toggleStatus === 1) {
                            console.log('Toggle should be ON');
                            toggleSwitchPeer.checked = true;
                            labelPeer.textContent = 'Peer to Peer Evaluation is Open.';
                            formFieldsPeer.classList.remove('d-none');
                        } else {
                            console.log('Toggle should be OFF');
                            toggleSwitchPeer.checked = false;
                            labelPeer.textContent = 'Peer to Peer Evaluation is Close.';
                            formFieldsPeer.classList.add('d-none');
                        }
                    }
                })
                .catch(error => console.log('Error fetching toggle status:', error));
        }

        window.onload = function () {
            checkToggleStatusPeer();
        };

        toggleSwitchPeer.addEventListener('change', function () {
            if (toggleSwitchPeer.checked) {
                labelPeer.textContent = 'Peer to Peer Evaluation is Open.';
                formFieldsPeer.classList.remove('d-none');

                Swal.fire({
                    title: 'Please select Semester and Academic Year',
                    html: `
                <div class="mb-3">
                    <label for="semester" class="form-label">Semester</label>
                    <select class="form-select" id="swalSemester" required>
                        <option value="">Select Semester</option>
                        <option value="FIRST">1st Semester</option>
                        <option value="SECOND">2nd Semester</option>
                        <option value="SUMMER">Summer</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="academicYear" class="form-label">Academic Year</label>
                    <select class="form-select" id="swalAcademicYear" required>
                        <option value="">Select Academic Year</option>
                            <?php
                            $currentYear = date("Y");
                            $nextYear = $currentYear + 3;

                            for ($year = $currentYear; $year <= $nextYear; $year++) {
                                $value = "$year-" . ($year + 1);
                                $selected = (isset($academic_year) && $academic_year === $value) ? 'selected' : '';
                                echo "<option value='$value' $selected>$year - " . ($year + 1) . "</option>";
                            } ?>
                        </option>
                    </select>
                </div>
            `,
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                    preConfirm: () => {
                        const semester = document.getElementById('swalSemester').value;
                        const academicYear = document.getElementById('swalAcademicYear').value;
                        if (!semester || !academicYear) {
                            Swal.showValidationMessage('Please fill in all fields');
                            return false;
                        }
                        return { semester, academicYear };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const { semester, academicYear } = result.value;

                        fetch('update_toggle_status.php', {
                            method: 'POST',
                            body: new URLSearchParams({
                                action: 'assign',
                                semester: semester,
                                academicYear: academicYear
                            }),
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            }
                        })
                            .then(response => response.json())
                            .then(data => {
                                Swal.fire('Saved!', data.message, 'success');
                            })
                            .catch(error => {
                                Swal.fire('Error!', 'Something went wrong.', 'error');
                            });
                    } else {
                        toggleSwitchPeer.checked = false;
                        labelPeer.textContent = 'Peer to Peer Evaluation is Close.';
                        formFieldsPeer.classList.add('d-none');
                    }
                });
            } else {
                labelPeer.textContent = 'Peer to Peer Evaluation is Close.';
                formFieldsPeer.classList.add('d-none');

                // Display confirmation dialog before clearing
                Swal.fire({
                    title: 'Closing Evaluation',
                    text: "Are you sure you want to close the evaluation for Peer to Peer?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, close it!',
                    cancelButtonText: 'No, keep it'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Proceed with the clear action
                        fetch('update_toggle_status.php', {
                            method: 'POST',
                            body: new URLSearchParams({
                                action: 'clear'
                            }),
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            }
                        })
                            .then(response => response.json())
                            .then(data => {
                                console.log(data); // Log to check the response
                                Swal.fire({
                                    title: 'Closed!',
                                    text: 'The Peer to Peer evaluation has been closed.',
                                    icon: 'info',
                                    confirmButtonText: 'OK'
                                });
                            })
                            .catch(error => {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Something went wrong while closing evaluation.',
                                    icon: 'error',
                                    confirmButtonText: 'Try Again'
                                });
                            });
                    } else {
                        // User chose not to clear, do nothing
                        toggleSwitchPeer.checked = true; // Keep the toggle switch in the "on" position
                        labelPeer.textContent = 'Peer to Peer Evaluation is Open.';
                        formFieldsPeer.classList.remove('d-none');
                    }
                });
            }
        });

    </script>
</body>

</html>