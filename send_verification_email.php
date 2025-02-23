<?php
session_start();
header('Content-Type: application/json');
require 'vendor/autoload.php'; // Assumes Composer install
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!isset($_SESSION['userID'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$capsuleID = $data['capsuleID'] ?? '';
$ownerEmail = $data['ownerEmail'] ?? '';
$nomineeEmail = $data['nomineeEmail'] ?? '';

if (empty($capsuleID) || empty($ownerEmail)) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

$pdo = new PDO("mysql:host=localhost;dbname=digitaltimecapsule", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $pdo->prepare("SELECT Title FROM capsules WHERE CapsuleID = ? AND userID = ?");
$stmt->execute([$capsuleID, $_SESSION['userID']]);
$capsule = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$capsule) {
    echo json_encode(['success' => false, 'message' => 'Capsule not found']);
    exit;
}

$title = $capsule['Title'];

// Generate token and expiration time
$token = bin2hex(random_bytes(16)); // e.g., "a1b2c3d4e5f6g7h8"
$expires = date('Y-m-d H:i:s', strtotime('+24 hours'));
$pdo->prepare("INSERT INTO tokens (token, capsuleID, expires_at) VALUES (?, ?, ?)")->execute([$token, $capsuleID, $expires]);
$link = "http://localhost/DigitalTimeCapsule/view_capsule.php?id=$capsuleID&token=$token";

$mail = new PHPMailer(true);
try {
    // Gmail SMTP settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'noreplydigitaltimecapsule@gmail.com'; // Your Gmail
    $mail->Password = 'gimvxvlcmwzrvwwp'; // Replace with your 16-character App Password (no spaces)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Sender and message
    $mail->setFrom('noreplydigitaltimecapsule@gmail.com', 'Digital Time Capsule Pro');
    $mail->Subject = "Capsule Unlocked: $title";
    $mail->Body = "Dear recipient,\n\nThe capsule '$title' (ID: $capsuleID) has been unlocked as of " . date('Y-m-d H:i:s') . ".\n\nYou can view the capsule using the following link: $link\n\nBest regards,\nDigital Time Capsule Pro Team";

    // Send to owner
    $mail->addAddress($ownerEmail);
    $mail->send();

    // Send to nominee if provided
    if (!empty($nomineeEmail)) {
        $mail->clearAddresses();
        $mail->addAddress($nomineeEmail);
        $mail->send();
    }

    echo json_encode(['success' => true, 'message' => 'Verification emails sent']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => "Mail error: {$mail->ErrorInfo}"]);
}
?>