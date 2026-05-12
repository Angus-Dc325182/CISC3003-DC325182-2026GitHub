<?php
/**
 * C.07: Forgot Password Functionality
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Paths must use ../ because PHPMailer is in the parent directory
require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = require 'connect.php';
    $email = $_POST["email"] ?? "";
    
    // Check if user exists
    $sql = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $token = bin2hex(random_bytes(16));
        $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));
        
        // Update user with reset token
        $sql = "UPDATE users SET reset_token = ?, reset_expires = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $token, $expiry, $email);
        
        if ($stmt->execute()) {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = MAIL_HOST;
                $mail->SMTPAuth   = true;
                $mail->Username   = MAIL_USERNAME;
                $mail->Password   = MAIL_PASSWORD;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
                $mail->Port       = 465;                         
                
                // CRITICAL: Bypass SSL certificate verification for XAMPP
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
                
                $mail->setFrom(MAIL_USERNAME, 'CISC3003 Support');
                $mail->addAddress($email);
                
                $reset_link = APP_URL . "/public/php/reset_password.php?token=$token";
                $mail->isHTML(true);
                $mail->Subject = "Password Reset Request";
                $mail->Body    = "Click <a href='$reset_link'>here</a> to reset your password. This link expires in 1 hour.";
                
                $mail->send();
                $message = "Success: A reset link has been sent to your email.";
            } catch (Exception $e) {
                $message = "Error: Mail could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    } else {
        $message = "If that email exists in our system, a link has been sent.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h1>Forgot Password</h1>
    <?php if ($message): ?> <p><?= htmlspecialchars($message) ?></p> <?php endif; ?>
    <form method="post">
        <label for="email">Enter your registered email:</label>
        <input type="email" name="email" id="email" required>
        <button type="submit">Send Reset Link</button>
    </form>
    <p><a href="login.php">Back to Login</a></p>
    <footer style="margin-top:50px; text-align:center;">
        CISC3003: Che Chi Hin, DC325182 2026
    </footer>
</body>
</html>