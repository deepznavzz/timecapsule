<?php
header('Content-Type: application/json');
session_start();
include 'db_connect.php';

try {
    // Check if POST data is set
    if (!isset($_POST['fullname']) || !isset($_POST['username']) || !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['confirm_password'])) {
        throw new Exception('Missing required fields');
    }

    // Sanitize inputs
    $fullname = filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($password !== $confirm_password) {
        throw new Exception('Passwords do not match');
    }

    if (empty($fullname) || empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        throw new Exception('All fields are required.');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Invalid email format.');
    } elseif (strlen($password) < 8) {
        throw new Exception('Password must be at least 8 characters.');
    }

    // Check for existing user
    $stmt = $conn->prepare("SELECT UserID FROM Users WHERE Username = ? OR Email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        throw new Exception('Username or email already taken.');
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO Users (FullName, Username, Email, Password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fullname, $username, $email, $hashed_password);
    if ($stmt->execute()) {
        $userID = $stmt->insert_id;
        session_regenerate_id(true);
        $_SESSION['userID'] = $userID;
        $_SESSION['username'] = $username;
        echo json_encode([
            'success' => true,
            'message' => 'Signup successful! Redirecting to dashboard...',
            'userID' => $userID,
            'username' => $username
        ]);
    } else {
        throw new Exception('Signup failed. Please try again.');
    }
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    // Log error (optional, for debugging)
    error_log($e->getMessage(), 3, 'signup_errors.log');
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>