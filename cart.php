<?php
session_start();
require 'db.php';

// Send user to login if they are not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Remove an item from the cart logic
if (isset($_GET['remove_id'])) {
    $remove_id = (int)$_GET['remove_id'];
    $deleteStmt = $pdo->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
    $deleteStmt->execute([$remove_id, $user_id]);
    header("Location: cart.php?msg=removed");
    exit;
}

// Fetch user's cart items from database
try {
    $query = "SELECT cart.id AS cart_id, products.name, products.price, cart.quantity 
              FROM cart 
              INNER JOIN products ON cart.product_id = products.id 
              WHERE cart.user_id = ? 
              ORDER BY cart.id DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_id]);
    $cart_items = $stmt->fetchAll();
} catch (PDOException $e) {
    $cart_items = [];
}

// Calculate the grand total price
$grand_total = 0;
foreach ($cart_items as $item) {
    $grand_total += ($item['price'] * $item['quantity']);
}

// 1. Merge the shared header configuration (handles global tags, base styles, and dynamic navigation)
require 'header.php';
?>

    <style>
        .cart-card, .summary-card { border: 1px solid var(--border-color); border-radius: 0px; background: #ffffff; }
        .summary-card { border-top: 4px solid var(--brand-accent); }
        .table-custom-matte th { background: #f1f5f9; color: var(--brand-primary); font-weight: 600; text-transform: uppercase; font-size: 0.75rem; padding: 12px; border-bottom: 1px solid var(--border-color); }
        .table-custom-matte td { padding: 16px 12px; border-bottom: 1px solid var(--border-color); }
    </style>

    <main class="container my-5">
        <div class="pb-2 mb-4 border-bottom">
            <h3 class="fw-bold text-dark text-uppercase tracking-wide m-0">Your Shopping Cart</h3>
        </div>

        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'removed'): ?>
            <div class="alert alert-danger rounded-0 border-0 text-uppercase small">Item has been removed from your shopping cart.</div>
        <?php endif; ?>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card cart-card p-4">
                    <div class="table-responsive">
                        <table class="table table-custom-matte align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Shoe Model</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($cart_items)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5" class="mb-3"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                                            <h6 class="text-dark fw-semibold text-uppercase m-0 mb-1">Your cart is empty</h6>
                                            <p class="small text-muted mb-3">You haven't added any shoes to your shopping list yet.</p>
                                            <a href="products.php" class="btn btn-flat-primary btn-sm px-4">Browse Shoe Catalog</a>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($cart_items as $item): ?>
                                        <tr>
                                            <td>
                                                <span class="fw-semibold text-dark text-uppercase small"><?php echo htmlspecialchars($item['name']); ?></span>
                                            </td>
                                            <td class="small">$<?php echo number_format($item['price'], 2); ?></td>
                                            <td>
                                                <span class="bg-light text-dark border p-1 px-2 small fw-medium">x<?php echo $item['quantity']; ?></span>
                                            </td>
                                            <td class="fw-bold text-dark small">$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                                            <td class="text-center">
                                                <a href="cart.php?remove_id=<?php echo $item['cart_id']; ?>" 
                                                   class="btn btn-sm btn-flat-outline-danger px-3" 
                                                   onclick="return confirm('Are you sure you want to remove this item from your cart?');">
                                                     Remove
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card summary-card p-4">
                    <h5 class="fw-bold text-dark text-uppercase tracking-wider mb-3">Order Summary</h5>
                    
                    <div class="d-flex justify-content-between align-items-center mb-2 text-muted small">
                        <span>Distinct Shoe Models:</span>
                        <strong class="text-dark"><?php echo count($cart_items); ?> unique item(s)</strong>
                    </div>
                    
                    <hr class="text-muted my-3">
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="text-dark fw-medium small text-uppercase">Total Price:</span>
                        <span class="fs-3 fw-bold text-brand-primary" style="color: var(--brand-primary);">$<?php echo number_format($grand_total, 2); ?></span>
                    </div>
                    
                    <button class="btn btn-flat-accent btn-lg w-100 py-3" 
                            onclick="alert('Checkout completed! Thank you for your purchase.')" 
                            <?php echo empty($cart_items) ? 'disabled' : ''; ?>>
                        Proceed to Checkout
                    </button>
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