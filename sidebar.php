<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$current_page = basename($_SERVER['PHP_SELF']);
?>
<aside class="sidebar-aside">
    <div class="w-100">
        <div class="sidebar-brand">
            📦 E-Shop Manager
        </div>
        <div class="sidebar-menu">
            <a href="dashboard.php" class="sidebar-link <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
                <span class="me-2">📊</span> Inventory Dashboard
            </a>
            <a href="add-product.php" class="sidebar-link <?php echo ($current_page == 'add-product.php') ? 'active' : ''; ?>">
                <span class="me-2">➕</span> Add New Product
            </a>
            <a href="admin-carts.php" class="sidebar-link <?php echo ($current_page == 'admin-carts.php') ? 'active' : ''; ?>">
                <span class="me-2">🛒</span> Customer Carts
            </a>
            <a href="index.php" class="sidebar-link">
                <span class="me-2">🛍️</span> View Public Store
            </a>
        </div>
    </div>
    
    <div class="sidebar-footer">
        <div class="small text-muted mb-1">Signed in as:</div>
        <div class="text-white text-truncate mb-3 fw-semibold"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
        <a href="logout.php" class="btn btn-danger btn-sm w-100 rounded-pill py-2 fw-medium">Logout</a>
    </div>
</aside>