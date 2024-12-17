<?php
session_start();
require_once '../classes/User.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user_id'];
$user = new User();
$userData = $user->getUserById($userId);
$userBoards = $user->getUserBoards($userId);
$userPins = $user->getUserPins($userId);
$userFollowers = $user->getUserFollowers($userId);
$userFollowing = $user->getUserFollowing($userId);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - JewelQuest</title>
    <link rel="stylesheet" href="../assets/css/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <!-- Navbar -->
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
            <button onclick="window.location.href = '../actions/logout.php'">Logout</button>
        </div>
    </nav>

    <!-- Profile Header -->
    <div class="profile-header">
        <div class="profile-picture-container">
            <img src="<?php echo htmlspecialchars($userData['profile_picture']); ?>" alt="Profile Picture" id="profile-picture">
            <div class="edit-overlay" id="edit-overlay">
                <button onclick="document.getElementById('profile-picture-input').click()">Edit</button>
            </div>
            <form id="profile-picture-form" action="../actions/upload_profile_picture.php" method="POST" enctype="multipart/form-data" style="display: none;">
                <input type="file" id="profile-picture-input" name="profile_picture" accept="image/*" onchange="uploadProfilePicture()">
                <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
            </form>
        </div>
        <div class="username"><?php echo htmlspecialchars($userData['username']); ?></div>
        <div class="bio"><?php echo htmlspecialchars($userData['bio']); ?></div>
        <div class="stats">
            <div><strong>Boards:</strong> <?php echo count($userBoards); ?></div>
            <div><strong>Pins:</strong> <?php echo count($userPins); ?></div>
            <div><strong>Followers:</strong> <?php echo count($userFollowers); ?></div>
            <div><strong>Following:</strong> <?php echo count($userFollowing); ?></div>
        </div>
        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] !== $userId): ?>
            <?php $isFollowing = $user->isFollowing($_SESSION['user_id'], $userId); ?>
            <button class="follow-button" 
                    onclick="<?php echo $isFollowing ? 'unfollowUser' : 'followUser' ?>(<?php echo $userId ?>)">
                <?php echo $isFollowing ? 'Unfollow' : 'Follow' ?>
            </button>
        <?php endif; ?>
    </div>

    <!-- Profile Tabs -->
    <div class="profile-tabs">
        <a href="#" class="active" id="boards-tab" onclick="switchToBoards()">Boards</a>
        <a href="#" id="pins-tab" onclick="switchToPins()">Pins</a>
    </div>

    <!-- Add Board Button -->
    <div class="add-board-button-container">
        <div class="add-board-button" id="add-board-button">
            <a href="create.php" class="btn">Add Board</a>
        </div>
    </div>

    <!-- Content Section -->
    <div class="content-section">
        <!-- Boards Content -->
        <div class="grid" id="boards-content">
            <?php foreach ($userBoards as $board): ?>
                <div class="board">
                    <img src="<?php echo htmlspecialchars($board['image']); ?>" alt="Board Image">
                    <div class="board-text">
                        <h3><?php echo htmlspecialchars($board['title']); ?></h3>
                        <p><?php echo htmlspecialchars($board['description']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pins Content (Hidden by Default) -->
        <div class="grid" id="pins-content" style="display: none;">
            <?php foreach ($userPins as $pin): ?>
                <div class="pin" data-pin-id="<?php echo $pin['id']; ?>">
                    <img src="../<?php echo htmlspecialchars($pin['image']); ?>" alt="Pinned Image">
                    <div class="pin-text">
                        <h3><?php echo htmlspecialchars($pin['title']); ?></h3>
                        <p><?php echo htmlspecialchars($pin['description']); ?></p>
                        <button class="unpin-button" onclick="unpinImage(<?php echo $pin['id']; ?>)">
                            <i class="fas fa-trash"></i> Unpin
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        function switchToBoards() {
            document.getElementById("boards-tab").classList.add("active");
            document.getElementById("pins-tab").classList.remove("active");
            document.getElementById("boards-content").style.display = "grid";
            document.getElementById("pins-content").style.display = "none";
            document.getElementById("add-board-button").style.display = "block";
        }

        function switchToPins() {
            document.getElementById("pins-tab").classList.add("active");
            document.getElementById("boards-tab").classList.remove("active");
            document.getElementById("pins-content").style.display = "grid";
            document.getElementById("boards-content").style.display = "none";
            document.getElementById("add-board-button").style.display = "none";
        }

        function logout() {
            alert("You have been logged out.");
            window.location.href = "login.php";
        }

        function addAccount() {
            alert("Redirecting to the add account page...");
            window.location.href = "add_account.php";
        }

        function uploadProfilePicture() {
            const form = document.getElementById('profile-picture-form');
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('profile-picture').src = data.new_image_url;
                } else {
                    alert('Failed to upload image: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while uploading the image.');
            });
        }

        // Ensure the "Add Board" button is visible by default
        document.addEventListener('DOMContentLoaded', function () {
            switchToBoards();
        });
    </script>
    <script src="../assets/js/pins.js"></script>
    <script src="../assets/js/follow.js"></script>
</body>
</html>
