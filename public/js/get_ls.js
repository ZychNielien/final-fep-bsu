$(document).ready(function () {
  var studentData = JSON.parse(localStorage.getItem("Student_Data"));
  console.log(studentData);
  var lastname = studentData[0].lastname;
  var firstname = studentData[0].firstname;
  var course = studentData[0].course;
  var year = studentData[0].year_level;
  var semester = studentData[0].semester;
  var srcode = studentData[0].sr_code;
  var getMajor = studentData[0].major;
  var getYear = studentData[0].year_id;
  var GetSemester = studentData[0].sem_id;

  $("#lastname").text(lastname);
  $("#firstname").text(firstname);
  $("#course").text(course);
  $("#year").text(year);
  $("#semester").text(semester);
  $("#usermajor").text(getMajor);

  if (year == "FIRST" || year == "SECOND") {
    $("#maxunit").text("23");
  } else {
    $("#maxunit").text("21");
  }

  // if(getMajor == 0){
  //   $('#submitMajor').on('click', function(){
  //     $.ajax({
  //       url: '../controller/getMajor.php',
  //       type: 'GET',
  //       data: {srcode: srcode},
  //       dataType: 'json',
  //       success: function(data){
  //         localStorage.setItem('GetMajor', JSON.stringify(data));
  //       }
  //     })

  //   });
  //   var getM = JSON.parse(localStorage.getItem("GetMajor"));
  //   var getMajor = getM[0].major;
  // }

  $.ajax({
    url: "../controller/getSem.php",
    type: "GET",
    dataType: "json",
    success: function (data) {
      localStorage.setItem("GetSemester", JSON.stringify(data));
    },
  });
  var getSem = JSON.parse(localStorage.getItem("GetSemester"));
  var GetSems = getSem[0].semester;
  $("#getSem, #getSem2").text(GetSems);

  if (year == "THIRD" && semester == "FIRST" && getMajor == 0) {
    $("#major").css("display", "flex");
    $("#usermajor2").css("display", "none");
    Swal.fire({
      title: "Choose your Major",
      text: "You need to choose your Major",
      icon: "warning",
      showCancelButton: true,
      cancelButtonText: "Close",
      cancelButtonColor: "#d33",
      showConfirmButton: false,
    });
  } else if (getMajor == 0) {
    $("#major").css("display", "none");
    $("#usermajor2").css("display", "none");
  } else {
    $("#major").css("display", "none");
  }

  if (getMajor == 0) {
    getMajor = "null";
  }

  $.ajax({
    url: "../controller/getSubject.php",
    type: "GET",
    data: {
      year_level: year,
      srcode: srcode,
      semester: semester,
      major: getMajor,
    },
    dataType: "json",
    success: function (data) {
      if ($.fn.DataTable.isDataTable("#enroll-table")) {
        $("#enroll-table").DataTable().clear().destroy();
      }
      $("#enroll-table").DataTable({
        searching: false,
        paging: false,
        info: false,
        sort: false,
        columns: [
          { data: "subject_code" },
          { data: "subject" },
          { data: "unit", className: "text-center" },
          { data: "section" },
          {
            data: null,
            render: function (row) {
              return row.last_name + ", " + row.first_name;
            },
          },
          {
            data: null,
            render: function (row) {
              if (row.Day2 == "N/A") {
                return row.days + " - " + row.startTime + " - " + row.endTime;
              } else {
                return (
                  row.days +
                  " - " +
                  row.startTime +
                  " - " +
                  row.endTime +
                  " / " +
                  row.Day2 +
                  " - " +
                  row.startTime2 +
                  " - " +
                  row.endTime2
                );
              }
            },
          },
          {
            data: null,
            render: function (row) {
              return row.slot + "/" + row.max_slot;
            },
          },
          {
            data: null,
            render: function (row) {
              return (
                '<input type="hidden" id="enroll-id" value="' +
                row.id +
                '"><button id="' +
                row.id +
                '" class="enroll-now btn border-1 border-success text-success btn-transparent"><i class="fa-solid fa-plus"></i></button>'
              );
            },
          },
        ],
        data: data,
      });
    },
  });

  // START UPDATE
  function checkButtonDisabled() {
    const isButtonDisabled = localStorage.getItem("isUpdateYSDisabled");
    if (isButtonDisabled === "true") {
      $("#UpdateYearOrSem").css("display", "none");
    } else {
      $("#UpdateYS").prop("disabled", false);
    }
  }

  checkButtonDisabled();

  $.ajax({
    url: "../controller/getOpenAYC.php",
    type: "GET",
    dataType: "json",
    success: function (data) {
      var isOpen = data[0].isOpen;

      if (isOpen != 1) {
        console.log("School Year is Closed");

        $("#UpdateYS").on("click", function () {
          const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: "btn btn-success ms-2",
              cancelButton: "btn btn-danger me-2",
            },
            buttonsStyling: false,
          });
          swalWithBootstrapButtons
            .fire({
              title: "Please confirm",
              text: "Confirm to update your status",
              icon: "info",
              showCancelButton: true,
              confirmButtonText: "Confirm",
              cancelButtonText: "Cancel",
              reverseButtons: true,
            })
            .then((result) => {
              if (result.isConfirmed) {
                // UPDATE YEAR AND SEM
                if (semester == "FIRST") {
                  $.ajax({
                    url: "../controller/updateSem.php",
                    type: "GET",
                    data: { srcode: srcode, sem: GetSemester },
                    success: function (data) {
                      $("#UpdateYS").prop("disabled", true);
                      localStorage.setItem("isUpdateYSDisabled", "true");

                      Swal.fire({
                        title: "Status updated",
                        text: "You will be redirected to Login Page",
                        icon: "success",
                        confirmButtonText: "Confirm",
                        showConfirmButton: true,
                        didClose: () => {
                          window.location.href = "../controller/logout.php";
                        },
                      });
                    },
                  });
                } else if (semester == "SECOND") {
                  $.ajax({
                    url: "../controller/updateYear.php",
                    type: "GET",
                    data: { srcode: srcode, year: getYear, sem: GetSemester },
                    success: function (data) {
                      $("#UpdateYS").prop("disabled", true);
                      localStorage.setItem("isUpdateYSDisabled", "true");

                      Swal.fire({
                        title: "Status updated",
                        text: "You will be redirected to Login Page",
                        icon: "success",
                        confirmButtonText: "Confirm",
                        showConfirmButton: true,
                        didClose: () => {
                          window.location.href = "../controller/logout.php";
                        },
                      });
                    },
                  });
                }
                // END UPDATE YEAR AND SEM
              } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                  title: "Cancelled",
                  text: "Updating status has been cancelled",
                  icon: "error",
                });
              }
            });
        });
      } else {
        console.log("School Year is still Open");
        localStorage.setItem("isUpdateYSDisabled", "false");
        $("#UpdateYearOrSem").css("display", "none");
      }
    },
  });
  //END UPDATE

  //enrollment part to
  $("#enroll-table tbody").on("click", ".enroll-now", function () {
    var id = $(this).attr("id");

    $.ajax({
      url: "../controller/sumUnit.php",
      type: "GET",
      data: { srcode: srcode, year: year },
      dataType: "json",
      success: function (data) {
        localStorage.setItem("UserTotalUnit", JSON.stringify(data));
      },
    });

    $.ajax({
      url: "../controller/checkSlot.php",
      type: "GET",
      data: { subject_id: id, srcode: srcode },
      dataType: "json",
      success: function (data) {
        var slot = parseInt(data[0].slot);
        var total_student = parseInt(data[0].total_slot);
        var UserTotalUnit = JSON.parse(localStorage.getItem("UserTotalUnit"));
        var unit = UserTotalUnit[0].TotalUnits;

        console.log(slot);
        console.log(total_student);

        const maxU = {
          FIRST: 23,
          SECOND: 23,
          THIRD: 21,
          FOURTH: 21,
        };

        if (unit == maxU[year]) {
          Swal.fire({
            title: "Unit Full",
            text: "You have reached the maximum Unit",
            icon: "warning",
            showCancelButton: true,
            cancelButtonText: "Close",
            cancelButtonColor: "#d33",
            showConfirmButton: false,
          });
          event.preventDefault();
        } else if (total_student == slot) {
          Swal.fire({
            title: "Section Full",
            text: "This Section is full, Find another Section",
            icon: "warning",
            showCancelButton: true,
            cancelButtonText: "Close",
            cancelButtonColor: "#d33",
            showConfirmButton: false,
          });
        } else if (total_student < slot) {
          Swal.fire({
            title: "Are you sure?",
            text: "You want to enroll in this subject?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "confirm",
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                url: "../controller/enroll.php",
                type: "POST",
                data: { id: id, srcode: srcode },
                success: function (data) {
                  Swal.fire({
                    icon: "success",
                    title: "You are now enroll in this subject",
                    toast: true,
                    timer: 1000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    position: "top-right",
                    didClose: () => {
                      window.location.reload();
                    },
                  });
                },
              });
            }
          });
        }
      },
    });
  });

  $.ajax({
    url: "../controller/sumUnit.php",
    type: "GET",
    data: { srcode: srcode, year: year },
    dataType: "json",
    success: function (data) {
      localStorage.setItem("UserTotalUnit", JSON.stringify(data));
      var totalUnits = data[0].TotalUnits;
      if (totalUnits === null) {
        $("#unit").text("0");
      } else {
        $("#unit").text(totalUnits);
      }
    },
  });

  // GET SECTION DEPENDING ON WHAT IS SELECTED SUBJECT
  $("#sub_id").on("change", function () {
    var subject = $(this).val();

    if (subject) {
      $.ajax({
        url: "../controller/getSection.php",
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
        url: "../controller/getEtime.php",
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
        url: "../controller/getStime.php",
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
        url: "../controller/getInstructor.php",
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
        url: "../controller/getStime2.php",
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
        url: "../controller/getEtime.php",
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
  });
  // $('#day2').on('change', function(){
  //     var day = $(this).val();
  //     var section = $('#sec_id').val();

  //     if(day){
  //         $.ajax({
  //             url: '../controller/getStime.php',
  //             type: 'POST',
  //             data: {day: day, section: section},
  //             success: function(response) {
  //                 $('#Stime2').html(response);
  //             }
  //         });
  //     }else{
  //         $('#Stime2').html('<option value="selected" selected disabled>---Select start time---</option>');
  //     }
  // });
});
