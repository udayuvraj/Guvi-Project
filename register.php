<?php
    require_once 'conn.php';
    $email = $_POST['email'];
    $fullName = $_POST['fullName'];
    $userName = $_POST['userName'];
    $password = $_POST['password'];

 
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  
    $stmt = $conn->prepare("INSERT INTO `users` VALUES('', ?, ?, ?, ?)");
    
  
    $stmt->bind_param("ssss", $email, $fullName, $userName, $hashedPassword);

 
    $stmt->execute();
    $stmt->close();

    echo json_encode(["status" => "Data Sent!"]);
?>
