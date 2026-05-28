<?php
// ─── welcome.php ──────────────────────────────────────────────────────────
// Session-protected page — redirects to login if no active session.
// Demonstrates: reading session data, session lifetime, password concepts.

require 'auth.php';
requireLogin(); // ← Guard: redirects to login.php if not logged in

// Read from session (set during login)
$name      = $_SESSION['name'];
$username  = $_SESSION['username'];
$role      = $_SESSION['role'];
$loginTime = date('Y-m-d H:i:s', $_SESSION['login_time']);
$sessionId = session_id();
$elapsed   = time() - $_SESSION['login_time']; // seconds since login
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome – <?= htmlspecialchars($name) ?></title>
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5; margin: 0; padding: 30px 20px;
        }
        .wrapper { max-width: 680px; margin: 0 auto; }

        /* Header bar */
        .topbar {
            background: #0f3460; color: #fff;
            padding: 16px 24px; border-radius: 10px;
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 24px;
        }
        .topbar h1 { margin: 0; font-size: 20px; }
        .topbar a {
            background: #e74c3c; color: #fff; padding: 8px 16px;
            border-radius: 5px; text-decoration: none; font-size: 13px;
        }
        .topbar a:hover { background: #c0392b; }

        /* Cards */
        .card {
            background: #fff; border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            padding: 24px; margin-bottom: 20px;
        }
        .card h3 { margin-top: 0; color: #0f3460; border-bottom: 2px solid #f0f2f5; padding-bottom: 10px; }

        /* Info table */
        table { width: 100%; border-collapse: collapse; }
        td { padding: 10px 12px; border-bottom: 1px solid #f0f2f5; font-size: 14px; }
        td:first-child { font-weight: bold; color: #555; width: 38%; }

        /* Session ID display */
        .session-id {
            background: #f4f4f4; padding: 8px 12px; border-radius: 5px;
            font-size: 12px; font-family: monospace; word-break: break-all;
            margin-top: 6px;
        }

        /* Concept boxes */
        .concept { border-radius: 8px; padding: 16px; font-size: 13px; margin-bottom: 20px; }
        .concept h4 { margin: 0 0 10px; }
        .concept ul { margin: 0; padding-left: 18px; line-height: 1.8; }
        .blue  { background: #eaf4fb; } .blue h4  { color: #2980b9; }
        .green { background: #eafaf1; } .green h4 { color: #1a7a4a; }
        .amber { background: #fef9e7; } .amber h4 { color: #b7950b; }

        code { background: #f0f0f0; padding: 2px 5px; border-radius: 3px; font-size: 12px; }
        .badge {
            display: inline-block; padding: 3px 10px; border-radius: 12px;
            font-size: 12px; font-weight: bold;
            background: <?= $role === 'Administrator' ? '#fdecea' : '#eafaf1' ?>;
            color: <?= $role === 'Administrator' ? '#c0392b' : '#1a7a4a' ?>;
        }
    </style>
</head>
<body>
<div class="wrapper">

    <!-- Top bar -->
    <div class="topbar">
        <h1>👋 Welcome, <?= htmlspecialchars($name) ?>!</h1>
        <a href="logout.php">Logout →</a>
    </div>

    <!-- Session Data Card -->
    <div class="card">
        <h3>📋 Your Session Data</h3>
        <table>
            <tr><td>Full Name</td><td><?= htmlspecialchars($name) ?></td></tr>
            <tr><td>Username</td><td><?= htmlspecialchars($username) ?></td></tr>
            <tr><td>Role</td><td><span class="badge"><?= htmlspecialchars($role) ?></span></td></tr>
            <tr><td>Logged In At</td><td><?= $loginTime ?></td></tr>
            <tr><td>Session Age</td><td><?= $elapsed ?> seconds</td></tr>
            <tr>
                <td>Session ID</td>
                <td>
                    <div class="session-id"><?= $sessionId ?></div>
                    <small style="color:#888;">Stored as a cookie in your browser — the actual data lives on the server.</small>
                </td>
            </tr>
        </table>
    </div>

    <!-- Concept: Sessions -->
    <div class="concept blue">
        <h4>🔵 How Sessions Work</h4>
        <ul>
            <li><code>session_start()</code> — must be called before any output; starts or resumes a session.</li>
            <li>PHP creates a unique <strong>Session ID</strong> and sends it to the browser as a cookie (<code>PHPSESSID</code>).</li>
            <li>Session data (<code>$_SESSION</code>) is stored <strong>on the server</strong>, not in the browser.</li>
            <li>On every request, the browser sends the session ID cookie back — PHP uses it to load the right session data.</li>
            <li><code>session_regenerate_id(true)</code> — called at login to prevent <strong>session fixation</strong> attacks.</li>
        </ul>
    </div>

    <!-- Concept: Password Handling -->
    <div class="concept green">
        <h4>🟢 Password Handling Concepts</h4>
        <ul>
            <li><strong>Never store plain-text passwords</strong> — always hash them before saving.</li>
            <li><code>password_hash($pass, PASSWORD_BCRYPT)</code> — creates a secure one-way bcrypt hash.</li>
            <li><code>password_verify($input, $hash)</code> — safely checks a plain-text input against the stored hash.</li>
            <li>bcrypt automatically includes a <strong>salt</strong> — protects against rainbow table attacks.</li>
            <li>The hash looks like: <code>$2y$10$...</code> — the <code>10</code> is the cost factor (work factor).</li>
            <li>Passwords are <strong>never stored in <code>$_SESSION</code></strong> — only the username and role.</li>
        </ul>
    </div>

    <!-- Concept: Login Logic -->
    <div class="concept amber">
        <h4>🟡 Login Logic Flow</h4>
        <ul>
            <li>User submits form → PHP reads <code>$_POST['username']</code> and <code>$_POST['password']</code>.</li>
            <li>Look up username in the user store (DB in real apps).</li>
            <li>If username not found → show vague error (don't reveal which field was wrong).</li>
            <li>If found → call <code>password_verify()</code> to check the password.</li>
            <li>On success → regenerate session ID, write to <code>$_SESSION</code>, redirect.</li>
            <li>On failure → increment failed attempt counter (rate limiting / lockout in real apps).</li>
        </ul>
    </div>

</div>
</body>
</html>
