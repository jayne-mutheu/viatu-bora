<?php
require 'db.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($username) && !empty($email) && !empty($password)) {
        // Securely hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            if ($stmt->execute([$username, $email, $hashed_password])) {
                $message = "<div class='alert alert-success'>Registration successful! <a href='login.php'>Login here</a></div>";
            }
        } catch (PDOException $e) {
            $message = "<div class='alert alert-danger'>Username or Email already exists.</div>";
        }
    } else {
        $message = "<div class='alert alert-warning'>Please fill in all fields.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - E-commerce System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .password-meter { height: 8px; border-radius: 4px; transition: width 0.3s ease, background-color 0.3s ease; }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow-sm mt-5">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Create Account</h3>
                        <?php echo $message; ?>
                        
                        <form action="register.php" method="POST" id="registerForm" novalidate>
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" id="username" name="username" class="form-control" required>
                                <div class="invalid-feedback">Username must be at least 3 characters.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Email address</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                                <div class="invalid-feedback">Please enter a valid email address.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                                <div class="invalid-feedback">Password is required.</div>
                                
                                <div class="mt-2">
                                    <div class="progress" style="height: 8px;">
                                        <div id="strength-bar" class="progress-bar password-meter" role="progressbar" style="width: 0%;"></div>
                                    </div>
                                    <small id="strength-text" class="text-muted mt-1 d-block">Password strength</small>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">Register</button>
                        </form>
                        <p class="text-center mt-3 small">Already have an account? <a href="login.php">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('registerForm');
            const username = document.getElementById('username');
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const strengthBar = document.getElementById('strength-bar');
            const strengthText = document.getElementById('strength-text');

            // 1. Password Strength Checker (Dynamic Handling)
            password.addEventListener('input', function() {
                const val = password.value;
                let strength = 0;
                
                if (val.length >= 6) strength += 1;
                if (val.match(/[A-Z]/)) strength += 1;
                if (val.match(/[0-9]/)) strength += 1;
                if (val.match(/[^a-zA-Z0-9]/)) strength += 1;

                if (val.length === 0) {
                    strengthBar.style.width = '0%';
                    strengthText.innerText = 'Password strength';
                    strengthText.className = 'text-muted mt-1 d-block';
                } else if (strength <= 1) {
                    strengthBar.style.width = '33%';
                    strengthBar.className = 'progress-bar bg-danger password-meter';
                    strengthText.innerText = 'Weak';
                    strengthText.className = 'text-danger mt-1 d-block';
                } else if (strength === 2 || strength === 3) {
                    strengthBar.style.width = '66%';
                    strengthBar.className = 'progress-bar bg-warning password-meter';
                    strengthText.innerText = 'Medium';
                    strengthText.className = 'text-warning mt-1 d-block';
                } else {
                    strengthBar.style.width = '100%';
                    strengthBar.className = 'progress-bar bg-success password-meter';
                    strengthText.innerText = 'Strong';
                    strengthText.className = 'text-success mt-1 d-block';
                }
            });

            // 2. Form Validation on Submit
            form.addEventListener('submit', function(event) {
                let isValid = true;

                // Username validation
                if (username.value.trim().length < 3) {
                    username.classList.add('is-invalid');
                    isValid = false;
                } else {
                    username.classList.remove('is-invalid');
                    username.classList.add('is-valid');
                }

                // Email validation using Regex
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email.value.trim())) {
                    email.classList.add('is-invalid');
                    isValid = false;
                } else {
                    email.classList.remove('is-invalid');
                    email.classList.add('is-valid');
                }

                // Password validation
                if (password.value.trim().length < 6) {
                    password.classList.add('is-invalid');
                    isValid = false;
                } else {
                    password.classList.remove('is-invalid');
                    password.classList.add('is-valid');
                }

                // Prevent submission if form is invalid
                if (!isValid) {
                    event.preventDefault();
                    event.stopPropagation();
                }
            });
            
            // Dynamic clearing of error states on typing
            [username, email, password].forEach(input => {
                input.addEventListener('input', () => {
                    input.classList.remove('is-invalid');
                });
            });
        });
    </script>
</body>
</html>