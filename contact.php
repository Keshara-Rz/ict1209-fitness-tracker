<?php
session_start();

// Connect to the database
require_once 'includes/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_message'])) {
    $firstName = trim($_POST['name'] ?? '');
    $surname = trim($_POST['surname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    $fullName = $firstName . ' ' . $surname;

    // Validation (Basic)
    if (empty($firstName) || empty($surname) || empty($email) || empty($message)) {
        $error = 'Please fill in all fields before submitting.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        $stmt = $pdo->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
        
        if ($stmt->execute([$fullName, $email, $message])) {
            $success = 'Transmission successful! Your message has been logged.';
        } else {
            $error = 'Failed to transmit message. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - FitPulse</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Link to our future CSS file -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="dark-theme bg-deep-dark">

    <!-- Ambient Glow Background -->
    <div class="ambient-bg-glow"></div>

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
                            <a class="nav-link custom-nav-link text-light-gray small " href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link custom-nav-link text-light-gray small" href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link custom-nav-link text-light-gray small" href="about.php">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link custom-nav-link text-light-gray small active-link" href="contact.php">Contact Us</a>
                        </li>
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
    <main class="content-wrapper pt-5 mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-xl-10">
                    
                    <div class="glass-card my-5 p-5 rounded-4 position-relative overflow-hidden h-auto">
                        
                        <!-- Glow effect -->
                        <div class="card-glow-accent" style="position: absolute; width: 350px; height: 350px; background: radial-gradient(circle, rgba(0,210,255,0.15) 0%, transparent 70%); top: -150px; right: -150px; z-index: 0; pointer-events: none; opacity: 0.4;"></div>
                        
                        <!-- The content row -->
                        <div class="row g-5 position-relative" style="z-index: 1;">
                            
                            <!-- Left Side: Text Content -->
                            <div class="col-md-5 d-flex flex-column border-end border-secondary border-opacity-25 pe-md-5">
                                
                                <div class="icon-box text-cyan mb-3 mt-2">
                                    <i class="bi bi-chat-right-dots" style="font-size: 3.5rem; filter: drop-shadow(0 0 10px #00d2ff);"></i>
                                </div>
                                
                                <h2 class="text-white futuristic-font text-glow mb-4 display-6">
                                    GET IN TOUCH WITH <br><span class="text-cyan">FITPULSE</span>
                                </h2>
                                
                                <p class="text-light-gray mb-5 lead fs-6">
                                    Have questions, feedback, or need technical support with your fitness tracker? Drop us a message below, and our team will get back to you within 24 hours.
                                </p>
                                
                                <div class="d-flex flex-column gap-4 mb-0">
                                    <div class="d-flex align-items-center gap-3 text-light-gray">
                                        <div class="bg-cyan bg-opacity-10 p-3 rounded-3 text-cyan"><i class="bi bi-envelope fs-5"></i></div>
                                        <span class="fs-6">support@fitpulse.com</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-3 text-light-gray">
                                        <div class="bg-cyan bg-opacity-10 p-3 rounded-3 text-cyan"><i class="bi bi-geo-alt fs-5"></i></div>
                                        <span class="fs-6">Faculty Of Technology<br>Rajarata University Of Sri Lanka</span>
                                    </div>
                                </div>
                                
                            </div>

                            <!-- Right Side: Contact Form -->
                            <div class="col-md-7 ps-md-5">
                                
                                <!-- FitPulse Logo -->
                                <div class="text-center mb-5 mt-2">
                                    <div class="d-inline-block px-5 py-2 glass-panel rounded-pill">
                                        <span class="text-white fw-light tracking-wide fs-3">Fit</span><span class="text-cyan fw-bold fs-3">Pulse</span>
                                    </div>
                                </div>

                                <?php if ($error): ?>
                                    <div class="alert alert-danger rounded-3 small border-0 bg-danger bg-opacity-25 text-white mb-4"><?php echo $error; ?></div>
                                <?php endif; ?>
                                
                                <?php if ($success): ?>
                                    <div class="alert alert-success rounded-3 small border-0 bg-success bg-opacity-25 text-white mb-4"><?php echo $success; ?></div>
                                <?php endif; ?>

                                <form id="mainContactForm" class="needs-validation" action="contact.php" method="POST" novalidate>
                                    
                                    <div class="row g-4">
                                        <div class="col-sm-6">
                                            <label class="form-label text-light-gray small text-uppercase tracking-wider">Name</label>
                                            <input type="text" name="name" class="form-control glass-input text-white py-2" required>
                                            <div class="invalid-feedback text-warning">Please provide your name.</div>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                            <label class="form-label text-light-gray small text-uppercase tracking-wider">Surname</label>
                                            <input type="text" name="surname" class="form-control glass-input text-white py-2" required>
                                            <div class="invalid-feedback text-warning">Please provide your surname.</div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <label class="form-label text-light-gray small text-uppercase tracking-wider">Email</label>
                                            <input type="email" name="email" class="form-control glass-input text-white py-2" required>
                                            <div class="invalid-feedback text-warning">Please provide a valid email address.</div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <label class="form-label text-light-gray small text-uppercase tracking-wider">Message</label>
                                            <textarea name="message" class="form-control glass-input text-white" rows="5" required></textarea>
                                            <div class="invalid-feedback text-warning">Please enter your message.</div>
                                        </div>
                                        
                                        <div class="col-12 mt-5 mb-2">
                                            <button type="submit" name="send_message" class="btn btn-glow-cyan w-100 rounded-pill py-3 fw-bold text-uppercase tracking-wider fs-6">
                                                Submit Message <i class="bi bi-send-fill ms-2"></i>
                                            </button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="glass-footer py-4 mt-auto border-top border-secondary border-opacity-25">
        <div class="container text-center">
            <p class="text-light-gray mb-0 small">&copy; 2026 FitPulse. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Future Custom JS -->
    <script src="js/script.js"></script>
</body>
</html>
