<?php
// Database Config
$servername = "localhost";
$username   = "u748207893_gradmapper";
$password   = "Placate-Friday-Matchless5";
$dbname     = "u748207893_gradmapperdb";

$conn = new mysqli($servername, $username, $password, $dbname);

$success = false;
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = trim($_POST['email']);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $conn->prepare("INSERT INTO subscribers (email, source) VALUES (?, 'splash') ON DUPLICATE KEY UPDATE created_at=NOW()");
        $stmt->bind_param("s", $email);
        if ($stmt->execute()) $success = true;
        $stmt->close();
    } else {
        $message = "Please enter a valid email.";
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
        :root { --primary: #1E3A8A; --accent: #10B981; }
        body { font-family: 'Inter', sans-serif; margin:0; transition: all 0.4s; }
        .light { background: #F8FAFC; color: #0F172A; }
        .dark  { background: #0F172A; color: #F1F5F9; }
        .hero { min-height: 100vh; background: linear-gradient(135deg, #1E3A8A 0%, #0F172A 100%); color: white; display: flex; align-items: center; text-align: center; }
        .container { max-width: 1100px; margin: 0 auto; padding: 2rem; }
        .logo { font-size: 3rem; font-weight: 700; margin-bottom: 1rem; }
        h1 { font-size: 3rem; margin: 0 0 1rem; }
        .tagline { font-size: 1.6rem; opacity: 0.95; }
        /* Add more styles as needed */
    </style>
</head>
<body class="light">
<div class="hero">
    <div class="container">
        <div class="logo">GradMapper</div>
        <h1>Navigate College Success</h1>
        <p class="tagline">Track Programs • Admissions • Costs • Career ROI</p>
        
        <!-- Email Form Here (same as before) -->
        <?php if ($success): ?>
            <h3 style="color:#10B981;">✅ Thank you! You're on the waitlist.</h3>
        <?php else: ?>
            <form method="POST" style="max-width:420px;margin:2rem auto;">
                <input type="email" name="email" placeholder="your@email.com" required style="padding:16px;width:100%;margin-bottom:10px;border-radius:8px;border:none;">
                <button type="submit" style="background:#10B981;color:white;padding:16px;width:100%;border:none;border-radius:8px;font-size:1.1rem;cursor:pointer;">Join the Waitlist</button>
            </form>
        <?php endif; ?>
    </div>
</div>
</body>
</html>