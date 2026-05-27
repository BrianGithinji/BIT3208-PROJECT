<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Shopora' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= $rootPath ?? '' ?>assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= $rootPath ?? '' ?>index.php">
            <i class="bi bi-shop"></i> Shopora
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="<?= $rootPath ?? '' ?>index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= $rootPath ?? '' ?>index.php?page=catalog">Products</a></li>
            </ul>
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item me-2">
                    <a class="nav-link position-relative" href="<?= $rootPath ?? '' ?>cart.php">
                        <i class="bi bi-cart3 fs-5"></i>
                        <?php $cartCount = array_sum(array_column($_SESSION['cart'] ?? [], 'qty')); ?>
                        <?php if ($cartCount > 0): ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><?= $cartCount ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <?php if (isset($_SESSION['user'])): ?>
                    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= $rootPath ?? '' ?>admin/index.php"><i class="bi bi-speedometer2"></i> Admin</a></li>
                    <?php endif; ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> <?= htmlspecialchars($_SESSION['user']['name']) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= $rootPath ?? '' ?>orders.php"><i class="bi bi-bag"></i> My Orders</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?= $rootPath ?? '' ?>auth/logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?= $rootPath ?? '' ?>auth/login.php">Login</a></li>
                    <li class="nav-item"><a class="btn btn-primary btn-sm ms-2" href="<?= $rootPath ?? '' ?>auth/register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
