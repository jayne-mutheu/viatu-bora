<?php
header('Content-Type: text/plain');
session_start();
require 'db.php';

// Security Check: Make sure user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access Denied: You must be an administrator to run this script.");
}

echo "=== STARTING SHOE INVENTORY REFRESH ===\n\n";

try {
    echo "[!] Clearing old inventory items...\n";
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
    $pdo->exec("TRUNCATE TABLE products;");
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");
    echo "[+] Old inventory successfully cleared.\n\n";

    $shoes = [
        // Brand 1: Nike
        [
            'name' => 'Nike Air Max Elite Running Shoes',
            'description' => 'Premium sports shoes engineered with signature air cushioning for high-impact protection and everyday lightweight comfort.',
            'price' => 150.00,
            'stock' => 40
        ],
        [
            'name' => 'Nike Court Legacy Classic Sneakers',
            'description' => 'A tribute to historic tennis culture, featuring durable leather, retro stitching, and a low-profile fit perfect for daily casual wear.',
            'price' => 85.00,
            'stock' => 55
        ],
        [
            'name' => 'Nike Zoom Swift Track Runners',
            'description' => 'High-performance running shoes made with breathable fly-knit uppers and springy foam bases built to break speed records.',
            'price' => 130.00,
            'stock' => 25
        ],

        // Brand 2: Adidas
        [
            'name' => 'Adidas UltraBoost Pro Cushioned Shoes',
            'description' => 'World-famous running sneakers featuring an ultra-responsive boost midsole and a flexible knit upper that hugs your foot.',
            'price' => 180.00,
            'stock' => 30
        ],
        [
            'name' => 'Adidas Originals Retro Gazelle',
            'description' => 'Classic streetwear staple made from authentic soft suede material with the signature contrasting side stripes.',
            'price' => 100.00,
            'stock' => 45
        ],
        [
            'name' => 'Adidas Grand Court Tennis Sneakers',
            'description' => 'A clean and sleek lifestyle sneaker with a comfortable cloudfoam sockliner for all-day cushioning.',
            'price' => 75.00,
            'stock' => 60
        ],

        // Brand 3: Vans
        [
            'name' => 'Vans Old Skool Classic Skate Shoes',
            'description' => 'The timeless low-top skate shoe designed with durable canvas, suede panels, and iconic waffle rubber outsoles for maximum grip.',
            'price' => 70.00,
            'stock' => 80
        ],
        [
            'name' => 'Vans Sk8-Hi High-Top Street Sneakers',
            'description' => 'Legendary lace-up high-top shoes with padded collars for extra support and reinforced toe caps to withstand daily wear.',
            'price' => 85.00,
            'stock' => 35
        ],
        [
            'name' => 'Vans Classic Checkerboard Slip-On',
            'description' => 'The original laceless canvas sneaker featuring a low profile design, elastic side accents, and the iconic checkerboard pattern.',
            'price' => 65.00,
            'stock' => 90
        ]
    ];

    echo "[!] Adding new Nike, Adidas, and Vans items to the database...\n";
    $query = "INSERT INTO products (name, description, price, stock) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);

    $count = 0;
    foreach ($shoes as $shoe) {
        $stmt->execute([
            $shoe['name'],
            $shoe['description'],
            $shoe['price'],
            $shoe['stock']
        ]);
        $count++;
        echo "    -> Added: [" . $shoe['name'] . "]\n";
    }

    echo "\n[+] SUCCESS: " . $count . " new products successfully loaded into your shop catalog.";

} catch (PDOException $e) {
    die("\n[X] ERROR LOADING DATA: " . $e->getMessage());
}
?>