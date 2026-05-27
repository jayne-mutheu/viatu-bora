<?php
session_start();
require 'db.php';

// Fetch all available shoes
try {
    $stmt = $pdo->query("SELECT * FROM products ORDER BY name ASC");
    $all_products = $stmt->fetchAll();
} catch (PDOException $e) {
    $all_products = [];
}

// 1. Merge the shared header configuration (handles global tags, base styles, and dynamic navigation)
require 'header.php';
?>

    <style>
        .product-card {
            border: 1px solid var(--border-color);
            border-radius: 0px;
            background: #ffffff;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 20px -5px rgba(0,0,0,0.05);
        }

        .card-image-viewport {
            background: #f1f5f9;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid var(--border-color);
        }
    </style>

    <main class="container my-5">
        <div class="pb-2 mb-4 border-bottom">
            <h3 class="fw-bold text-dark text-uppercase tracking-wide m-0">Our Shoe Collection</h3>
            <p class="text-muted small m-0 mt-1">Browse through our complete collection of active, formal, and everyday footwear styles.</p>
        </div>

        <div class="row g-4">
            <?php if (empty($all_products)): ?>
                <div class="col-12 text-center py-5 text-muted">
                    <p class="m-0 text-uppercase small">No products found in the database store.</p>
                </div>
            <?php else: ?>
                <?php foreach ($all_products as $product): ?>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="card product-card h-100">
                            <div class="card-image-viewport">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/></svg>
                            </div>
                            <div class="card-body p-3 d-flex flex-column">
                                <h6 class="fw-bold text-dark text-uppercase small mb-1 text-truncate"><?php echo htmlspecialchars($product['name']); ?></h6>
                                <p class="text-muted small flex-grow-1 mb-3" style="font-size:0.75rem; line-height:1.4;"><?php echo htmlspecialchars(substr($product['description'], 0, 75)) . '...'; ?></p>
                                
                                <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top">
                                    <span class="fw-bold text-dark small">$<?php echo number_format($product['price'], 2); ?></span>
                                    <div class="btn-group gap-1">
                                        <a href="view-product.php?id=<?php echo $product['id']; ?>" class="btn btn-flat-outline btn-sm px-2">View Details</a>
                                        <a href="add-to-cart.php?product_id=<?php echo $product['id']; ?>&quantity=1" class="btn btn-flat-accent btn-sm px-2">Add</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <footer class="bg-dark text-white-50 text-center py-4 mt-5 border-top border-secondary">
        <p class="mb-0 small text-uppercase tracking-wider">&copy; 2026 ViatuBora. All Rights Reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>