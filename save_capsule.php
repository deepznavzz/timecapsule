<?php
session_start();
header('Content-Type: application/json');
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['userID'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$userID = $_SESSION['userID'];
$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
$unlockDateTime = $_POST['unlockDateTime'];
$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
$contents = filter_input(INPUT_POST, 'contents', FILTER_SANITIZE_STRING);
$ownerEmail = filter_input(INPUT_POST, 'ownerEmail', FILTER_SANITIZE_EMAIL);
$nomineeEmail = filter_input(INPUT_POST, 'nomineeEmail', FILTER_SANITIZE_EMAIL) ?: NULL;

if (empty($title) || empty($unlockDateTime) || empty($ownerEmail)) {
    echo json_encode(['success' => false, 'message' => 'Title, unlock date/time, and owner email are required.']);
    exit;
}

$now = new DateTime();
$minTime = (new DateTime())->modify('+5 minutes'); // 5 minutes from now
$unlock = new DateTime($unlockDateTime);
if ($unlock < $minTime) {
    echo json_encode(['success' => false, 'message' => 'Unlock date/time must be at least 5 minutes from now.']);
    exit;
}

if (!filter_var($ownerEmail, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid owner email.']);
    exit;
}

// File upload
$filePath = null;
if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
    $fileName = uniqid('capsule_') . '_' . basename($_FILES['file']['name']);
    $filePath = $uploadDir . $fileName;
    if (!move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
        echo json_encode(['success' => false, 'message' => 'File upload failed.']);
        exit;
    }
}

$stmt = $conn->prepare("INSERT INTO Capsules (UserID, Title, UnlockDateTime, Description, Contents, FilePath, OwnerEmail, NomineeEmail) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssssss", $userID, $title, $unlockDateTime, $description, $contents, $filePath, $ownerEmail, $nomineeEmail);
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Capsule saved! You’ll be notified when it unlocks.', 'capsuleID' => $stmt->insert_id]);
} else {
    echo json_encode(['success' => false, 'message' => 'Save failed: ' . $stmt->error]);
}
$stmt->close();
$conn->close();
?>