<?php
// ============================================================
// CISC3003 Final Exam Paper 02 – Scenario C
// C.09: User dashboard after login
// Student: [Your Name] | [Your Student ID] | 2026
// ============================================================

session_start();
require_once 'connect.php';

// Guard: must be logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$stmt = $conn->prepare(
    "SELECT full_name, email, created_at, last_login
     FROM users WHERE id = ? LIMIT 1"
);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user   = $result->fetch_assoc();
$stmt->close();
$conn->close();

$memberSince = date('d F Y', strtotime($user['created_at']));
$lastLogin   = $user['last_login']
               ? date('d F Y H:i', strtotime($user['last_login']))
               : 'First login';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard – CISC3003</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

<nav class="navbar">
    <span class="nav-brand">CISC3003 Portal</span>
    <div class="nav-links">
        <span>👋 Welcome, <?= htmlspecialchars($user['full_name']) ?></span>
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>
</nav>

<main class="dashboard">

    <!-- Welcome Card -->
    <div class="card welcome-card">
        <h2>🎉 Welcome back,
            <?= htmlspecialchars($user['full_name']) ?>!</h2>
        <p>You have been a member since <strong><?= $memberSince ?></strong>.</p>
        <p>Last login: <strong><?= $lastLogin ?></strong></p>
    </div>

    <!-- Profile Info Card -->
    <div class="card">
        <h3>👤 Your Profile</h3>
        <table class="profile-table">
            <tr>
                <th>Name</th>
                <td><?= htmlspecialchars($user['full_name']) ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?= htmlspecialchars($user['email']) ?></td>
            </tr>
            <tr>
                <th>Member Since</th>
                <td><?= $memberSince ?></td>
            </tr>
        </table>
    </div>

    <!-- Quick Links Card -->
    <div class="card">
        <h3>⚡ Quick Actions</h3>
        <div class="quick-links">
            <a href="forgot_password.php" class="ql-btn">🔑 Change Password</a>
            <a href="logout.php"          class="ql-btn danger">🚪 Logout</a>
        </div>
    </div>

</main>

<footer>
    <p>CISC3003 Web Programming: Angus, CHE CHI HIN, DC325182 2026</p>
</footer>

</body>
</html>