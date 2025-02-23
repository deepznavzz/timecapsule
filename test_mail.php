<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', 'C:\xampp\php\logs\php_error_log');

$to = "navadeep77@localhost";
$subject = "Test Email from PHP";
$message = "This is a test email via Mercury Mail!";
$headers = "From: navadeep77@localhost";

if (mail($to, $subject, $message, $headers, "-fnavadeep77@localhost")) {
    echo "Email sent successfully!";
} else {
    echo "Email sending failed.";
    error_log("Mail failed to $to at " . date('Y-m-d H:i:s'));
}
?>