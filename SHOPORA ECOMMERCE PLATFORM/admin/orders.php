<?php
require 'auth_check.php';
require '../db.php';
$pageTitle = 'Manage Orders - Admin';
$rootPath = '../';

// Update order status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $pdo->prepare("UPDATE orders SET status=? WHERE id=?")
        ->execute([$_POST['status'], (int)$_POST['order_id']]);
    header('Location: orders.php?updated=1'); exit;
}

$orders = $pdo->query("SELECT o.*, u.name AS customer, u.email FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC")->fetchAll();
$statuses = ['pending','processing','shipped','delivered','cancelled'];
$colors   = ['pending'=>'warning','processing'=>'info','shipped'=>'primary','delivered'=>'success','cancelled'=>'danger'];

include '../includes/header.php';
?>
<div class="container py-4">
    <h3 class="fw-bold mb-4"><i class="bi bi-bag"></i> Manage Orders</h3>
    <?php if (isset($_GET['updated'])): ?><div class="alert alert-success py-2">Order status updated.</div><?php endif; ?>
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr><th>#</th><th>Customer</th><th>Total</th><th>Status</th><th>Date</th><th>Update Status</th></tr>
                </thead>
                <tbody>
                <?php foreach ($orders as $o): ?>
                <tr>
                    <td>#<?= $o['id'] ?></td>
                    <td>
                        <div class="fw-semibold"><?= htmlspecialchars($o['customer']) ?></div>
                        <small class="text-muted"><?= htmlspecialchars($o['email']) ?></small>
                    </td>
                    <td>KES <?= number_format($o['total'], 2) ?></td>
                    <td><span class="badge bg-<?= $colors[$o['status']] ?>"><?= ucfirst($o['status']) ?></span></td>
                    <td><?= date('d M Y', strtotime($o['created_at'])) ?></td>
                    <td>
                        <form method="POST" class="d-flex gap-2">
                            <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                            <select name="status" class="form-select form-select-sm" style="width:140px">
                                <?php foreach ($statuses as $s): ?>
                                <option value="<?= $s ?>" <?= $o['status'] === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button class="btn btn-sm btn-primary">Save</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
