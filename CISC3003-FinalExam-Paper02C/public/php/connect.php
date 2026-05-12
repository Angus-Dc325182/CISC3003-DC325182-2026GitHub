<?php


define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'cisc3003_scenarioc');

// Mail configuration for SMTP (Used for Activation/Reset tasks)
define('MAIL_HOST',     'smtp.gmail.com');
define('MAIL_USERNAME', 'chechihin24@gmail.com');
define('MAIL_PASSWORD', 'xlol zjms lios bucc');
define('MAIL_PORT',     587);

// Base URL for redirections and email links
define('APP_URL', 'http://localhost/CISC3003-FinalExam-Paper02C');

// Establish Connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check Connection Error
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

// Set charset to avoid encoding issues
$conn->set_charset('utf8mb4');

// Return connection object for inclusion in other files
return $conn;