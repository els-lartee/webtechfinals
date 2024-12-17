<?php
session_start();
require_once '../classes/User.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: ../index.php');
    exit();
}

$db = new Database();
$boardId = $_GET['id'];
$board = $db->fetch('boards', "id = $boardId");

if (!$board) {
    header('Location: ../index.php');
    exit();
}

$user = new User();
$boardOwner = $user->getUserById($board['user_id']);
$isFollowing = $user->isFollowing($_SESSION['user_id'], $board['user_id']);
$isPinned = $user->hasPinnedImage($_SESSION['user_id'], $boardId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Board Details - JewelQuest</title>
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="stylesheet" href="../assets/css/board.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo-section">
            <div class="logo">
                <img src="../assets/images/logo.webp" alt="JewelQuest Logo">
            </div>
            <div class="nav-buttons">
                <a href="../index.php" class="home-button">Home</a>
                <a href="create.php" class="create-button">Create</a>
            </div>
        </div>
        <div class="user-actions">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="userprofile.php" class="profile-button">Profile</a>
                <a href="../actions/logout.php" class="logout-button">Logout</a>
            <?php else: ?>
                <a href="login.php" class="login-button">Login</a>
                <a href="signup.php" class="signup-button">Sign Up</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="board-details">
        
        <img src="<?php echo htmlspecialchars($board['image']); ?>" alt="Board Image">
        
        <div class="user-info">
                <div class="board-owner">
                    <div class="owner-info">
                        <img src="<?php echo htmlspecialchars($boardOwner['profile_picture']); ?>" alt="Profile Picture">
                        <span>
                            Posted by
                            <?php echo htmlspecialchars($boardOwner['username']); ?>
                        </span>
                    </div>
                    <?php if ($_SESSION['user_id'] !== $boardOwner['id']): ?>
                        <button class="follow-button" 
                                onclick="<?php echo $isFollowing ? 'unfollowUser' : 'followUser' ?>(<?php echo $boardOwner['id'] ?>)">
                            <?php echo $isFollowing ? 'Unfollow' : 'Follow' ?>
                        </button>
                    <?php endif; ?>
                </div>
        </div>
        <div class="board-actions">
            <?php if ($_SESSION['user_id'] !== $boardOwner['id']): ?>
                <button class="pin-button <?php echo $isPinned ? 'pinned' : ''; ?>" 
                        onclick="handlePin(<?php echo $boardId; ?>)" 
                        <?php echo $isPinned ? 'disabled' : ''; ?>>
                    <i class="fas fa-thumbtack"></i>
                    <?php echo $isPinned ? 'Pinned' : 'Pin'; ?>
                </button>
            <?php endif; ?>
        </div>
    </div>
    <script src="../assets/js/follow.js"></script>
    <script src="../assets/js/pins.js"></script>
</body>
</html>