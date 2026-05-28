<?php
// ─── includes/auth.php ────────────────────────────────────────────────────
// Shared authentication helper — included by every page.
// Contains: user store, session start, session guard functions.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ── Simulated User Store ──────────────────────────────────────────────────
// In a real app these come from the database (see database/schema.sql).
// Passwords are bcrypt hashes — NEVER plain text.
// Generate a hash: echo password_hash('secret', PASSWORD_BCRYPT);
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

// Redirect to login if no active session
function requireLogin(): void {
    if (empty($_SESSION['logged_in'])) {
        header('Location: login.php');
        exit;
    }
}

// Check if a session is active
function isLoggedIn(): bool {
    return !empty($_SESSION['logged_in']);
}
