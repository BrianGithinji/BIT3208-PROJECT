<?php
session_start();
if (isset($_SESSION['user'])) { header('Location: ../index.php'); exit; }
require '../db.php';

$error = '';
$pageTitle = 'Login - SmartShop';
$rootPath = '../';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($pass, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user'] = ['id' => $user['id'], 'name' => $user['name'], 'role' => $user['role']];
        header('Location: ' . ($user['role'] === 'admin' ? '../admin/index.php' : '../index.php'));
        exit;
    }
    $error = 'Invalid email or password.';
}

include '../includes/header.php';
?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-4">
                <h4 class="fw-bold mb-4 text-center"><i class="bi bi-box-arrow-in-right"></i> Login</h4>
                <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success py-2"><?= htmlspecialchars($_SESSION['success']) ?></div>
                <?php unset($_SESSION['success']); endif; ?>
                <?php if ($error): ?>
                <div class="alert alert-danger py-2"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <form method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required autofocus>
                        <div class="invalid-feedback">Enter your email.</div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                        <div class="invalid-feedback">Enter your password.</div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
                <p class="text-center mt-3 mb-0 small">No account? <a href="register.php">Register here</a></p>
                <hr class="my-3">
               
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
