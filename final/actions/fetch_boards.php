<?php
require_once '../db/connect.php';

$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;

$db = new Database();
$query = "SELECT * FROM boards LIMIT $limit OFFSET $offset";
$result = $db->query($query);

$boards = [];
while ($row = $result->fetch_assoc()) {
    $row['image'] = 'uploads/images/' . basename($row['image']); // Ensure correct path
    $boards[] = $row;
}

echo json_encode($boards);
?>