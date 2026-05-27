<?php
require 'auth_check.php';
require '../db.php';
$pageTitle = 'Admin Dashboard - SmartShop';
$rootPath = '../';

$stats = [
    'products' => $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn(),
    'orders'   => $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn(),
    'users'    => $pdo->query("SELECT COUNT(*) FROM users WHERE role='customer'")->fetchColumn(),
    'revenue'  => $pdo->query("SELECT COALESCE(SUM(total),0) FROM orders WHERE status != 'cancelled'")->fetchColumn(),
];
$recentOrders = $pdo->query("SELECT o.*, u.name AS customer FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC LIMIT 8")->fetchAll();

include '../includes/header.php';
?>
<div class="container-fluid py-4">
    <div class="container">
        <h3 class="fw-bold mb-4"><i class="bi bi-speedometer2"></i> Admin Dashboard</h3>
        <div class="row g-3 mb-4">
            <?php
            $cards = [
                ['label'=>'Total Products','value'=>$stats['products'],'icon'=>'bi-box-seam','color'=>'primary'],
                ['label'=>'Total Orders','value'=>$stats['orders'],'icon'=>'bi-bag','color'=>'success'],
                ['label'=>'Customers','value'=>$stats['users'],'icon'=>'bi-people','color'=>'info'],
                ['label'=>'Revenue (KES)','value'=>number_format($stats['revenue'],2),'icon'=>'bi-currency-dollar','color'=>'warning'],
            ];
            foreach ($cards as $c): ?>
            <div class="col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm admin-stat-card p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-<?= $c['color'] ?> bg-opacity-10 rounded p-3">
                            <i class="bi <?= $c['icon'] ?> fs-4 text-<?= $c['color'] ?>"></i>
                        </div>
                        <div>
                            <div class="text-muted small"><?= $c['label'] ?></div>
                            <div class="fw-bold fs-5"><?= $c['value'] ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="row g-3">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white fw-semibold d-flex justify-content-between">
                        <span>Recent Orders</span>
                        <a href="orders.php" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light"><tr><th>#</th><th>Customer</th><th>Total</th><th>Status</th><th>Date</th><th></th></tr></thead>
                            <tbody>
                            <?php foreach ($recentOrders as $o):
                                $colors = ['pending'=>'warning','processing'=>'info','shipped'=>'primary','delivered'=>'success','cancelled'=>'danger'];
                            ?>
                            <tr>
                                <td>#<?= $o['id'] ?></td>
                                <td><?= htmlspecialchars($o['customer']) ?></td>
                                <td>KES <?= number_format($o['total'],2) ?></td>
                                <td><span class="badge bg-<?= $colors[$o['status']] ?>"><?= ucfirst($o['status']) ?></span></td>
                                <td><?= date('d M Y', strtotime($o['created_at'])) ?></td>
                                <td><a href="orders.php?update=<?= $o['id'] ?>" class="btn btn-xs btn-outline-secondary btn-sm">Update</a></td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm p-3">
                    <h6 class="fw-semibold mb-3">Quick Actions</h6>
                    <div class="d-grid gap-2">
                        <a href="products.php?action=add" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Add Product</a>
                        <a href="products.php" class="btn btn-outline-primary"><i class="bi bi-box-seam"></i> Manage Products</a>
                        <a href="orders.php" class="btn btn-outline-success"><i class="bi bi-bag"></i> Manage Orders</a>
                        <a href="users.php" class="btn btn-outline-info"><i class="bi bi-people"></i> Manage Users</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
