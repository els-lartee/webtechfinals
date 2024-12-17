<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JewelQuest - Home</title>
    <link rel="stylesheet" href="assets/css/home.css">
    <style>
        /* General Reset */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        /* Navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: white;
            border-bottom: 1px solid #ccc;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .logo img {
            height: 40px;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        .nav-links a {
            color: black;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            transition: color 0.3s;
            padding: 8px 16px;
            border-radius: 20px;
            background-color: #d0c9c948;
        }

        .nav-links a:hover {
            color: #02000ba5; 
        }

        /* Auth Buttons */
        .auth-buttons a {
            color: black;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s;
            padding: 8px 16px;
            border-radius: 20px;
            background-color: #d0c9c948;
            margin-left: 10px;
        }

        .auth-buttons a:hover {
            background-color: rgba(8, 55, 104, 0.1);
        }

        /* Logout Button */
        .logout-button {
            background-color: #ff4d4d;
            color: white;
        }

        .logout-button:hover {
            background-color: #e60000;
        }

        /* Search Bar */
        .search-bar {
            text-align: center;
            margin: 20px 0;
        }

        .search-bar input {
            width: 80%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Gallery */
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 15px;
            padding: 20px;
            margin: 0 auto;
            max-width: 1200px;
        }

        .gallery-item {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .gallery-item:hover {
            transform: scale(1.04);
        }

        .gallery-item img {
            width: 100%;
            height: 500px;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
        }

        .gallery-text {
            padding: 15px;
            text-align: center;
        }

        .gallery-text h3 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }

        .gallery-text p {
            margin-top: 10px;
            font-size: 14px;
            color: #666;
            line-height: 1.5;
        }

        /* Media Queries */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                text-align: center;
            }

            .nav-links {
                flex-direction: column;
                gap: 10px;
            }

            .search-bar input {
                width: 90%;
            }

            .gallery {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 10px;
            }
        }

        @media (min-width: 1200px) {
            .gallery {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <!-- Logo and Buttons Section -->
        <div class="logo-section">
            <div class="logo">
                <img src="assets/images/logo.webp" alt="JewelQuest Logo">
            </div>
            <ul class="nav-links">
                <li><a href="index.php" class="home-button">Home</a></li>
                <li><a href="view/create.php" class="create-button">Create</a></li>
                <li><a href="view/userprofile.php" class="profile-button">Profile</a></li>
            </ul>
        </div>
        <div class="auth-buttons">
            <?php if ($isLoggedIn): ?>
                <a href="actions/logout.php" class="logout-button">Logout</a>
            <?php else: ?>
                <a href="view/login.php" class="login-button">Login</a>
                <a href="view/signup.php" class="signup-button">Sign Up</a>
            <?php endif; ?>
        </div>
    </nav>

    <!-- Search Bar -->
    <div class="search-bar">
        <input type="text" placeholder="Search for jewelry...">
    </div>

    <!-- Jewelry Gallery -->
    <div class="gallery" id="gallery"></div>

    <!-- Inline JavaScript -->
    <script>

        document.addEventListener("DOMContentLoaded", function() {
            const gallery = document.getElementById("gallery");
            let offset = 0;
            const limit = 10;

            function loadImages() {
                fetch(`actions/fetch_boards.php?limit=${limit}&offset=${offset}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(board => {
                            const item = document.createElement("div");
                            item.className = "gallery-item";
                            
                            const img = document.createElement("img");
                            img.src = board.image;
                            img.alt = board.title;
                            
                            const textDiv = document.createElement("div");
                            textDiv.className = "gallery-text";
                            
                            const title = document.createElement("h3");
                            title.textContent = board.title;
                            
                            const description = document.createElement("p");
                            description.textContent = board.description || "No description available";
                            
                            const pinButton = document.createElement("button");
                            pinButton.className = "pin-button";
                            pinButton.innerHTML = '<i class="fas fa-thumbtack"></i> Pin';
                            pinButton.onclick = (e) => {
                                e.stopPropagation();
                                if (isLoggedIn) {
                                    pinImage(board.id, board.image, board.description);
                                } else {
                                    window.location.href = "view/login.php";
                                }
                            };
                            // Inside your image loading function:
                            pinButton.addEventListener('click', async () => {

                                pinImage(board.id, board.image, board.description);

                            });
                            textDiv.appendChild(pinButton);

                            textDiv.appendChild(title);
                            textDiv.appendChild(description);
                            item.appendChild(img);
                            item.appendChild(textDiv);
                            
                            item.addEventListener("click", () => {
                                if (isLoggedIn) {
                                    window.location.href = `view/board.php?id=${board.id}`;
                                } else {
                                    window.location.href = "view/login.php";
                                }
                            });
                            
                            gallery.appendChild(item);
                        });
                        offset += limit;
                    })
                    .catch(error => console.error('Error fetching boards:', error));
            }

            // Initial load
            loadImages();

            // Infinite scroll event
            window.addEventListener("scroll", () => {
                if (window.innerHeight + window.scrollY >= document.body.offsetHeight) {
                    loadImages();
                }
            });

            // Redirect to login if not logged in
            const isLoggedIn = <?php echo json_encode($isLoggedIn); ?>;
            if (!isLoggedIn) {
                document.querySelector('.create-button').addEventListener('click', function(event) {
                    event.preventDefault();
                    window.location.href = 'view/login.php';
                });
                document.querySelector('.profile-button').addEventListener('click', function(event) {
                    event.preventDefault();
                    window.location.href = 'view/login.php';
                });
            }
        });
    </script>
    <script src="assets/js/pins.js"></script>
</body>
</html>
