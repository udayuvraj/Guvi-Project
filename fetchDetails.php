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
        $mongodata=array(
            "userId"=>$userId,
        );
        
        $fetch = $usersCollection->findOne($mongodata);
        echo json_encode([
            "status" => "true",
            "userId" => $userId,
            "fullName" => $fetch['fullName'],
            "phone" => $fetch['phone'],
            "age" => $fetch['age'],
            "dob" => $fetch['dob'],
            "address" => $fetch['address']
        ]);
    } else {
        echo json_encode(["status" => "false", "message" => "User not found in the database"]);
    }
}
else {
    echo json_encode(["status" => "false", "message" => "Authorization header is missing"]);
}
?>   