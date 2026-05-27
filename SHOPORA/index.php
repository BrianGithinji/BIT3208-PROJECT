<?php
session_start();
require 'db.php';
$pageTitle = 'SmartShop - Home';

// Filters
$search = trim($_GET['search'] ?? '');
$cat_id = (int)($_GET['category'] ?? 0);
$sort   = $_GET['sort'] ?? 'newest';

// Categories
$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();

// Products query
$where = ['1=1'];
$params = [];
if ($search) { $where[] = 'p.name LIKE :search'; $params[':search'] = "%$search%"; }
if ($cat_id) { $where[] = 'p.category_id = :cat'; $params[':cat'] = $cat_id; }
$orderBy = match($sort) {
    'price_asc'  => 'p.price ASC',
    'price_desc' => 'p.price DESC',
    'name'       => 'p.name ASC',
    default      => 'p.created_at DESC'
};
$sql = "SELECT p.*, c.name AS category FROM products p LEFT JOIN categories c ON p.category_id = c.id
        WHERE " . implode(' AND ', $where) . " ORDER BY $orderBy";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();

// Add to cart (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $pid = (int)$_POST['product_id'];
    if (!isset($_SESSION['cart'][$pid])) $_SESSION['cart'][$pid] = ['qty' => 0];
    $_SESSION['cart'][$pid]['qty']++;
    header('Location: index.php?' . http_build_query($_GET));
    exit;
}

include 'includes/header.php';
?>

<?php if (!($search || $cat_id)): ?>
<section class="hero text-center">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3">Welcome to Shopora</h1>
        <p class="lead mb-4">Discover amazing products at unbeatable prices</p>
        <a href="#catalog" class="btn btn-light btn-lg px-5">Shop Now</a>
    </div>
</section>
<?php endif; ?>

<div class="container py-5" id="catalog">
    <div class="row g-4">
        <!-- Sidebar Filters -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm p-3 sidebar-filter">
                <h6 class="fw-bold mb-3"><i class="bi bi-funnel"></i> Filters</h6>
                <form method="GET">
                    <div class="mb-3">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search products..." value="<?= htmlspecialchars($search) ?>" id="live-search">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Category</label>
                        <?php foreach ($categories as $cat): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="<?= $cat['id'] ?>" id="cat<?= $cat['id'] ?>" <?= $cat_id == $cat['id'] ? 'checked' : '' ?> onchange="this.form.submit()">
                            <label class="form-check-label small" for="cat<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></label>
                        </div>
                        <?php endforeach; ?>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="0" <?= !$cat_id ? 'checked' : '' ?> onchange="this.form.submit()">
                            <label class="form-check-label small">All Categories</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Sort By</label>
                        <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="newest" <?= $sort==='newest'?'selected':'' ?>>Newest</option>
                            <option value="price_asc" <?= $sort==='price_asc'?'selected':'' ?>>Price: Low to High</option>
                            <option value="price_desc" <?= $sort==='price_desc'?'selected':'' ?>>Price: High to Low</option>
                            <option value="name" <?= $sort==='name'?'selected':'' ?>>Name A-Z</option>
                        </select>
                    </div>
                    <?php if ($search || $cat_id): ?>
                    <a href="index.php" class="btn btn-outline-secondary btn-sm w-100">Clear Filters</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0"><?= count($products) ?> Product<?= count($products) != 1 ? 's' : '' ?> Found</h5>
            </div>
            <?php if (empty($products)): ?>
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-search fs-1"></i>
                    <p class="mt-2">No products found. <a href="index.php">Browse all</a></p>
                </div>
            <?php else: ?>
            <div class="row g-3">
                <?php foreach ($products as $p): ?>
                <div class="col-sm-6 col-xl-4 product-card-wrap" data-name="<?= htmlspecialchars($p['name']) ?>">
                    <div class="card product-card h-100 shadow-sm">
                        <img src="<?= htmlspecialchars($p['image'] ?? 'https://via.placeholder.com/400x200?text=No+Image') ?>" class="card-img-top" alt="<?= htmlspecialchars($p['name']) ?>">
                        <div class="card-body d-flex flex-column">
                            <span class="badge-category mb-2"><?= htmlspecialchars($p['category'] ?? 'Uncategorized') ?></span>
                            <h6 class="card-title fw-semibold"><?= htmlspecialchars($p['name']) ?></h6>
                            <p class="card-text text-muted small flex-grow-1"><?= htmlspecialchars(substr($p['description'], 0, 80)) ?>...</p>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <span class="fw-bold text-primary fs-5">KES <?= number_format($p['price'], 2) ?></span>
                                <small class="text-muted"><?= $p['stock'] ?> left</small>
                            </div>
                            <?php if ($p['stock'] > 0): ?>
                            <form method="POST" class="mt-2">
                                <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                                <button type="submit" name="add_to_cart" class="btn btn-primary btn-sm w-100">
                                    <i class="bi bi-cart-plus"></i> Add to Cart
                                </button>
                            </form>
                            <?php else: ?>
                            <button class="btn btn-secondary btn-sm w-100 mt-2" disabled>Out of Stock</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
