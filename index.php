<?php
session_start();
require 'db.php';

// Fetch the 3 newest arrivals for the homepage grid
try {
    $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC LIMIT 3");
    $featured_products = $stmt->fetchAll();
} catch (PDOException $e) {
    $featured_products = [];
}

// 1. Merge the shared header configuration (handles global tags, base styles, and dynamic navigation)
require 'header.php';
?>

    <style>
        .hero-banner {
            background: linear-gradient(180deg, rgba(9, 13, 22, 0.95) 0%, rgba(30, 41, 59, 0.85) 100%), 
                        url('https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=1920&auto=format&fit=crop') no-repeat center center;
            background-size: cover;
            color: white;
            padding: 140px 0;
            border-bottom: 4px solid var(--brand-accent);
        }

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
            height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid var(--border-color);
        }
    </style>

    <header class="hero-banner text-center">
        <div class="container">
            <span class="text-info text-uppercase fw-bold small tracking-wider d-block mb-2">// Welcome to ViatuBora</span>
            <h1 class="display-4 text-uppercase tracking-tight mb-3" style="font-weight:800;">Premium Footwear & Comfort</h1>
            <p class="lead text-white-50 max-w-2xl mx-auto mb-5 fs-6">Discover durable running sneakers, handmade leather dress shoes, and rugged outdoor boots designed for long-lasting wear.</p>
            <a href="products.php" class="btn btn-flat-accent btn-lg px-5 py-3">Browse Full Collection</a>
        </div>
    </header>

    <main class="container my-5">
        <div class="pb-2 mb-4 border-bottom d-flex justify-content-between align-items-end">
            <h4 class="fw-bold text-dark text-uppercase tracking-wide m-0">Our Newest Arrivals</h4>
            <a href="products.php" class="text-decoration-none small text-uppercase fw-semibold">See All Shoes &rarr;</a>
        </div>

        <div class="row g-4">
            <?php foreach ($featured_products as $product): ?>
                <div class="col-md-4">
                    <div class="card product-card h-100">
                        <div class="card-image-viewport">
                            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/></svg>
                        </div>
                        <div class="card-body p-4 d-flex flex-column">
                            <h5 class="card-title fw-bold text-dark text-uppercase small m-0 mb-2"><?php echo htmlspecialchars($product['name']); ?></h5>
                            <p class="card-text text-muted small flex-grow-1 text-truncate-2"><?php echo htmlspecialchars($product['description']); ?></p>
                            <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                                <span class="fs-5 fw-bold text-dark">$<?php echo number_format($product['price'], 2); ?></span>
                                <div class="btn-group gap-1">
                                    <a href="view-product.php?id=<?php echo $product['id']; ?>" class="btn btn-flat-outline btn-sm px-2">View Details</a>
                                    <a href="add-to-cart.php?product_id=<?php echo $product['id']; ?>&quantity=1" class="btn btn-flat-accent btn-sm px-2">Add to Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer class="bg-dark text-white-50 text-center py-4 mt-5 border-top border-secondary">
        <p class="mb-0 small text-uppercase tracking-wider">&copy; 2026 ViatuBora. All Rights Reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>