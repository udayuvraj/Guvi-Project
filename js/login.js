$(document).ready(function () {
    $('#login').on('click', function (event) {

        event.preventDefault();

        var email = $('#email').val();
        var password = $('#password').val();
        var formData = {
            email: email,
            password: password
        };
        if ($('#email').val() == "" || $('#password').val() == "") {
            alert("Please complete the Required fields");
        } else {
            $.ajax({
                type: "POST",
                url: "login.php",
                data: formData,
                success: function (response) {
                    try {
                        var responseData = JSON.parse(response);

                        if (responseData.status === "Login Successful") {
                            console.log("Updating HTML elements...");
                            var token = responseData.token;
                            console.log(token);
                            console.log("hi there")
                            localStorage.setItem('token', token);
                            alert("Login Successful!");

                            window.location.href = "profile.html";

                        }
                        else if (responseData.status === "Incorrect Password") {
                            alert("Password entered is Incorrect");
                        }
                        else if (responseData.status === "User not found") {
                            alert("User not found!");
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

    });
});