<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - JewelQuest</title>
    <link rel="stylesheet" href="../assets/css/forgot_password.css">
</head>
<body>
    <div class="forgot-password-container">
        <!-- Logo -->
        <div class="logo">
            <img src="../assets/images/logo.webp" alt="JewelQuest Logo" alt="JewelQuest Logo" alt="JewelQuest Logo">
        </div>

        <!-- Forgot Password Form -->
        <div class="form-header">
            <h2>Reset Your Password</h2>
            <p>Enter your registered email address, and we'll send you a link to reset your password.</p>
        </div>
        <form id="forgot-password-form" action="process_forgot_password.php" method="POST">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <button type="submit" class="btn">Send Reset Link</button>
            <p class="back-to-login"><a href="login.php">Back to Log in</a></p>
        </form>
    </div>
</body>
</html>
