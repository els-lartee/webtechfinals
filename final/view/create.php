<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post - JewelQuest</title>
    <link rel="stylesheet" href="../assets/css/create.css">

    <!-- Include Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="logo-section">
            <div class="logo">
                <img src="../assets/images/logo.webp" alt="JewelQuest Logo">
            </div>
            <div class="nav-buttons">
                <a href="../index.php">Home</a>
                <a href="#" class="active">Create</a>
            </div>
        </div>
    </nav>

    <!-- Create Post Form -->
    <div class="create-container">
        <div class="create-header">Create a New Post</div>
        <!-- Error Messages -->
        <div id="error-messages" class="error-messages"></div>
        <form id="create-post-form" action="../actions/create_post.php" method="POST" enctype="multipart/form-data">
            <!-- Image Preview -->
            <div class="form-group">
                <label for="upload-images">Upload Image</label>
                <input type="file" id="upload-images" name="upload-images" accept="image/*" onchange="previewImage()" required>
                <div class="upload-preview" id="upload-preview"></div>
            </div>

            <!-- Title -->
            <div class="form-group">
                <label for="post-title">Title</label>
                <input type="text" id="post-title" name="post-title" placeholder="Enter post title" required>
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="post-description">Description</label>
                <textarea id="post-description" name="post-description" rows="4" placeholder="Add a description" required></textarea>
            </div>

            <!-- Link -->
            <div class="form-group">
                <label for="post-link">Link</label>
                <input type="text" id="post-link" name="post-link" placeholder="Enter link to the product">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="create-button">Create Post</button>
        </form>
    </div>

    <script>
        function previewImage() {
            const preview = document.getElementById('upload-preview');
            const file = document.getElementById('upload-images').files[0];
            const reader = new FileReader();

            reader.addEventListener('load', function () {
                preview.innerHTML = `<img src="${reader.result}" alt="Image Preview">`;
            });

            if (file) {
                reader.readAsDataURL(file);
            }
        }

        document.getElementById('create-post-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form from submitting traditionally
            var formData = new FormData(this);
            var xhr = new XMLHttpRequest();
            xhr.open('POST', this.action, true);
            xhr.onload = function() {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    window.location.href = '../view/userprofile.php';
                } else {
                    var errorDiv = document.getElementById('error-messages');
                    errorDiv.innerHTML = '<p>' + response.error + '</p>';
                    errorDiv.style.display = 'block';
                }
            };
            xhr.send(formData);
        });
    </script>
</body>
</html>
