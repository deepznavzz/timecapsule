<?php
session_start();
require 'db_connect.php'; // Assuming you have a file for database connection

$token = $_GET['token'] ?? '';
$capsuleID = $_GET['id'] ?? '';

if (empty($token) || empty($capsuleID)) {
    header('HTTP/1.1 400 Bad Request');
    echo "Missing token or capsule ID.";
    exit;
}

$stmt = $pdo->prepare("SELECT capsuleID, expires_at, used FROM tokens WHERE token = ?");
$stmt->execute([$token]);
$tokenData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tokenData || $tokenData['capsuleID'] !== $capsuleID || $tokenData['used'] || new DateTime($tokenData['expires_at']) < new DateTime()) {
    header('HTTP/1.1 403 Forbidden');
    echo "Invalid or expired token.";
    exit;
}

$pdo->prepare("UPDATE tokens SET used = TRUE WHERE token = ?")->execute([$token]);

$stmt = $pdo->prepare("SELECT * FROM capsules WHERE CapsuleID = ?");
$stmt->execute([$capsuleID]);
$capsule = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$capsule || ($capsule['Status'] !== 'Unlocked' && new DateTime($capsule['UnlockDateTime']) > new DateTime())) {
    header('HTTP/1.1 403 Forbidden');
    echo "Capsule not found or not unlocked.";
    exit;
}

// Your code to display the capsule details goes here
?>