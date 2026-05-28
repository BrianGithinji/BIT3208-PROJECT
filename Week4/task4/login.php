<?php
// ─── login.php ────────────────────────────────────────────────────────────
// Handles: rendering the login form (GET) + processing credentials (POST).
// Demonstrates: login logic, password_verify(), session creation.

require 'auth.php';

// Already logged in — no need to show login page
if (isLoggedIn()) {
    header('Location: welcome.php');
    exit;
}

$error    = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Read & sanitize inputs
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';      // raw — only used for verify(), never echoed

    // 2. Basic presence check
    if (empty($username) || empty($password)) {
        $error = 'Please enter both username and password.';

    } elseif (!isset($USERS[$username])) {
        // 3. Username lookup — vague message prevents user enumeration
        $error = 'Invalid username or password.';

    } else {
        // 4. PASSWORD VERIFICATION
        // password_verify() safely compares the plain-text input
        // against the stored bcrypt hash — returns true/false.
        if (password_verify($password, $USERS[$username]['password'])) {

            // 5. Regenerate session ID on login — prevents session fixation attacks
            session_regenerate_id(true);

            // 6. Store only what's needed in session — NEVER store the password
            $_SESSION['logged_in']  = true;
            $_SESSION['username']   = $username;
            $_SESSION['name']       = $USERS[$username]['name'];
            $_SESSION['role']       = $USERS[$username]['role'];
            $_SESSION['login_time'] = time();

            header('Location: welcome.php');
            exit;

        } else {
            $error = 'Invalid username or password.';
        }
    }

    // Preserve username in form on error (but never the password)
    $username = htmlspecialchars($username);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login – Task 4</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh; display: flex; align-items: center; justify-content: center; margin: 0;
        }
        .card {
            background: #fff; border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            width: 100%; max-width: 420px; padding: 40px;
        }
        .logo { text-align: center; font-size: 40px; margin-bottom: 8px; }
        h2 { text-align: center; margin: 0 0 6px; color: #1a1a2e; }
        .tagline { text-align: center; color: #888; font-size: 13px; margin-bottom: 28px; }
        label { display: block; font-size: 13px; font-weight: bold; color: #555; margin-bottom: 5px; }
        input[type="text"], input[type="password"] {
            width: 100%; padding: 11px 14px; border: 1px solid #ddd;
            border-radius: 6px; font-size: 14px; transition: border-color .2s;
        }
        input:focus { outline: none; border-color: #0f3460; }
        .field { margin-bottom: 18px; }
        .error {
            background: #fdecea; color: #c0392b;
            padding: 11px 14px; border-radius: 6px;
            font-size: 13px; margin-bottom: 18px;
            border-left: 4px solid #e74c3c;
        }
        button {
            width: 100%; padding: 12px; background: #0f3460;
            color: #fff; border: none; border-radius: 6px;
            font-size: 15px; cursor: pointer; transition: background .2s;
        }
        button:hover { background: #16213e; }
        .hint {
            margin-top: 20px; background: #f0f4ff;
            padding: 14px; border-radius: 6px; font-size: 12px; color: #555;
        }
        .hint strong { color: #0f3460; }
        .hint table { width: 100%; margin-top: 6px; border-collapse: collapse; }
        .hint td { padding: 4px 8px; border-bottom: 1px solid #dde; }
        .hint td:first-child { font-weight: bold; }
    </style>
</head>
<body>
<div class="card">
    <div class="logo">🔐</div>
    <h2>Sign In</h2>
    <p class="tagline">Task 4 – Sessions &amp; Login Logic</p>

    <?php if ($error): ?>
        <div class="error">⚠️ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php">

        <div class="field">
            <label for="username">Username</label>
            <input type="text" id="username" name="username"
                   value="<?= $username ?>" placeholder="e.g. brian" required autofocus>
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Your password" required>
        </div>

        <button type="submit">Login →</button>
    </form>

    <div class="hint">
        <strong>Demo Credentials</strong>
        <table>
            <tr><td>brian</td><td>secret</td><td>Student</td></tr>
            <tr><td>admin</td><td>password</td><td>Administrator</td></tr>
        </table>
    </div>
</div>
</body>
</html>
