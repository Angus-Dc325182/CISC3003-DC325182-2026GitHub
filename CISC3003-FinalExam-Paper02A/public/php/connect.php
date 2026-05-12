


<?php


define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'cisc3003_scenarioa');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

return $conn;
?>

<!-- Footer - Required for scoring -->
<footer>
    <p>CISC3003 Web Programming: Che Chi Hin, DC325182 2026</p>
</footer>

<script src="js/script.js"></script>
</body>
</html>