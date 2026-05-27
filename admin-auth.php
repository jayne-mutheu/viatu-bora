<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in AND if they have an admin role
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Stop unauthorized users and send them back to the shop
    header("Location: index.php?error=unauthorized");
    exit;
}
?>