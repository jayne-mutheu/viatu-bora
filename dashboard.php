<?php
session_start();
require 'admin-auth.php'; // 🔐 Protection Active
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    $deleteStmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $deleteStmt->execute([$delete_id]);
    header("Location: dashboard.php?msg=deleted");
    exit;
}

$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll();

include 'admin-header.php';
include 'sidebar.php';
?>

<main class="main-workspace">
    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
        <div class="alert alert-warning shadow-sm">Product record deleted successfully.</div>
    <?php endif; ?>
    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'updated'): ?>
        <div class="alert alert-success shadow-sm">Product specifications updated successfully.</div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="page-title mb-1">Inventory Dashboard</h2>
            <p class="subtitle mb-0">Manage your products, stock metrics, and system choice items.</p>
        </div>
        <a href="add-product.php" class="btn btn-custom-primary">+ Add Product</a>
    </div>

    <div class="card dashboard-card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Product</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($products)): ?>
                        <tr><td colspan="6" class="text-center p-5 text-muted">No products found.</td></tr>
                    <?php else: ?>
                        <?php foreach ($products as $item): ?>
                            <tr>
                                <td><strong>#<?php echo $item['id']; ?></strong></td>
                                <td><strong><?php echo htmlspecialchars($item['name']); ?></strong></td>
                                <td><?php echo htmlspecialchars($item['description']); ?></td>
                                <td><strong>$<?php echo number_format($item['price'], 2); ?></strong></td>
                                <td>
                                    <?php if ($item['stock'] > 10): ?>
                                        <span class="stock-high"><?php echo $item['stock']; ?> In Stock</span>
                                    <?php else: ?>
                                        <span class="stock-low"><?php echo $item['stock']; ?> Low Stock</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <a href="edit-product.php?id=<?php echo $item['id']; ?>" class="btn btn-edit btn-sm me-2">Edit</a>
                                    <a href="dashboard.php?delete_id=<?php echo $item['id']; ?>" class="btn btn-delete btn-sm" onclick="return confirm('Delete permanently?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
</div>
</body>
</html>