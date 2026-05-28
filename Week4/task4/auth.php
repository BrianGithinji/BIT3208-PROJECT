<?php
// ─── auth.php ─────────────────────────────────────────────────────────────
// Shared authentication helper — included by every page in this task.
// Contains: user store, session helpers, password concepts.

session_start();

// ── Simulated User Database ───────────────────────────────────────────────
// In a real app these records come from a database table.
// Passwords are stored as bcrypt hashes — NEVER plain text.
//
// To generate a hash yourself:  echo password_hash('secret', PASSWORD_BCRYPT);
//
$USERS = [
    'brian' => [
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B9bd/C2', // "secret"
        'name'     => 'Brian Doe',
        'course'   => 'BIT',
        'role'     => 'Student',
    ],
    'admin' => [
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // "password"
        'name'     => 'Admin User',
        'course'   => 'N/A',
        'role'     => 'Administrator',
    ],
];

// ── Session Guard ─────────────────────────────────────────────────────────
// Call this at the top of any page that requires login.
// Redirects to login.php if the user has no active session.
function requireLogin(): void {
    if (empty($_SESSION['logged_in'])) {
        header('Location: login.php');
        exit;
    }
}

// ── Check if already logged in ────────────────────────────────────────────
function isLoggedIn(): bool {
    return !empty($_SESSION['logged_in']);
}
