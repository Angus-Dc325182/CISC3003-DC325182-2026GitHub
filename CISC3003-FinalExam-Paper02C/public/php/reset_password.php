<?php


session_start();
require_once 'connect.php';

$token   = $_GET['token'] ?? '';
$errors  = $_SESSION['errors']  ?? [];
$success = $_SESSION['success'] ?? '';
unset($_SESSION['errors'], $_SESSION['success']);

// Validate token
$valid_user = null;
if (!empty($token)) {
    $stmt = $conn->prepare(
        "SELECT id, full_name FROM users
         WHERE reset_token = ?
           AND reset_expires > NOW()
         LIMIT 1"
    );
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $valid_user = $result->fetch_assoc();
    }
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['do_reset'])) {

    $token      = $_POST['token'] ?? '';
    $password   = $_POST['password'] ?? '';
    $confirm    = $_POST['confirm']  ?? '';
    $errors     = [];

    if (strlen($password) < 8)
        $errors[] = 'Password must be at least 8 characters.';
    if ($password !== $confirm)
        $errors[] = 'Passwords do not match.';

    // Re-validate token
    $stmt2 = $conn->prepare(
        "SELECT id FROM users
         WHERE reset_token = ? AND reset_expires > NOW()
         LIMIT 1"
    );
    $stmt2->bind_param('s', $token);
    $stmt2->execute();
    $res2 = $stmt2->get_result();
    if ($res2->num_rows === 0)
        $errors[] = 'Reset link has expired or is invalid.';

    if (empty($errors)) {
        $row  = $res2->fetch_assoc();
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $upd  = $conn->prepare(
            "UPDATE users
             SET password_hash = ?,
                 reset_token   = NULL,
                 reset_expires = NULL
             WHERE id = ?"
        );
        $upd->bind_param('si', $hash, $row['id']);
        if ($upd->execute()) {
            $_SESSION['success'] = 'Password reset successful! Please login.';
            $upd->close();
            $stmt2->close();
            $conn->close();
            header('Location: login.php');
            exit;
        } else {
            $errors[] = 'Failed to reset password.';
        }
        $upd->close();
    }

    $stmt2->close();
    $_SESSION['errors'] = $errors;
    header("Location: reset_password.php?token=$token");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password – CISC3003</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header>
    <h1>Reset Your Password</h1>
</header>
<main class="auth-container">

    <?php if (!empty($errors)): ?>
        <div class="alert error">
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($valid_user): ?>
        <p>Hi <strong><?= htmlspecialchars($valid_user['full_name']) ?></strong>,
           enter your new password:</p>
        <form action="reset_password.php" method="post">
            <input type="hidden" name="token"
                   value="<?= htmlspecialchars($token) ?>">
            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password"
                       placeholder="Min 8 characters" required>
            </div>
            <div class="form-group">
                <label for="confirm">Confirm Password</label>
                <input type="password" id="confirm" name="confirm"
                       placeholder="Repeat new password" required>
            </div>
            <button type="submit" name="do_reset">Reset Password</button>
        </form>
    <?php else: ?>
        <div class="alert error">
            Invalid or expired reset link.
            <a href="forgot_password.php">Request a new one.</a>
        </div>
    <?php endif; ?>

</main>
<footer>
    <p>CISC3003 Web Programming: Angus, CHE CHI HIN, DC325182 2026</p>
</footer>
</body>
</html>