<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ob_start();
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['userID'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    ob_end_flush();
    exit;
}

include 'db_connect.php';

$userID = $_SESSION['userID'];
$currentDateTime = date('Y-m-d H:i:s');

$stmt = $conn->prepare("SELECT CapsuleID, Title, UnlockDateTime, Status, Description, Contents, FilePath, OwnerEmail, NomineeEmail FROM Capsules WHERE UserID = ?");
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
    ob_end_flush();
    exit;
}

$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

$capsules = [];
while ($row = $result->fetch_assoc()) {
    $isUnlocked = (strtotime($row['UnlockDateTime']) <= time());
    if ($isUnlocked && $row['Status'] === 'Locked') {
        $row['Status'] = 'Unlocked';
        $subject = "Your Time Capsule '{$row['Title']}' Has Unlocked!";
        $message = "Dear Navadeep77,\n\nYour capsule '{$row['Title']}' unlocked on {$row['UnlockDateTime']}.\n\nAccess it at: http://localhost/DigitalTimeCapsule/dashboard.php\n\nRegards,\nDigital Time Capsule Pro";
        $headers = "From: navadeep77@localhost";

        mail($row['OwnerEmail'], $subject, $message, $headers);
        if ($row['NomineeEmail']) {
            mail($row['NomineeEmail'], $subject, $message, $headers);
        }

        $updateStmt = $conn->prepare("UPDATE Capsules SET Status = 'Unlocked' WHERE CapsuleID = ?");
        $updateStmt->bind_param("i", $row['CapsuleID']);
        $updateStmt->execute();
        $updateStmt->close();
    }
    $capsules[] = $row;
}
$stmt->close();
$conn->close();

ob_end_clean();
echo json_encode(['success' => true, 'capsules' => $capsules]);
?>