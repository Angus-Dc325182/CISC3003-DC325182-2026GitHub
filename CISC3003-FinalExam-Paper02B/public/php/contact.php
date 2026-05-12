<?php
session_start();

// ── B.02: Modified paths to look for PHPMailer folder in the parent directory ──
require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


// B.05: Only allow POST requests (Security best practice)
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['send'])) {
    header('Location: index.php');
    exit;
}

// Retrieve and sanitize form inputs
$sender_name  = filter_input(INPUT_POST, 'sender_name', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
$sender_email = filter_input(INPUT_POST, 'sender_email', FILTER_SANITIZE_EMAIL) ?? '';
$subject      = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
$body         = filter_input(INPUT_POST, 'body', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';

$errors = [];

// B.01: Server-side validation logic
if (empty(trim($sender_name))) $errors[] = 'Name is required.';
if (empty(trim($subject)))     $errors[] = 'Subject is required.';
if (empty(trim($body)))        $errors[] = 'Message body cannot be empty.';
if (!filter_var($sender_email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please provide a valid email address.';
}

// Redirect back with errors if validation fails
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header('Location: index.php');
    exit;
}

// B.02 & B.03: Initialize and configure PHPMailer
$mail = new PHPMailer(true);

try {
    // B.04: SMTP Debugging (Change to SMTP::DEBUG_OFF for production)
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->Debugoutput = 'html';
    
    // Server settings for Gmail SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'chechihin24@gmail.com';   
    $mail->Password   = 'xlol zjms lios bucc';      
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;
    
    // Add this block inside the try{} section in contact.php
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    
    // B.03: Set email recipients (Using your verified Gmail to avoid spam filters)
    $mail->setFrom('chechihin24@gmail.com', 'CISC3003 Contact System');
    $mail->addAddress('chechihin24@gmail.com', 'Angus Che'); // Sending mail to yourself for testing
    $mail->addReplyTo($sender_email, $sender_name);       // Allow admin to reply to the user
    
    // Email Content configuration
    $mail->isHTML(true);
    $mail->Subject = "New Contact: " . $subject;
    $mail->Body    = "
        <h3>New Message Received</h3>
        <p><strong>From:</strong> {$sender_name} ({$sender_email})</p>
        <p><strong>Subject:</strong> {$subject}</p>
        <p><strong>Message:</strong><br>" . nl2br(htmlspecialchars($body)) . "</p>
    ";
    $mail->AltBody = strip_tags($body); // Plain text version for non-HTML mail clients
    
    // Execute sending
    $mail->send();
    
    // B.05: Post / Redirect / Get pattern - Success path
    $_SESSION['success'] = 'Success! Your email has been sent to the admin.';
    header('Location: index.php');
    exit;
    
} catch (Exception $e) {
    // B.04: Catch and display errors for debugging purposes
    $_SESSION['errors'] = [
        'Critical Error: Message could not be sent.',
        'Technical Detail: ' . $mail->ErrorInfo
    ];
    header('Location: index.php');
    exit;
}