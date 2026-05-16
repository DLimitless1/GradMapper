<?php
// ==================== DATABASE CONNECTION ====================
$servername = "localhost";
$username   = "u748207893_gradmapper";
$password   = "Placate-Friday-Matchless5";
$dbname     = "u748207893_gradmapperdb";

$conn = new mysqli($servername, $username, $password, $dbname);

$success = false;
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = trim($_POST['email']);
    $source = "splash";

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $conn->prepare("INSERT INTO subscribers (email, source, created_at) 
                                VALUES (?, ?, NOW()) 
                                ON DUPLICATE KEY UPDATE created_at = NOW()");
        $stmt->bind_param("ss", $email, $source);
        
        if ($stmt->execute()) {
            $success = true;
            $message = "✅ Thank you! You're on the waitlist. We'll notify you at launch.";
        } else {
            $message = "⚠️ Something went wrong. Please try again.";
        }
        $stmt->close();
    } else {
        $message = "⚠️ Please enter a valid email address.";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GradMapper | Navigate College Success</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; }
    .logo-font { font-family: 'Montserrat', sans-serif; }
    .hero-bg { background: linear-gradient(135deg, #1E3A8A 0%, #0F172A 100%); }
    .input-focus { transition: all 0.3s; }
    .input-focus:focus { box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.3); }
  </style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100">

  <!-- Navbar -->
  <nav class="border-b border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-950/80 backdrop-blur-md fixed w-full z-50">
    <div class="max-w-7xl mx-auto px-6 py-5 flex justify-between items-center">
      <div class="flex items-center gap-3">
        <span class="text-3xl">🎓</span>
        <span class="logo-font text-2xl font-bold tracking-tight text-[#1E3A8A] dark:text-white">GradMapper</span>
      </div>
      <div class="flex items-center gap-8 text-sm font-medium">
        <a href="#" class="hover:text-[#10B981] transition">Features</a>
        <a href="#" class="hover:text-[#10B981] transition">For Counselors</a>
        <a href="#" class="hover:text-[#10B981] transition">Pricing</a>
        <button onclick="toggleDarkMode()" class="text-xl">🌗</button>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero-bg min-h-screen flex items-center pt-20">
    <div class="max-w-5xl mx-auto px-6 text-center text-white">
      <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur px-4 py-2 rounded-full text-sm mb-6">
        <span class="w-2 h-2 bg-[#10B981] rounded-full animate-pulse"></span>
        Beta launching Summer 2026
      </div>
     
      <h1 class="text-6xl md:text-7xl font-bold tracking-tighter leading-none mb-6 logo-font">
        College Made Clear.<br>
        <span class="text-[#10B981]">One Dashboard.</span>
      </h1>
     
      <p class="text-xl md:text-2xl max-w-2xl mx-auto text-slate-200 mb-10">
        Track programs, admissions, real costs, and career ROI. Side-by-side comparisons. Live progress bars. Auto-updated data.
      </p>

      <!-- Email Capture Form -->
      <div class="max-w-md mx-auto mb-12">
        <?php if ($success): ?>
          <div class="bg-emerald-900/30 border border-emerald-500 text-emerald-100 p-6 rounded-3xl text-lg">
            <?= $message ?>
          </div>
        <?php else: ?>
          <form method="POST" class="space-y-4">
            <?php if ($message): ?>
              <p class="text-orange-300 text-sm"><?= $message ?></p>
            <?php endif; ?>
            
            <div class="flex flex-col sm:flex-row gap-3">
              <input 
                type="email" 
                name="email" 
                placeholder="your@email.com" 
                required
                class="input-focus flex-1 px-6 py-4 rounded-2xl bg-white/10 border border-white/30 text-white placeholder:text-slate-300 focus:outline-none text-lg">
              
              <button 
                type="submit"
                class="bg-[#10B981] hover:bg-emerald-600 font-semibold px-10 py-4 rounded-2xl text-lg transition transform hover:scale-105 whitespace-nowrap">
                Join Waitlist
              </button>
            </div>
          </form>
        <?php endif; ?>
      </div>

      <div class="flex flex-col sm:flex-row gap-4 justify-center mb-16">
        <a href="https://forms.gle/XtKFZMR8Bs1umz1x5" target="_blank"
           class="bg-white text-[#1E3A8A] hover:bg-slate-100 font-semibold px-8 py-4 rounded-2xl text-lg transition">
          Student Survey
        </a>
        <a href="#surveys" 
           class="border border-white/70 hover:bg-white/10 font-semibold px-8 py-4 rounded-2xl text-lg transition">
          All Surveys
        </a>
      </div>

      <div class="mt-8 flex justify-center gap-8 text-sm opacity-75">
        <div>✅ Real-time Scraped Data</div>
        <div>✅ Multi-Currency Support</div>
        <div>✅ Progress Trackers</div>
      </div>
    </div>
  </section>

  <!-- Trust Bar -->
  <div class="py-6 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800">
    <div class="max-w-5xl mx-auto px-6 text-center text-slate-500 dark:text-slate-400 text-sm">
      Trusted by future grads, parents, and counselors • Complements Common App • Built for high school & college success
    </div>
  </div>

  <script>
    function toggleDarkMode() {
      document.documentElement.classList.toggle('dark');
    }
  </script>
</body>
</html>