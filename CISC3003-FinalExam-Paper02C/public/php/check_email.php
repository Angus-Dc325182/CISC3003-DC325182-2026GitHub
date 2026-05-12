<?php
/**
 * C.06: Validate the email using an Ajax request
 */
$conn = require 'connect.php';

$email = $_GET["email"] ?? "";

// SQL query to check if the email exists in the users table
$sql = "SELECT id FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

header("Content-Type: application/json");

// available is true if no user is found with this email
echo json_encode(["available" => $result->num_rows === 0]);