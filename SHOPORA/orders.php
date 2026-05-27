<?php
session_start();
if (!isset($_SESSION['user'])) { header('Location: auth/login.php'); exit; }
require 'db.php';
$pageTitle = 'My Orders - SmartShop';

$orders = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$orders->execute([$_SESSION['user']['id']]);
$orders = $orders->fetchAll();

include 'includes/header.php';
?>
<div class="container py-5">
    <h3 class="fw-bold mb-4"><i class="bi bi-bag-check"></i> My Orders</h3>
    <?php if (isset($_SESSION['order_success'])): ?>
    <div class="alert alert-success">
        <i class="bi bi-check-circle-fill"></i> Order #<?= $_SESSION['order_success'] ?> placed successfully! Thank you.
    </div>
    <?php unset($_SESSION['order_success']); endif; ?>
    <?php if (empty($orders)): ?>
        <p class="text-muted">No orders yet. <a href="index.php">Start shopping!</a></p>
    <?php else: ?>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr><th>#</th><th>Date</th><th>Total</th><th>Status</th><th>Items</th></tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $order):
                $items = $pdo->prepare("SELECT oi.*, p.name FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?");
                $items->execute([$order['id']]);
                $items = $items->fetchAll();
                $statusColors = ['pending'=>'warning','processing'=>'info','shipped'=>'primary','delivered'=>'success','cancelled'=>'danger'];
            ?>
            <tr>
                <td>#<?= $order['id'] ?></td>
                <td><?= date('d M Y, H:i', strtotime($order['created_at'])) ?></td>
                <td class="fw-semibold">KES <?= number_format($order['total'], 2) ?></td>
                <td><span class="badge bg-<?= $statusColors[$order['status']] ?> order-status-badge"><?= ucfirst($order['status']) ?></span></td>
                <td>
                    <?php foreach ($items as $i): ?>
                    <small class="d-block"><?= htmlspecialchars($i['name']) ?> &times; <?= $i['quantity'] ?></small>
                    <?php endforeach; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>
<?php include 'includes/footer.php'; ?>
