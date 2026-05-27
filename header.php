<?php
// Ensure a session is active before checking variables
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
$is_logged_in = isset($_SESSION['user_id']);
$username = $is_logged_in ? $_SESSION['username'] : '';
$is_admin = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');

// Helper function to mark the active page in the navbar
function is_active($page_name) {
    return (basename($_SERVER['PHP_SELF']) == $page_name) ? 'active' : 'text-white-50';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ViatuBora | Premium Footwear</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand-primary: #090d16;
            --brand-accent: #0284c7;
            --surface-bg: #f8fafc;
            --border-color: #e2e8f0;
            --text-dark: #1e293b;
        }

        body { 
            background: var(--surface-bg); 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            color: var(--text-dark);
        }
        
        .navbar-custom { 
            background: var(--brand-primary); 
            padding: 18px 0;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .brand-logo-text { letter-spacing: 1.5px; font-weight: 800; }
        
        /* Premium Global Button Layout Styles */
        .btn-flat-accent {
            background: var(--brand-accent);
            color: white;
            border-radius: 0px;
            border: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }
        .btn-flat-accent:hover { background: #0369a1; color: white; }

        .btn-flat-outline {
            border: 1px solid var(--brand-primary);
            color: var(--brand-primary);
            border-radius: 0px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            background: transparent;
            letter-spacing: 0.5px;
        }
        .btn-flat-outline:hover { background: var(--brand-primary); color: white; }
    </style>
</head>
<body>

    <!-- Dynamic Global Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 brand-logo-text fs-4" href="index.php">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-info"><path d="M3 21h18M4 18h16M7 14h1M16 14h1M8 10h8M9 6h6"/></svg>
                VIATU<span class="text-info">BORA</span>
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#storeNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="storeNavbar">
                <ul class="navbar-nav align-items-center gap-2">
                    
                    <!-- Public Links (Always Visible) -->
                    <li class="nav-item">
                        <a class="nav-link text-white px-3 small text-uppercase <?php echo is_active('index.php'); ?>" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 small text-uppercase <?php echo is_active('products.php'); ?>" href="products.php">Shop Shoes</a>
                    </li>

                    <?php if ($is_logged_in): ?>
                        <!-- Logged-In User Links -->
                        <li class="nav-item">
                            <a class="nav-link px-3 small text-uppercase <?php echo is_active('cart.php'); ?>" href="cart.php">My Cart</a>
                        </li>
                        
                       

                        <!-- User Profile Status & Logout -->
                        <li class="nav-item ms-lg-3 py-2 py-lg-0">
                            <span class="text-white-50 small me-2 d-block d-lg-inline-block">
                                Hello, <strong class="text-info"><?php echo htmlspecialchars($username); ?></strong>
                            </span>
                            <a class="btn btn-outline-danger btn-sm rounded-0 px-3 text-uppercase font-weight-bold" style="font-size: 0.7rem;" href="logout.php">Logout</a>
                        </li>

                    <?php else: ?>
                        <!-- Guest Links (Not Logged In) -->
                        <li class="nav-item ms-lg-3 py-2 py-lg-0">
                            <a class="btn btn-outline-light btn-sm rounded-0 px-3 text-uppercase me-2" style="font-size: 0.7rem;" href="login.php">Login</a>
                            <a class="btn btn-info btn-sm rounded-0 px-3 text-uppercase text-dark font-weight-bold" style="font-size: 0.7rem;" href="register.php">Register</a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </nav>