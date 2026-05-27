<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    if (!empty($name) && isset($price) && isset($stock)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO products (name, description, price, stock) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$name, $description, $price, $stock])) {
                header("Location: dashboard.php?msg=updated");
                exit;
            }
        } catch (PDOException $e) {
            die("Transaction Error: " . $e->getMessage());
        }
    }
}
header("Location: add-product.php");
exit;
?>