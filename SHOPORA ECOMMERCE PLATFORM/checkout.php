<?php
session_start();
if (!isset($_SESSION['user'])) { header('Location: auth/login.php'); exit; }
require 'db.php';
$pageTitle = 'Checkout - SmartShop';

if (empty($_SESSION['cart'])) { header('Location: cart.php'); exit; }

// Fetch cart products
$ids = implode(',', array_map('intval', array_keys($_SESSION['cart'])));
$products = $pdo->query("SELECT * FROM products WHERE id IN ($ids)")->fetchAll(PDO::FETCH_UNIQUE);
$cartItems = [];
$total = 0;
foreach ($_SESSION['cart'] as $pid => $item) {
    if (isset($products[$pid])) {
        $subtotal = $products[$pid]['price'] * $item['qty'];
        $total += $subtotal;
        $cartItems[] = array_merge($products[$pid], ['qty' => $item['qty'], 'subtotal' => $subtotal]);
    }
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $phone   = trim($_POST['phone'] ?? '');
    $payment = $_POST['payment'] ?? '';

    if (!$name)    $errors[] = 'Full name is required.';
    if (!$address) $errors[] = 'Delivery address is required.';
    if (!$phone)   $errors[] = 'Phone number is required.';
    if (!$payment) $errors[] = 'Select a payment method.';

    if (empty($errors)) {
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
            $stmt->execute([$_SESSION['user']['id'], $total]);
            $orderId = $pdo->lastInsertId();

            $itemStmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            foreach ($cartItems as $item) {
                $itemStmt->execute([$orderId, $item['id'], $item['qty'], $item['price']]);
                $pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ?")->execute([$item['qty'], $item['id']]);
            }
            $pdo->commit();
            $_SESSION['cart'] = [];
            $_SESSION['order_success'] = $orderId;
            header('Location: orders.php'); exit;
        } catch (Exception $e) {
            $pdo->rollBack();
            $errors[] = 'Order failed. Please try again.';
        }
    }
}

include 'includes/header.php';
?>
<div class="container py-5">
    <h3 class="fw-bold mb-4"><i class="bi bi-credit-card"></i> Checkout</h3>
    <?php foreach ($errors as $e): ?>
    <div class="alert alert-danger py-2"><?= htmlspecialchars($e) ?></div>
    <?php endforeach; ?>
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-4">
                <h5 class="fw-semibold mb-3">Delivery Details</h5>
                <form method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($_SESSION['user']['name']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" name="phone" class="form-control" placeholder="+254 7XX XXX XXX" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Delivery Address</label>
                        <textarea name="address" class="form-control" rows="2" required placeholder="Street, City, County"></textarea>
                    </div>
                    <h5 class="fw-semibold mb-3 mt-4">Payment Method</h5>
                    <div class="row g-2 mb-4">
                        <?php foreach (['M-Pesa' => 'bi-phone', 'Credit Card' => 'bi-credit-card-2-front', 'Cash on Delivery' => 'bi-cash-coin'] as $method => $icon): ?>
                        <div class="col-4">
                            <input type="radio" class="btn-check" name="payment" id="pay_<?= $method ?>" value="<?= $method ?>" required>
                            <label class="btn btn-outline-primary w-100 py-3" for="pay_<?= $method ?>">
                                <i class="bi <?= $icon ?> d-block fs-4 mb-1"></i>
                                <small><?= $method ?></small>
                            </label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="submit" class="btn btn-success w-100 btn-lg">
                        <i class="bi bi-check-circle"></i> Place Order &mdash; KES <?= number_format($total, 2) ?>
                    </button>
                </form>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm p-4">
                <h5 class="fw-semibold mb-3">Order Summary</h5>
                <?php foreach ($cartItems as $item): ?>
                <div class="d-flex justify-content-between mb-2 small">
                    <span><?= htmlspecialchars($item['name']) ?> &times; <?= $item['qty'] ?></span>
                    <span>KES <?= number_format($item['subtotal'], 2) ?></span>
                </div>
                <?php endforeach; ?>
                <hr>
                <div class="d-flex justify-content-between fw-bold">
                    <span>Total</span><span class="text-primary">KES <?= number_format($total, 2) ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
