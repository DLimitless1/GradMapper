<?php
// waitlist.php - Saves emails to your MySQL database

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Database credentials (from your Hostinger info)
$servername = "localhost";
$username   = "u748207893_gradmapper";
$password   = "Placate-Friday-Matchless5";
$dbname     = "u748207893_gradmapperdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Connection failed. Please try again later."]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $conn->prepare("INSERT IGNORE INTO waitlist (email) VALUES (?)");
        $stmt->bind_param("s", $email);
        
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "✅ Thank you! You've been added to the waitlist."]);
        } else {
            echo json_encode(["success" => false, "message" => "This email is already registered."]);
        }
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "❌ Please enter a valid email address."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}

$conn->close();
?>