<?php
header('Content-Type: application/json');
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Username and password required.']);
        exit;
    }

    $stmt = $conn->prepare("SELECT UserID, Username, Password FROM Users WHERE Username = ? OR Email = ?");
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userID, $dbUsername, $hashed_password);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            session_regenerate_id(true);
            $_SESSION['userID'] = $userID;
            $_SESSION['username'] = $dbUsername;
            echo json_encode([
                'success' => true,
                'message' => 'Welcome back! Redirecting...',
                'userID' => $userID,
                'username' => $dbUsername
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Incorrect password.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'User not found.']);
    }
    $stmt->close();
    $conn->close();
    exit;
}
echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
?>