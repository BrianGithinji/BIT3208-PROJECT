<?php
session_start();
require 'db.php';
$pageTitle = 'Cart - SmartShop';

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $pid    = (int)($_POST['product_id'] ?? 0);

    if ($action === 'remove') {
        unset($_SESSION['cart'][$pid]);
    } elseif ($action === 'update') {
        $delta = (int)($_POST['delta'] ?? 0);
        if (isset($_SESSION['cart'][$pid])) {
            $_SESSION['cart'][$pid]['qty'] = max(0, $_SESSION['cart'][$pid]['qty'] + $delta);
            if ($_SESSION['cart'][$pid]['qty'] === 0) unset($_SESSION['cart'][$pid]);
        }
    } elseif ($action === 'clear') {
        $_SESSION['cart'] = [];
    }

    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) exit; // AJAX
    header('Location: cart.php'); exit;
}

// Fetch product details for cart items
$cartItems = [];
$total = 0;
if (!empty($_SESSION['cart'])) {
    $ids = implode(',', array_map('intval', array_keys($_SESSION['cart'])));
    $products = $pdo->query("SELECT * FROM products WHERE id IN ($ids)")->fetchAll(PDO::FETCH_UNIQUE);
    foreach ($_SESSION['cart'] as $pid => $item) {
        if (isset($products[$pid])) {
            $p = $products[$pid];
            $subtotal = $p['price'] * $item['qty'];
            $total += $subtotal;
            $cartItems[] = array_merge($p, ['qty' => $item['qty'], 'subtotal' => $subtotal]);
        }
    }
}

include 'includes/header.php';
?>
<div class="container py-5">
    <h3 class="fw-bold mb-4"><i class="bi bi-cart3"></i> Shopping Cart</h3>
    <?php if (empty($cartItems)): ?>
        <div class="text-center py-5 text-muted">
            <i class="bi bi-cart-x fs-1"></i>
            <p class="mt-2">Your cart is empty. <a href="index.php">Continue shopping</a></p>
        </div>
    <?php else: ?>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <?php foreach ($cartItems as $item): ?>
                    <div class="d-flex align-items-center p-3 border-bottom gap-3">
                        <img src="<?= htmlspecialchars($item['image'] ?? '') ?>" class="cart-item-img" alt="">
                        <div class="flex-grow-1">
                            <h6 class="mb-1"><?= htmlspecialchars($item['name']) ?></h6>
                            <small class="text-muted">KES <?= number_format($item['price'], 2) ?> each</small>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn btn-outline-secondary btn-sm" onclick="updateQty(<?= $item['id'] ?>, -1)">-</button>
                            <span class="fw-semibold px-2"><?= $item['qty'] ?></span>
                            <button class="btn btn-outline-secondary btn-sm" onclick="updateQty(<?= $item['id'] ?>, 1)">+</button>
                        </div>
                        <span class="fw-bold text-primary" style="min-width:100px;text-align:right">KES <?= number_format($item['subtotal'], 2) ?></span>
                        <form method="POST">
                            <input type="hidden" name="action" value="remove">
                            <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                            <button class="btn btn-link text-danger p-0"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <form method="POST" class="mt-2">
                <input type="hidden" name="action" value="clear">
                <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash3"></i> Clear Cart</button>
            </form>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4">
                <h5 class="fw-bold mb-3">Order Summary</h5>
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal</span><span>KES <?= number_format($total, 2) ?></span>
                </div>
                <div class="d-flex justify-content-between mb-2 text-muted small">
                    <span>Shipping</span><span>Free</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5 mb-4">
                    <span>Total</span><span class="text-primary">KES <?= number_format($total, 2) ?></span>
                </div>
                <?php if (isset($_SESSION['user'])): ?>
                <a href="checkout.php" class="btn btn-primary w-100"><i class="bi bi-credit-card"></i> Proceed to Checkout</a>
                <?php else: ?>
                <a href="auth/login.php" class="btn btn-primary w-100">Login to Checkout</a>
                <?php endif; ?>
                <a href="index.php" class="btn btn-outline-secondary w-100 mt-2">Continue Shopping</a>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php include 'includes/footer.php'; ?>
