$(document).ready(function() {

    $('#studentLogin').on('click', function(){

        var studentSRCode = $('#studentSRCode').val();

        $.ajax({
            url: '../../controller/localStorage.php',
            type: 'GET',
            data: {studentSRCode: studentSRCode},
            dataType: 'json',
            success: function(data) {
                localStorage.setItem('Student_Data', JSON.stringify(data));
                console.log(data);
            }
        });

    });   

});