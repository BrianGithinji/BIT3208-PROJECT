<?php
// ─── index.php ────────────────────────────────────────────────────────────
// Entry point — redirect based on session state.
require 'includes/auth.php';

if (isLoggedIn()) {
    header('Location: dashboard.php');
} else {
    header('Location: login.php');
}
exit;
