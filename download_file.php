<?php
session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: /DigitalTimeCapsule/login.html");
    exit;
}

if (!isset($_GET['id'])) {
    header('HTTP/1.1 400 Bad Request');
    echo "No capsule ID provided.";
    exit;
}

$userID = $_SESSION['userID'];
$capsuleID = $_GET['id'];

$pdo = new PDO("mysql:host=localhost;dbname=digitaltimecapsule", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $pdo->prepare("SELECT CapsuleID, Title, UnlockDateTime, Status, Description, Contents, FilePath, OwnerEmail, NomineeEmail FROM capsules WHERE CapsuleID = ? AND userID = ?");
$stmt->execute([$capsuleID, $userID]);
$capsule = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$capsule) {
    header('HTTP/1.1 404 Not Found');
    echo "Capsule not found.";
    exit;
}

// Check if capsule is unlocked based on UnlockDateTime only
$now = new DateTime('now', new DateTimeZone('UTC'));
$unlockTime = new DateTime($capsule['UnlockDateTime'], new DateTimeZone('UTC'));
$isUnlocked = $capsule['Status'] === 'Unlocked' || $unlockTime <= $now;

if (!$isUnlocked) {
    header('HTTP/1.1 403 Forbidden');
    echo "Capsule is still locked.";
    exit;
}

// Update Status to "Unlocked" if it’s not already
if ($capsule['Status'] !== 'Unlocked') {
    $pdo->prepare("UPDATE capsules SET Status = 'Unlocked' WHERE CapsuleID = ?")->execute([$capsuleID]);
}

// Generate capsule data as a text string
$data = "Capsule Details\n";
$data .= "---------------\n";
$data .= "Capsule ID: " . $capsule['CapsuleID'] . "\n";
$data .= "Title: " . $capsule['Title'] . "\n";
$data .= "Unlock Date/Time: " . $capsule['UnlockDateTime'] . "\n";
$data .= "Status: Unlocked\n";
$data .= "Description: " . ($capsule['Description'] ?: "None") . "\n";
$data .= "Contents: " . ($capsule['Contents'] ?: "None") . "\n";
$data .= "File Path: " . ($capsule['FilePath'] ?: "No file attached") . "\n";
$data .= "Owner Email: " . $capsule['OwnerEmail'] . "\n";
$data .= "Nominee Email: " . ($capsule['NomineeEmail'] ?: "None") . "\n";

// If a file exists, serve it instead; otherwise, serve the data
if (!empty($capsule['FilePath']) && file_exists($capsule['FilePath'])) {
    $filePath = $capsule['FilePath'];
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
    header('Content-Length: ' . filesize($filePath));
    readfile($filePath);
    exit;
} else {
    // Serve capsule data as a text file
    $filename = "Capsule_{$capsule['CapsuleID']}_Details.txt";
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Content-Length: ' . strlen($data));
    echo $data;
    exit;
}
?>