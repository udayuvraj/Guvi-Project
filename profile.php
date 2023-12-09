<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once 'redis_conn.php';
require_once 'conn.php';

$mongodbConnection = new MongoDB\Client('mongodb://localhost:27017');
$myDatabase = $mongodbConnection->UserInfo;

$usersCollection = $myDatabase->users; 


$headers = apache_request_headers();
if (isset($headers['Authorization'])) {
    $token = str_replace('Bearer ', '', $headers['Authorization']);
    $userId = $redis->get($token);
    
    if ($userId !== null) {
        $query = "SELECT email, full_name, user_name FROM users WHERE id = $userId";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $user = mysqli_fetch_assoc($result);
            if ($user !== null) {
                $mongodata=array(
                    "userId"=>$userId,
                );
                $fetch = $usersCollection->findOne($mongodata);
                if($fetch === null){
                    $senddata= array(
                        "userId" => $userId,
                        "fullName" => $user['full_name'],
                        "phone" => "Phone Number(Not available)",
                        "age" => "Age(Not avaibale)",
                        "dob" => "Date of Birth(Not available)",
                        "address" => "Address(Not available)"
                    );
                    $insert = $usersCollection->insertOne($senddata);
                }
                $fetch = $usersCollection->findOne($mongodata);
                echo json_encode([
                    "status" => "true",
                    "userId" => $userId,
                    "email" => $user['email'],
                    "fullName" => $fetch['fullName'],
                    "phone" => $fetch['phone'],
                    "age" => $fetch['age'],
                    "dob" => $fetch['dob'],
                    "address" => $fetch['address']
                ]);
            } else {
                echo json_encode(["status" => "false", "message" => "User not found in the database"]);
            }

            mysqli_free_result($result);
        } else {
            echo json_encode(["status" => "false", "message" => "Error in query: " . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(["status" => "false", "message" => "User not found"]);
    }
    
} else {
    echo json_encode(["status" => "false", "message" => "Authorization header is missing"]);
}
?>
