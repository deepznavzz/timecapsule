<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['userID'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$capsuleID = $input['capsuleID'] ?? '';
$status = $input['status'] ?? '';

if (empty($capsuleID) || empty($status)) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

// Database connection (adjust as per your setup)
$conn = new mysqli('localhost', 'root', '', 'digitaltimecapsule');
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

$stmt = $conn->prepare("UPDATE capsules SET Status = ? WHERE CapsuleID = ? AND UserID = ?");
$stmt->bind_param('ssi', $status, $capsuleID, $_SESSION['userID']);
$success = $stmt->execute();

echo json_encode([
    'success' => $success,
    'message' => $success ? 'Status updated successfully' : 'Failed to update status'
]);

$stmt->close();
$conn->close();
?>