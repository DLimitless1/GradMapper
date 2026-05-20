<?php
// Handle waitlist form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $servername = "localhost";
    $username   = "u748207893_gradmapper";
    $password   = "Placate-Friday-Matchless5";
    $dbname     = "u748207893_gradmapperdb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        $message = "Database connection failed.";
    } else {
        $email = trim($_POST['email']);
        
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $stmt = $conn->prepare("INSERT IGNORE INTO waitlist (email) VALUES (?)");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $message = "✅ Thank you! You've been added to the waitlist.";
            $stmt->close();
        } else {
            $message = "❌ Please enter a valid email address.";
        }
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GradMapper | Navigate College Success</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Montserrat:wght@600;700&display=swap" rel="stylesheet">
  
  <style>
    body { font-family: 'Inter', sans-serif; }
    .logo-font { font-family: 'Montserrat', sans-serif; }
    .hero-bg { background: linear-gradient(135deg, #1E3A8A 0%, #0F172A 100%); }
  </style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100">

  <!-- Navbar -->
  <nav class="border-b border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-950/80 backdrop-blur-md fixed w-full z-50">
    <div class="max-w-6xl mx-auto px-6 py-5 flex justify-between items-center">
      <div class="flex items-center gap-3">
        <img src="assets/images/gradmapper_logo.png" alt="GradMapper Logo" class="h-10 w-auto">
        <span class="logo-font text-3xl font-bold tracking-tight text-[#1E3A8A] dark:text-white">GradMapper</span>
      </div>
      <button onclick="toggleDarkMode()" class="text-2xl px-4 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition">🌗</button>
    </div>
  </nav>

  <!-- Hero -->
  <section class="hero-bg min-h-screen flex items-center pt-20">
    <div class="max-w-5xl mx-auto px-6 text-center text-white">
      <div class="inline-flex items-center gap-2 bg-white/10 px-5 py-2 rounded-full text-sm mb-8 backdrop-blur">
        <span class="w-2.5 h-2.5 bg-[#10B981] rounded-full animate-pulse"></span>
        Coming Soon — Summer 2026
      </div>
      
      <h1 class="text-5xl md:text-7xl font-bold tracking-tighter leading-none mb-6 logo-font">
        Navigate College Success
      </h1>
      <p class="text-2xl md:text-3xl font-medium text-emerald-100 mb-4">
        Track Programs • Admissions • Costs • Career ROI
      </p>
      
      <p class="max-w-2xl mx-auto text-lg md:text-xl text-slate-200 mb-12">
        The modern planning platform that brings college clarity. Side-by-side comparisons, live trackers, and real cost calculators.
      </p>

      <a href="#surveys" class="inline-block bg-[#10B981] hover:bg-emerald-600 text-white font-semibold text-xl px-12 py-5 rounded-2xl transition transform hover:scale-105">
        Help Shape GradMapper → Take Our Surveys
      </a>
    </div>
  </section>

  <!-- Surveys -->
  <section id="surveys" class="py-24 bg-white dark:bg-slate-900">
    <div class="max-w-4xl mx-auto px-6">
      <div class="text-center mb-16">
        <h2 class="text-4xl font-bold tracking-tight text-[#1E3A8A] dark:text-white mb-4">Help Shape the Future of College Planning</h2>
        <p class="text-xl text-slate-600 dark:text-slate-300">Your input will make college planning dramatically better for everyone.</p>
      </div>

      <div class="grid md:grid-cols-2 gap-6">
        <a href="https://forms.gle/XtKFZMR8Bs1umz1x5?utm_source=website&utm_medium=splash&utm_campaign=launch" target="_blank" class="group bg-slate-50 dark:bg-slate-800 hover:bg-white dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 p-8 rounded-3xl transition-all hover:shadow-xl">
          <div class="text-[#10B981] text-sm font-semibold mb-2">FOR STUDENTS</div>
          <h3 class="text-2xl font-semibold mb-3">Students Survey</h3>
          <p class="text-slate-600 dark:text-slate-400 mb-6">High school & prospective college students</p>
          <span class="text-[#1E3A8A] dark:text-emerald-400 group-hover:gap-3 transition-all inline-flex items-center">Take Survey →</span>
        </a>

        <!-- Add the other 3 survey cards similarly (Parent, Leaders, Counselors) if needed. I can expand if you want. -->
      </div>
    </div>
  </section>

  <!-- Waitlist Form -->
  <section class="py-20 bg-[#1E3A8A] text-white">
    <div class="max-w-xl mx-auto px-6 text-center">
      <h2 class="text-3xl font-bold mb-4">Join the Waitlist</h2>
      <p class="text-emerald-100 mb-8">Be the first to get early access when we launch.</p>
      
      <?php if (isset($message)): ?>
        <p class="mb-6 text-lg <?= strpos($message, '✅') !== false ? 'text-emerald-300' : 'text-red-300' ?>">
          <?= htmlspecialchars($message) ?>
        </p>
      <?php endif; ?>

      <form method="POST" class="flex flex-col sm:flex-row gap-4">
        <input type="email" name="email" placeholder="your@email.com" required
               class="flex-1 px-6 py-4 rounded-2xl text-slate-900 focus:outline-none focus:ring-4 focus:ring-emerald-400">
        <button type="submit" 
                class="bg-[#10B981] hover:bg-emerald-600 font-semibold px-10 py-4 rounded-2xl transition">
          Join Waitlist
        </button>
      </form>
    </div>
  </section>

  <script>
    function toggleDarkMode() {
      document.documentElement.classList.toggle('dark');
    }
  </script>
</body>
</html>