<?php
// ─── Registration Form Processor ─────────────────────────────────────────
// Demonstrates: POST method, input sanitization, validation, password hashing

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.html');
    exit;
}

// 1. SANITIZE – strip tags and whitespace to prevent XSS
$fullname = htmlspecialchars(trim($_POST['fullname']));
$email    = htmlspecialchars(trim($_POST['email']));
$course   = htmlspecialchars(trim($_POST['course']));
$password = $_POST['password'];           // raw – will be hashed, not echoed
$confirm  = $_POST['confirm_password'];

// 2. VALIDATE
$errors = [];

if (empty($fullname)) $errors[] = "Full name is required.";
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email address.";
if (empty($course))   $errors[] = "Please select a course.";
if (strlen($password) < 8) $errors[] = "Password must be at least 8 characters.";
if ($password !== $confirm)  $errors[] = "Passwords do not match.";

// 3. SECURE PASSWORD HANDLING – never store plain-text passwords
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// In a real app you would INSERT into a database here:
// $stmt = $pdo->prepare("INSERT INTO users (fullname, email, course, password) VALUES (?, ?, ?, ?)");
// $stmt->execute([$fullname, $email, $course, $hashedPassword]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Result</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .card { background: #fff; padding: 35px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); width: 100%; max-width: 500px; }
        h2 { margin-top: 0; }
        .success { color: #27ae60; }
        .error-box { background: #fdecea; color: #c0392b; padding: 15px; border-radius: 6px; }
        .error-box ul { margin: 8px 0 0; padding-left: 18px; }
        .info-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .info-table td { padding: 9px 12px; border-bottom: 1px solid #eee; font-size: 14px; }
        .info-table td:first-child { font-weight: bold; color: #555; width: 40%; }
        .hash-box { background: #f4f4f4; padding: 10px; border-radius: 5px; font-size: 12px; word-break: break-all; margin-top: 10px; }
        .concept { margin-top: 20px; background: #eafaf1; padding: 15px; border-radius: 6px; font-size: 13px; }
        .concept h4 { margin: 0 0 8px; color: #1a7a4a; }
        a { display: inline-block; margin-top: 15px; color: #3498db; font-size: 14px; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
<div class="card">

<?php if (!empty($errors)): ?>
    <h2>Registration Failed</h2>
    <div class="error-box">
        <strong>Please fix the following errors:</strong>
        <ul><?php foreach ($errors as $e) echo "<li>" . htmlspecialchars($e) . "</li>"; ?></ul>
    </div>
    <a href="register.html">← Try Again</a>

<?php else: ?>
    <h2 class="success">✅ Registration Successful!</h2>

    <table class="info-table">
        <tr><td>Full Name</td><td><?= $fullname ?></td></tr>
        <tr><td>Email</td><td><?= $email ?></td></tr>
        <tr><td>Course</td><td><?= $course ?></td></tr>
        <tr><td>Password Stored As</td><td>Hashed (bcrypt)</td></tr>
    </table>

    <p style="font-size:13px; color:#555; margin-top:15px;"><strong>Hashed password (what gets saved to DB):</strong></p>
    <div class="hash-box"><?= $hashedPassword ?></div>

    <div class="concept">
        <h4>Secure Form Handling – Key Points</h4>
        <ul>
            <li><strong>POST</strong> method — data sent in request body, not in URL.</li>
            <li><code>htmlspecialchars()</code> — prevents XSS by encoding special characters.</li>
            <li><code>filter_var(FILTER_VALIDATE_EMAIL)</code> — validates email format server-side.</li>
            <li><code>password_hash()</code> — bcrypt hashes the password; never store plain text.</li>
            <li><code>password_verify()</code> — used at login to check password against the hash.</li>
        </ul>
    </div>

    <a href="login.html">→ Proceed to Login</a>
<?php endif; ?>

</div>
</body>
</html>
