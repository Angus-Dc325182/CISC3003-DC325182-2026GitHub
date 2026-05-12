<?php

session_start();

// If already logged in → go to dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CISC3003 – Scenario C | Home</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<header>
    <h1>CISC3003 – Scenario C</h1>
    <p>Full Authentication System with PHP &amp; MySQL</p>
</header>

<main class="hero">
    <div class="hero-box">
        <h2>Welcome!</h2>
        <p>Please register or login to continue.</p>
        <div class="btn-group">
            <a href="register.php" class="btn btn-primary">Sign Up</a>
            <a href="login.php"    class="btn btn-outline">Login</a>
        </div>
    </div>
</main>

<footer>
    <p>CISC3003 Web Programming: Angus, CHE CHI HIN, DC325182 2026</p>
</footer>

</body>
</html>