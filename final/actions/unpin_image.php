<?php
session_start();
require_once '../classes/User.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User();
    $pinId = $_POST['pin_id'] ?? null;
    
    if (!$pinId) {
        echo json_encode(['success' => false, 'error' => 'No pin ID provided']);
        exit();
    }
    
    $result = $user->unpinImage($pinId, $_SESSION['user_id']);
    echo json_encode(['success' => $result]);
}
?>