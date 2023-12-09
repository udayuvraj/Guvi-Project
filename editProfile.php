<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once 'redis_conn.php';

$mongodbConnection = new MongoDB\Client('mongodb://localhost:27017');
$myDatabase = $mongodbConnection->UserInfo;

$usersCollection = $myDatabase->users; 
$headers = apache_request_headers();

if (isset($headers['Authorization'])) {
    $token = str_replace('Bearer ', '', $headers['Authorization']);
    $userId = $redis->get($token);
    
    if ($userId !== null) {
        $fullName = $_POST['fullName'];
        $phone = $_POST['phone'];
        $age = $_POST['age'];
        $dob = $_POST['dob'];
        $address = $_POST['address'];

        $updatedData = array(
            "userId" => $userId,
            "fullName" => $fullName,
            "phone" => $phone,
            "age" => $age,
            "dob" => $dob,
            "address" => $address
        );

        $filter = ["userId" => $userId];

        $update = [
            '$set' => $updatedData,
        ];

        $result = $usersCollection->updateOne($filter, $update);

        if ($result->getModifiedCount() > 0) {
            echo json_encode(["status" => "true", "message" => "Data edited"]);
        } else {
            echo json_encode(["status" => "false", "message" => "No matching document found for update"]);
        }
    } else {
        echo json_encode(["status" => "false", "message" => "User not found"]);
    }
    
} else {
    echo json_encode(["status" => "false", "message" => "Authorization header is missing"]);
}

?>
