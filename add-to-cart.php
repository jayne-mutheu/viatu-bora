<?php
session_start();
require 'db.php';

// 1. Force corporate authentication boundary: Users must possess active session logs
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// 2. Validate incoming resource parameters safely
if (!isset($_GET['product_id']) || empty($_GET['product_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = (int)$_GET['product_id'];

try {
    // 3. Verify that the culinary component exists and has available hardware stock
    $prodCheck = $pdo->prepare("SELECT stock FROM products WHERE id = ?");
    $prodCheck->execute([$product_id]);
    $product = $prodCheck->fetch();

    if (!$product) {
        // Redirect to main index with an invalid item parameter flag if missing
        header("Location: index.php");
        exit;
    }

    if ($product['stock'] <= 0) {
        // Drop safely out into the index catalog triggered as empty depletion status
        header("Location: index.php?msg=outofstock");
        exit;
    }

    // 4. Check if this specific kitchenware entity is already sitting in the client's ledger allocation
    $cartCheck = $pdo->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?");
    $cartCheck->execute([$user_id, $product_id]);
    $existing_item = $cartCheck->fetch();

    if ($existing_item) {
        // Increment processing matrix allocation by 1 unit step
        $new_quantity = $existing_item['quantity'] + 1;
        $updateStmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
        $updateStmt->execute([$new_quantity, $existing_item['id']]);
    } else {
        // Establish a fresh transactional record item row inside the cart compilation table
        $insertStmt = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)");
        $insertStmt->execute([$user_id, $product_id]);
    }

    // Redirect smoothly back to the index view with an active transaction flag banner triggered
    header("Location: index.php?msg=added");
    exit;

} catch (PDOException $e) {
    // Return structured text fallback for infrastructure faults matching enterprise guidelines
    die("Database transaction fault in core cart engine processing pipeline: " . $e->getMessage());
}
?>