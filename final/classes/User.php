<?php
require_once '../db/connect.php';

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getUserById($userId) {
        return $this->db->fetch('users', "id = $userId");
    }

    public function getUserBoards($userId) {
        return $this->db->fetchAll('boards', "user_id = $userId");
    }

    public function getUserPins($userId) {
        return $this->db->fetchAll('pins', "user_id = $userId ORDER BY created_at DESC");
    }

    public function getUserFollowers($userId) {
        return $this->db->fetchAll('followers', "user_id = $userId");
    }

    public function getUserFollowing($userId) {
        return $this->db->fetchAll('followers', "follower_id = $userId");
    }

    public function uploadProfilePicture($userId, $file) {
        $targetDir = "../uploads/images/";
        $targetFile = $targetDir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            return ['success' => false, 'error' => "File is not an image."];
        }

        // Check file size.
        if($file["size"] > 2000000) {
            return ['success' => false, 'error' => "Sorry, your file is too large. Max file size is 2MB."];
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            return ['success' => false, 'error' => "Sorry, only JPG, JPEG, PNG & GIF files are allowed."];
        }

        // Check if file already exists
        if (file_exists($targetFile)) {
            return ['success' => false, 'error' => "Sorry, file already exists."];
        }

        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            $newImageUrl = $targetFile;
            $stmt = $this->db->connect()->prepare("UPDATE users SET profile_picture = ? WHERE id = ?");
            $stmt->bind_param("si", $newImageUrl, $userId);

            if ($stmt->execute()) {
                $stmt->close();
                return ['success' => true, 'new_image_url' => $newImageUrl];
            } else {
                $stmt->close();
                return ['success' => false, 'error' => "Failed to update database."];
            }
        } else {
            return ['success' => false, 'error' => "Sorry, there was an error uploading your file."];
        }
    }

    public function addBoard($userId, $title, $image, $description, $link) {
        $targetDir = "../uploads/images/";
        $targetFile = $targetDir . basename($image["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if image file is an actual image
        $check = getimagesize($image["tmp_name"]);
        if ($check === false) {
            return ['success' => false, 'error' => 'File is not an image.'];
        }

        // Move uploaded file
        if (move_uploaded_file($image["tmp_name"], $targetFile)) {
            $data = [
                'user_id' => $userId,
                'title' => $title,
                'image' => $targetFile,
                'description' => $description,
                'link' => $link
            ];
            $insertResult = $this->db->insert('boards', $data);

            if ($insertResult) {
                return ['success' => true];
            } else {
                return ['success' => false, 'error' => 'Failed to insert board into database.'];
            }
        } else {
            return ['success' => false, 'error' => 'Failed to upload image.'];
        }
    }

    public function isImagePinned($userId, $boardId) {
        // Prepare statement with exact match
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM pins WHERE user_id = ? AND board_id = ?");
        $stmt->bind_param("ii", $userId, $boardId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            $row = $result->fetch_assoc();
            $stmt->close();
            return $row['count'] > 0;
        }
        $stmt->close();
        return false;
    }

    public function pinImage($userId, $boardId, $image, $description = '') {
        try {
            // First normalize the image path
            $imageFilename = basename($image);
            $normalizedPath = 'uploads/images/' . $imageFilename;

            if ($this->isImagePinned($userId, $boardId)) {
                return ['success' => false, 'error' => 'Image has been pinned'];
            }

            $stmt = $this->db->prepare("INSERT INTO pins (user_id, board_id, title, image, description) VALUES (?, ?, ?, ?, ?)");
            $title = 'Pinned Image';
            $stmt->bind_param("iisss", $userId, $boardId, $title, $normalizedPath, $description);
            $result = $stmt->execute();
            $stmt->close();

            return [
                'success' => $result,
                'message' => $result ? 'Image pinned successfully' : 'Failed to pin image'
            ];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return ['success' => false, 'error' => 'Internal Server Error'];
        }
    }

    public function unpinImage($pinId, $userId) {
        return $this->db->delete('pins', "id = $pinId AND user_id = $userId");
    }

    public function followUser($followerId, $userId) {
        $data = [
            'user_id' => $userId,
            'follower_id' => $followerId
        ];
        return $this->db->insert('followers', $data);
    }

    public function unfollowUser($followerId, $userId) {
        return $this->db->delete('followers', "user_id = $userId AND follower_id = $followerId");
    }

    public function isFollowing($followerId, $userId) {
        $result = $this->db->fetch('followers', "user_id = $userId AND follower_id = $followerId");
        return $result !== null;
    }

    public function getPinnedImages($userId) {
        return $this->db->fetchAll('pins', "user_id = $userId");
    }

    public function hasPinnedImage($userId, $boardId) {
        $result = $this->db->fetch('pins', "user_id = $userId AND board_id = $boardId");
        return !empty($result);
    }
}
?>