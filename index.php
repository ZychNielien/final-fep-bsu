<?php
session_start();


if (isset($_SESSION['studentSRCode'])) {
  header('Location: view/student_view.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>BatStateU Faculty Evaluation</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap 5 JS (Popper.js is included) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  <link rel="shortcut icon" href="public/picture/cics.png" type="image/x-icon" />
  <link rel="stylesheet" href="public/css/login.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- SweetAlert2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css" rel="stylesheet">

  <!-- SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>

  <!-- JQUERY CDN -->
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>

  <!-- LOCALSTORAGE JS -->
  <script src="public/js/localStorage.js"></script>
  <!--  -->

  <style>
    .register {
      text-align: center;
    }

    .register span,
    .register a {
      text-decoration: none;
      color: white;

    }

    .register span {
      font-size: 13px;
    }

    .register a {
      font-weight: bold;
    }
  </style>
</head>

<body>
  <main>

    <!-- Modal -->
    <div class="modal fade" id="studentRegistration" tabindex="-1" aria-labelledby="studentRegistrationLabel"
      aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-danger">
            <h5 class="modal-title text-white" id="studentRegistrationLabel">Student Registration Process</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-3 ">

            <form action="controller/controller.php" method="POST">
              <div class="mb-3">
                <span for="studentName" class="form-label">SR-CODE</span>
                <input type="text" name="srcode" id="srcode" autocomplete="off" class="form-control"
                  placeholder="Enter Sr-code">
              </div>
              <div class="mb-3">
                <span for="studentEmail" class="form-label">First Name</span>
                <input type="text" name="firstname" id="firstname" autocomplete="off" class="form-control"
                  placeholder="Enter first name">
              </div>
              <div class="mb-3">
                <span for="studentPassword" class="form-label">Middle Name</span>
                <input type="text" name="middlename" id="middlename" autocomplete="off" class="form-control"
                  placeholder="Enter middel name">
              </div>
              <div class="mb-3">
                <span for="studentName" class="form-label">Last Name</span>
                <input type="text" name="lastname" id="lastname" autocomplete="off" class="form-control"
                  placeholder="Enter last name">
              </div>
              <div class="mb-3">
                <span for="studentEmail" class="form-label">Year Level</span>
                <select name="year" id="year" class="form-select">
                  <option value="selected" selected disabled>---Select Year level---</option>
                  <option value="1">FIRST</option>
                  <option value="2">SECOND</option>
                  <option value="3">THIRD</option>
                  <option value="4">FOURTH</option>
                </select>
              </div>
              <div class="mb-3">
                <span for="studentPassword" class="form-label">Course</span>
                <select name="course" id="course" class="form-select">
                  <option value="selected" selected disabled>---Select Course---</option>
                  <option value="Bachelor of Science in Information Technology">Bachelor of Science in Information
                    Technology</option>
                  <option value="Bachelor of Science in Computer Science">Bachelor of Science in Computer Science
                  </option>
                </select>
              </div>
              <div class="mb-3">
                <span for="studentPassword" class="form-label">Semester</span>
                <select name="sem" id="sem" class="form-select">
                  <option value="selected" selected disabled>---Select Semester---</option>
                  <option value="1">FIRST</option>
                  <option value="2">SECOND</option>
                </select>
              </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <input type="submit" name="submit_student" id="submit_student" class="btn btn-success" value="Submit">
          </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="facultyRegistration" tabindex="-1" aria-labelledby="facultyRegistrationLabel"
      aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-danger">
            <h5 class="modal-title text-white" id="facultyRegistrationLabel">Student Registration Process</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="myForm" method="POST" action="controller/facultyQuery.php" enctype="multipart/form-data">
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
                <input type="text" class="form-control my-1" id="gsuite" placeholder="Enter your Gsuite" name="gsuite">
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
              <button type="submit" id="addFaculty" name="addFaculty" class="btn btn-primary">Submit</button>
            </div>
            <!-- INPUT NI IMAGE -->
            <input type="file" id="imageInput" name="image" accept="image/*" style="display: none;"
              onchange="previewImage();">
          </form>
        </div>
      </div>
    </div>


    <div class="box">
      <div class="inner-box">
        <div class="forms-wrap">
          <form action="controller/login.php" method="POST" autocomplete="off" class="sign-in-form formAll" style="  width: 80%;
  margin: 0 auto;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: space-evenly;
  grid-column: 1 / 2;
  grid-row: 1 / 2;
  transition: opacity 0.02s 0.4s;">
            <div class="logo">
              <img src="public/picture/bsu.png" alt="BatStateU-Logo" />
              <img src="public/picture/cics.png" alt="CICS-Logo" />
            </div>

            <div class="heading">
              <h2>Student Login</h2>
              <h6>Are you a Faculty?</h6>
              <a href="#" class="toggle">Click here</a>
            </div>

            <div class="actual-form">
              <div class="input-wrap">
                <input type="text" name="studentSRCode" id="studentSRCode" minlength="4" class="input-field"
                  autocomplete="off" required />
                <label>SR-Code</label>
              </div>

              <div class="input-wrap">
                <input type="password" name="studentpass" minlength="4" id="passStudentInput" class="input-field"
                  autocomplete="off" required />
                <label>Password</label>
                <span class="password-toggle-icon"><i class="fa-solid fa-eye" id="passStudent"></i></span>
              </div>

              <input type="submit" name="studentLogin" id="studentLogin" value="Sign In" class="sign-btn" />

              <div class="register">
                <span>Don't have an account? <a href="#" data-bs-toggle="modal"
                    data-bs-target="#studentRegistration">Request Now</a></span>
              </div>
            </div>
          </form>

          <form action="controller/login.php" method="POST" autocomplete="off" class="sign-up-form formAll">
            <div class="logo">
              <img src="public/picture/bsu.png" alt="BatStateU-Logo" />
              <img src="public/picture/cics.png" alt="CICS-Logo" />
            </div>

            <div class="heading">
              <h2>Faculty Login</h2>
              <h6>Are you a Student?</h6>
              <a href="#" class="toggle">Click here</a>
            </div>

            <div class="actual-form">

              <div class="input-wrap">
                <input type="text" class="input-field" autocomplete="off" name="gsuite" required />
                <label>Gsuite</label>
              </div>

              <div class="input-wrap">
                <input type="password" name="password" minlength="2" id="passFacultyInput" class="input-field"
                  autocomplete="off" required />
                <label>Password</label>
                <span class="password-toggle-icon"><i class="fa-solid fa-eye" id="passFaculty"></i></span>
              </div>

              <input type="submit" name="facultyadmin" value="Sign In" class="sign-btn" />
              <div class="register">
                <span>Don't have an account? <a href="#" data-bs-toggle="modal"
                    data-bs-target="#facultyRegistration">Request Now</a></span>
              </div>
            </div>
          </form>
        </div>

        <div class="carousel" style="


            ">
          <div class="images-wrapper">
            <img src="public/picture/BatStateU-cover-1.jpg" class="image img-1 show" alt />
            <img src="public/picture/BatStateU-cover-2.jpg" class="image img-2" alt />
            <img src="public/picture/BatStateU-cover-3.jpg" class="image img-3" alt />
          </div>

          <div class="text-slider">
            <div class="text-wrap">
              <div class="text-group">
                <h2>Leading innovations,</h2>
                <h2>Transforming Lives,</h2>
                <h2>Building the Nation.</h2>
              </div>
            </div>

            <div class="bullets">
              <span class="active" data-value="1"></span>
              <span data-value="2"></span>
              <span data-value="3"></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- SweetAlert2 JS (Ensure this is loaded correctly) -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>

  <!-- jQuery CDN -->
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>

  <script src="public/js/main.js"></script>
  <script>
    $(document).ready(function () {

      // Show password for Student 
      $('#passStudent').click(function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        $("#passStudentInput").attr('type', $("#passStudentInput").attr('type') === 'password' ? 'text' : 'password');
      })

      // Show password for Faculty
      $('#passFaculty').click(function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        $("#passFacultyInput").attr('type', $("#passFacultyInput").attr('type') === 'password' ? 'text' : 'password');
      })
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

      <?php if (isset($_GET['alert']) && $_GET['alert'] === 'major') {
        ?>
        Swal.fire({
          title: "Status Updated",
          text: "You have been logged out after selecting your major",
          icon: "info",
          button: "Ok",
        }).then(() => {
          const urlWithoutParams = window.location.origin + window.location.pathname;
          window.history.replaceState({}, document.title, urlWithoutParams);
        });
        <?php
      }
      ?>

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

    })

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
  </script>


</body>

</html>