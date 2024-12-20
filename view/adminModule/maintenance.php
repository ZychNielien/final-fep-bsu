<?php
// NAV BAR
include "components/navBar.php"

  ?>

<head>
  <link rel="stylesheet" href="../../fontawesome/css/all.min.css">

  <!-- DATATABLES -->
  <link rel="stylesheet" href="../../public/DataTables/datatables.min.css">
  <script src="../../public/DataTables/datatables.min.js"></script>
  <!--  -->

  <!-- TITLE WEB PAGE -->
  <title>Maintenance Table</title>

  <!-- ALL STYLES, CSS AND SCRIPTS -->
  <link rel="stylesheet" href="../../public/css/style.css">
  <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
  <script src="../../public/js/jquery-3.7.1.min.js"></script>
  <style>
    ul li {
      list-style: none;
    }

    .star {
      color: gold;
      font-size: 30px;
    }
  </style>
  <!-- datatables -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!--  -->
</head>

<!-- CONTENT CONTAINER -->
<section class="contentContainer">
  <!-- START TAB -->
  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="AddStudent-tab" data-bs-toggle="tab" data-bs-target="#AddStudent"
        type="button" role="tab" aria-controls="AddStudent" aria-selected="false"><i class="fa-solid fa-user-plus"></i>
        Student Approval</button>
    </li>

    <li class="nav-item" role="presentation">
      <button class="nav-link " id="approveStudents-tab" data-bs-toggle="tab" data-bs-target="#approveStudents"
        type="button" role="tab" aria-controls="approveStudents" aria-selected="false"><i
          class="fa-solid fa-user-plus"></i>
        Approved Students</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="facultyApproval-tab" data-bs-toggle="tab" data-bs-target="#facultyApproval"
        type="button" role="tab" aria-controls="facultyApproval" aria-selected="false"><i
          class="fa-solid fa-user-plus"></i>
        Faculty Approval</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link " id="approveFaculty-tab" data-bs-toggle="tab" data-bs-target="#approveFaculty"
        type="button" role="tab" aria-controls="approveFaculty" aria-selected="false"><i
          class="fa-solid fa-user-plus"></i>
        Approved Faculty</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="AssignSub-tab" data-bs-toggle="tab" data-bs-target="#AssignSub" type="button"
        role="tab" aria-controls="AssignSub" aria-selected="true"><i class="fa-solid fa-book-open-reader"></i> Assign
        Subject</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="AddSub-tab" data-bs-toggle="tab" data-bs-target="#AddSub" type="button" role="tab"
        aria-controls="AddSub" aria-selected="false"><i class="fa-solid fa-book"></i> Add Subject</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="AddSec-tab" data-bs-toggle="tab" data-bs-target="#AddSec" type="button" role="tab"
        aria-controls="AddSec" aria-selected="false"><i class="fa-solid fa-users-between-lines"></i> Add
        Section</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="Addprereq-tab" data-bs-toggle="tab" data-bs-target="#Addprereq" type="button"
        role="tab" aria-controls="Addprereq" aria-selected="false"><i class="fa-solid fa-clipboard-list"></i> Add
        Prerequisite</button>
    </li>
  </ul>
  <!-- END TAB -->

  <!-- START TAB BODY -->
  <div class="tab-content" id="myTabContent">

    <!-- STUDENTS APPROVAL  -->
    <div class="tab-pane fade show active" id="AddStudent" role="tabpanel" aria-labelledby="AddStudent-tab">
      <div class="container my-5">
        <h3 class="mb-4 text-center">Student Approval & Rejection</h3>


        <!-- Live Search Input -->
        <div class="mb-3">
          <input type="text" id="searchInput" class="form-control" placeholder="Search by student name...">
        </div>

        <!-- Form for submitting student approval/rejection -->
        <form action="../../controller/approve_reject.php" method="POST">
          <!-- Action buttons to submit form -->
          <div class="text-center my-3">
            <button type="submit" name="approve" class="btn btn-success  px-4 py-2">Submit</button>
          </div>
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
                          <input type="radio" name="approval_<?php echo $studentRow['srcode']; ?>" value="1"
                            id="approve_<?php echo $studentRow['srcode']; ?>" class="form-check-input" />
                          <label for="approve_<?php echo $studentRow['srcode']; ?>" class="form-check-label">Approve</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input type="radio" name="approval_<?php echo $studentRow['srcode']; ?>" value="2"
                            id="reject_<?php echo $studentRow['srcode']; ?>" class="form-check-input" />
                          <label for="reject_<?php echo $studentRow['srcode']; ?>" class="form-check-label">Reject</label>
                        </div>

                      </td>
                    </tr>

                    <!-- Student Information Modal -->
                    <div class="modal fade" id="studentInfoModal_<?php echo $studentRow['srcode']; ?>" tabindex="-1"
                      aria-labelledby="studentInfoModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header bg-danger">
                            <h5 class="modal-title text-white" id="studentInfoModalLabel">Student Information:
                              <span
                                class="fw-bold"><?php echo $studentRow['firstname'] . ' ' . $studentRow['lastname']; ?></span>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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


        </form>
      </div>
    </div>

    <!-- LIST OF APPROVED STUDENTS -->
    <div class="tab-pane fade" id="approveStudents" role="tabpanel" aria-labelledby="approveStudents-tab">
      <div class="container my-5">
        <h3 class="mb-4 text-center">Student Approval & Rejection</h3>
        <div class="d-flex justify-content-end my-2">
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Rejected Students
          </button>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">List of Rejected Students</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <table class="table table-bordered table-striped text-center" id="studentApprovedTable">
                  <thead class="bg-danger">
                    <tr class="text-white">
                      <th>SR-Code</th>
                      <th>Student Name</th>
                      <th>Course</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // SQL query to get the students whose status is 0 (not approved yet)
                    $studentSQL = "SELECT * FROM studentlogin sl 
                                    INNER JOIN student_basic_info sbi ON sl.srcode = sbi.sr_code 
                                    INNER JOIN student_status st ON sl.srcode = st.sr_code
                                    WHERE sl.status = 2";
                    $studentSQL_query = mysqli_query($con, $studentSQL);

                    // Check if there are students to display
                    if (mysqli_num_rows($studentSQL_query) > 0) {
                      while ($studentRow = mysqli_fetch_assoc($studentSQL_query)) {
                        ?>
                        <tr>
                          <td><?php echo $studentRow['srcode']; ?></td>
                          <td><?php echo $studentRow['firstname'] . ' ' . $studentRow['lastname']; ?></td>
                          <td>
                            <?php echo $studentRow['course']; ?>
                          </td>
                          <td>
                            <form id="deleteForm" action="../../controller/deleteApprove.php" method="POST">
                              <input type="hidden" name="srcode" value="<?php echo $studentRow['srcode']; ?>">
                              <button type="button" class="btn btn-danger" id="deleteButton">Delete</button>
                            </form>
                          </td>
                        </tr>
                        <?php
                      }
                    } else {
                      echo "<tr><td colspan='3' class='text-center'>No students to approve/reject</td></tr>";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>


        <!-- Live Search Input -->
        <div class="mb-3">
          <input type="text" id="searchInputApproved" class="form-control" placeholder="Search by student name...">
        </div>

        <!-- Form for submitting student approval/rejection -->
        <form action="../../controller/approve_reject.php" method="POST">
          <!-- Action buttons to submit form -->
          <div class="table-responsive">
            <table class="table table-bordered table-striped text-center" id="studentApprovedTable">
              <thead class="bg-danger">
                <tr class="text-white">

                  <th>Student Name</th>
                  <th>Year Level</th>
                  <th>Information</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // SQL query to get the students whose status is 0 (not approved yet)
                $studentSQL = "SELECT * FROM studentlogin sl 
                                   INNER JOIN student_basic_info sbi ON sl.srcode = sbi.sr_code 
                                   INNER JOIN student_status st ON sl.srcode = st.sr_code
                                   WHERE sl.status = 1";
                $studentSQL_query = mysqli_query($con, $studentSQL);

                // Check if there are students to display
                if (mysqli_num_rows($studentSQL_query) > 0) {
                  while ($studentRow = mysqli_fetch_assoc($studentSQL_query)) {
                    ?>
                    <tr>

                      <td><?php echo $studentRow['firstname'] . ' ' . $studentRow['lastname']; ?></td>
                      <td><?php echo $studentRow['year_level']; ?></td>
                      <td>
                        <!-- Button to trigger Modal -->
                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                          data-bs-target="#studentInfoModal_<?php echo $studentRow['srcode']; ?>">Information</button>
                      </td>
                      <td>
                        <!-- Delete Button -->
                        <button type="button" class="btn btn-danger deleteButton"
                          data-src="<?php echo $studentRow['srcode']; ?>">Delete</button>
                      </td>
                    </tr>

                    <!-- Student Information Modal -->
                    <div class="modal fade" id="studentInfoModal_<?php echo $studentRow['srcode']; ?>" tabindex="-1"
                      aria-labelledby="studentInfoModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header bg-danger">
                            <h5 class="modal-title text-white" id="studentInfoModalLabel">Student Information:
                              <span
                                class="fw-bold"><?php echo $studentRow['firstname'] . ' ' . $studentRow['lastname']; ?></span>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                          </div>
                          <div class="modal-body">
                            <p><strong>SR Code:</strong> <?php echo $studentRow['sr_code']; ?></p>
                            <p><strong>First Name:</strong> <?php echo $studentRow['firstname']; ?></p>
                            <p><strong>Last Name:</strong> <?php echo $studentRow['lastname']; ?></p>
                            <p><strong>Middle Name:</strong> <?php echo $studentRow['middlename']; ?></p>
                            <p><strong>Email:</strong>
                              <?php echo strtolower($studentRow['firstname']) . '.' . strtolower($studentRow['lastname']) . '@g.batstate-u.edu.ph'; ?>
                            </p>
                            <p><strong>Course:</strong> <?php echo $studentRow['course']; ?></p>
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


        </form>
      </div>
    </div>

    <!-- FACULTY APPROVAL  -->
    <div class="tab-pane fade" id="facultyApproval" role="tabpanel" aria-labelledby="facultyApproval-tab">
      <div class="container my-5">
        <h3 class="mb-4 text-center">Faculty Approval & Rejection</h3>

        <!-- Live Search Input -->
        <div class="mb-3">
          <input type="text" id="searchInputFaculty" class="form-control" placeholder="Search by faculty name...">
        </div>

        <!-- Form for submitting student approval/rejection -->
        <form action="../../controller/approve_reject.php" method="POST">
          <!-- Action buttons to submit form -->
          <div class="text-center my-3">
            <button type="submit" name="approveFaculty" class="btn btn-success  px-4 py-2">Submit</button>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered table-striped text-center" id="facultyTable">
              <thead class="bg-danger">
                <tr class="text-white">
                  <th>Faculty</th>
                  <th>Information</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // SQL query to get the students whose status is 0 (not approved yet)
                $studentSQL = "SELECT * FROM instructor 
                                   WHERE status = 0";
                $studentSQL_query = mysqli_query($con, $studentSQL);

                // Check if there are students to display
                if (mysqli_num_rows($studentSQL_query) > 0) {
                  while ($studentRow = mysqli_fetch_assoc($studentSQL_query)) {
                    ?>
                    <tr>
                      <td><?php echo $studentRow['first_name'] . ' ' . $studentRow['last_name']; ?></td>
                      <td>
                        <!-- Button to trigger Modal -->
                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                          data-bs-target="#facultyApprovalInfoModal_<?php echo $studentRow['faculty_Id']; ?>">Information</button>
                      </td>
                      <td>
                        <!-- Individual Approval and Rejection radio buttons for each faculty -->
                        <div class="form-check form-check-inline">
                          <input type="radio" name="approveFaculty_<?php echo $studentRow['faculty_Id']; ?>" value="1"
                            id="approveFaculty_<?php echo $studentRow['faculty_Id']; ?>" class="form-check-input" />
                          <label for="approveFaculty_<?php echo $studentRow['faculty_Id']; ?>"
                            class="form-check-label">Approve</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input type="radio" name="approveFaculty_<?php echo $studentRow['faculty_Id']; ?>" value="2"
                            id="rejectFaculty_<?php echo $studentRow['faculty_Id']; ?>" class="form-check-input" />
                          <label for="rejectFaculty_<?php echo $studentRow['faculty_Id']; ?>"
                            class="form-check-label">Reject</label>
                        </div>

                      </td>
                    </tr>

                    <!-- Student Information Modal -->
                    <div class="modal fade" id="facultyApprovalInfoModal_<?php echo $studentRow['faculty_Id']; ?>"
                      tabindex="-1" aria-labelledby="facultyApprovalInfoModal_Label" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header bg-danger">
                            <h5 class="modal-title text-white" id="facultyApprovalInfoModal_Label">Student Information:
                              <span
                                class="fw-bold"><?php echo $studentRow['first_name'] . ' ' . $studentRow['last_name']; ?></span>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="d-flex justify-content-center align-items-center">
                              <img src="<?php echo '../' . htmlspecialchars($studentRow['image']); ?>" alt="Faculty Image"
                                class="img-fluid" style="height: 130px; width: auto;">
                            </div>
                            <div class="w-100 d-flex my-3">
                              <div class="w-25 text-center">
                                <span class="fw-bold">Full Name</span>
                              </div>
                              <div class="w-75 text-center">
                                <span><?php echo $studentRow['first_name'] . ' ' . $studentRow['last_name']; ?></span>
                              </div>
                            </div>
                            <div class="w-100 d-flex my-3">
                              <div class="w-25 text-center">
                                <span class="fw-bold">Email</span>
                              </div>
                              <div class="w-75 text-center">
                                <span><?php echo $studentRow['gsuite']; ?></span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php
                  }
                } else {
                  echo "<tr><td colspan='3' class='text-center'>No faculty to approve/reject</td></tr>";
                }
                ?>
              </tbody>
            </table>
          </div>


        </form>
      </div>
    </div>

    <!-- LIST OF APPROVED FACULTY -->
    <div class="tab-pane fade" id="approveFaculty" role="tabpanel" aria-labelledby="approveFaculty-tab">
      <div class="container my-5">
        <h3 class="mb-4 text-center">Faculty Approval & Rejection</h3>

        <div class="d-flex justify-content-evenly my-2">
          <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#facultyRegistration">
            Add Faculty
          </button>
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#rejectedFaculty">
            Rejected Faculty
          </button>
        </div>

        <div class="modal fade" id="facultyRegistration" tabindex="-1" aria-labelledby="facultyRegistrationLabel"
          aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="facultyRegistrationLabel">Faculty Registration Process</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form id="myForm" method="POST" action="../../controller/facultyQuery.php" enctype="multipart/form-data">
                <div class="modal-body">
                  <!-- IMAGE DIV -->
                  <div class="d-flex justify-content-center mb-3">
                    <img id="imagePreview" alt="Image Preview" src="https://via.placeholder.com/300"
                      style="max-height: 130px; cursor: pointer;" onclick="selectImage();" />
                  </div>
                  <div class="d-flex justify-content-evenly mt-4">
                    <!-- FIRST NAME DIV -->
                    <div class="form-group">
                      <span for="firstName">First Name</span>
                      <input type="text" class="form-control my-1" id="firstName" placeholder="Enter your first name"
                        name="first_name" required>
                    </div>
                    <!-- LAST NAME DIV -->
                    <div class="form-group">
                      <span for="lastName">Last Name</span>
                      <input type="text" class="form-control my-1" id="lastName" placeholder="Enter your last name"
                        name="last_name" required>
                    </div>
                  </div>
                  <!-- GSUITE DIV, NAKAHIDE PINAGCONCAT KO YUNG FIRST NAME AT LAST NAME -->
                  <div class="form-group mx-3" style="display:none;">
                    <span for="gsuite">Gsuite</span>
                    <input type="text" class="form-control my-1" id="gsuite" placeholder="Enter your Gsuite"
                      name="gsuite">
                  </div>
                  <!-- PASSWORD DIV, NAKAHIDE ANG GINAWA KONG DEFAULT PASSWORD IS LAST NAME ALL CAPS -->
                  <div class="form-group mx-3" style="display:none;">
                    <span for="password">Password</span>
                    <input type="password" class="form-control my-1" id="password" placeholder="Enter your password"
                      name="password">
                  </div>
                  <!-- USER TYPE DIV, NAKAHIDE MATIK LAHAT FACULTY ANG USER TYPE TATLO LANG ANG ADMIN -->
                  <div class="form-group mx-3" style="display:none;">
                    <span for="password">type</span>
                    <input type="password" class="form-control my-1" id="password" placeholder="Enter your password"
                      name="type">
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" id="addFaculty" name="addFacultyAdmin" class="btn btn-primary">Submit</button>
                </div>
                <!-- INPUT NI IMAGE -->
                <input type="file" id="imageInput" name="image" accept="image/*" style="display: none;"
                  onchange="previewImage();">
              </form>
            </div>
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="rejectedFaculty" tabindex="-1" aria-labelledby="rejectedFacultyLabel"
          aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="rejectedFacultyLabel">List of Rejected Faculty</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <table class="table table-bordered table-striped text-center" id="rejectedFacultyTable">
                  <thead class="bg-danger">
                    <tr class="text-white">
                      <th>Image</th>
                      <th>Faculty Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>


                    <?php
                    // SQL query to get the students whose status is 0 (not approved yet)
                    $studentSQL = "SELECT * FROM instructor 
                                   WHERE status = 2";
                    $studentSQL_query = mysqli_query($con, $studentSQL);

                    // Check if there are students to display
                    if (mysqli_num_rows($studentSQL_query) > 0) {
                      while ($studentRow = mysqli_fetch_assoc($studentSQL_query)) {
                        ?>
                        <tr>
                          <td> <img src="<?php echo '../' . htmlspecialchars($studentRow['image']); ?>" alt="Faculty Image"
                              class="img-fluid" style="height: 100px; width: auto;"></td>
                          <td><?php echo $studentRow['first_name'] . ' ' . $studentRow['last_name']; ?></td>
                          <td>
                            <form action="../../controller/deleteApprove.php" method="POST">
                              <input type="hidden" name="faculty" value="<?php echo $studentRow['faculty_Id']; ?>">
                              <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                          </td>
                        </tr>
                        <?php
                      }
                    } else {
                      echo "<tr><td colspan='3' class='text-center'>No Faculty to approve/reject</td></tr>";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>


        <!-- Live Search Input -->
        <div class="mb-3">
          <input type="text" id="searchInputApprovedFaculty" class="form-control"
            placeholder="Search by faculty name...">
        </div>

        <!-- Form for submitting student approval/rejection -->
        <form action="../../controller/approve_reject.php" method="POST">

          <div class="table-responsive">
            <table class="table table-bordered table-striped text-center" id="facultyApprovedTable">
              <thead class="bg-danger">
                <tr class="text-white">
                  <th>Faculty</th>
                  <th>Information</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // SQL query to get the students whose status is 0 (not approved yet)
                $studentSQL = "SELECT * FROM instructor 
                                   WHERE status = 1";
                $studentSQL_query = mysqli_query($con, $studentSQL);

                // Check if there are students to display
                if (mysqli_num_rows($studentSQL_query) > 0) {
                  while ($studentRow = mysqli_fetch_assoc($studentSQL_query)) {
                    ?>
                    <tr>
                      <td><?php echo $studentRow['first_name'] . ' ' . $studentRow['last_name']; ?></td>
                      <td>
                        <!-- Button to trigger Modal -->
                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                          data-bs-target="#facultyApprovalInfoModal_<?php echo $studentRow['faculty_Id']; ?>">Information</button>
                      </td>
                    </tr>

                    <!-- Student Information Modal -->
                    <div class="modal fade" id="facultyApprovalInfoModal_<?php echo $studentRow['faculty_Id']; ?>"
                      tabindex="-1" aria-labelledby="facultyApprovalInfoModal_Label" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header bg-danger">
                            <h5 class="modal-title text-white" id="facultyApprovalInfoModal_Label">Student Information:
                              <span
                                class="fw-bold"><?php echo $studentRow['first_name'] . ' ' . $studentRow['last_name']; ?></span>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="d-flex justify-content-center align-items-center">
                              <img src="<?php echo '../' . htmlspecialchars($studentRow['image']); ?>" alt="Faculty Image"
                                class="img-fluid" style="height: 130px; width: auto;">
                            </div>
                            <div class="w-100 d-flex my-3">
                              <div class="w-25 text-center">
                                <span class="fw-bold">Full Name</span>
                              </div>
                              <div class="w-75 text-center">
                                <span><?php echo $studentRow['first_name'] . ' ' . $studentRow['last_name']; ?></span>
                              </div>
                            </div>
                            <div class="w-100 d-flex my-3">
                              <div class="w-25 text-center">
                                <span class="fw-bold">Email</span>
                              </div>
                              <div class="w-75 text-center">
                                <span><?php echo $studentRow['gsuite']; ?></span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php
                  }
                } else {
                  echo "<tr><td colspan='3' class='text-center'>No faculty to approve/reject</td></tr>";
                }
                ?>
              </tbody>
            </table>
          </div>


        </form>
      </div>
    </div>

    <!-- START ASSIGN SUB -->
    <div class="tab-pane fade" id="AssignSub" role="tabpanel" aria-labelledby="AssignSub-tab">
      <div class="container p-2">
        <div class="mt-3 d-flex justify-content-between">
          <h3 class=""><i class="fa-solid fa-book-open-reader"></i> Assign Subject</h3>
          <div>
            <button class="btn btn-success d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#assigned">
              <i class="fa-solid fa-plus"></i> Assign Subject
            </button>
          </div>
        </div>
        <!-- Live Search Input -->
        <div class="my-3">
          <input type="text" id="searchInputAssignTable" class="form-control" placeholder="Search by Subject...">
        </div>
        <table class="table table-striped table-bordered text-center mt-5" style="font-family: monospace"
          id="assignTable">
          <thead>
            <tr class="text-dark">
              <th class="bg-danger">Code</th>
              <th class="bg-danger">Description</th>
              <th class="bg-danger">Unit</th>
              <th class="bg-danger">Section</th>
              <th class="bg-danger">Instructor</th>
              <th class="bg-danger">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $query = "SELECT 
                        A.id, 
                        S.subject_code, 
                        S.subject, 
                        S.unit, 
                        SC.section, 
                        I.last_name,
                        A.slot AS max_slot, 
                        I.first_name
                    FROM assigned_subject A 
                    INNER JOIN subject S 
                        ON A.subject_id = S.subject_id 
                    INNER JOIN instructor I 
                        ON A.faculty_id = I.faculty_id 
                    INNER JOIN section SC 
                        ON A.section_id = SC.id";

            $query_run = mysqli_query($con, $query);

            if (mysqli_num_rows($query_run) > 0) {
              while ($row = mysqli_fetch_assoc($query_run)) {
                ?>
                <tr>
                  <td><?php echo $row['subject_code'] ?></td>
                  <td><?php echo $row['subject'] ?></td>
                  <td><?php echo $row['unit'] ?></td>
                  <td><?php echo $row['section'] ?></td>
                  <td><?php echo $row['last_name'] ?>, <?php echo $row['first_name'] ?></td>

                  <td><button type="button" id="<?php echo $row['id'] ?>" class="btn btn-danger delete-AS">Delete</button>
                  </td>


                </tr>
                <?php
              }
            } else {
              ?>
              <tr>
                <td colspan="6">No Enrolled Subject!</td>
              </tr>
              <?php
            }
            ?>

          </tbody>
        </table>
      </div>
    </div>
    <!-- START ASSIGNED SUBJECT MODAL -->
    <div class="modal fade" id="assigned" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-danger">
            <h5 class="modal-title text-light" id="enroll_modalLabel">ASSIGNED INSTRUCTOR</h5>
            <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="container">
              <form action="../../controller/controller.php" method="POST">
                <div>
                  <div class="row mb-3">
                    <div class="col">
                      <label for="sub_id" class="form-label fw-bold">Subject:</label>
                      <Select name="sub_id" id="sub_id" class="form-select">
                        <option value="selected" selected disabled>---Select Subject---</option>
                        <!-- FIRST YEAR -->
                        <optgroup label="FIRST YEAR">
                        <optgroup label="First Semester">
                          <?php
                          $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '1' AND semester = '1' ORDER BY year ASC";

                          $query_sub_run = mysqli_query($con, $query_sub);

                          $check_sub = mysqli_num_rows($query_sub_run) > 0;

                          if ($check_sub) {
                            while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                              ?>
                              <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?>
                              </option>
                              <?php
                            }
                          }
                          ?>
                        </optgroup>
                        <optgroup label="Second Semester">
                          <?php
                          $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '1' AND semester = '2' ORDER BY year ASC";

                          $query_sub_run = mysqli_query($con, $query_sub);

                          $check_sub = mysqli_num_rows($query_sub_run) > 0;

                          if ($check_sub) {
                            while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                              ?>
                              <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?>
                              </option>
                              <?php
                            }
                          }
                          ?>
                        </optgroup>
                        </optgroup>
                        <!-- SECOND YEAR -->
                        <optgroup label="SECOND YEAR">
                        <optgroup label="First Semester">
                          <?php
                          $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '2' AND semester = '1' ORDER BY year ASC";

                          $query_sub_run = mysqli_query($con, $query_sub);

                          $check_sub = mysqli_num_rows($query_sub_run) > 0;

                          if ($check_sub) {
                            while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                              ?>
                              <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?>
                              </option>
                              <?php
                            }
                          }
                          ?>
                        </optgroup>
                        <optgroup label="Second Semester">
                          <?php
                          $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '2' AND semester = '2' ORDER BY year ASC";

                          $query_sub_run = mysqli_query($con, $query_sub);

                          $check_sub = mysqli_num_rows($query_sub_run) > 0;

                          if ($check_sub) {
                            while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                              ?>
                              <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?>
                              </option>
                              <?php
                            }
                          }
                          ?>
                        </optgroup>
                        </optgroup>
                        w
                        <!-- THIRD YEAR -->
                        <optgroup label="THIRD YEAR">
                        <optgroup label="First Semester">
                          <?php
                          $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '3' AND semester = '1' ORDER BY year ASC";

                          $query_sub_run = mysqli_query($con, $query_sub);

                          $check_sub = mysqli_num_rows($query_sub_run) > 0;

                          if ($check_sub) {
                            while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                              ?>
                              <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?>
                              </option>
                              <?php
                            }
                          }
                          ?>
                        </optgroup>
                        <optgroup label="Second Semester">
                          <?php
                          $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '3' AND semester = '2' ORDER BY year ASC";

                          $query_sub_run = mysqli_query($con, $query_sub);

                          $check_sub = mysqli_num_rows($query_sub_run) > 0;

                          if ($check_sub) {
                            while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                              ?>
                              <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?>
                              </option>
                              <?php
                            }
                          }
                          ?>
                        </optgroup>
                        </optgroup>
                        <!-- FOURTH YEAR -->
                        <optgroup label="FOURTH YEAR">
                        <optgroup label="First Semester">
                          <?php
                          $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '4' AND semester = '1' ORDER BY year ASC";

                          $query_sub_run = mysqli_query($con, $query_sub);

                          $check_sub = mysqli_num_rows($query_sub_run) > 0;

                          if ($check_sub) {
                            while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                              ?>
                              <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?>
                              </option>
                              <?php
                            }
                          }
                          ?>
                        </optgroup>
                        <optgroup label="Second Semester">
                          <?php
                          $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '4' AND semester = '2' ORDER BY year ASC";

                          $query_sub_run = mysqli_query($con, $query_sub);

                          $check_sub = mysqli_num_rows($query_sub_run) > 0;

                          if ($check_sub) {
                            while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                              ?>
                              <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?>
                              </option>
                              <?php
                            }
                          }
                          ?>
                        </optgroup>
                        </optgroup>
                      </Select>
                    </div>
                    <div class="col">
                      <label for="sec_id" class="form-label fw-bold">Section:</label>
                      <Select name="sec_id" id="sec_id" class="form-select">
                        <option value="selected" selected disabled>---Select Section---</option>

                      </Select>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col">
                      <label for="fclty_id" class="form-label fw-bold">Instructor:</label>
                      <Select name="fclty_id" id="fclty_id" class="form-select">
                        <option value="selected" selected disabled>---Select Instructor---</option>

                      </Select>
                    </div>
                    <div class="col-3">
                      <label for="slot" class="form-label fw-bold">Slot:</label>
                      <input type="text" class="form-control" id="slot" name="slot" placeholder="slot per section">
                    </div>
                  </div>
                  <div class="row mb-3" id="sched_part" style="display: none;">
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                      <h5>Schedule of the subject:</h5>
                      <div class="btn btn-secondary" id="sched2" disabled><i class="fa-solid fa-plus"></i> Another
                        Schedule</div>
                    </div>
                    <div class="col">
                      <label for="day" class="form-label fw-bold">Day:</label>
                      <Select name="day" id="day" class="form-select">
                        <option value="selected" selected disabled>---Select the day---</option>
                        <?php
                        $query_day = "SELECT day_id, days FROM days";

                        $query_day_run = mysqli_query($con, $query_day);

                        $check_day = mysqli_num_rows($query_day_run) > 0;

                        if ($check_day) {
                          while ($row_day = mysqli_fetch_array($query_day_run)) {
                            ?>
                            <option value="<?php echo $row_day['day_id'] ?>"><?php echo $row_day['days'] ?></option>
                            <?php
                          }
                        }
                        ?>
                      </Select>
                    </div>
                    <div class="col">
                      <label for="Stime" class="form-label fw-bold">Start Time:</label>
                      <Select name="Stime" id="Stime" class="form-select">
                        <option value="selected" selected disabled>---Select start time---</option>

                      </Select>
                    </div>
                    <div class="col">
                      <label for="Etime" class="form-label fw-bold">End Time:</label>
                      <Select name="Etime" id="Etime" class="form-select">
                        <option value="selected" selected disabled>---Select end time---</option>

                      </Select>
                    </div>
                  </div>
                  <div class="row mb-3" id="sched_part2" style="display: none;">
                    <div class="mb-3">
                      <h5>Second Schedule of the subject:</h5>
                    </div>
                    <div class="col">
                      <label for="day2" class="form-label fw-bold">Day:</label>
                      <Select name="day2" id="day2" class="form-select">
                        <option value="selected" selected disabled>---Select the day---</option>
                        <?php
                        $query_day = "SELECT day_id, days FROM days";

                        $query_day_run = mysqli_query($con, $query_day);

                        $check_day = mysqli_num_rows($query_day_run) > 0;

                        if ($check_day) {
                          while ($row_day = mysqli_fetch_array($query_day_run)) {
                            ?>
                            <option value="<?php echo $row_day['day_id'] ?>"><?php echo $row_day['days'] ?></option>
                            <?php
                          }
                        }
                        ?>
                      </Select>
                    </div>
                    <div class="col">
                      <label for="Stime2" class="form-label fw-bold">Start Time:</label>
                      <Select name="Stime2" id="Stime2" class="form-select">
                        <option value="selected" selected disabled>---Select start time---</option>

                      </Select>
                    </div>
                    <div class="col">
                      <label for="Etime2" class="form-label fw-bold">End Time:</label>
                      <Select name="Etime2" id="Etime2" class="form-select">
                        <option value="selected" selected disabled>---Select end time---</option>

                      </Select>
                    </div>
                  </div>
                </div>
            </div>
          </div>
          <div class="modal-footer d-flex justify-content-between">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                class="fa-regular fa-circle-xmark"></i> Close</button>
            <input type="submit" name="submit_assigned" id="submit_assigned" class="btn btn-success" value="Assigned">
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- END ASSIGNED SUBJECT MODAL -->

    <!-- START ADD SUBJECT TAB -->
    <div class="tab-pane fade" id="AddSub" role="tabpanel" aria-labelledby="AddSub-tab">
      <div class="container p-2">
        <div class="mt-3 d-flex justify-content-between">
          <h3 class=""><i class="fa-solid fa-book"></i> Add Subject</h3>
          <div>
            <button class="btn btn-success d-flex align-items-center" data-bs-toggle="modal"
              data-bs-target="#addsubject">
              <i class="fa-solid fa-plus"></i> Add Subject
            </button>
          </div>
        </div>
        <!-- Live Search Input -->
        <div class="my-3">
          <input type="text" id="searchInputSubjectKo" class="form-control" placeholder="Search by Subject...">
        </div>

        <!-- START TABLE -->
        <table id="subject_table" class="table table-striped table-bordered text-center mt-5"
          style="font-family: monospace" id="addTable">
          <thead>
            <tr class="text-dark">
              <th class="bg-danger">Subject Code</th>
              <th class="bg-danger">Subject</th>
              <th class="bg-danger">Unit</th>
              <th class="bg-danger">Semester</th>
              <th class="bg-danger">Year Level</th>
              <th class="bg-danger">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $query_st = "SELECT S.subject_id, S.subject, S.unit, S.year, YL.year_level, SM.semester, S.subject_code 
                              FROM `subject` S INNER JOIN year_level YL ON S.year = YL.year_id INNER JOIN semester SM ON S.semester = SM.sem_id ORDER BY S.year";
            $query_run_st = mysqli_query($con, $query_st);

            if (mysqli_num_rows($query_run_st) > 0) {
              while ($row = mysqli_fetch_assoc($query_run_st)) {
                ?>
                <tr>
                  <td><?php echo $row['subject_code'] ?></td>
                  <td><?php echo $row['subject'] ?></td>
                  <td><?php echo $row['unit'] ?></td>
                  <td><?php echo $row['year_level'] ?></td>
                  <td><?php echo $row['semester'] ?></td>
                  <td>
                    <button type="button" id="<?php echo $row['subject_id'] ?>" class="btn btn-primary edit-sub"
                      data-bs-toggle="modal" data-bs-target="#editsubject">Edit</button>
                    <!-- <button type="button" id="<?php echo $row['subject_id'] ?>" class="btn btn-danger delete-sub">Delete</button> -->
                  </td>
                </tr>
                <?php
              }
            } else {
              ?>
              <tr>
                <td colspan="6">No Subject data</td>
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>
        <!-- END TABLE -->

        <!-- START ADD SUBJECT MODAL -->
        <div class="modal fade" id="addsubject" tabindex="-1">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header bg-danger">
                <h5 class="modal-title text-light" id="addsubject_modalLabel">ADD SUBJECT</h5>
                <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="container">
                  <form action="../../controller/controller.php" method="POST">
                    <div class="row mb-3">
                      <div class="col">
                        <label for="subject" class="form-label">Subject:</label>
                        <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject Name">
                      </div>
                      <div class="col">
                        <label for="unit" class="form-label">Unit:</label>
                        <input type="text" name="unit" id="unit" class="form-control" placeholder="Unit subject">
                      </div>
                      <div class="col">
                        <label for="code" class="form-label">Subject Code:</label>
                        <input type="text" name="code" id="code" class="form-control" placeholder="Subject Code">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col">
                        <label for="semes" class="form-label">Semester:</label>
                        <Select name="semes" id="semes" class="form-select">
                          <option value="selected" selected disabled>---Select semester---</option>
                          <?php
                          $query_sem = "SELECT sem_id, semester FROM semester";

                          $query_sem_run = mysqli_query($con, $query_sem);

                          $check_sem = mysqli_num_rows($query_sem_run) > 0;

                          if ($check_sem) {
                            while ($row_sem = mysqli_fetch_array($query_sem_run)) {
                              ?>
                              <option value="<?php echo $row_sem['sem_id'] ?>"><?php echo $row_sem['semester'] ?> SEMESTER
                              </option>
                              <?php
                            }
                          }
                          ?>
                        </Select>
                      </div>
                      <div class="col">
                        <label for="yearlvl" class="form-label">Year level:</label>
                        <Select name="yearlvl" id="yearlvl" class="form-select">
                          <option value="selected" selected disabled>---Select year level---</option>
                          <?php
                          $query_year = "SELECT year_id, year_level FROM year_level";

                          $query_year_run = mysqli_query($con, $query_year);

                          $check_year = mysqli_num_rows($query_year_run) > 0;

                          if ($check_year) {
                            while ($row_year = mysqli_fetch_array($query_year_run)) {
                              ?>
                              <option value="<?php echo $row_year['year_id'] ?>"><?php echo $row_year['year_level'] ?> YEAR
                              </option>
                              <?php
                            }
                          }
                          ?>
                        </Select>
                      </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                    class="fa-regular fa-circle-xmark"></i> Close</button>
                <input type="submit" name="submit_sub" id="submit_sub" class="btn btn-success" value="Save">
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- END ADD SUBJECT MODAL -->

        <!-- START EDIT SUBJECT MODAL -->
        <div class="modal fade" id="editsubject" tabindex="-1">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header bg-danger">
                <h5 class="modal-title text-light" id="editsubject_modalLabel">UPDATE SUBJECT</h5>
                <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="container">
                  <form action="../../controller/controller.php" method="POST">
                    <div class="row mb-3">
                      <input type="hidden" name="subID" id="subID">
                      <div class="col">
                        <label for="subject2" class="form-label">Subject:</label>
                        <input type="text" name="subject2" id="subject2" class="form-control"
                          placeholder="Subject Name">
                      </div>
                      <div class="col">
                        <label for="unit2" class="form-label">Unit:</label>
                        <input type="text" name="unit2" id="unit2" class="form-control" placeholder="Unit subject">
                      </div>
                      <div class="col">
                        <label for="code2" class="form-label">Subject Code:</label>
                        <input type="text" name="code2" id="code2" class="form-control" placeholder="Subject Code">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col">
                        <label for="semes2" class="form-label">Semester:</label>
                        <Select name="semes2" id="semes2" class="form-select">
                          <option value="selected" selected disabled>---Select semester---</option>
                          <?php
                          $query_sem = "SELECT sem_id, semester FROM semester";

                          $query_sem_run = mysqli_query($con, $query_sem);

                          $check_sem = mysqli_num_rows($query_sem_run) > 0;

                          if ($check_sem) {
                            while ($row_sem = mysqli_fetch_array($query_sem_run)) {
                              ?>
                              <option value="<?php echo $row_sem['sem_id'] ?>"><?php echo $row_sem['semester'] ?> SEMESTER
                              </option>
                              <?php
                            }
                          }
                          ?>
                        </Select>
                      </div>
                      <div class="col">
                        <label for="yearlvl2" class="form-label">Year level:</label>
                        <Select name="yearlvl2" id="yearlvl2" class="form-select">
                          <option value="selected" selected disabled>---Select year level---</option>
                          <?php
                          $query_year = "SELECT year_id, year_level FROM year_level";

                          $query_year_run = mysqli_query($con, $query_year);

                          $check_year = mysqli_num_rows($query_year_run) > 0;

                          if ($check_year) {
                            while ($row_year = mysqli_fetch_array($query_year_run)) {
                              ?>
                              <option value="<?php echo $row_year['year_id'] ?>"><?php echo $row_year['year_level'] ?> YEAR
                              </option>
                              <?php
                            }
                          }
                          ?>
                        </Select>
                      </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                    class="fa-regular fa-circle-xmark"></i> Close</button>
                <input type="submit" name="updatesub" id="updatesub" class="btn btn-success" value="Update">
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- END EDIT SUBJECT MODAL -->

      </div>
    </div>

    <!-- END ASSIGN SUB -->

    <!-- START ADD SECTION -->
    <div class="tab-pane fade" id="AddSec" role="tabpanel" aria-labelledby="AddSec-tab">
      <div class="container p-2">
        <div class="mt-3 d-flex justify-content-between">
          <h3 class=""><i class="fa-solid fa-users-between-lines"></i> Add Section</h3>
          <div>
            <button class="btn btn-success d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addSec">
              <i class="fa-solid fa-plus"></i> Add Section
            </button>
          </div>
        </div>

        <!-- Live Search Input -->
        <div class="my-3">
          <input type="text" id="searchInputSection" class="form-control" placeholder="Search by Subject...">
        </div>

        <!-- START TABLE -->
        <table id="section_table" class="table table-striped table-bordered text-center mt-5"
          style="font-family: monospace" id="sectionTable">
          <thead>
            <tr class="text-dark">
              <th class="bg-danger">Section</th>
              <th class="bg-danger">Year Level</th>
              <th class="bg-danger">Semester</th>
              <th class="bg-danger">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $query = "SELECT S.id, S.section, S.year_id, YL.year_level, SM.semester
                              FROM section S INNER JOIN year_level YL ON S.year_id = YL.year_id INNER JOIN semester SM ON S.sem_id = SM.sem_id ORDER BY S.year_id";
            $query_run = mysqli_query($con, $query);

            if (mysqli_num_rows($query_run) > 0) {
              while ($row = mysqli_fetch_assoc($query_run)) {
                ?>
                <tr>
                  <td><?php echo $row['section'] ?></td>
                  <td><?php echo $row['year_level'] ?></td>
                  <td><?php echo $row['semester'] ?></td>
                  <td>
                    <button type="button" id="<?php echo $row['id'] ?>" class="btn btn-primary edit-sec"
                      data-bs-toggle="modal" data-bs-target="#editsection">Edit</button>
                    <button type="button" id="<?php echo $row['id'] ?>" class="btn btn-danger delete-sec">Delete</button>
                  </td>
                </tr>
                <?php
              }
            } else {
              ?>
              <tr>
                <td colspan="4">No Section data</td>
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>
        <!-- END TABLE -->

      </div>
    </div>

    <!-- START ADD SECTION MODAL -->
    <div class="modal fade" id="addSec" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-danger">
            <h5 class="modal-title text-light" id="enroll_modalLabel">ADD SECTION</h5>
            <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="container">
              <form action="../../controller/controller.php" method="POST">
                <div class="row mb-3">
                  <div class="col">
                    <label for="addsection" class="form-label">Section: </label>
                    <input type="text" name="addsection" id="addsection" class="form-control" placeholder="ex. IT-1101">
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col">
                    <label for="year_id" class="form-label">Year level:</label>
                    <Select name="year_id" id="year_id" class="form-select">
                      <option value="selected" selected disabled>---Select year level---</option>
                      <?php
                      $query_year = "SELECT year_id, year_level FROM year_level";

                      $query_year_run = mysqli_query($con, $query_year);

                      $check_year = mysqli_num_rows($query_year_run) > 0;

                      if ($check_year) {
                        while ($row_year = mysqli_fetch_array($query_year_run)) {
                          ?>
                          <option value="<?php echo $row_year['year_id'] ?>"><?php echo $row_year['year_level'] ?> YEAR
                          </option>
                          <?php
                        }
                      }
                      ?>
                    </Select>
                  </div>
                  <div class="col">
                    <label for="sem_id" class="form-label">Semester:</label>
                    <Select name="sem_id" id="sem_id" class="form-select">
                      <option value="selected" selected disabled>---Select semester---</option>
                      <?php
                      $query_sem = "SELECT sem_id, semester FROM semester";

                      $query_sem_run = mysqli_query($con, $query_sem);

                      $check_sem = mysqli_num_rows($query_sem_run) > 0;

                      if ($check_sem) {
                        while ($row_sem = mysqli_fetch_array($query_sem_run)) {
                          ?>
                          <option value="<?php echo $row_sem['sem_id'] ?>"><?php echo $row_sem['semester'] ?> SEMESTER
                          </option>
                          <?php
                        }
                      }
                      ?>
                    </Select>
                  </div>
                </div>
            </div>
          </div>
          <div class="modal-footer d-flex justify-content-between">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                class="fa-regular fa-circle-xmark"></i> Close</button>
            <input type="submit" name="submit_section" id="submit_section" class="btn btn-success" value="Save">
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- END ADD SECTION MODAL -->

    <!-- START EDIT SECTION MODAL -->
    <div class="modal fade" id="editsection" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-danger">
            <h5 class="modal-title text-light" id="editsec_modalLabel">EDIT SECTION</h5>
            <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="container">
              <form action="../../controller/controller.php" method="POST">
                <div class="row mb-3">
                  <div class="col">
                    <input type="hidden" name="secID" id="secID">
                    <label for="addsection2" class="form-label">Section: </label>
                    <input type="text" name="addsection2" id="addsection2" class="form-control"
                      placeholder="ex. IT-1101">
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col">
                    <label for="year_id2" class="form-label">Year level:</label>
                    <Select name="year_id2" id="year_id2" class="form-select">
                      <option value="selected" selected disabled>---Select year level---</option>
                      <?php
                      $query_year = "SELECT year_id, year_level FROM year_level";

                      $query_year_run = mysqli_query($con, $query_year);

                      $check_year = mysqli_num_rows($query_year_run) > 0;

                      if ($check_year) {
                        while ($row_year = mysqli_fetch_array($query_year_run)) {
                          ?>
                          <option value="<?php echo $row_year['year_id'] ?>"><?php echo $row_year['year_level'] ?> YEAR
                          </option>
                          <?php
                        }
                      }
                      ?>
                    </Select>
                  </div>
                  <div class="col">
                    <label for="sem_id2" class="form-label">Semester:</label>
                    <Select name="sem_id2" id="sem_id2" class="form-select">
                      <option value="selected" selected disabled>---Select semester---</option>
                      <?php
                      $query_sem = "SELECT sem_id, semester FROM semester";

                      $query_sem_run = mysqli_query($con, $query_sem);

                      $check_sem = mysqli_num_rows($query_sem_run) > 0;

                      if ($check_sem) {
                        while ($row_sem = mysqli_fetch_array($query_sem_run)) {
                          ?>
                          <option value="<?php echo $row_sem['sem_id'] ?>"><?php echo $row_sem['semester'] ?> SEMESTER
                          </option>
                          <?php
                        }
                      }
                      ?>
                    </Select>
                  </div>
                </div>
            </div>
          </div>
          <div class="modal-footer d-flex justify-content-between">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                class="fa-regular fa-circle-xmark"></i> Close</button>
            <input type="submit" name="updateSection" id="updateSection" class="btn btn-success" value="Update">
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- END EDIT SECTION MODAL -->

    <!-- START PREREQ TAB -->
    <div class="tab-pane fade" id="Addprereq" role="tabpanel" aria-labelledby="AddSec-tab">
      <div class="container p-2">
        <div class="mt-3 d-flex justify-content-between">
          <h3 class=""><i class="fa-solid fa-clipboard-list"></i> Add Prerequisite Subject</h3>
          <div>
            <button class="btn btn-success d-flex align-items-center" data-bs-toggle="modal"
              data-bs-target="#add_Prereq">
              <i class="fa-solid fa-plus"></i> Add Prerequisite Subject
            </button>
          </div>
        </div>

        <!-- Live Search Input -->
        <div class="my-3">
          <input type="text" id="searchInputPre" class="form-control" placeholder="Search by Subject...">
        </div>

        <!-- START TABLE -->
        <table id="pprereq_table" class="table table-striped table-bordered text-center mt-5"
          style="font-family: monospace" id="preTable">
          <thead>
            <tr class="text-dark">
              <th class="bg-danger" colspan="2">Subject</th>
              <th class="bg-danger" colspan="2">Prerequisite Subject</th>
              <th class="bg-danger">Year Level</th>
              <th class="bg-danger">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $query = "SELECT P.id, S.subject_code, S.subject, SS.subject_code AS prereq_code, SS.subject AS prereq, YL.year_level, P.year_id 
                          FROM prereq_subject P 
                          INNER JOIN subject S ON P.subject_id = S.subject_id 
                          INNER JOIN subject SS ON P.prereq_id = SS.subject_id 
                          INNER JOIN year_level YL ON P.year_id = YL.year_id ORDER BY P.year_id";
            $query_run = mysqli_query($con, $query);

            if (mysqli_num_rows($query_run) > 0) {
              while ($row = mysqli_fetch_assoc($query_run)) {
                ?>
                <tr>
                  <td><?php echo $row['subject_code'] ?></td>
                  <td><?php echo $row['subject'] ?></td>
                  <td><?php echo $row['prereq_code'] ?></td>
                  <td><?php echo $row['prereq'] ?></td>
                  <td><?php echo $row['year_level'] ?></td>
                  <td>
                    <button type="button" id="<?php echo $row['id'] ?>" class="btn btn-primary edit-prereq"
                      data-bs-toggle="modal" data-bs-target="#edit_Prereq">Edit</button>
                    <button type="button" id="<?php echo $row['id'] ?>" class="btn btn-danger delete-prereq">Delete</button>
                  </td>
                </tr>
                <?php
              }
            } else {
              ?>
              <tr>
                <td colspan="4">No Section data</td>
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>
        <!-- END TABLE -->

      </div>

      <!-- START ADD PREREQ MODAL -->
      <div class="modal fade" id="add_Prereq" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-danger">
              <h5 class="modal-title text-light" id="add_Prereq_modalLabel">ADD PREREQUISITE SUBJECT</h5>
              <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="container">
                <form action="../../controller/controller.php" method="POST">
                  <div class="row mb-3">
                    <label for="prereq_sub">Subject: </label>
                    <select name="prereq_sub" id="prereq_sub" class="form-select">
                      <option value="selected" selected disabled>---Select Subject---</option>
                      <!-- FIRST YEAR -->
                      <optgroup label="FIRST YEAR">
                      <optgroup label="First Semester">
                        <?php
                        $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '1' AND semester = '1' ORDER BY year ASC";

                        $query_sub_run = mysqli_query($con, $query_sub);

                        $check_sub = mysqli_num_rows($query_sub_run) > 0;

                        if ($check_sub) {
                          while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                            ?>
                            <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?></option>
                            <?php
                          }
                        }
                        ?>
                      </optgroup>
                      <optgroup label="Second Semester">
                        <?php
                        $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '1' AND semester = '2' ORDER BY year ASC";

                        $query_sub_run = mysqli_query($con, $query_sub);

                        $check_sub = mysqli_num_rows($query_sub_run) > 0;

                        if ($check_sub) {
                          while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                            ?>
                            <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?></option>
                            <?php
                          }
                        }
                        ?>
                      </optgroup>
                      </optgroup>
                      <!-- SECOND YEAR -->
                      <optgroup label="SECOND YEAR">
                      <optgroup label="First Semester">
                        <?php
                        $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '2' AND semester = '1' ORDER BY year ASC";

                        $query_sub_run = mysqli_query($con, $query_sub);

                        $check_sub = mysqli_num_rows($query_sub_run) > 0;

                        if ($check_sub) {
                          while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                            ?>
                            <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?></option>
                            <?php
                          }
                        }
                        ?>
                      </optgroup>
                      <optgroup label="Second Semester">
                        <?php
                        $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '2' AND semester = '2' ORDER BY year ASC";

                        $query_sub_run = mysqli_query($con, $query_sub);

                        $check_sub = mysqli_num_rows($query_sub_run) > 0;

                        if ($check_sub) {
                          while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                            ?>
                            <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?></option>
                            <?php
                          }
                        }
                        ?>
                      </optgroup>
                      </optgroup>
                      w
                      <!-- THIRD YEAR -->
                      <optgroup label="THIRD YEAR">
                      <optgroup label="First Semester">
                        <?php
                        $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '3' AND semester = '1' ORDER BY year ASC";

                        $query_sub_run = mysqli_query($con, $query_sub);

                        $check_sub = mysqli_num_rows($query_sub_run) > 0;

                        if ($check_sub) {
                          while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                            ?>
                            <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?></option>
                            <?php
                          }
                        }
                        ?>
                      </optgroup>
                      <optgroup label="Second Semester">
                        <?php
                        $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '3' AND semester = '2' ORDER BY year ASC";

                        $query_sub_run = mysqli_query($con, $query_sub);

                        $check_sub = mysqli_num_rows($query_sub_run) > 0;

                        if ($check_sub) {
                          while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                            ?>
                            <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?></option>
                            <?php
                          }
                        }
                        ?>
                      </optgroup>
                      </optgroup>
                      <!-- FOURTH YEAR -->
                      <optgroup label="FOURTH YEAR">
                      <optgroup label="First Semester">
                        <?php
                        $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '4' AND semester = '1' ORDER BY year ASC";

                        $query_sub_run = mysqli_query($con, $query_sub);

                        $check_sub = mysqli_num_rows($query_sub_run) > 0;

                        if ($check_sub) {
                          while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                            ?>
                            <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?></option>
                            <?php
                          }
                        }
                        ?>
                      </optgroup>
                    </select>
                  </div>
                  <div class="row mb-3">
                    <label for="prerequisite">Prerequisite Subject: </label>
                    <select name="prerequisite" id="prerequisite" class="form-select">
                      <option value="selected" selected disabled>---Select Prerequisite Subject---</option>
                      <!-- FIRST YEAR -->
                      <optgroup label="FIRST YEAR">
                      <optgroup label="First Semester">
                        <?php
                        $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '1' AND semester = '1' ORDER BY year ASC";

                        $query_sub_run = mysqli_query($con, $query_sub);

                        $check_sub = mysqli_num_rows($query_sub_run) > 0;

                        if ($check_sub) {
                          while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                            ?>
                            <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?></option>
                            <?php
                          }
                        }
                        ?>
                      </optgroup>
                      <optgroup label="Second Semester">
                        <?php
                        $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '1' AND semester = '2' ORDER BY year ASC";

                        $query_sub_run = mysqli_query($con, $query_sub);

                        $check_sub = mysqli_num_rows($query_sub_run) > 0;

                        if ($check_sub) {
                          while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                            ?>
                            <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?></option>
                            <?php
                          }
                        }
                        ?>
                      </optgroup>
                      </optgroup>
                      <!-- SECOND YEAR -->
                      <optgroup label="SECOND YEAR">
                      <optgroup label="First Semester">
                        <?php
                        $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '2' AND semester = '1' ORDER BY year ASC";

                        $query_sub_run = mysqli_query($con, $query_sub);

                        $check_sub = mysqli_num_rows($query_sub_run) > 0;

                        if ($check_sub) {
                          while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                            ?>
                            <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?></option>
                            <?php
                          }
                        }
                        ?>
                      </optgroup>
                      <optgroup label="Second Semester">
                        <?php
                        $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '2' AND semester = '2' ORDER BY year ASC";

                        $query_sub_run = mysqli_query($con, $query_sub);

                        $check_sub = mysqli_num_rows($query_sub_run) > 0;

                        if ($check_sub) {
                          while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                            ?>
                            <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?></option>
                            <?php
                          }
                        }
                        ?>
                      </optgroup>
                      </optgroup>
                      w
                      <!-- THIRD YEAR -->
                      <optgroup label="THIRD YEAR">
                      <optgroup label="First Semester">
                        <?php
                        $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '3' AND semester = '1' ORDER BY year ASC";

                        $query_sub_run = mysqli_query($con, $query_sub);

                        $check_sub = mysqli_num_rows($query_sub_run) > 0;

                        if ($check_sub) {
                          while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                            ?>
                            <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?></option>
                            <?php
                          }
                        }
                        ?>
                      </optgroup>
                      <optgroup label="Second Semester">
                        <?php
                        $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '3' AND semester = '2' ORDER BY year ASC";

                        $query_sub_run = mysqli_query($con, $query_sub);

                        $check_sub = mysqli_num_rows($query_sub_run) > 0;

                        if ($check_sub) {
                          while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                            ?>
                            <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?></option>
                            <?php
                          }
                        }
                        ?>
                      </optgroup>
                      </optgroup>
                      <!-- FOURTH YEAR -->
                      <optgroup label="FOURTH YEAR">
                      <optgroup label="First Semester">
                        <?php
                        $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '4' AND semester = '1' ORDER BY year ASC";

                        $query_sub_run = mysqli_query($con, $query_sub);

                        $check_sub = mysqli_num_rows($query_sub_run) > 0;

                        if ($check_sub) {
                          while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                            ?>
                            <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?></option>
                            <?php
                          }
                        }
                        ?>
                      </optgroup>
                    </select>
                  </div>
                  <div class="row">
                    <label for="prereq_year" class="form-label">Year level:</label>
                    <Select name="prereq_year" id="prereq_year" class="form-select">
                      <option value="selected" selected disabled>---Select year level---</option>
                      <?php
                      $query_year = "SELECT year_id, year_level FROM year_level";

                      $query_year_run = mysqli_query($con, $query_year);

                      $check_year = mysqli_num_rows($query_year_run) > 0;

                      if ($check_year) {
                        while ($row_year = mysqli_fetch_array($query_year_run)) {
                          ?>
                          <option value="<?php echo $row_year['year_id'] ?>"><?php echo $row_year['year_level'] ?> YEAR
                          </option>
                          <?php
                        }
                      }
                      ?>
                    </Select>
                  </div>
              </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                  class="fa-regular fa-circle-xmark"></i> Close</button>
              <input type="submit" name="submit_prereq" id="submit_prereq" class="btn btn-success" value="Save">
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- END PREREQ MODAL -->

      <!-- START EDIT PREREQ MODAL -->
      <div class="modal fade" id="edit_Prereq" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-danger">
              <h5 class="modal-title text-light" id="edit_Prereq_modalLabel">EDIT PREREQUISITE SUBJECT</h5>
              <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="container">
                <form action="../../controller/controller.php" method="POST">
                  <input type="hidden" name="prereqID" id="prereqID">
                  <div class="row mb-3">
                    <label for="prereq_sub2">Subject: </label>
                    <select name="prereq_sub2" id="prereq_sub2" class="form-select">
                      <option value="selected" selected disabled>---Select Subject---</option>
                      <!-- FIRST YEAR -->
                      <optgroup label="FIRST YEAR">
                      <optgroup label="First Semester">
                        <?php
                        $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '1' AND semester = '1' ORDER BY year ASC";

                        $query_sub_run = mysqli_query($con, $query_sub);

                        $check_sub = mysqli_num_rows($query_sub_run) > 0;

                        if ($check_sub) {
                          while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                            ?>
                            <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?></option>
                            <?php
                          }
                        }
                        ?>
                      </optgroup>
                      <optgroup label="Second Semester">
                        <?php
                        $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '1' AND semester = '2' ORDER BY year ASC";

                        $query_sub_run = mysqli_query($con, $query_sub);

                        $check_sub = mysqli_num_rows($query_sub_run) > 0;

                        if ($check_sub) {
                          while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                            ?>
                            <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?></option>
                            <?php
                          }
                        }
                        ?>
                      </optgroup>
                      </optgroup>
                      <!-- SECOND YEAR -->
                      <optgroup label="SECOND YEAR">
                      <optgroup label="First Semester">
                        <?php
                        $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '2' AND semester = '1' ORDER BY year ASC";

                        $query_sub_run = mysqli_query($con, $query_sub);

                        $check_sub = mysqli_num_rows($query_sub_run) > 0;

                        if ($check_sub) {
                          while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                            ?>
                            <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?></option>
                            <?php
                          }
                        }
                        ?>
                      </optgroup>
                      <optgroup label="Second Semester">
                        <?php
                        $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '2' AND semester = '2' ORDER BY year ASC";

                        $query_sub_run = mysqli_query($con, $query_sub);

                        $check_sub = mysqli_num_rows($query_sub_run) > 0;

                        if ($check_sub) {
                          while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                            ?>
                            <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?></option>
                            <?php
                          }
                        }
                        ?>
                      </optgroup>
                      </optgroup>
                      w
                      <!-- THIRD YEAR -->
                      <optgroup label="THIRD YEAR">
                      <optgroup label="First Semester">
                        <?php
                        $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '3' AND semester = '1' ORDER BY year ASC";

                        $query_sub_run = mysqli_query($con, $query_sub);

                        $check_sub = mysqli_num_rows($query_sub_run) > 0;

                        if ($check_sub) {
                          while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                            ?>
                            <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?></option>
                            <?php
                          }
                        }
                        ?>
                      </optgroup>
                      <optgroup label="Second Semester">
                        <?php
                        $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '3' AND semester = '2' ORDER BY year ASC";

                        $query_sub_run = mysqli_query($con, $query_sub);

                        $check_sub = mysqli_num_rows($query_sub_run) > 0;

                        if ($check_sub) {
                          while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                            ?>
                            <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?></option>
                            <?php
                          }
                        }
                        ?>
                      </optgroup>
                      </optgroup>
                      <!-- FOURTH YEAR -->
                      <optgroup label="FOURTH YEAR">
                      <optgroup label="First Semester">
                        <?php
                        $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '4' AND semester = '1' ORDER BY year ASC";

                        $query_sub_run = mysqli_query($con, $query_sub);

                        $check_sub = mysqli_num_rows($query_sub_run) > 0;

                        if ($check_sub) {
                          while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                            ?>
                            <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?></option>
                            <?php
                          }
                        }
                        ?>
                      </optgroup>
                    </select>
                  </div>
                  <div class="row mb-3">
                    <label for="prerequisite2">Prerequisite Subject: </label>
                    <select name="prerequisite2" id="prerequisite2" class="form-select">
                      <option value="selected" selected disabled>---Select Prerequisite Subject---</option>
                      <!-- FIRST YEAR -->
                      <optgroup label="FIRST YEAR">
                      <optgroup label="First Semester">
                        <?php
                        $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '1' AND semester = '1' ORDER BY year ASC";

                        $query_sub_run = mysqli_query($con, $query_sub);

                        $check_sub = mysqli_num_rows($query_sub_run) > 0;

                        if ($check_sub) {
                          while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                            ?>
                            <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?></option>
                            <?php
                          }
                        }
                        ?>
                      </optgroup>
                      <optgroup label="Second Semester">
                        <?php
                        $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '1' AND semester = '2' ORDER BY year ASC";

                        $query_sub_run = mysqli_query($con, $query_sub);

                        $check_sub = mysqli_num_rows($query_sub_run) > 0;

                        if ($check_sub) {
                          while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                            ?>
                            <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?></option>
                            <?php
                          }
                        }
                        ?>
                      </optgroup>
                      </optgroup>
                      <!-- SECOND YEAR -->
                      <optgroup label="SECOND YEAR">
                      <optgroup label="First Semester">
                        <?php
                        $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '2' AND semester = '1' ORDER BY year ASC";

                        $query_sub_run = mysqli_query($con, $query_sub);

                        $check_sub = mysqli_num_rows($query_sub_run) > 0;

                        if ($check_sub) {
                          while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                            ?>
                            <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?></option>
                            <?php
                          }
                        }
                        ?>
                      </optgroup>
                      <optgroup label="Second Semester">
                        <?php
                        $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '2' AND semester = '2' ORDER BY year ASC";

                        $query_sub_run = mysqli_query($con, $query_sub);

                        $check_sub = mysqli_num_rows($query_sub_run) > 0;

                        if ($check_sub) {
                          while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                            ?>
                            <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?></option>
                            <?php
                          }
                        }
                        ?>
                      </optgroup>
                      </optgroup>
                      w
                      <!-- THIRD YEAR -->
                      <optgroup label="THIRD YEAR">
                      <optgroup label="First Semester">
                        <?php
                        $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '3' AND semester = '1' ORDER BY year ASC";

                        $query_sub_run = mysqli_query($con, $query_sub);

                        $check_sub = mysqli_num_rows($query_sub_run) > 0;

                        if ($check_sub) {
                          while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                            ?>
                            <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?></option>
                            <?php
                          }
                        }
                        ?>
                      </optgroup>
                      <optgroup label="Second Semester">
                        <?php
                        $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '3' AND semester = '2' ORDER BY year ASC";

                        $query_sub_run = mysqli_query($con, $query_sub);

                        $check_sub = mysqli_num_rows($query_sub_run) > 0;

                        if ($check_sub) {
                          while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                            ?>
                            <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?></option>
                            <?php
                          }
                        }
                        ?>
                      </optgroup>
                      </optgroup>
                      <!-- FOURTH YEAR -->
                      <optgroup label="FOURTH YEAR">
                      <optgroup label="First Semester">
                        <?php
                        $query_sub = "SELECT subject_id, subject FROM subject WHERE year = '4' AND semester = '1' ORDER BY year ASC";

                        $query_sub_run = mysqli_query($con, $query_sub);

                        $check_sub = mysqli_num_rows($query_sub_run) > 0;

                        if ($check_sub) {
                          while ($row_sub = mysqli_fetch_array($query_sub_run)) {
                            ?>
                            <option value="<?php echo $row_sub['subject_id'] ?>"><?php echo $row_sub['subject'] ?></option>
                            <?php
                          }
                        }
                        ?>
                      </optgroup>
                    </select>
                  </div>
                  <div class="row">
                    <label for="prereq_year2" class="form-label">Year level:</label>
                    <Select name="prereq_year2" id="prereq_year2" class="form-select">
                      <option value="selected" selected disabled>---Select year level---</option>
                      <?php
                      $query_year = "SELECT year_id, year_level FROM year_level";

                      $query_year_run = mysqli_query($con, $query_year);

                      $check_year = mysqli_num_rows($query_year_run) > 0;

                      if ($check_year) {
                        while ($row_year = mysqli_fetch_array($query_year_run)) {
                          ?>
                          <option value="<?php echo $row_year['year_id'] ?>"><?php echo $row_year['year_level'] ?> YEAR
                          </option>
                          <?php
                        }
                      }
                      ?>
                    </Select>
                  </div>
              </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                  class="fa-regular fa-circle-xmark"></i> Close</button>
              <input type="submit" name="update_prereq" id="update_prereq" class="btn btn-success" value="Update">
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- END PREREQ MODAL -->

    </div>
    <!-- END PREREQ TAB -->

  </div>
  <!-- END TAB BODY -->


</section>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

  // VALIDATION KAPAG HINDI NAKAPAGINPUT NG IMAGE SI ADMIN
  $('#myForm').on('submit', function (event) {
    var imageInput = $('#imageInput');

    if (imageInput[0].files.length === 0) {
      event.preventDefault();
      Swal.fire({
        icon: 'warning',
        title: 'Oops...',
        text: 'Please upload a picture before submitting.',
        confirmButtonText: 'Okay'
      });
      imageInput.focus();
    }
  });

  $('#new_image').on('change', function () {
    var input = this;

    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $('#facultyImage').attr('src', e.target.result).show();
      }
      reader.readAsDataURL(input.files[0]);
    }
  });



  // HIDDEN INPUT NI IMAGE
  function selectImage() {
    $('#imageInput').click();
  }

  // IMAGE PREVIEW PARA KAPAG PUMILI NG IMAGE MAGDISPLAY AGAD
  function previewImage() {
    const file = document.getElementById('imageInput').files[0];
    const reader = new FileReader();

    reader.onload = function (e) {
      document.getElementById('imagePreview').src = e.target.result;
    }

    if (file) {
      reader.readAsDataURL(file);
    }
  }

  // Display SweetAlert if session status is set
  <?php if (isset($_SESSION['status'])): ?>
    Swal.fire({
      text: "<?php echo $_SESSION['status']; ?>",
      icon: "<?php echo $_SESSION['status_code']; ?>",
      showConfirmButton: true
    });
    <?php
    // Clear session variables after alert is shown
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);
    ?>
  <?php endif; ?>

  $(document).ready(function () {
    // Reusable live search function
    function liveSearch(inputId, tableId) {
      $(inputId).on('keyup', function () {
        var value = $(this).val().toLowerCase();
        $(tableId + ' tbody tr').filter(function () {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
      });
    }
    // Live search for subject table
    $('#searchInputPre').on('keyup', function () {
      var value = $(this).val().toLowerCase();  // Get search input
      $('#pprereq_table tbody tr').filter(function () {
        // Check if subject or prerequisite contains the search term
        $(this).toggle(
          $(this).text().toLowerCase().indexOf(value) > -1
        );
      });
    });

    $('#searchInputSubjectKo').on('keyup', function () {
      var value = $(this).val().toLowerCase();  // Get search input
      $('#subject_table tbody tr').filter(function () {
        // Check if any of the text in the row contains the search term
        $(this).toggle(
          $(this).text().toLowerCase().indexOf(value) > -1
        );
      });
    });

    // Live search for the section table
    $('#searchInputSection').on('keyup', function () {
      var value = $(this).val().toLowerCase();  // Get search input
      $('#section_table tbody tr').filter(function () {
        // Check if any of the text in the row contains the search term
        $(this).toggle(
          $(this).text().toLowerCase().indexOf(value) > -1
        );
      });
    });

    $('#searchInputApprovedFaculty').on('keyup', function () {
      var value = $(this).val().toLowerCase();  // Get search input
      $('#facultyApprovedTable tbody tr').filter(function () {
        // Check if the faculty name (in column 1) matches the search input
        $(this).toggle(
          $(this).find('td:first').text().toLowerCase().indexOf(value) > -1
        );
      });
    });


    $('#searchInputApproved').on('keyup', function () {
      var value = $(this).val().toLowerCase();  // Get search input
      $('#studentApprovedTable tbody tr').filter(function () {
        // Check if the student's name (in column 1) matches the search input
        $(this).toggle(
          $(this).find('td:first').text().toLowerCase().indexOf(value) > -1
        );
      });
    });

    // Apply live search to all tables
    liveSearch('#searchInput', '#studentTable');
    liveSearch('#searchInputFaculty', '#facultyTable');
    liveSearch('#searchInputAssignTable', '#assignTable');
    liveSearch('#searchInputAdd', '#addTable');
    liveSearch('#searchInputSection', '#sectionTable');
    liveSearch('#searchInputPre', '#preTable');

  });
</script>
<script>

  //EDIT STUDENT
  $('.edit-st').on('click', function () {
    var srcode = $(this).attr('id');

    $.ajax({
      url: '../../controller/getSRCst.php',
      type: 'GET',
      data: { srcode: srcode },
      dataType: 'json',
      success: function (data) {
        var STdata = data[0];

        $('#srcode2').val(STdata.sr_code);
        $('#srcode3').val(STdata.sr_code);
        $('#lastname2').val(STdata.lastname);
        $('#firstname2').val(STdata.firstname);
        $('#middlename2').val(STdata.middlename);
        $('#year2').val(STdata.year_level);
        $('#course2').val(STdata.course);
        $('#sem2').val(STdata.sem_id);
      }
    });
  });

  //DELETE STUDENT
  $('.delete-st').on('click', function () {
    var srcode = $(this).attr('id');

    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: "btn btn-success ms-2",
        cancelButton: "btn btn-danger me-2"
      },
      buttonsStyling: false
    });
    swalWithBootstrapButtons.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "No, cancel!",
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '../../controller/deleteSRCst.php',
          type: 'POST',
          data: { srcode: srcode },
          success: function (data) {
            swalWithBootstrapButtons.fire({
              title: "Deleted!",
              icon: "success",
              toast: true,
              timer: 1000,
              timerProgressBar: true,
              showConfirmButton: false,
              position: "top-right",
              didClose: () => {
                window.location.reload();
              },
            });
          }
        });
      } else if (
        result.dismiss === Swal.DismissReason.cancel
      ) {
        swalWithBootstrapButtons.fire({
          title: "Cancelled",
          text: "file is safe",
          icon: "error"
        });
      }
    });
  });

  //DELETE ASSIGNED SUBJECT
  $('.delete-AS').on('click', function () {
    var asID = $(this).attr('id');
    console.log(asID)
    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: "btn btn-success ms-2",
        cancelButton: "btn btn-danger me-2"
      },
      buttonsStyling: false
    });
    swalWithBootstrapButtons.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "No, cancel!",
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '../../controller/deleteAssigned.php',
          type: 'POST',
          data: { ID: asID },
          success: function (data) {
            swalWithBootstrapButtons.fire({
              title: "Deleted!",
              icon: "success",
              toast: true,
              timer: 1000,
              timerProgressBar: true,
              showConfirmButton: false,
              position: "top-right",
              didClose: () => {
                window.location.reload();
              },
            });
          }
        });
      } else if (
        result.dismiss === Swal.DismissReason.cancel
      ) {
        swalWithBootstrapButtons.fire({
          title: "Cancelled",
          text: "file is safe",
          icon: "error"
        });
      }
    });
  });

  //GET SUBJECT
  $('.edit-sub').on('click', function () {
    var subID = $(this).attr('id');

    $.ajax({
      url: '../../controller/getmaintSub.php',
      type: 'GET',
      data: { subject_id: subID },
      dataType: 'json',
      success: function (data) {
        var subdata = data[0];
        $('#subID').val(subdata.subject_id);
        $('#subject2').val(subdata.subject);
        $('#unit2').val(subdata.unit);
        $('#code2').val(subdata.subject_code);
        $('#semes2').val(subdata.sem);
        $('#yearlvl2').val(subdata.year);
      }
    });
  });

  //GET SECTION
  $('.edit-sec').on('click', function () {
    var id = $(this).attr('id');

    $.ajax({
      url: '../../controller/getmaintSec.php',
      type: 'GET',
      data: { id: id },
      dataType: 'json',
      success: function (data) {
        var secdata = data[0];
        $('#secID').val(secdata.id);
        $('#addsection2').val(secdata.section);
        $('#year_id2').val(secdata.year_id);
        $('#sem_id2').val(secdata.sem_id);
      }
    });
  });

  //DELETE SECTION
  $('.delete-sec').on('click', function () {
    var secID = $(this).attr('id');

    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: "btn btn-success ms-2",
        cancelButton: "btn btn-danger me-2"
      },
      buttonsStyling: false
    });
    swalWithBootstrapButtons.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "No, cancel!",
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '../../controller/deleteSec.php',
          type: 'POST',
          data: { secID: secID },
          success: function (data) {
            swalWithBootstrapButtons.fire({
              title: "Deleted!",
              icon: "success",
              toast: true,
              timer: 1000,
              timerProgressBar: true,
              showConfirmButton: false,
              position: "top-right",
              didClose: () => {
                window.location.reload();
              },
            });
          }
        });
      } else if (
        result.dismiss === Swal.DismissReason.cancel
      ) {
        swalWithBootstrapButtons.fire({
          title: "Cancelled",
          text: "file is safe",
          icon: "error"
        });
      }
    });
  });

  //GET PREREQUISITE
  $('.edit-prereq').on('click', function () {
    var prereqID = $(this).attr('id');

    $.ajax({
      url: '../../controller/getPrereq.php',
      type: 'GET',
      data: { id: prereqID },
      dataType: 'json',
      success: function (data) {
        var prereqdata = data[0];

        $('#prereqID').val(prereqdata.id);
        $('#prereq_sub2').val(prereqdata.subject_id);
        $('#prerequisite2').val(prereqdata.prereq_id);
        $('#prereq_year2').val(prereqdata.year_id);
      }
    });
  });
  //DELETE PREREQUISITE
  $('.delete-prereq').on('click', function () {
    var prereqID = $(this).attr('id');

    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: "btn btn-success ms-2",
        cancelButton: "btn btn-danger me-2"
      },
      buttonsStyling: false
    });
    swalWithBootstrapButtons.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "No, cancel!",
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '../../controller/deletePrereq.php',
          type: 'POST',
          data: { ID: prereqID },
          success: function (data) {
            swalWithBootstrapButtons.fire({
              title: "Deleted!",
              icon: "success",
              toast: true,
              timer: 1000,
              timerProgressBar: true,
              showConfirmButton: false,
              position: "top-right",
              didClose: () => {
                window.location.reload();
              },
            });
          }
        });
      } else if (
        result.dismiss === Swal.DismissReason.cancel
      ) {
        swalWithBootstrapButtons.fire({
          title: "Cancelled",
          text: "file is safe",
          icon: "error"
        });
      }
    });
  });



  //START ASSIGN SUBJECT JS
  // GET SECTION DEPENDING ON WHAT IS SELECTED SUBJECT
  $("#sub_id").on("change", function () {
    var subject = $(this).val();

    if (subject) {
      $.ajax({
        url: "../../controller/getSection.php",
        type: "POST",
        data: { sub_id: subject },
        success: function (response) {
          $("#sec_id").html(response);
        },
      });
    } else {
      $("#sec_id").html(
        '<option value="selected" selected disabled>---Select Section---</option>'
      );
    }
  });

  //GET END TIME 3HRS MAX TIME
  $("#Stime").on("change", function () {
    var Stime = $(this).val();

    if (Stime) {
      $.ajax({
        url: "../../controller/getEtime.php",
        type: "POST",
        data: { stime: Stime },
        success: function (response) {
          $("#Etime").html(response);
        },
      });
    } else {
      $("#Etime").html(
        '<option value="selected" selected disabled>---Select end time---</option>'
      );
    }
  });

  //SHOW SCHEDULE PART IF SECTION DROPDOWN HAS BEEN SELECTED
  $("#sec_id").on("change", function () {
    $("#sched_part").css("display", "flex");
    $("#day, #day2").val("selected");
    $("#Stime, #Stime2").html(
      '<option value="selected" selected disabled>---Select start time---</option>'
    );
    $("#Etime, #Etime2").html(
      '<option value="selected" selected disabled>---Select end time---</option>'
    );
  });
  $("#sub_id").on("change", function () {
    $("#day, #day2").val("selected");
    $("#Stime, #Stime2").html(
      '<option value="selected" selected disabled>---Select start time---</option>'
    );
    $("#Etime, #Etime2").html(
      '<option value="selected" selected disabled>---Select end time---</option>'
    );
  });
  $("#sched2").on("click", function () {
    $("#sched_part2").css("display", "flex");
  });

  //CHECK FOR STRAT TIME IF ALREADY TAKEN
  $("#day").on("change", function () {
    var day = $(this).val();
    var section = $("#sec_id").val();

    if (day) {
      $.ajax({
        url: "../../controller/getStime.php",
        type: "POST",
        data: { day: day, section: section },
        success: function (response) {
          $("#Stime").html(response);
        },
      });
    } else {
      $("#Stime").html(
        '<option value="selected" selected disabled>---Select start time---</option>'
      );
    }
  });

  //GET INSTRUCTOR THAT DOES NOT BEING ASSIGNED ON THE SELECTED SUBJECT
  $("#sub_id").on("change", function () {
    var sub_id = $(this).val();

    if (sub_id) {
      $.ajax({
        url: "../../controller/getInstructor.php",
        type: "POST",
        data: { sub_id: sub_id },
        success: function (response) {
          $("#fclty_id").html(response);
        },
      });
    } else {
      $("#fclty_id").html(
        '<option value="selected" selected disabled>---Select Instructor---</option>'
      );
    }
  });

  //REMOVE THE SELECTED TIME ON THE FIRSTH SCHEDULE
  $("#day2").on("change", function () {
    var Etime = $("#Etime").val();
    var Stime = $("#Stime").val();
    var day = $("#day2").val();
    var section = $("#sec_id").val();

    // $('#sched2').attr('disabled', false);

    if (Etime) {
      $.ajax({
        url: "../../controller/getStime2.php",
        type: "POST",
        data: {
          Etime: Etime,
          Stime: Stime,
          day: day,
          section: section,
        },
        success: function (response) {
          $("#Stime2").html(response);
        },
      });
    } else {
      $("#Stime2").html(
        '<option value="selected" selected disabled>---Select start time---</option>'
      );
    }
  });
  $("#Stime2").on("change", function () {
    var Stime = $(this).val();

    if (Stime) {
      $.ajax({
        url: "../../controller/getEtime.php",
        type: "POST",
        data: { stime: Stime },
        success: function (response) {
          $("#Etime2").html(response);
        },
      });
    } else {
      $("#Etime2").html(
        '<option value="selected" selected disabled>---Select end time---</option>'
      );
    }
  });//END OF ASSIGN SUBJECT JS</script>

<script>
  $(document).ready(function () {
    $('.deleteButton').click(function () {
      var srcode = $(this).data('src'); // Get the student code
      console.log('Student code:', srcode);  // Debug line to check if data-src is fetched
      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: "btn btn-success ms-2",
          cancelButton: "btn btn-danger me-2"
        },
        buttonsStyling: false
      });
      swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this action!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
            url: "../../controller/deleteApprove.php",
            data: {
              srcode: srcode
            },
            dataType: "json",
            success: function (response) {
              if (response.success) {

                swalWithBootstrapButtons.fire({
                  title: "Deleted!",
                  text: "The student record has been deleted.",
                  icon: "success",
                  toast: true,
                  timer: 1000,
                  timerProgressBar: true,
                  showConfirmButton: false,
                  position: "top-right",
                  didClose: () => {
                    window.location.reload();
                  },
                });
              } else {

                swalWithBootstrapButtons.fire({
                  title: "Error!",
                  text: "There was an error deleting the record.",
                  icon: "error",
                  toast: true,
                  timer: 1000,
                  timerProgressBar: true,
                  showConfirmButton: false,
                  position: "top-right",
                  didClose: () => {
                    window.location.reload();
                  },
                });
              }
            },
            error: function (jqXHR, textStatus, errorThrown) {

              swalWithBootstrapButtons.fire({
                title: "Error!",
                text: "An error occurred while trying to delete the record.",
                icon: "error",
                toast: true,
                timer: 1000,
                timerProgressBar: true,
                showConfirmButton: false,
                position: "top-right",
                didClose: () => {
                  window.location.reload();
                },
              });
            }
          });
        }
      });
    });
  });

</script>