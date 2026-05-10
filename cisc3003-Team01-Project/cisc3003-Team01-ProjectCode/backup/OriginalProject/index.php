<?php
declare(strict_types=1);

/**
 * Default document for hosts that only look for index.php (e.g. some free shared hosting).
 * .htaccess sets DirectoryIndex home.php; this file keeps "/" working if that is ignored.
 */
require __DIR__ . '/home.php';
