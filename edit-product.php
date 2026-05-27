<?php
session_start();
require 'admin-auth.php'; // 🔐 Protection Active
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$id = (int)$_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $updateStmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, stock = ? WHERE id = ?");
    $updateStmt->execute([$name, $description, $price, $stock, $id]);
    header("Location: dashboard.php?msg=updated");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

include 'admin-header.php';
include 'sidebar.php';
?>
<main class="main-workspace">
    <div class="mb-5">
        <h2 class="page-title mb-1">Edit Record Item #<?php echo $product['id']; ?></h2>
    </div>
    <div class="row">
        <div class="col-xl-6 col-lg-8">
            <div class="card dashboard-card p-4 bg-white">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Product Title</label>
                        <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="4"><?php echo htmlspecialchars($product['description']); ?></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3"><label class="form-label">Price</label><input type="number" step="0.01" name="price" class="form-control" value="<?php echo $product['price']; ?>" required></div>
                        <div class="col-md-6 mb-3"><label class="form-label">Stock</label><input type="number" name="stock" class="form-control" value="<?php echo $product['stock']; ?>" required></div>
                    </div>
                    <button type="submit" class="btn btn-custom-primary w-100 py-2">Update Product Specifications</button>
                </form>
            </div>
        </div>
    </div>
</main>
</div>
</body>
</html>