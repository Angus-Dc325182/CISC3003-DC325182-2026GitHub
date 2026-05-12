<?php
/**
 * CISC3003 Final Exam - Scenario B
 * Frontend Contact Form with CSS integration and Session status display.
 */

session_start();

// Retrieve success/error messages from session
$success = $_SESSION['success'] ?? '';
$errors  = $_SESSION['errors']  ?? [];

// Clear the messages so they don't reappear on refresh
unset($_SESSION['success'], $_SESSION['errors']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scenario B | SMTP Contact Form</title>
    <!-- Importing Water.css as recommended in tutorial -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .required-star { color: #e74c3c; }
        .alert { padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem; }
        .success-box { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error-box { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>

<header>
    <h1>CISC3003 - Scenario B</h1>
    <p>Contact Form utilizing PHPMailer & SMTP</p>
</header>

<main>
    <!-- B.05: Displaying status messages via PRG Pattern -->
    <?php if ($success): ?>
        <div class="alert success-box"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="alert error-box">
            <strong>The following errors occurred:</strong>
            <ul style="margin: 0.5rem 0 0 1rem;">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- B.01: Contact form with method="post" and destination "contact.php" -->
    <form action="contact.php" method="post" id="contactForm" novalidate>

        <div class="form-group">
            <label for="sender_name">Full Name <span class="required-star">*</span></label>
            <input type="text" id="sender_name" name="sender_name" placeholder="John Doe" required>
        </div>

        <div class="form-group">
            <label for="sender_email">Email Address <span class="required-star">*</span></label>
            <input type="email" id="sender_email" name="sender_email" placeholder="john@example.com" required>
        </div>

        <div class="form-group">
            <label for="subject">Subject <span class="required-star">*</span></label>
            <input type="text" id="subject" name="subject" placeholder="General Inquiry" required>
        </div>

        <div class="form-group">
            <label for="body">Message Body <span class="required-star">*</span></label>
            <textarea id="body" name="body" rows="6" placeholder="How can we help you?" required></textarea>
        </div>

        <button type="submit" name="send">Send Message</button>

    </form>
</main>

<!-- REQUIRED FOOTER FOR SCORING -->
<footer style="margin-top: 3rem; padding-top: 1.5rem; border-top: 1px solid #444; text-align: center; font-size: 0.9rem;">
    <p>CISC3003 Web Programming: Angus, CHE CHI HIN, DC325182 2026</p>
</footer>

<script src="js/script.js"></script>
</body>
</html>