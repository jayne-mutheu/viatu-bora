<?php
require 'db.php';
session_start();
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            // Save the role directly into the session pipeline
            $_SESSION['role'] = $user['role']; 
 
            // Redirect based on role entry match
            if ($_SESSION['role'] === 'admin') {
                header("Location: dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            $message = "<div class='alert alert-danger'>Invalid credentials.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5 pt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow-sm p-4">
                    <h3 class="text-center mb-4">Sign In</h3>
                    <?php echo $message; ?>
                    
                    <form method="POST" id="loginForm" novalidate>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" id="login-username" name="username" class="form-control" required>
                            <div class="invalid-feedback">Please enter your username.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" id="login-password" name="password" class="form-control" required>
                            <div class="invalid-feedback">Please enter your password.</div>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Login</button>
                    </form>
                    <p class="text-center mt-3 small">New here? <a href="register.php">Register</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('loginForm');
            const username = document.getElementById('login-username');
            const password = document.getElementById('login-password');

            form.addEventListener('submit', function(event) {
                let isValid = true;

                if (username.value.trim() === '') {
                    username.classList.add('is-invalid');
                    isValid = false;
                } else {
                    username.classList.remove('is-invalid');
                }

                if (password.value.trim() === '') {
                    password.classList.add('is-invalid');
                    isValid = false;
                } else {
                    password.classList.remove('is-invalid');
                }

                if (!isValid) {
                    event.preventDefault();
                }
            });

            // Dynamic Input Handling: Remove red border when user starts typing
            username.addEventListener('input', () => username.classList.remove('is-invalid'));
            password.addEventListener('input', () => password.classList.remove('is-invalid'));
        });
    </script>
</body>
</html>