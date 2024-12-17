<?php
session_start();
require_once '../classes/User.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User();
    $followerId = $_SESSION['user_id'];
    $userId = $_POST['user_id'] ?? null;
    
    if (!$userId) {
        echo json_encode(['success' => false, 'error' => 'No user ID provided']);
        exit();
    }
    
    $result = $user->unfollowUser($followerId, $userId);
    echo json_encode(['success' => $result]);
}