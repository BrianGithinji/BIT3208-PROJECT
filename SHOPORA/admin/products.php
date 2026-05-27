<?php
require 'auth_check.php';
require '../db.php';
$pageTitle = 'Manage Products - Admin';
$rootPath = '../';

$action = $_GET['action'] ?? 'list';
$editId = (int)($_GET['id'] ?? 0);
$errors = [];
$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $desc     = trim($_POST['description'] ?? '');
    $price    = (float)($_POST['price'] ?? 0);
    $stock    = (int)($_POST['stock'] ?? 0);
    $cat_id   = (int)($_POST['category_id'] ?? 0);
    $image    = trim($_POST['image'] ?? '');

    if (!$name)    $errors[] = 'Product name is required.';
    if ($price <= 0) $errors[] = 'Price must be greater than 0.';

    if (empty($errors)) {
        if ($_POST['form_action'] === 'add') {
            $pdo->prepare("INSERT INTO products (name, description, price, stock, category_id, image) VALUES (?,?,?,?,?,?)")
                ->execute([$name, $desc, $price, $stock, $cat_id ?: null, $image]);
        } else {
            $pid = (int)$_POST['product_id'];
            $pdo->prepare("UPDATE products SET name=?, description=?, price=?, stock=?, category_id=?, image=? WHERE id=?")
                ->execute([$name, $desc, $price, $stock, $cat_id ?: null, $image, $pid]);
        }
        header('Location: products.php?saved=1'); exit;
    }
}

// Delete
if ($action === 'delete' && $editId) {
    $pdo->prepare("DELETE FROM products WHERE id=?")->execute([$editId]);
    header('Location: products.php?deleted=1'); exit;
}

// Fetch for edit
$editProduct = null;
if ($action === 'edit' && $editId) {
    $editProduct = $pdo->prepare("SELECT * FROM products WHERE id=?");
    $editProduct->execute([$editId]);
    $editProduct = $editProduct->fetch();
}

// Product list
$products = $pdo->query("SELECT p.*, c.name AS category FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC")->fetchAll();

include '../includes/header.php';
?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0"><i class="bi bi-box-seam"></i> Products</h3>
        <a href="products.php?action=add" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Add Product</a>
    </div>

    <?php if (isset($_GET['saved'])): ?><div class="alert alert-success py-2">Product saved successfully.</div><?php endif; ?>
    <?php if (isset($_GET['deleted'])): ?><div class="alert alert-warning py-2">Product deleted.</div><?php endif; ?>

    <?php if ($action === 'add' || $action === 'edit'): ?>
    <div class="card border-0 shadow-sm p-4 mb-4">
        <h5 class="fw-semibold mb-3"><?= $action === 'add' ? 'Add New Product' : 'Edit Product' ?></h5>
        <?php foreach ($errors as $e): ?><div class="alert alert-danger py-2"><?= htmlspecialchars($e) ?></div><?php endforeach; ?>
        <form method="POST" class="needs-validation" novalidate>
            <input type="hidden" name="form_action" value="<?= $action ?>">
            <?php if ($editProduct): ?><input type="hidden" name="product_id" value="<?= $editProduct['id'] ?>"><?php endif; ?>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Product Name *</label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($editProduct['name'] ?? '') ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Price (KES) *</label>
                    <input type="number" name="price" class="form-control" step="0.01" min="0.01" value="<?= $editProduct['price'] ?? '' ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Stock</label>
                    <input type="number" name="stock" class="form-control" min="0" value="<?= $editProduct['stock'] ?? 0 ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select">
                        <option value="">-- Select Category --</option>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= ($editProduct['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Image URL</label>
                    <input type="url" name="image" class="form-control" value="<?= htmlspecialchars($editProduct['image'] ?? '') ?>" placeholder="https://...">
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($editProduct['description'] ?? '') ?></textarea>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Save Product</button>
                    <a href="products.php" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr><th>ID</th><th>Image</th><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Actions</th></tr>
                </thead>
                <tbody>
                <?php foreach ($products as $p): ?>
                <tr>
                    <td>#<?= $p['id'] ?></td>
                    <td><img src="<?= htmlspecialchars($p['image'] ?? '') ?>" style="width:50px;height:50px;object-fit:cover;border-radius:6px" alt=""></td>
                    <td class="fw-semibold"><?= htmlspecialchars($p['name']) ?></td>
                    <td><?= htmlspecialchars($p['category'] ?? '-') ?></td>
                    <td>KES <?= number_format($p['price'], 2) ?></td>
                    <td><span class="badge bg-<?= $p['stock'] > 5 ? 'success' : ($p['stock'] > 0 ? 'warning' : 'danger') ?>"><?= $p['stock'] ?></span></td>
                    <td>
                        <a href="products.php?action=edit&id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        <a href="products.php?action=delete&id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this product?')"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
