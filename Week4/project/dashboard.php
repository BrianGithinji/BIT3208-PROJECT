<?php
// ─── dashboard.php ────────────────────────────────────────────────────────
// Session-protected dashboard — redirects to login if no active session.
require 'includes/auth.php';
requireLogin();

$name      = $_SESSION['name'];
$username  = $_SESSION['username'];
$role      = $_SESSION['role'];
$loginTime = date('Y-m-d H:i:s', $_SESSION['login_time']);
$sessionId = session_id();
$elapsed   = time() - $_SESSION['login_time'];
$badgeClass = $role === 'Administrator' ? 'badge-admin' : 'badge-student';

$pageTitle = 'Dashboard – ' . $name;
require 'includes/header.php';
?>

<div class="wrapper">

    <!-- Session Data -->
    <div class="card">
        <h3>📋 Session Data</h3>
        <table class="info-table">
            <tr><td>Full Name</td><td><?= htmlspecialchars($name) ?></td></tr>
            <tr><td>Username</td><td><?= htmlspecialchars($username) ?></td></tr>
            <tr><td>Role</td><td><span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($role) ?></span></td></tr>
            <tr><td>Logged In At</td><td><?= $loginTime ?></td></tr>
            <tr>
                <td>Session Age</td>
                <td><span id="session-timer"><?= $elapsed ?></span> seconds</td>
            </tr>
            <tr>
                <td>Session ID</td>
                <td>
                    <div class="session-id"><?= $sessionId ?></div>
                    <small style="color:#888;">Cookie in browser — data stored on server.</small>
                </td>
            </tr>
        </table>
    </div>

    <!-- Concept: Sessions -->
    <div class="concept blue">
        <h4>🔵 How Sessions Work</h4>
        <ul>
            <li><code>session_start()</code> — starts or resumes a session; must run before any output.</li>
            <li>PHP generates a unique <strong>Session ID</strong> sent to the browser as a <code>PHPSESSID</code> cookie.</li>
            <li><code>$_SESSION</code> data lives on the <strong>server</strong> — only the ID travels to the browser.</li>
            <li>Every request sends the cookie back; PHP loads the matching session data.</li>
            <li><code>session_regenerate_id(true)</code> at login prevents <strong>session fixation</strong> attacks.</li>
        </ul>
    </div>

    <!-- Concept: Password Handling -->
    <div class="concept green">
        <h4>🟢 Password Handling</h4>
        <ul>
            <li>Passwords stored as bcrypt hashes — <strong>never plain text</strong>.</li>
            <li><code>password_hash($pass, PASSWORD_BCRYPT)</code> — one-way hash with automatic salt.</li>
            <li><code>password_verify($input, $hash)</code> — safely checks input against the stored hash.</li>
            <li>Hash format: <code>$2y$10$...</code> — cost factor <code>10</code> controls hashing speed.</li>
            <li>Passwords are <strong>never stored in <code>$_SESSION</code></strong>.</li>
        </ul>
    </div>

    <!-- Concept: Login Logic -->
    <div class="concept amber">
        <h4>🟡 Login Logic Flow</h4>
        <ul>
            <li>Read <code>$_POST['username']</code> and <code>$_POST['password']</code> from the form.</li>
            <li>Look up username in the user store / database.</li>
            <li>Use a <strong>vague error</strong> ("Invalid username or password") — never reveal which field failed.</li>
            <li>On match → <code>session_regenerate_id()</code>, write to <code>$_SESSION</code>, redirect.</li>
            <li>On failure → show error, keep username in field, clear password field.</li>
        </ul>
    </div>

</div>

<?php require 'includes/footer.php'; ?>
