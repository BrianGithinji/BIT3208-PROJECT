<?php
// ─── login.php ────────────────────────────────────────────────────────────
// Renders the login form (GET) and processes credentials (POST).
require 'includes/auth.php';

if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

$error    = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Please enter both username and password.';

    } elseif (!isset($USERS[$username])) {
        $error = 'Invalid username or password.';

    } elseif (password_verify($password, $USERS[$username]['password'])) {
        session_regenerate_id(true);

        $_SESSION['logged_in']  = true;
        $_SESSION['username']   = $username;
        $_SESSION['name']       = $USERS[$username]['name'];
        $_SESSION['role']       = $USERS[$username]['role'];
        $_SESSION['login_time'] = time();

        header('Location: dashboard.php');
        exit;

    } else {
        $error = 'Invalid username or password.';
    }

    $username = htmlspecialchars($username);
}

$pageTitle = 'Login – BIT3208';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="login-body">

<div class="login-card">
    <div class="logo">🔐</div>
    <h2>Sign In</h2>
    <p class="tagline">BIT3208 Advanced Web Design – Week 4</p>

    <?php if ($error): ?>
        <div class="alert alert-error">⚠️ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <div class="field">
            <label for="username">Username</label>
            <input type="text" id="username" name="username"
                   value="<?= $username ?>" placeholder="e.g. brian" required autofocus>
        </div>
        <div class="field">
            <label for="password">Password</label>
            <input type="password" id="password" name="password"
                   placeholder="Your password" required>
        </div>
        <button type="submit" class="btn">Login →</button>
    </form>

    <div class="hint">
        <strong>Demo Credentials</strong>
        <table>
            <tr><td>brian</td><td>secret</td><td>Student</td></tr>
            <tr><td>admin</td><td>password</td><td>Administrator</td></tr>
        </table>
    </div>
</div>

<script src="js/main.js"></script>
</body>
</html>
