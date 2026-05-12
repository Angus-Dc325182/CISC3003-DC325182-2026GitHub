<?php
/**
 * C.04: Login functionality
 * C.08: Ensure user is confirmed before allowing login
 */
session_start();
$login_error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Include database connection
    $conn = require 'connect.php';
    
    $email    = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";
    
    // Search for the user by email
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    
    // Verify password against stored hash
    if ($user && password_verify($password, $user["password_hash"])) {
        
        // C.08: Check if account is active
        if ($user["is_active"] == 1) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["full_name"];
            header("Location: dashboard.php");
            exit;
        } else {
            $login_error = "Please activate your account via email before logging in.";
        }
        
    } else {
        $login_error = "Invalid credentials. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Scenario C | Login</title>
    <!-- Water.css for consistent styling -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    
    <!-- C.05: Include Just-Validate for client-side check -->
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
    <!-- Link to your script.js which contains the #loginForm validation logic -->
    <script src="../js/script.js" defer></script>
</head>
<body>
    <h1>User Login</h1>
    
    <?php if ($login_error): ?>
        <p style="color:red; font-weight:bold;"><?= htmlspecialchars($login_error) ?></p>
    <?php endif; ?>

    <!-- C.05: Correct Form ID and novalidate for JS validation -->
    <form method="post" id="loginForm" novalidate>
        <label for="login_email">Email</label>
        <input type="email" name="email" id="login_email" placeholder="example@mail.com" required>

        <label for="login_password">Password</label>
        <input type="password" name="password" id="login_password" required>

        <button type="submit">Log in</button>
    </form>
    
    <p><a href="forgot_password.php">Forgot Password?</a></p>

    <footer style="margin-top: 50px; text-align: center; border-top: 1px solid #ccc; padding-top: 20px;">
        CISC3003 Web Programming: Che Chi Hin, DC325182 2026
    </footer>
</body>
</html>