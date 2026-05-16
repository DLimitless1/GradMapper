<?php
// ==================== DATABASE CONFIG ====================
$servername = "localhost";
$username   = "u748207893_gradmapper";
$password   = "Placate-Friday-Matchless5";
$dbname     = "u748207893_gradmapperdb";

$conn = new mysqli($servername, $username, $password, $dbname);
$success = false;
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = trim($_POST['email']);
    $source = "splash_page";

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $conn->prepare("INSERT INTO subscribers (email, source, created_at) 
                                VALUES (?, ?, NOW()) 
                                ON DUPLICATE KEY UPDATE created_at=NOW()");
        $stmt->bind_param("ss", $email, $source);
        
        if ($stmt->execute()) {
            $success = true;
            $message = "✅ You're on the list! We'll notify you at launch.";
        } else {
            $message = "Something went wrong. Please try again.";
        }
        $stmt->close();
    } else {
        $message = "Please enter a valid email address.";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GradMapper - Navigate College Success</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1E3A8A;
            --accent: #10B981;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', system-ui, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            transition: all 0.4s ease;
        }
        .light { background: #F8FAFC; color: #0F172A; }
        .dark  { background: #0F172A; color: #F1F5F9; }

        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #1E3A8A 0%, #0F172A 100%);
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }
        .logo {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        h1 {
            font-size: 3.2rem;
            line-height: 1.1;
            margin-bottom: 1.5rem;
        }