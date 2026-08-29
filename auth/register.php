<?php
// Connect to the database
require_once '../includes/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    $username = $first_name . ' ' . $last_name;

    // 3. Validation
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
        $error = 'Please fill in all required fields.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            $error = 'This email is already registered. Please login.';
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            $insert_stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            
            if ($insert_stmt->execute([$username, $email, $hashed_password])) {
                $success = 'Registration successful! You can now login.';
            } else {
                $error = 'Something went wrong. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - FitPulse</title>
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

        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-7 col-xl-6">
                    
                    <div class="glass-card p-4 p-md-5 rounded-4 position-relative overflow-hidden mt-4">
                        <!-- Decorative glow -->
                        <div class="card-glow-accent top-left" style="position: absolute; width: 250px; height: 250px; background: radial-gradient(circle, rgba(0,210,255,0.15) 0%, transparent 70%); top: -100px; left: -100px; z-index: 0; pointer-events: none; opacity: 0.5;"></div>
                        
                        <div class="position-relative" style="z-index: 1;">
                            <div class="text-center mb-4">
                                <h2 class="text-white futuristic-font text-glow mb-2">CREATE PROFILE</h2>
                                <p class="text-light-gray small">Join the future of fitness tracking today.</p>
                            </div>

                            <?php if ($error): ?>
                                <div class="alert alert-danger rounded-3 small border-0 bg-danger bg-opacity-25 text-white mb-4"><?php echo $error; ?></div>
                            <?php endif; ?>
                            
                            <?php if ($success): ?>
                                <div class="alert alert-success rounded-3 small border-0 bg-success bg-opacity-25 text-white mb-4"><?php echo $success; ?></div>
                            <?php endif; ?>


                            <form id="signupForm" class="needs-validation" action="register.php" method="POST" novalidate>
                                
                                <div class="row g-3 mb-4">
                                    <div class="col-sm-6">
                                        <label class="form-label text-light-gray small text-uppercase tracking-wider">First Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-transparent border-secondary border-opacity-50 text-cyan"><i class="bi bi-person"></i></span>
                                            <input type="text" name="first_name" class="form-control glass-input text-white border-start-0" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label text-light-gray small text-uppercase tracking-wider">Last Name</label>
                                        <input type="text" name="last_name" class="form-control glass-input text-white" required>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label text-light-gray small text-uppercase tracking-wider">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-transparent border-secondary border-opacity-50 text-cyan"><i class="bi bi-envelope"></i></span>
                                        <input type="email" name="email" class="form-control glass-input text-white border-start-0" required>
                                    </div>
                                </div>
                                
                                <div class="row g-3 mb-4">
                                    <div class="col-sm-6">
                                        <label class="form-label text-light-gray small text-uppercase tracking-wider">Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-transparent border-secondary border-opacity-50 text-cyan"><i class="bi bi-lock"></i></span>
                                            <input type="password" name="password" class="form-control glass-input text-white border-start-0" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label text-light-gray small text-uppercase tracking-wider">Confirm</label>
                                        <input type="password" name="confirm_password" class="form-control glass-input text-white" required>
                                    </div>
                                </div>

                                <div class="mb-4 form-check">
                                    <input type="checkbox" name="terms" class="form-check-input bg-transparent border-cyan" id="termsCheck" required>
                                    <label class="form-check-label text-light-gray small" for="termsCheck">
                                        I agree to share my email with FitPulse.
                                    </label>
                                </div>
                                
                                <button type="submit" class="btn btn-glow-cyan w-100 rounded-pill py-3 fw-bold text-uppercase tracking-wider mb-4">
                                    Register Account <i class="bi bi-person-plus ms-2"></i>
                                </button>
                                
                                <div class="text-center text-light-gray small">
                                    Already have a profile? <a href="login.php" class="text-cyan text-decoration-none fw-bold">Login Here</a>
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