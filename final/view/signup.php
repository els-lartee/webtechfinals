<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - JewelQuest</title>
    <link rel="stylesheet" href="../assets/css/signup.css">
</head>
<body>
    <div class="signup-container">
        <div class="logo">
            <img src="../assets/images/logo.webp" alt="JewelQuest Logo">
        </div>
        <div class="form-header">
            <h2>Create Your Account</h2>
            <p>Join JewelQuest and explore stunning collections.</p>
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
        if (isset($_SESSION['success'])) {
            echo '<div class="success-message">';
            echo '<p>' . htmlspecialchars($_SESSION['success']) . '</p>';
            echo '</div>';
            unset($_SESSION['success']);
        }
        ?>
        <form id="signup-form" action="../actions/register.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm_password" placeholder="Confirm your password" required>
            </div>
            <button type="submit" class="btn">Sign Up</button>
            <p class="login-link">Already have an account? <a href="login.php">Log in</a></p>
        </form>
    </div>

    <script src="../assets/js/script.js"></script>
</body>
</html>
