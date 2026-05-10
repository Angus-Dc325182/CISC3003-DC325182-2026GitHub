<?php
/**
 * Minimal auth + HTML — if this works but dashboard.php is 500, the failure is not session/auth bootstrap.
 * DELETE after debugging.
 */
declare(strict_types=1);
header('Content-Type: text/html; charset=utf-8');
require_once __DIR__ . '/includes/auth.php';
requireUserSession();
startAuthSession();
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Dashboard tiny probe</title></head>
<body><p>If you see this, auth/session and a short response work.</p></body>
</html>
