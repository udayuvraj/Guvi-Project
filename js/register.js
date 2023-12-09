$(document).ready(function () {
    $('#signup').on('click', function (event) {

        event.preventDefault();

        var email = $('#email').val();
        var fullName = $('#fullName').val();
        var userName = $('#userName').val();
        var password = $('#password').val();

        var formData = {
            email: email,
            fullName: fullName,
            userName: userName,
            password: password
        };
        if ($('#email').val() == "" || $('#fullName').val() == "" || $('#userName').val() == "" ||
            $('#password').val() == "") {
            alert("Please complete the Required fields");
        } else {
            $.ajax({
                type: "POST",
                url: "register.php",
                data: formData,
                success: function (response) {
                    try {
                        // Parse the JSON response
                        var responseData = JSON.parse(response);

                        // Check the status property
                        if (responseData.status === "Data Sent!") {
                            alert("Signup Successful!");
                            window.location.href = "login.html";
                            // $('body').load("login.html").hide().fadeIn(1000);
                        }
                    } catch (error) {
                        console.error("Error parsing JSON response:", error);
                    }
                },

                error: function (error) {
                    console.error("Error sending data:", error);
                }
            });

        }

    })
})