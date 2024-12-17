<?php
session_start();
require_once '../classes/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = ['success' => false];

    if (isset($_FILES['upload-images']) && isset($_POST['post-title']) && isset($_POST['post-description'])) {
        $userId = $_SESSION['user_id'];
        $title = $_POST['post-title'];
        $description = $_POST['post-description'];
        $link = isset($_POST['post-link']) ? $_POST['post-link'] : '';
        $image = $_FILES['upload-images'];

        $user = new User();
        $result = $user->addBoard($userId, $title, $image, $description, $link);

        if ($result['success']) {
            $response['success'] = true;
        } else {
            $response['error'] = $result['error'];
        }
    } else {
        $response['error'] = 'Please fill in all required fields.';
    }

    echo json_encode($response);
}
?>