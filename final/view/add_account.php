<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Another Account - JewelQuest</title>
    <link rel="stylesheet" href="../assets/css/add_account.css">
</head>
<body>
    <div class="container">
        <h1>Add Another Account</h1>
        <form action="save_account.php" method="POST">
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
            <button type="submit" class="btn">Add Account</button>
        </form>
        <a href="profile.html" class="back-link">Go Back to Profile</a>
    </div>
</body>
</html>
