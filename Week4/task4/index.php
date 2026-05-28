<?php
// ─── index.php ────────────────────────────────────────────────────────────
// Entry point — redirect based on session state.
require 'auth.php';

if (isLoggedIn()) {
    header('Location: welcome.php');
} else {
    header('Location: login.php');
}
exit;
