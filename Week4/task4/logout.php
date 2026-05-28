<?php
// ─── logout.php ───────────────────────────────────────────────────────────
// Properly destroys the session — three steps required for a clean logout.

session_start();

// Step 1: Clear all session variables
$_SESSION = [];

// Step 2: Delete the session cookie from the browser
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), '',
        time() - 42000,
        $params['path'], $params['domain'],
        $params['secure'], $params['httponly']
    );
}

// Step 3: Destroy the session data on the server
session_destroy();

// Redirect to login page
header('Location: login.php');
exit;
