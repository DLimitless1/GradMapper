<?php
// Database connection
$servername = "localhost"; // or mysql.hostinger.com if needed
$username = "u748207893_gradmapper";
$password = "Placate-Friday-Matchless5";
$dbname = "u748207893_gradmapperdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    // Silent fail for production - log if needed
    $db_error = true;
} else {
    $db_error = false;
}

$success = false;
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = trim($_POST['email']);
    $source = "splash";
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $conn->prepare("INSERT INTO subscribers (email, source, created_at) VALUES (?, ?, NOW()) ON DUPLICATE KEY UPDATE created_at=NOW()");
        $stmt->bind_param("ss", $email, $source);
        
        if ($stmt->execute()) {
            $success = true;
        }
        $stmt->close();
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
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            transition: background 0.3s, color 0.3s;
        }
        .light { background: #F8FAFC; color: #0F172A; }
        .dark { background: #0F172A; color: #F1F5F9; }

        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #1E3A8A 0%, #0F172A 100%);
            color: white;
            text-align: center;
            position: relative;
        }
        .container { max-width: 1100px; margin: 0 auto; padding: 2rem; }
        
        h1 { font-size: 3.5rem; margin: 0 0 1rem; }
        .tagline { font-size: 1.5rem; opacity: 0.95; margin-bottom: 2rem; }
        
        .form-container {
            max-width: 420px;
            margin: 2rem auto;
            background: rgba(255,255,255,0.1);
            padding: 2rem;
            border-radius: 16px;
            backdrop-filter: blur(10px);
        }
        
        input[type="email"] {
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }
        
        button {
            background: #10B981;
            color: white;
            border: none;
            padding: 16px 32px;
            font-size: 1.2rem;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-weight: 600;
        }
        
        .survey-buttons {
            margin-top: 3rem;
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: center;
        }
        
        .btn-survey {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 12px 24px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
        }
        
        .toggle {
            position: absolute;
            top: 30px;
            right: 30px;
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            padding: 10px 16px;
            border-radius: 50px;
            cursor: pointer;
        }
    </style>
</head>
<body class="light">

<div class="hero">
    <button class="toggle" onclick="toggleTheme()">🌙 / ☀️</button>
    
    <div class="container">
        <img src="https://via.placeholder.com/180x60/10B981/ffffff?text=GradMapper" alt="GradMapper" style="margin-bottom: 2rem;">
        
        <h1>Navigate College Success</h1>
        <p class="tagline">Track Programs • Admissions • Costs • Career ROI</p>
        
        <div class="form-container">
            <?php if ($success): ?>
                <h3 style="color:#10B981;">✅ Thank you! You're on the list.</h3>
                <p>We'll notify you when GradMapper launches.</p>
            <?php else: ?>
                <form method="POST">
                    <input type="email" name="email" placeholder="Enter your email" required>
                    <button type="submit">Join the Waitlist →</button>
                </form>
            <?php endif; ?>
        </div>

        <div class="survey-buttons">
            <a href="https://forms.gle/XtKFZMR8Bs1umz1x5" target="_blank" class="btn-survey">Student Survey</a>
            <a href="https://forms.gle/BVFZdZbK4r8euQBf8" target="_blank" class="btn-survey">Parent Survey</a>
            <a href="https://forms.gle/tcqwBPhx8356sRaAA" target="_blank" class="btn-survey">High School Leaders</a>
            <a href="https://forms.gle/XJLie4AooU2Fktnk7" target="_blank" class="btn-survey">Counselors</a>
            <a href="https://forms.gle/tWPhhZ5JgsqTxG6YA" target="_blank" class="btn-survey">Universities</a>
        </div>
        
        <p style="margin-top: 3rem; opacity: 0.8;">College Made Clear: Programs, Admissions, Costs, Careers.</p>
    </div>
</div>

<script>
function toggleTheme() {
    document.body.classList.toggle('dark');
    document.body.classList.toggle('light');
}
</script>

</body>
</html>