<?php
session_start();
require_once '../db/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();

    // Sanitize and validate inputs
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $errors = [];

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $errors[] = 'Please fill in all fields.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format.';
    }

    if ($password !== $confirm_password) {
        $errors[] = 'Passwords do not match.';
    }

    // Check if username or email already exists
    $stmt = $db->connect()->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $errors[] = 'Username or email already exists.';
    }

    $stmt->close();

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: ../view/signup.php');
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user into the database
    $stmt = $db->connect()->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Registration successful! Redirecting to login page in 2 seconds...';
        header('Location: ../view/signup.php');
        exit();
    } else {
        $_SESSION['errors'] = ['Error registering user.'];
        header('Location: ../view/signup.php');
        exit();
    }
}
?>