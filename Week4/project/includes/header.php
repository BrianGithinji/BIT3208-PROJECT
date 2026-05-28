<?php
// ─── includes/header.php ─────────────────────────────────────────────────
// Shared page header — included at the top of every page.
// $pageTitle must be set before including this file.
$pageTitle = $pageTitle ?? 'BIT3208 Project';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php if (isLoggedIn()): ?>
<nav class="navbar">
    <span class="nav-brand">🎓 BIT3208</span>
    <div class="nav-links">
        <a href="dashboard.php" class="<?= basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : '' ?>">Dashboard</a>
        <span class="nav-user">👤 <?= htmlspecialchars($_SESSION['name']) ?></span>
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>
</nav>
<?php endif; ?>
