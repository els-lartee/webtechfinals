<?php
session_start();
require_once '../classes/User.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit();
}

if (!isset($_POST['board_id']) || !isset($_POST['image'])) {
    echo json_encode(['success' => false, 'error' => 'Missing required parameters']);
    exit();
}

try {
    $user = new User();
    $result = $user->pinImage(
        $_SESSION['user_id'],
        $_POST['board_id'],
        $_POST['image'],
        $_POST['description'] ?? ''
    );

    echo json_encode($result);
} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['success' => false, 'error' => 'Internal Server Error']);
}
exit();
?>