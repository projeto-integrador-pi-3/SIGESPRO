<?php
if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '#') === 0 || strpos($line, '=') === false) continue;
        [$key, $value] = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value);
    }
}

$host    = $_ENV['DB_HOST']     ?? getenv('DB_HOST')     ?: 'localhost';
$porta   = (int)($_ENV['DB_PORT']     ?? getenv('DB_PORT')     ?: 3306);
$usuario = $_ENV['DB_USER']     ?? getenv('DB_USER')     ?: 'root';
$senha   = $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD') ?: '';
$banco   = $_ENV['DB_NAME']     ?? getenv('DB_NAME')     ?: 'sigespro';

$conn = new mysqli($host, $usuario, $senha, $banco, $porta);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
?>
