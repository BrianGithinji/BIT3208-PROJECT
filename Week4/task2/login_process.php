<?php
// ─── Login Form Processor ─────────────────────────────────────────────────
// Demonstrates: POST method, password_verify(), session management

session_start(); // Start session to track logged-in user

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.html');
    exit;
}

// 1. SANITIZE inputs
$email    = htmlspecialchars(trim($_POST['email']));
$password = $_POST['password']; // raw – used only for verification, never echoed

$errors = [];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";
if (empty($password)) $errors[] = "Password is required.";

// 2. SIMULATED DATABASE CHECK
// In a real app, you'd query the DB:
// $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
// $stmt->execute([$email]);
// $user = $stmt->fetch();

// Simulated stored user (password is bcrypt hash of "password123")
$mockUsers = [
    'brian@example.com' => [
        'name'     => 'Brian Doe',
        'course'   => 'BIT',
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' // "password"
    ]
];

$loginSuccess = false;
$user = null;

if (empty($errors)) {
    if (isset($mockUsers[$email])) {
        // 3. VERIFY PASSWORD using password_verify() — compares plain text against hash
        if (password_verify($password, $mockUsers[$email]['password'])) {
            $loginSuccess = true;
            $user = $mockUsers[$email];

            // Store user info in session (never store password in session)
            $_SESSION['user_name']  = $user['name'];
            $_SESSION['user_email'] = $email;
            $_SESSION['logged_in']  = true;
        } else {
            // Vague error message — don't reveal whether email or password was wrong
            $errors[] = "Invalid email or password.";
        }
    } else {
        $errors[] = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Result</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .card { background: #fff; padding: 35px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); width: 100%; max-width: 500px; }
        h2 { margin-top: 0; }
        .success { color: #27ae60; }
        .error-box { background: #fdecea; color: #c0392b; padding: 15px; border-radius: 6px; }
        .info-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .info-table td { padding: 9px 12px; border-bottom: 1px solid #eee; font-size: 14px; }
        .info-table td:first-child { font-weight: bold; color: #555; width: 40%; }
        .concept { margin-top: 20px; background: #f5eef8; padding: 15px; border-radius: 6px; font-size: 13px; }
        .concept h4 { margin: 0 0 8px; color: #7d3c98; }
        code { background: #f0f0f0; padding: 2px 5px; border-radius: 3px; }
        a { display: inline-block; margin-top: 15px; color: #8e44ad; font-size: 14px; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .hint { font-size: 12px; color: #888; margin-top: 10px; }
    </style>
</head>
<body>
<div class="card">

<?php if (!empty($errors)): ?>
    <h2>Login Failed</h2>
    <div class="error-box">
        <?php foreach ($errors as $e) echo "<p style='margin:4px 0'>" . htmlspecialchars($e) . "</p>"; ?>
    </div>
    <p class="hint">💡 Try: <strong>brian@example.com</strong> / <strong>password</strong></p>
    <a href="login.html">← Try Again</a>

<?php else: ?>
    <h2 class="success">✅ Login Successful!</h2>

    <table class="info-table">
        <tr><td>Welcome</td><td><?= htmlspecialchars($user['name']) ?></td></tr>
        <tr><td>Email</td><td><?= htmlspecialchars($email) ?></td></tr>
        <tr><td>Course</td><td><?= htmlspecialchars($user['course']) ?></td></tr>
        <tr><td>Session Started</td><td>Yes — <code>$_SESSION['logged_in'] = true</code></td></tr>
        <tr><td>Login Time</td><td><?= date('Y-m-d H:i:s') ?></td></tr>
    </table>

    <div class="concept">
        <h4>Secure Login – Key Points</h4>
        <ul>
            <li><strong>POST</strong> — credentials sent in request body, not the URL.</li>
            <li><code>password_verify($input, $hash)</code> — safely checks password against bcrypt hash.</li>
            <li><strong>Vague error messages</strong> — "Invalid email or password" (not "wrong password") prevents user enumeration.</li>
            <li><strong>Sessions</strong> — <code>session_start()</code> creates a server-side session; only a session ID cookie is sent to the browser.</li>
            <li><strong>Never</strong> store plain-text passwords or put passwords in GET URLs.</li>
        </ul>
    </div>

    <a href="contact.html">→ Go to Contact Form</a>
<?php endif; ?>

</div>
</body>
</html>
