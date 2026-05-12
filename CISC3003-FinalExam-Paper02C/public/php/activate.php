<?php
/**
 * C.08: Account activation logic via token verification
 */
$conn = require 'connect.php';

$token = $_GET["token"] ?? "";

if (empty($token)) {
    die("Activation token is missing.");
}

// Update the user record to active (1) and clear the token
$sql = "UPDATE users SET is_active = 1, activation_token = NULL WHERE activation_token = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $token);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "<h1>Success!</h1><p>Your account is now active. <a href='login.php'>Click here to Login</a>.</p>";
} else {
    echo "<h1>Error</h1><p>Invalid or already used activation link.</p>";
}