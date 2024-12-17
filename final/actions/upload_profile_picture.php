<?php
session_start();
require_once '../classes/User.php';

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture']) && isset($_POST['user_id'])) {
    $userId = $_POST['user_id'];
    $user = new User();

    $result = $user->uploadProfilePicture($userId, $_FILES['profile_picture']);

    if ($result['success']) {
        $response['success'] = true;
        $response['new_image_url'] = $result['new_image_url'];
    } else {
        $response['error'] = $result['error'];
    }
}

echo json_encode($response);
?>