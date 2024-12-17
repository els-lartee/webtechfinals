<?php
session_start();
require_once '../db/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();

    // Sanitize inputs
    $identifier = trim($_POST['identifier']);
    $password = $_POST['password'];

    $errors = [];

    if (empty($identifier) || empty($password)) {
        $errors[] = 'Please fill in all fields.';
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: ../view/login.php');
        exit();
    }

    // Check if identifier is email or username
    $stmt = $db->connect()->prepare("SELECT id, username, password FROM users WHERE email = ? OR username = ?");
    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        $_SESSION['errors'] = ['Invalid username/email or password.'];
        header('Location: ../view/login.php');
        exit();
    }

    $stmt->bind_result($id, $username, $hashed_password);
    $stmt->fetch();

    // Verify password
    if (!password_verify($password, $hashed_password)) {
        $_SESSION['errors'] = ['Invalid username/email or password.'];
        header('Location: ../view/login.php');
        exit();
    }

    // Set session variables and redirect
    $_SESSION['user_id'] = $id;
    $_SESSION['username'] = $username;
    header('Location: ../view/userprofile.php');
    exit();
}
?>