<?php
session_start();
require_once '../classes/User.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit();
}

$user = new User();
$pinnedImages = $user->getPinnedImages($_SESSION['user_id']);
echo json_encode(['success' => true, 'pins' => $pinnedImages]);