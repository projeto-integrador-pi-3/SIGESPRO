<?php
require_once __DIR__ . '/env_loader.php';

$host    = $_ENV['DB_HOST']     ?? getenv('DB_HOST')     ?: 'localhost';
$porta   = (int)($_ENV['DB_PORT']     ?? getenv('DB_PORT')     ?: 3306);
$usuario = $_ENV['DB_USER']     ?? getenv('DB_USER')     ?: 'root';
$senha   = $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD') ?: '';
$banco   = $_ENV['DB_NAME']     ?? getenv('DB_NAME')     ?: 'sigespro';

$conn = new mysqli($host, $usuario, $senha, $banco, $porta);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
$conn->set_charset('utf8mb4');
?>
