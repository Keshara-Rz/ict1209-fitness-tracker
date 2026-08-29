<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

// Connect to the database
require_once 'includes/db.php';

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Logging a new workout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['log_activity'])) {
    $activity = trim($_POST['activity']);
    $duration = (int)$_POST['duration'];
    $calories = (int)$_POST['calories'];

    if (!empty($activity) && $duration > 0 && $calories > 0) {
        $stmt = $pdo->prepare("INSERT INTO workouts (user_id, activity, duration, calories_burned) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $activity, $duration, $calories]);
        
        // Refresh the page 
        header("Location: dashboard.php");
        exit();
    }
}

if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM workouts WHERE id = ? AND user_id = ?");
    $stmt->execute([$delete_id, $user_id]);
    
    header("Location: dashboard.php");
    exit();
}

$stmt = $pdo->prepare("SELECT id, activity, duration, calories_burned, created_at FROM workouts WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$workouts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate Summary Statistics
$total_sessions = count($workouts);
$total_active_time = 0;
$total_calories = 0;
$chart_data_raw = [];

foreach ($workouts as $w) {
    $total_active_time += $w['duration'];
    $total_calories += $w['calories_burned'];
    
    $act = $w['activity'];
    if (!isset($chart_data_raw[$act])) {
        $chart_data_raw[$act] = 0;
    }
    $chart_data_raw[$act] += $w['calories_burned'];
}

$chart_labels_json = json_encode(array_keys($chart_data_raw));
$chart_values_json = json_encode(array_values($chart_data_raw));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - FitPulse</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="dark-theme bg-deep-dark">

    <div class="ambient-bg-glow"></div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top py-4" style="z-index: 1050;">
        <div class="container">
            <div class="glass-nav-pill w-100 d-flex align-items-center justify-content-between px-3 px-lg-4 py-2 py-lg-1 rounded-4 rounded-lg-pill">
                
                <a class="navbar-brand d-flex align-items-center m-0" href="index.php">
                    <span class="text-white fw-light tracking-wide fs-6">Fit</span><span class="text-cyan fw-bold fs-6">Pulse</span>
                </a>

                <button class="navbar-toggler border-0 shadow-none text-white ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <i class="bi bi-list fs-3"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav align-items-center gap-1 gap-lg-2 mx-lg-auto mt-3 mt-lg-0 pb-3 pb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link custom-nav-link text-light-gray small " href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link custom-nav-link text-light-gray small active-link" href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link custom-nav-link text-light-gray small" href="about.php">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link custom-nav-link text-light-gray small" href="contact.php">Contact Us</a>
                        </li>
                    </ul>
                    
                    <div class="d-none d-lg-flex align-items-center gap-4 mt-3 mt-lg-0">
                        <span class="text-light-gray small">Welcome, <span class="text-white fw-bold"><?php echo htmlspecialchars($username); ?></span></span>
                        <a href="auth/logout.php" class="btn btn-outline-glow-white rounded-pill px-4 py-2 small fw-bold">Log Out</a>
                    </div>
                </div>
                
            </div>
        </div>
    </nav>

    <!-- Main Dashboard Content -->
    <main class="content-wrapper pt-5 mt-5 mb-5">
        <div class="container py-4">
            
            <!-- Dashboard Header -->
            <div class="d-flex justify-content-between align-items-center mb-5 mt-2">
                <div>
                    <!-- Dynamic Name -->
                    <h2 class="text-white futuristic-font text-glow mb-1">WELCOME BACK, <span class="text-cyan"><?php echo strtoupper(htmlspecialchars($username)); ?>!</span></h2>
                    <p class="text-light-gray mb-0">Track your daily progress, log physical activities, and analyze metrics.<br> <span id="currentDate" class="text-cyan"></span></p>
                </div>
            </div>

            <!-- ROW 1: Summary Stats -->
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="glass-card p-4 rounded-4 position-relative overflow-hidden h-100">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-cyan bg-opacity-10 p-3 rounded-3 text-cyan"><i class="bi bi-fire fs-4"></i></div>
                            <div>
                                <h6 class="text-light-gray small text-uppercase tracking-wider mb-1">Total Calories</h6>
                                <h3 class="text-white mb-0 futuristic-font text-glow"><?php echo $total_calories; ?> <span class="fs-6 text-cyan">kcal</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="glass-card p-4 rounded-4 position-relative overflow-hidden h-100">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-purple bg-opacity-10 p-3 rounded-3" style="color: #b026ff;"><i class="bi bi-stopwatch fs-4"></i></div>
                            <div>
                                <h6 class="text-light-gray small text-uppercase tracking-wider mb-1">Active Time</h6>
                                <h3 class="text-white mb-0 futuristic-font text-glow"><?php echo $total_active_time; ?> <span class="fs-6" style="color: #b026ff;">mins</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="glass-card p-4 rounded-4 position-relative overflow-hidden h-100">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-success bg-opacity-10 p-3 rounded-3 text-success"><i class="bi bi-activity fs-4"></i></div>
                            <div>
                                <h6 class="text-light-gray small text-uppercase tracking-wider mb-1">Sessions</h6>
                                <h3 class="text-white mb-0 futuristic-font text-glow"><?php echo $total_sessions; ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ROW 2: Form & Chart -->
            <div class="row g-4 mb-4 align-items-stretch">
                
                <!-- Left: Form -->
                <div class="col-lg-5">
                    <div class="glass-card p-4 p-md-5 rounded-4 position-relative overflow-hidden h-100 d-flex flex-column">
                        <div class="card-glow-accent top-left" style="position: absolute; z-index: 0; pointer-events: none; opacity: 0.2;"></div>
                        <div class="position-relative flex-grow-1" style="z-index: 1;">
                            <h4 class="text-white mb-4 futuristic-font border-bottom border-secondary pb-2">
                                <i class="bi bi-lightning-charge text-cyan me-2"></i>Log Exercise
                            </h4>
                            
                            <!-- Connected Form -->
                            <form method="POST" action="dashboard.php" class="needs-validation" novalidate>
                                <div class="mb-4">
                                    <label class="form-label text-light-gray small text-uppercase tracking-wider">Activity</label>
                                    <input type="text" name="activity" class="form-control glass-input text-white py-2" placeholder="e.g. VR Boxing" required>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label text-light-gray small text-uppercase tracking-wider">Duration (mins)</label>
                                    <input type="number" name="duration" class="form-control glass-input text-white py-2" placeholder="45" min="1" required>
                                </div>
                                <div class="mb-5">
                                    <label class="form-label text-light-gray small text-uppercase tracking-wider">Calories Burned</label>
                                    <input type="number" name="calories" class="form-control glass-input text-white py-2" placeholder="320" min="1" required>
                                </div>
                                
                                <button type="submit" name="log_activity" class="btn btn-outline-glow-white border-2 w-100 rounded-pill py-3 fw-bold text-uppercase tracking-wider mt-auto">
                                    Log Activity <i class="bi bi-plus-lg ms-2"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right: Chart Area -->
                <div class="col-lg-7">
                    <div class="glass-card p-4 p-md-5 rounded-4 position-relative overflow-hidden h-100">
                        <h4 class="text-white mb-4 futuristic-font border-bottom border-secondary pb-2">
                            <i class="bi bi-pie-chart text-cyan me-2"></i>Energy Expenditure
                        </h4>
                        
                        <div class="position-relative w-100 d-flex justify-content-center align-items-center" style="height: 300px; margin-top: 2rem;">
                            
                            <?php if ($total_sessions > 0): ?>
                                <canvas id="caloriesChart"></canvas>
                            <?php else: ?>
                                <div class="text-center position-absolute">
                                    <i class="bi bi-activity fs-1 text-cyan mb-3 d-block"></i>
                                    <h4 class="text-white futuristic-font text-glow">NO ACTIVITY YET</h4>
                                    <p class="text-light-gray small mb-0">Log your first workout to see your progress chart ignite.</p>
                                </div>
                            <?php endif; ?>
                            
                        </div>
                    </div>
                </div>
            </div>

            <!-- ROW 3: History Table -->
            <div class="row">
                <div class="col-12">
                    <div class="glass-card p-4 p-md-5 rounded-4 position-relative overflow-hidden">
                        <h4 class="text-white mb-4 futuristic-font border-bottom border-secondary pb-2">
                            <i class="bi bi-list-ul text-cyan me-2"></i>Recent Logs
                        </h4>
                        
                        <div class="table-responsive mt-3">
                            <table class="table table-borderless align-middle mb-0 text-white text-nowrap" style="--bs-table-bg: transparent;">
                                <tbody>
                                    <!-- Dynamic Table Rows -->
                                    <?php if (!empty($workouts)): ?>
                                        <?php foreach ($workouts as $workout): ?>
                                            <?php 
                                                $date = new DateTime($workout['created_at']);
                                                $dateStr = $date->format('M j, Y');
                                                $timeStr = $date->format('h:i A');
                                            ?>
                                            <tr>
                                                <td class="text-light-gray small"><?php echo $dateStr; ?><br><span class="text-cyan"><?php echo $timeStr; ?></span></td>
                                                <td class="text-white"><?php echo htmlspecialchars($workout['activity']); ?></td>
                                                <td class="text-white"><?php echo htmlspecialchars($workout['duration']); ?> mins</td>
                                                <td class="text-glow text-cyan"><?php echo htmlspecialchars($workout['calories_burned']); ?> kcal</td>
                                                <td class="text-end">
                                                    <a href="dashboard.php?delete_id=<?php echo $workout['id']; ?>" class="btn btn-sm btn-outline-danger rounded-circle" onclick="return confirm('Are you sure you want to delete this log?');"><i class="bi bi-trash"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-light-gray py-4">You have not logged any workouts yet.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </main>

    <!-- Footer -->
    <footer class="glass-footer py-4 mt-auto">
        <div class="container text-center">
            <p class="text-light-gray mb-0 small">&copy; 2026 FitPulse. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Chart and Date Logic -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const dateOptions = { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric' };
            const dateEl = document.getElementById('currentDate');
            if(dateEl) dateEl.innerHTML = new Date().toLocaleDateString('en-US', dateOptions).toUpperCase();

            // Initialize Chart with PHP Data
            const chartCanvas = document.getElementById('caloriesChart');
            
            if (chartCanvas) {
                const phpLabels = <?php echo $chart_labels_json; ?>;
                const phpData = <?php echo $chart_values_json; ?>;
                
                const chartData = {
                    labels: phpLabels,
                    datasets: [{
                        data: phpData,
                        backgroundColor: ['rgba(0, 210, 255, 0.8)', 'rgba(255, 204, 0, 0.8)', 'rgba(176, 38, 255, 0.8)', 'rgba(255, 51, 102, 0.8)', 'rgba(51, 255, 153, 0.8)'],
                        borderColor: 'rgba(3, 7, 18, 1)', 
                        borderWidth: 3,
                        hoverOffset: 8
                    }]
                };

                new Chart(chartCanvas, {
                    type: 'doughnut',
                    data: chartData,
                    options: { 
                        responsive: true, 
                        maintainAspectRatio: false, 
                        color: '#9ca3af', 
                        plugins: { legend: { position: 'right', labels: { font: { family: 'Rajdhani', size: 14 } } } } 
                    }
                });
            }
        });
    </script>
</body>
</html>