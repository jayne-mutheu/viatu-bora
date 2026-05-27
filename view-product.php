<?php
session_start();
require 'db.php';

// If no product ID is provided, go back to shop page
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: products.php");
    exit;
}

$product_id = (int)$_GET['id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();
    
    if (!$product) {
        die("Error: We couldn't find the shoe model you are looking for.");
    }
} catch (PDOException $e) {
    die("Database Connection Error: " . $e->getMessage());
}

// 1. Merge the shared header configuration (handles global tags, base styles, and dynamic navigation)
require 'header.php';
?>

    <style>
        .detail-card { border: 1px solid var(--border-color); border-radius: 0px; background: #ffffff; }

        .image-container-viewport {
            background: #f1f5f9;
            min-height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-right: 1px solid var(--border-color);
        }

        @media (max-width: 991.98px) {
            .image-container-viewport { border-right: none; border-bottom: 1px solid var(--border-color); min-height: 300px; }
        }

        .specs-table th { width: 30%; font-weight: 600; color: var(--brand-primary); text-transform: uppercase; font-size: 0.75rem; background: #f8fafc; }
        .badge-stock-indicator { padding: 6px 12px; border-radius: 0px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
    </style>

    <main class="container my-5">
        <div class="mb-4">
            <a href="products.php" class="text-decoration-none small text-uppercase fw-bold text-muted">&larr; Return to Shoe Catalog</a>
        </div>

        <div class="card detail-card overflow-hidden">
            <div class="row g-0">
                <div class="col-lg-6">
                    <div class="image-container-viewport">
                        <svg width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/></svg>
                    </div>
                </div>

                <div class="col-lg-6 p-5 d-flex flex-column justify-content-center">
                    <div class="mb-3">
                        <span class="text-info text-uppercase fw-bold small tracking-wider d-block mb-1">// Product Overview</span>
                        <h2 class="fw-bold text-dark text-uppercase m-0"><?php echo htmlspecialchars($product['name']); ?></h2>
                    </div>

                    <div class="d-flex align-items-center gap-3 mb-4">
                        <span class="fs-3 fw-bold text-dark">$<?php echo number_format($product['price'], 2); ?></span>
                        <div>
                            <?php if ($product['stock'] > 0): ?>
                                <span class="badge bg-dark text-white badge-stock-indicator">In Stock (<?php echo $product['stock']; ?> available)</span>
                            <?php else: ?>
                                <span class="badge bg-danger text-white badge-stock-indicator">Out of Stock</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <h6 class="text-uppercase fw-bold text-dark small mb-2">Item Description</h6>
                    <p class="text-muted small mb-4 lead" style="font-size: 0.95rem; line-height: 1.6;">
                        <?php echo htmlspecialchars($product['description']); ?>
                    </p>

                    <table class="table table-bordered specs-table mb-4 align-middle small">
                        <tbody>
                            <tr>
                                <th>Sole Type</th>
                                <td class="text-muted">Durable vulcanized non-slip rubber</td>
                            </tr>
                            <tr>
                                <th>Design Style</th>
                                <td class="text-muted">Comfort fit with padded interiors</td>
                            </tr>
                        </tbody>
                    </table>

                    <form action="add-to-cart.php" method="GET" class="row g-2">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        
                        <div class="col-sm-4">
                            <select name="quantity" class="form-select form-select-lg rounded-0 text-center small fs-6 h-100" style="border: 1px solid var(--border-color);" <?php echo ($product['stock'] <= 0) ? 'disabled' : ''; ?>>
                                <?php 
                                $max_selectable = min($product['stock'], 5);
                                for ($i = 1; $i <= $max_selectable; $i++): 
                                ?>
                                    <option value="<?php echo $i; ?>">Qty: <?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-flat-accent btn-lg w-100 py-3 text-uppercase" <?php echo ($product['stock'] <= 0) ? 'disabled' : ''; ?>>
                                <?php echo ($product['stock'] > 0) ? 'Add Item to Cart' : 'Currently Out of Stock'; ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-dark text-white-50 text-center py-4 mt-5 border-top border-secondary">
        <p class="mb-0 small text-uppercase tracking-wider">&copy; 2026 ViatuBora. All Rights Reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>