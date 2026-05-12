<?php
if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '#') === 0 || strpos($line, '=') === false) continue;
        [$key, $value] = explode('=', $line, 2);
        $k = trim($key);
        if (!isset($_ENV[$k]) && getenv($k) === false) {
            $_ENV[$k] = trim($value);
        }
    }
}
