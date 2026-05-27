<?php
session_start();
require 'admin-auth.php'; // 🔐 Protection Active
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'admin-header.php';
include 'sidebar.php';
?>

<main class="main-workspace">
    <div class="mb-5">
        <h2 class="page-title mb-1">Add New Catalog Item</h2>
        <p class="subtitle mb-0">Create and populate new records straight into your system inventory.</p>
    </div>

    <div class="row">
        <div class="col-xl-6 col-lg-8">
            <div class="card dashboard-card p-4 bg-white">
                <form action="insert-product.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-medium">Product Title</label>
                        <input type="text" name="name" class="form-control p-2" required placeholder="e.g., Wireless Mouse">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Detailed Description</label>
                        <textarea name="description" class="form-control p-2" rows="4" placeholder="Enter full specifications..."></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-medium">Price Metric ($)</label>
                            <input type="number" step="0.01" name="price" class="form-control p-2" required placeholder="0.00">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-medium">Starting Stock Allocation</label>
                            <input type="number" name="stock" class="form-control p-2" required placeholder="e.g., 50">
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-custom-primary w-100 py-2">Save New Product Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
</div>
</body>
</html>