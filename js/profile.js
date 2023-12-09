console.log('Profile.js script is running');
$(document).ready(function () {

    var token = localStorage.getItem('token');
    console.log(token);
    $.ajax({
        headers: { "Authorization": "Bearer " + token },
        type: 'GET',
        url: 'profile.php',
        success: function (response) {
            try {
                var responseData = JSON.parse(response);
                if (responseData.status === "false") {
                    window.location.href = "login.html";
                }
                else {
                    $('#emailAd').text(responseData.email);
                    $('#name').text(responseData.fullName);
                    $('#fullName').text(responseData.fullName);
                    $('#phone').text(responseData.phone);
                    $('#age').text(responseData.age);
                    $('#dob').text(responseData.dob);
                    $('#address').text(responseData.address);
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

    $('#editButton').on('click', function (event) {

        event.preventDefault();
        window.location.href = "editProfile.html";


    });

    $('#logout').on('click', function (event) {
        event.preventDefault();
        console.log('Logout button clicked');
        localStorage.removeItem('token'); // Corrected line
        window.location.href = "login.html";
    });
});