<?php
session_start();

// Connect to the database
require_once '../includes/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validation
    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password.';
    } else {
        $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify credentials
        if ($user && password_verify($password, $user['password'])) {
            
            session_regenerate_id(true); 
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            // Redirect to dashboard
            header("Location: ../dashboard.php");
            exit();
        } else {
            $error = 'Invalid email or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FitPulse</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="dark-theme bg-deep-dark">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg glass-nav fixed-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="../index.php">
                <span class="text-white fw-light tracking-wide fs-6">Fit</span><span class="text-cyan fw-bold fs-6">Pulse</span>
            </a>
        </div>
    </nav>

    <!-- Main Auth Content -->
    <main class="content-wrapper min-vh-100 d-flex align-items-center pt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    
                    <div class="glass-card p-5 rounded-4 position-relative overflow-hidden mt-5">
                        <!-- Decorative glow -->
                        <div class="card-glow-accent top-right" style="position: absolute; width: 250px; height: 250px; background: radial-gradient(circle, rgba(0,210,255,0.15) 0%, transparent 70%); top: -100px; right: -100px; z-index: 0; pointer-events: none; opacity: 0.5;"></div>
                        
                        <div class="position-relative" style="z-index: 1;">
                            <div class="text-center mb-4">
                                <h2 class="text-white futuristic-font text-glow mb-2">WELCOME BACK</h2>
                                <p class="text-light-gray small">Enter your credentials to access your dashboard.</p>
                            </div>

                            <?php if ($error): ?>
                                <div class="alert alert-danger rounded-3 small border-0 bg-danger bg-opacity-25 text-white mb-4"><?php echo $error; ?></div>
                            <?php endif; ?>

                            <form id="loginForm" class="needs-validation" action="login.php" method="POST" novalidate>
                                
                                <div class="mb-4">
                                    <label class="form-label text-light-gray small text-uppercase tracking-wider">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-transparent border-secondary border-opacity-50 text-cyan"><i class="bi bi-envelope"></i></span>
                                        <input type="email" name="email" class="form-control glass-input text-white border-start-0" required>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label class="form-label text-light-gray small text-uppercase tracking-wider m-0">Password</label>
                                        <!-- Dummy Forgot Password Link (Only for visual) -->
                                        <a href="#" class="text-cyan text-decoration-none small">Forgot Password?</a>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text bg-transparent border-secondary border-opacity-50 text-cyan"><i class="bi bi-lock"></i></span>
                                        <input type="password" name="password" class="form-control glass-input text-white border-start-0" required>
                                    </div>
                                </div>

                                <div class="mb-4 form-check">
                                    <input type="checkbox" name="remember" class="form-check-input bg-transparent border-cyan" id="rememberMe">
                                    <label class="form-check-label text-light-gray small" for="rememberMe">Remember me on this device</label>
                                </div>
                                
                                <button type="submit" class="btn btn-glow-cyan w-100 rounded-pill py-3 fw-bold text-uppercase tracking-wider mb-4">
                                    Initialize Session <i class="bi bi-box-arrow-in-right ms-2"></i>
                                </button>
                                
                                <div class="text-center text-light-gray small">
                                    Don't have an account? <a href="register.php" class="text-cyan text-decoration-none fw-bold">Sign Up Now</a>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/script.js"></script>
</body>
</html>
