<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$servername = "https://grad-mapper.com/"; // Usually just the hostname
$username = "u748207893_gradmapper";
$password = "Placate-Friday-Matchless5";
$dbname = "u748207893_gradmapperdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed"]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $conn->prepare("INSERT INTO waitlist (email, created_at) VALUES (?, NOW())");
        $stmt->bind_param("s", $email);
        
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Thank you!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Already registered"]);
        }
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Invalid email"]);
    }
}

$conn->close();
?>