<?php
session_start();
require_once 'includes/db.php';

// Count total users
$stmtUsers = $pdo->query("SELECT COUNT(*) FROM users");
$realUsers = $stmtUsers->fetchColumn();

// Count total workouts
$stmtWorkouts = $pdo->query("SELECT COUNT(*) FROM workouts");
$realWorkouts = $stmtWorkouts->fetchColumn();

// Count unique exercises
$stmtExercises = $pdo->query("SELECT COUNT(DISTINCT activity) FROM workouts");
$realExercises = $stmtExercises->fetchColumn();

$displayUsers = number_format(500 + $realUsers);
$displayWorkouts = number_format(2000 + $realWorkouts);
$displayExercises = number_format(100 + $realExercises);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitPulse - Track Your Fitness</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="dark-theme bg-deep-dark">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top py-4" style="z-index: 1050;">
        <div class="container">
            
            <!-- The floating glass pill -->
            <div class="glass-nav-pill w-100 d-flex align-items-center justify-content-between px-3 px-lg-4 py-2 py-lg-1 rounded-4 rounded-lg-pill">
                
                <!-- 1. Logo (Left) -->
                <a class="navbar-brand d-flex align-items-center m-0" href="index.php">
                    <span class="text-white fw-light tracking-wide fs-6">Fit</span><span class="text-cyan fw-bold fs-6">Pulse</span>
                </a>

                <!-- 2. Mobile Hamburger Toggle -->
                <button class="navbar-toggler border-0 shadow-none text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <i class="bi bi-list fs-3"></i>
                </button>

                <!-- 3. Collapsible Menu -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    
                    <!-- Center Links -->
                    <ul class="navbar-nav align-items-center gap-1 gap-lg-2 mx-lg-auto mt-3 mt-lg-0 pb-3 pb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link custom-nav-link text-light-gray small active-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link custom-nav-link text-light-gray small" href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link custom-nav-link text-light-gray small" href="about.php">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link custom-nav-link text-light-gray small" href="contact.php">Contact Us</a>
                    </ul>
                    
                    <!-- Desktop Auth Buttons -->
                    <div class="d-none d-lg-flex align-items-center gap-4 mt-3 mt-lg-0">
                        <?php if(isset($_SESSION['user_id'])): ?>
                            <span class="text-light-gray small">Welcome, <span class="text-white fw-bold"><?php echo htmlspecialchars($_SESSION['username']); ?></span></span>
                            <a href="auth/logout.php" class="btn btn-outline-glow-white rounded-pill px-4 py-2 small fw-bold">Log Out</a>
                        <?php else: ?>
                            <a href="auth/login.php" class="text-light-gray text-decoration-none small hover-white">Login</a>
                            <a href="auth/register.php" class="btn btn-glow-cyan rounded-pill px-4 py-2 small fw-bold d-flex align-items-center gap-2 text-dark">
                                Sign Up <i class="bi bi-arrow-up-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>

                </div>
                
            </div>
        </div>
    </nav>

    <!-- Main Content Wrapper -->
    <main class="content-wrapper">
        
        <!-- Hero Section -->
        <section class="hero-section position-relative d-flex align-items-center min-vh-100 pt-5 overflow-hidden">
            
            <!-- Hero Background Slideshow -->
            <div id="heroSlideshow" class="carousel slide carousel-fade position-absolute top-0 start-0 w-100 h-100" data-bs-ride="carousel" data-bs-pause="false" data-bs-interval="7000" style="z-index: 0;">
                
                <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-75" style="z-index: 1;"></div>

                <!-- Images -->
                <div class="carousel-inner w-100 h-100">
                    
                    <!-- Image 1 (Active) -->
                    <div class="carousel-item active w-100 h-100">
                        <img src="images/images 1.png" class="d-block w-100 h-100" style="object-fit: cover;" alt="Virtual travel running environment">
                    </div>
                    
                    <!-- Image 2 -->
                    <div class="carousel-item w-100 h-100">
                        <img src="images/images 2.png" class="d-block w-100 h-100" style="object-fit: cover;" alt="Holographic architectural construction space">
                    </div>
                    
                    <!-- Image 3 -->
                    <div class="carousel-item w-100 h-100">
                        <img src="images/images 3.png" class="d-block w-100 h-100" style="object-fit: cover;" alt="Drone video perspective of VR fitness arena">
                    </div>
                    
                    <!-- Image 4 -->
                    <div class="carousel-item w-100 h-100">
                        <img src="images/images 4.png" class="d-block w-100 h-100" style="object-fit: cover;" alt="Upscaled digital workout gear">
                    </div>

                    <!-- Image 5 -->
                    <div class="carousel-item w-100 h-100">
                        <img src="images/images 5.png" class="d-block w-100 h-100" style="object-fit: cover;" alt="Futuristic gym interior">
                    </div>

                    <!-- Image 6 -->
                    <div class="carousel-item w-100 h-100">
                        <img src="images/images 6.png" class="d-block w-100 h-100" style="object-fit: cover;" alt="Cyberpunk neon lighting">
                    </div>
                    
                </div>
            </div>
                <div class="hero-overlay"></div>
            </div>

            <!-- Hero Content -->
            <div class="container position-relative hero-content">
                <div class="row">
                    <div class="col-lg-7">
                        <br><br><p class="text-cyan text-uppercase tracking-wider mb-2 small fw-bold">Your Digital Fitness Companion</p>
                        <h1 class="display-2 fw-bold text-white lh-sm mb-4 futuristic-font">
                            TRACK YOUR <br>
                            <span class="text-cyan text-glow">FITNESS</span><br>
                            REACH YOUR <span class="text-outline">GOALS</span>
                        </h1>
                        <p class="lead text-light-gray mb-5 pe-lg-5">
                            Managing your fitness journey shouldn't be complicated. FitPulse removes the paperwork and guesswork from your daily routine by providing an interactive platform to log your exercises cleanly.
                        </p>
                        <!-- CTA -->
                        <a href="auth/register.php" id="getStartedBtn" class="btn btn-outline-glow-white border-2 rounded-pill px-5 py-3 fw-bold">
                            Get Started <i class="bi bi-arrow-up-right ms-2"></i>
                        </a>
                    </div>
                </div>

                <div class="row mt-5 pt-5">
                    <div class="col-12">
                        <div class="glass-panel rounded-4 p-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-4">
                            
                            <div class="stat-item d-flex align-items-center gap-3">
                                <div class="icon-box text-cyan fs-3"><i class="bi bi-people"></i></div>
                                <div>
                                    <h4 class="text-white mb-0 fw-bold"><?php echo $displayUsers; ?><span class="text-white fs-4">+</h4>
                                    <p class="text-light-gray small mb-0">Users Logged</p>
                                </div>
                            </div>

                            <div class="vr bg-cyan d-none d-md-block opacity-25"></div>

                            <div class="stat-item d-flex align-items-center gap-3">
                                <div class="icon-box text-cyan fs-3"><i class="bi bi-activity"></i></div>
                                <div>
                                    <h4 class="text-white mb-0 fw-bold"><?php echo $displayWorkouts; ?><span class="text-white fs-4">+</span></h4>
                                    <p class="text-light-gray small mb-0">Workouts Tracked</p>
                                </div>
                            </div>

                            <div class="vr bg-cyan d-none d-md-block opacity-25"></div>

                            <div class="stat-item d-flex align-items-center gap-3">
                                <div class="icon-box text-cyan fs-3"><i class="bi bi-grid"></i></div>
                                <div>
                                    <h4 class="text-white mb-0 fw-bold"><?php echo $displayExercises; ?><span class="text-white fs-4">+</h4>
                                    <p class="text-light-gray small mb-0">Exercise Types</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Introduction Section -->
        <section class="intro-section min-vh-100 d-flex align-items-center position-relative z-1">
            <div class="container pt-5">
                <div class="row align-items-center g-5">
                    
                    <!-- Left Side: Heading & Quick Info -->
                    <div class="col-lg-5 pe-lg-5">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="bg-cyan bg-opacity-10 p-2 rounded-3 text-cyan">
                                <i class="bi bi-info-circle fs-4"></i>
                            </div>
                            <span class="text-cyan text-uppercase tracking-wider small fw-bold">About The Platform</span>
                        </div>
                        
                        <h2 class="text-white futuristic-font text-glow mb-4 display-6">
                            WHAT IS <br><span class="text-cyan">FITPULSE?</span>
                        </h2>
                        
                        
                        <p class="text-light-gray mb-5 fs-6" style="line-height: 1.7;">
                            Step away from manual logs and cluttered apps. FitPulse is engineered to provide a frictionless, immersive environment where your fitness data becomes your greatest asset.
                        </p>
                        
                        <a href="about.php" class="btn btn-outline-cyan rounded-pill px-4 py-2 text-uppercase tracking-wider small fw-bold">
                            Discover Our Story <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                    
                    <div class="col-lg-7">
                        <div class="glass-panel p-4 p-md-5 rounded-4 position-relative overflow-hidden h-auto">
                            <!-- Background Glow Accent -->
                            <div class="card-glow-accent top-left" style="position: absolute; width: 250px; height: 250px; background: radial-gradient(circle, rgba(0,210,255,0.1) 0%, transparent 70%); top: -100px; left: -100px; z-index: 0; pointer-events: none; opacity: 0.5;"></div>
                            
                            <div class="position-relative" style="z-index: 1;">
                                <p class="text-white lead mb-4" style="line-height: 1.8;">
                                    FitPulse is your ultimate digital fitness companion, designed for modern athletes and casual gym-goers alike to bridge the gap between raw data and actionable insights.
                                </p>
                                <p class="text-light-gray mb-5 fs-6" style="line-height: 1.7;">
                                    Whether you are logging intense virtual reality workouts, tracking daily calories, or monitoring your long-term health metrics, FitPulse provides a seamless, distraction-free environment to help you focus entirely on crushing your goals.
                                </p>
                                
                                <div class="row g-4 pt-4 border-top border-secondary border-opacity-25">
                                    
                                    <div class="col-sm-6">
                                        <div class="d-flex align-items-start gap-3">
                                            <i class="bi bi-cpu text-cyan fs-3 text-glow"></i>
                                            <div>
                                                <h6 class="text-white mb-1 futuristic-font tracking-wider fs-6">SMART TRACKING</h6>
                                                <p class="text-light-gray small mb-0">Automated calorie calculations based on your logs.</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <div class="d-flex align-items-start gap-3">
                                            <i class="bi bi-fingerprint text-cyan fs-3 text-glow"></i>
                                            <div>
                                                <h6 class="text-white mb-1 futuristic-font tracking-wider fs-6">SECURE DATA</h6>
                                                <p class="text-light-gray small mb-0">End-to-end encrypted user profiles and history.</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <div class="d-flex align-items-start gap-3">
                                            <i class="bi bi-headset text-cyan fs-3 text-glow"></i>
                                            <div>
                                                <h6 class="text-white mb-1 futuristic-font tracking-wider fs-6">VIRTUAL SYNC</h6>
                                                <p class="text-light-gray small mb-0">Easily log your next-gen holographic routines.</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <div class="d-flex align-items-start gap-3">
                                            <i class="bi bi-lightning-charge text-cyan fs-3 text-glow"></i>
                                            <div>
                                                <h6 class="text-white mb-1 futuristic-font tracking-wider fs-6">ZERO LATENCY</h6>
                                                <p class="text-light-gray small mb-0">Lightning-fast client-side metric processing.</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>

        <!-- Core Features Section -->
        <section class="features-section min-vh-100 d-flex align-items-center position-relative z-1">
            <div class="container pt-5">
                <div class="text-center mb-5">
                    <h2 class="text-white futuristic-font text-glow">CORE <span class="text-cyan">FEATURES</span></h2>
                </div>
                
                <div class="row g-4 justify-content-center">
                    <!-- Feature 1 -->
                    <div class="col-md-4">
                        <div class="glass-card h-auto p-4 rounded-4 position-relative overflow-hidden">
                            <div class="card-glow-accent top-left" style="position: absolute; z-index: 0; opacity: 0.5; "></div>
                            <div class="position-relative" style="z-index: 1;">
                                <i class="bi bi-shield-lock text-cyan fs-1 mb-3 d-block"></i>
                                <h4 class="text-white mb-3">Secure Logins</h4>
                                <p class="text-light-gray text-sm mb-0">Create your personalized profile securely. Your data is protected using server-side hashing algorithms so your fitness history stays completely private.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="col-md-4">
                        <div class="glass-card h-auto p-4 rounded-4 position-relative overflow-hidden">
                            <div class="card-glow-accent top-left" style="position: absolute; z-index: 0; opacity: 0.5; "></div>
                            <div class="position-relative" style="z-index: 1;">
                                <i class="bi bi-clock-history text-cyan fs-1 mb-3 d-block"></i>
                                <h4 class="text-white mb-3">Activity History</h4>
                                <p class="text-light-gray text-sm mb-0">Look back at your consistency. View every workout you've completed in a structured history grid that loads your database logs instantly.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="col-md-4">
                        <div class="glass-card h-auto p-4 rounded-4 position-relative overflow-hidden">
                            <div class="card-glow-accent top-left" style="position: absolute; z-index: 0; opacity: 0.5; "></div>
                            <div class="position-relative" style="z-index: 1;">
                                <i class="bi bi-graph-up-arrow text-cyan fs-1 mb-3 d-block"></i>
                                <h4 class="text-white mb-3">Real-time Metrics</h4>
                                <p class="text-light-gray text-sm mb-0">Calculate your progress on the fly. Built-in interactive calculators compute your estimated calorie burns and metrics seamlessly using client-side logic.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="glass-footer py-4 mt-auto border-top border-secondary border-opacity-25">
        <div class="container text-center">
            <p class="text-light-gray mb-0 small">&copy; 2026 FitPulse. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="js/script.js"></script>
</body>
</html>
