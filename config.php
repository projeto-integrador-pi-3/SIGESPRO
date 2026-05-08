<?php
require_once __DIR__ . '/env_loader.php';
define('BASE_URL', $_ENV['APP_URL'] ?? getenv('APP_URL') ?: 'http://localhost/SIGESPRO');
?>
