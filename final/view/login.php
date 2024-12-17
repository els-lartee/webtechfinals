<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - JewelQuest</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
    <div class="login-container">
        <!-- Logo -->
        <div class="logo">
            <img src="../assets/images/logo.webp" alt="JewelQuest Logo">
        </div>

        <!-- Login Form -->
        <div class="form-header">
            <h2>Welcome Back!</h2>
            <p>Log in to explore the world of exquisite jewelry.</p>
        </div>
        <?php
        if (isset($_SESSION['errors'])) {
            echo '<div class="error-messages">';
            foreach ($_SESSION['errors'] as $error) {
                echo '<p>' . htmlspecialchars($error) . '</p>';
            }
            echo '</div>';
            unset($_SESSION['errors']);
        }
        ?>
        <form id="login-form" action="../actions/login.php" method="POST">
            <div class="form-group">
                <label for="identifier">Username or Email</label>
                <input type="text" id="identifier" name="identifier" placeholder="Enter your username or email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn">Log In</button>
            <p class="forgot-password">
                <a href="forgot_password.php">Forgot Password?</a>
            </p>
            <p class="signup-link">Don't have an account? <a href="signup.php">Sign up</a></p>
        </form>
    </div>
</body>
</html>
