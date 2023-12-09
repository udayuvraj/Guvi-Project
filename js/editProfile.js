$(document).ready(function () {
    var tokenn = localStorage.getItem('token');

    $.ajax({

        headers: { "Authorization": "Bearer " + tokenn },
        type: 'GET',
        url: 'fetchDetails.php',
        success: function (response) {
            try {
                var responseData = JSON.parse(response);
                if (responseData.status === "false") {
                    window.location.href = "login.html";
                }
                else {
                    $('#fullName').val(responseData.fullName);
                    $('#phone').val(responseData.phone);
                    $('#age').val(responseData.age);
                    $('#dob').val(responseData.dob);
                    $('#address').val(responseData.address);
                    console.log(responseData);
                }
            } catch (error) {
                console.error("Error parsing JSON response:", error);
            }
        },
        error: function (error) {
            console.error("Error sending data:", error);
        }
    });


    $('#editProfile').on('click', function (event) {

        event.preventDefault();
        var token = localStorage.getItem('token');
        var fullName = $('#fullName').val();
        var phone = $('#phone').val();
        var age = $('#age').val();
        var dob = $('#dob').val();
        var address = $('#address').val();
        var formData = {
            fullName: fullName,
            phone: phone,
            age: age,
            dob: dob,
            address: address
        };
        alert("Details updated successfully!");
        $.ajax({
            headers: { "Authorization": "Bearer " + token },
            type: "POST",
            url: "editProfile.php",
            data: formData,
            success: function (response) {
                try {
                    var responseData = JSON.parse(response);
                    console.log(responseData);
                    window.location.href = "profile.html";
                } catch (error) {
                    console.error("Error parsing JSON response:", error);
                }
            },

            error: function (error) {
                console.error("Error sending data:", error);
            }
        });


    });





});