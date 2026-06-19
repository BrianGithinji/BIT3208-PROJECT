<?php
require 'auth_check.php';
require '../db.php';
$pageTitle = 'Manage Users - Admin';
$rootPath = '../';

// Toggle role
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $uid  = (int)$_POST['user_id'];
    $role = $_POST['role'] === 'admin' ? 'admin' : 'customer';
    $pdo->prepare("UPDATE users SET role=? WHERE id=?")->execute([$role, $uid]);
    header('Location: users.php?updated=1'); exit;
}

// Delete user (not self)
if (isset($_GET['delete'])) {
    $uid = (int)$_GET['delete'];
    if ($uid !== $_SESSION['user']['id']) {
        $pdo->prepare("DELETE FROM users WHERE id=?")->execute([$uid]);
    }
    header('Location: users.php?deleted=1'); exit;
}

$users = $pdo->query("SELECT u.*, COUNT(o.id) AS order_count FROM users u LEFT JOIN orders o ON u.id = o.user_id GROUP BY u.id ORDER BY u.created_at DESC")->fetchAll();

include '../includes/header.php';
?>
<div class="container py-4">
    <h3 class="fw-bold mb-4"><i class="bi bi-people"></i> Manage Users</h3>
    <?php if (isset($_GET['updated'])): ?><div class="alert alert-success py-2">User role updated.</div><?php endif; ?>
    <?php if (isset($_GET['deleted'])): ?><div class="alert alert-warning py-2">User deleted.</div><?php endif; ?>
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr><th>#</th><th>Name</th><th>Email</th><th>Role</th><th>Orders</th><th>Joined</th><th>Actions</th></tr>
                </thead>
                <tbody>
                <?php foreach ($users as $u): ?>
                <tr>
                    <td>#<?= $u['id'] ?></td>
                    <td class="fw-semibold"><?= htmlspecialchars($u['name']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td>
                        <form method="POST" class="d-flex gap-2 align-items-center">
                            <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                            <select name="role" class="form-select form-select-sm" style="width:120px">
                                <option value="customer" <?= $u['role'] === 'customer' ? 'selected' : '' ?>>Customer</option>
                                <option value="admin" <?= $u['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                            </select>
                            <button class="btn btn-sm btn-primary">Save</button>
                        </form>
                    </td>
                    <td><?= $u['order_count'] ?></td>
                    <td><?= date('d M Y', strtotime($u['created_at'])) ?></td>
                    <td>
                        <?php if ($u['id'] !== $_SESSION['user']['id']): ?>
                        <a href="users.php?delete=<?= $u['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this user?')"><i class="bi bi-trash"></i></a>
                        <?php else: ?>
                        <span class="text-muted small">You</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
