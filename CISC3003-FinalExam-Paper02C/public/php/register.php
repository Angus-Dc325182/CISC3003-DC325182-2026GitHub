<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Paths fixed to look in parent directory
require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$status_msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = require 'connect.php';
    
    $full_name = trim($_POST["full_name"] ?? "");
    $email     = trim($_POST["email"] ?? "");
    $password  = $_POST["password"] ?? "";
    
    if (empty($full_name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8) {
        $status_msg = "Error: Invalid details or password too short.";
    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $activation_token = bin2hex(random_bytes(16));
        
        $sql = "INSERT INTO users (full_name, email, password_hash, activation_token, is_active) VALUES (?, ?, ?, ?, 0)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $full_name, $email, $password_hash, $activation_token);
        
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
                
                // SSL Bypass for Localhost
                $mail->SMTPOptions = array(
                    'ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true)
                );
                
                $mail->setFrom(MAIL_USERNAME, 'CISC3003 System');
                $mail->addAddress($email);
                
                $link = APP_URL . "/public/php/activate.php?token=$activation_token";
                $mail->isHTML(true);
                $mail->Subject = "Account Activation Required";
                $mail->Body    = "Hi $full_name, <br>Click <a href='$link'>here</a> to verify your account.";
                
                $mail->send();
                $status_msg = "Success: Check your email to activate your account!";
            } catch (Exception $e) {
                $status_msg = "Warning: Account created, but email failed: {$mail->ErrorInfo}";
            }
        } else {
            $status_msg = "Error: Registration failed (Email may exist).";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Scenario C | Signup</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <!-- Just-Validate Library -->
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
    <!-- Your JS file -->
    <script src="../js/script.js" defer></script>
    <style>
        /* Strength Meter Styling */
        #password-strength { font-weight: bold; margin-top: 5px; font-size: 0.9em; }
        .strength-Weak { color: #ff4d4d; }
        .strength-Fair { color: #ffa500; }
        .strength-Good { color: #2ecc71; }
        .strength-Strong { color: #1d8348; }
    </style>
</head>
<body>
    <h1>Signup Page</h1>
    <?php if ($status_msg): ?> <p><?= htmlspecialchars($status_msg) ?></p> <?php endif; ?>
    
    <form action="register.php" method="post" id="signupForm" novalidate>
        <label for="full_name">Full Name</label>
        <input type="text" id="full_name" name="full_name" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
        <!-- C.05 Screenshot 4: Strength Meter Placeholder -->
        <div id="password-strength">Strength: <span id="strength-text">None</span></div>

        <!-- C.05 Screenshot 2: Added Confirm Password field -->
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>

        <button type="submit">Sign up</button>
    </form>
    <footer>CISC3003 Web Programming: Che Chi Hin, DC325182 2026</footer>
</body>
</html>