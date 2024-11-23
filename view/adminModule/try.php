<?php
include "../../model/dbconnection.php";
?>

<head>
    <!-- Bootstrap 5 CSS (for styling) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery (needed for live search functionality) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 5 JS (for modal and other components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<div class="container my-5">
    <h3 class="mb-4 text-center">Student Approval & Rejection</h3>

    <!-- Live Search Input -->
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Search by student name...">
    </div>

    <!-- Form for submitting student approval/rejection -->
    <form action="../../controller/approve_reject.php" method="POST">
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center" id="studentTable">
                <thead class="bg-danger">
                    <tr class="text-white">
                        <th>Student Name</th>
                        <th>Information</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // SQL query to get the students whose status is 0 (not approved yet)
                    $studentSQL = "SELECT * FROM studentlogin sl 
                                   INNER JOIN student_basic_info sbi ON sl.srcode = sbi.sr_code 
                                   WHERE sl.status = 0";
                    $studentSQL_query = mysqli_query($con, $studentSQL);

                    // Check if there are students to display
                    if (mysqli_num_rows($studentSQL_query) > 0) {
                        while ($studentRow = mysqli_fetch_assoc($studentSQL_query)) {
                            ?>
                            <tr>
                                <td><?php echo $studentRow['firstname'] . ' ' . $studentRow['lastname']; ?></td>
                                <td>
                                    <!-- Button to trigger Modal -->
                                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#studentInfoModal_<?php echo $studentRow['srcode']; ?>">Information</button>
                                </td>
                                <td>
                                    <!-- Individual Approval and Rejection radio buttons for each student -->
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="approve_<?php echo $studentRow['srcode']; ?>" value="1"
                                            id="approve_<?php echo $studentRow['srcode']; ?>" class="form-check-input" />
                                        <label for="approve_<?php echo $studentRow['srcode']; ?>"
                                            class="form-check-label">Approve</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="reject_<?php echo $studentRow['srcode']; ?>" value="2"
                                            id="reject_<?php echo $studentRow['srcode']; ?>" class="form-check-input" />
                                        <label for="reject_<?php echo $studentRow['srcode']; ?>"
                                            class="form-check-label">Reject</label>
                                    </div>
                                </td>
                            </tr>

                            <!-- Student Information Modal -->
                            <div class="modal fade" id="studentInfoModal_<?php echo $studentRow['srcode']; ?>" tabindex="-1"
                                aria-labelledby="studentInfoModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="studentInfoModalLabel">Student Information:
                                                <?php echo $studentRow['firstname'] . ' ' . $studentRow['lastname']; ?>
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>SR Code:</strong> <?php echo $studentRow['sr_code']; ?></p>
                                            <p><strong>First Name:</strong> <?php echo $studentRow['firstname']; ?></p>
                                            <p><strong>Last Name:</strong> <?php echo $studentRow['lastname']; ?></p>
                                            <p><strong>Middle Name:</strong> <?php echo $studentRow['middlename']; ?></p>
                                            <p><strong>Email:</strong>
                                                <?php echo strtolower($studentRow['firstname']) . '.' . strtolower($studentRow['lastname']) . '@g.batstate-u.edu.ph'; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='3' class='text-center'>No students to approve/reject</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Action buttons to submit form -->
        <div class="text-center mt-3">
            <button type="submit" name="approve" class="btn btn-success btn-lg px-4 py-2">Approve Selected</button>
            <button type="submit" name="reject" class="btn btn-danger btn-lg px-4 py-2">Reject Selected</button>
        </div>
    </form>
</div>

<!-- Add the jQuery script for live search -->
<script>
    $(document).ready(function () {
        // Live search functionality
        $('#searchInput').on('keyup', function () {
            var value = $(this).val().toLowerCase();
            $('#studentTable tbody tr').filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
    });
</script>