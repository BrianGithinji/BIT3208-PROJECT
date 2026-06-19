<?php
session_start();
if (isset($_SESSION['user'])) { header('Location: ../index.php'); exit; }
require '../db.php';

$errors = [];
$pageTitle = 'Register - SmartShop';
$rootPath = '../';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';
    $conf  = $_POST['confirm_password'] ?? '';

    if (strlen($name) < 2)          $errors[] = 'Name must be at least 2 characters.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email address.';
    if (strlen($pass) < 8)          $errors[] = 'Password must be at least 8 characters.';
    if ($pass !== $conf)             $errors[] = 'Passwords do not match.';

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = 'Email already registered.';
        } else {
            $hash = password_hash($pass, PASSWORD_BCRYPT);
            $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)")->execute([$name, $email, $hash]);
            $_SESSION['success'] = 'Account created! Please log in.';
            header('Location: login.php'); exit;
        }
    }
}

include '../includes/header.php';
?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm border-0 p-4">
                <h4 class="fw-bold mb-4 text-center"><i class="bi bi-person-plus"></i> Create Account</h4>
                <?php foreach ($errors as $e): ?>
                <div class="alert alert-danger py-2"><?= htmlspecialchars($e) ?></div>
                <?php endforeach; ?>
                <form method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required minlength="2">
                        <div class="invalid-feedback">Enter your full name.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                        <div class="invalid-feedback">Enter a valid email.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required minlength="8">
                        <div id="pw-strength" class="mt-1"></div>
                        <div class="invalid-feedback">Minimum 8 characters.</div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                        <div class="invalid-feedback">Passwords must match.</div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Register</button>
                </form>
                <p class="text-center mt-3 mb-0 small">Already have an account? <a href="login.php">Login</a></p>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
