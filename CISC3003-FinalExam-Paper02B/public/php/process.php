<?php


session_start();
require_once 'connect.php';

// ── Only handle POST requests ──────────────────────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['submit'])) {
    header('Location: index.php');
    exit;
}

// ── A.05: Retrieve POST data ───────────────────────────────
$full_name  = $_POST['full_name']  ?? '';
$email      = $_POST['email']      ?? '';
$phone      = $_POST['phone']      ?? '';
$country    = $_POST['country']    ?? '';
$gender     = $_POST['gender']     ?? '';
$hobbies    = $_POST['hobbies']    ?? [];
$message    = $_POST['message']    ?? '';
$newsletter = isset($_POST['newsletter']) ? 1 : 0;

$errors = [];

// ── A.06: Validate using PHP filter functions ──────────────

// Sanitize text inputs
$full_name = filter_var(
    trim($full_name),
    FILTER_SANITIZE_SPECIAL_CHARS
    );
$phone   = filter_var(trim($phone),   FILTER_SANITIZE_SPECIAL_CHARS);
$country = filter_var(trim($country), FILTER_SANITIZE_SPECIAL_CHARS);
$gender  = filter_var(trim($gender),  FILTER_SANITIZE_SPECIAL_CHARS);
$message = filter_var(trim($message), FILTER_SANITIZE_SPECIAL_CHARS);

// Validate full name
if (empty($full_name)) {
    $errors[] = 'Full name is required.';
} elseif (strlen($full_name) < 2) {
    $errors[] = 'Full name must be at least 2 characters.';
} elseif (!preg_match("/^[a-zA-Z\s\-']+$/u", $full_name)) {
    $errors[] = 'Full name can only contain letters, spaces, hyphens.';
}

// Validate email using FILTER_VALIDATE_EMAIL
if (empty($email)) {
    $errors[] = 'Email address is required.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please enter a valid email address.';
} else {
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
}

// Validate country
if (empty($country)) {
    $errors[] = 'Please select a country.';
}

// Validate message
if (empty($message)) {
    $errors[] = 'Message is required.';
} elseif (strlen($message) < 10) {
    $errors[] = 'Message must be at least 10 characters.';
}

// Validate hobbies
$hobbies_allowed = ['Reading', 'Coding', 'Gaming', 'Sports', 'Music'];
$hobbies_clean   = [];
foreach ($hobbies as $hobby) {
    if (in_array($hobby, $hobbies_allowed, true)) {
        $hobbies_clean[] = $hobby;
    }
}
$hobbies_str = implode(', ', $hobbies_clean);

// ── If validation errors, redirect back ───────────────────
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header('Location: index.php');
    exit;
}

// ── A.07: Avoid SQL injection - use prepared statements ────
// ── A.08: Prepared statement to INSERT record ─────────────
// ── A.10: SQL INSERT INTO statement ───────────────────────

$sql = "INSERT INTO users
            (full_name, email, phone, gender, country,
             hobbies, message, newsletter)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    $_SESSION['errors'] = ['Database error: ' . $conn->error];
    header('Location: index.php');
    exit;
}

// Bind parameters (s = string, i = integer)
$stmt->bind_param(
    'sssssssi',
    $full_name,
    $email,
    $phone,
    $gender,
    $country,
    $hobbies_str,
    $message,
    $newsletter
    );

if ($stmt->execute()) {
    $_SESSION['success'] =
    "Registration successful! Welcome, $full_name.";
} else {
    // Handle duplicate email
    if ($conn->errno === 1062) {
        $_SESSION['errors'] = ['This email is already registered.'];
    } else {
        $_SESSION['errors'] = ['Failed to save record: ' . $stmt->error];
    }
}

$stmt->close();
$conn->close();

// Post / Redirect / Get pattern
header('Location: index.php');
exit;
?>


<!-- Footer - Required for scoring -->
<footer>
    <p>CISC3003 Web Programming: Che Chi Hin, DC325182 2026</p>
</footer>

<script src="js/script.js"></script>
</body>
</html>