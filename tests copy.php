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
            <input class="form-check-input" type="checkbox" id="customSwitch1Student" style="width: 2.5em;">
            <label class="form-check-label" for="customSwitch1Student">Off</label>
        </div>

        <div id="formFieldsStudent" class="d-none mt-3">
            <!-- The form fields for selecting semester and academic year will be added here dynamically -->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.2/dist/sweetalert2.all.min.js"></script>
    <script>
        const toggleSwitchStudent = document.getElementById('customSwitch1Student');
        const labelStudent = toggleSwitchStudent.nextElementSibling;
        const formFieldsStudent = document.getElementById('formFieldsStudent');

        function checkToggleStatusStudent() {
            fetch('update_toggle_statusStudent.php', {
                method: 'GET'
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Response from server:', data);

                    if (data.status === 'success') {
                        if (data.toggleStatus === 1) {
                            console.log('Toggle should be ON');
                            toggleSwitchStudent.checked = true;
                            labelStudent.textContent = 'Student Evaluation is Open.';
                            formFieldsStudent.classList.remove('d-none');
                        } else {
                            console.log('Toggle should be OFF');
                            toggleSwitchStudent.checked = false;
                            labelStudent.textContent = 'Student Evaluation is Close.';
                            formFieldsStudent.classList.add('d-none');
                        }
                    }
                })
                .catch(error => console.log('Error fetching toggle status:', error));
        }

        window.onload = function () {
            checkToggleStatusStudent();
        };

        toggleSwitchStudent.addEventListener('change', function () {
            if (toggleSwitchStudent.checked) {
                labelStudent.textContent = 'Student Evaluation is Open.';
                formFieldsStudent.classList.remove('d-none');

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

                        fetch('update_toggle_statusStudent.php', {
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
                        toggleSwitchStudent.checked = false;
                        labelStudent.textContent = 'Student Evaluation is Close.';
                        formFieldsStudent.classList.add('d-none');
                    }
                });
            } else {
                labelStudent.textContent = 'Student Evaluation is Close.';
                formFieldsStudent.classList.add('d-none');

                // Display confirmation dialog before clearing
                Swal.fire({
                    title: 'Closing Evaluation',
                    text: "Are you sure you want to close the evaluation for Student?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, close it!',
                    cancelButtonText: 'No, keep it'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Proceed with the clear action
                        fetch('update_toggle_statusStudent.php', {
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
                                    text: 'The Student evaluation has been closed.',
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
                        toggleSwitchStudent.checked = true; // Keep the toggle switch in the "on" position
                        labelStudent.textContent = 'Student Evaluation is Open.';
                        formFieldsStudent.classList.remove('d-none');
                    }
                });
            }
        });

    </script>
</body>

</html>