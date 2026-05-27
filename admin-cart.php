<?php
session_start();
require 'admin-auth.php'; // 🔐 Protection Active
require 'db.php';

// Security check: Only logged-in users (admins) can view this
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

try {
    // SQL JOIN to fetch cart details along with user details and product details
    $query = "SELECT 
                cart.id AS cart_id, 
                users.username, 
                users.email, 
                products.name AS product_name, 
                products.price, 
                cart.quantity, 
                cart.added_at 
              FROM cart
              INNER JOIN users ON cart.user_id = users.id
              INNER JOIN products ON cart.product_id = products.id
              ORDER BY cart.added_at DESC";
              
    $stmt = $pdo->query($query);
    $cart_items = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}

include 'admin-header.php';
include 'sidebar.php';
?>

<main class="main-workspace">
    <div class="mb-5">
        <h2 class="page-title mb-1">Customer Active Carts</h2>
        <p class="subtitle mb-0">Monitor what items customers have currently placed in their shopping carts.</p>
    </div>

    <div class="card dashboard-card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Date Added</th>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Product Item</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total Value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($cart_items)): ?>
                        <tr>
                            <td colspan="7" class="text-center p-5 text-muted">
                                No active customer carts found at the moment.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($cart_items as $item): ?>
                            <tr>
                                <td class="small text-muted"><?php echo date('M d, Y H:i', strtotime($item['added_at'])); ?></td>
                                <td><strong><?php echo htmlspecialchars($item['username']); ?></strong></td>
                                <td><?php echo htmlspecialchars($item['email']); ?></td>
                                <td><span class="badge bg-secondary-subtle text-dark p-2">📦 <?php echo htmlspecialchars($item['product_name']); ?></span></td>
                                <td>$<?php echo number_format($item['price'], 2); ?></td>
                                <td><strong>x<?php echo $item['quantity']; ?></strong></td>
                                <td class="text-primary fw-bold">
                                    $<?php echo number_format($item['price'] * $item['quantity'], 2); ?>
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