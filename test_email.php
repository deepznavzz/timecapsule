<?php
$to = "test@localcapsule.com";
$subject = "Test Email from hMailServer";
$message = "This is a test email.";
$headers = "From: sender@localcapsule.com";

if (mail($to, $subject, $message, $headers)) {
    echo "Email sent successfully!";
} else {
    echo "Failed to send email.";
}
?>