<?php
// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle POST request only
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Token validation
    if (empty($_POST['token']) || $_POST['token'] !== 'FsWga4&@f6aw') {
        echo '<span class="notice">Error: Invalid token.</span>';
        exit;
    }

    // Sanitize and validate inputs
    $name = strip_tags(trim($_POST['name']));
    $from = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone = strip_tags(trim($_POST['phone']));
    $subject = strip_tags(trim($_POST['subject']));
    $message = nl2br(strip_tags(trim($_POST['message'])));

    if (!filter_var($from, FILTER_VALIDATE_EMAIL)) {
        echo '<span class="notice">Invalid email address.</span>';
        exit;
    }

    // Compose email
    $to = 'johndue141@gmail.com'; // Replace with your real email

    $headers = "From: $name <$from>\r\n";
    $headers .= "Reply-To: $from\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";

    $body = "
        <strong>New Contact Message Received:</strong><br><br>
        <strong>Name:</strong> {$name}<br>
        <strong>Email:</strong> {$from}<br>
        <strong>Phone:</strong> {$phone}<br>
        <strong>Subject:</strong> {$subject}<br><br>
        <strong>Message:</strong><br>
        {$message}<br><br>
        <hr>
        <small>This message was sent from the website contact form.</small>
    ";

    // Send email
    $sent = mail($to, $subject, $body, $headers);

    // Return response
    if ($sent) {
        echo '<div class="success"><i class="fas fa-check-circle"></i><h3>Thank You!</h3>Your message has been sent successfully.</div>';
    } else {
        echo '<div class="notice">Error: Failed to send your message. Please try again later.</div>';
    }

} else {
    // Reject non-POST access
    echo '<span class="notice">Access Denied!</span>';
    exit;
}
?>
