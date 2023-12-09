<?php
require_once 'conn.php';
require_once 'redis_conn.php';

$email = $_POST['email'];
$password = $_POST['password'];

// Hash the password
$password = mysqli_real_escape_string($conn, $password);

$query = "SELECT id, password FROM users WHERE email = ?";
$stmt = $conn->prepare($query);

if ($stmt) {
    // Bind parameters
    $stmt->bind_param("s", $email);

    // Execute the statement
    $stmt->execute();

    // Bind the result variables
    $stmt->bind_result($userId, $hashedPassword);

    // Fetch the result
    if ($stmt->fetch()) {
        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            $sessionToken = bin2hex(random_bytes(32));

            // Set session token in Redis
            $redis->set($sessionToken, $userId);
            
            echo json_encode(["status" => "Login Successful", "token" => $sessionToken]);
        } else {
            echo json_encode(["status" => "Incorrect Password"]);
        }
    } else {
        echo json_encode(["status" => "User not found"]);
    }

    // Close the statement
    $stmt->close();
} else {
    echo json_encode(["status" => "Error in query: " . $conn->error]);
}

// Close the database connection
$conn->close();
?>
