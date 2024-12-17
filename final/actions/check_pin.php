<?php
session_start();
require_once '../classes/User.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User();
    
    $boardId = $_POST['board_id'] ?? null;
    $image = $_POST['image'] ?? null;
    
    if (!$boardId || !$image) {
        echo json_encode(['success' => false, 'error' => 'Missing required fields']);
        exit();
    }
    
    $isPinned = $user->isImagePinned($_SESSION['user_id'], $boardId, $image);
    echo json_encode([
        'success' => true,
        'isPinned' => $isPinned
    ]);
    exit();
}