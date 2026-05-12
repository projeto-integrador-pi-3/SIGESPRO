<?php
require_once __DIR__ . '/env_loader.php';

$host    = $_ENV['DB_HOST']     ?? getenv('DB_HOST')
        ?: $_ENV['MYSQLHOST']   ?? getenv('MYSQLHOST')   ?: 'localhost';
$porta   = (int)($_ENV['DB_PORT']     ?? getenv('DB_PORT')
        ?: $_ENV['MYSQLPORT']   ?? getenv('MYSQLPORT')   ?: 3306);
$usuario = $_ENV['DB_USER']     ?? getenv('DB_USER')
        ?: $_ENV['MYSQLUSER']   ?? getenv('MYSQLUSER')   ?: 'root';
$senha   = $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD')
        ?: $_ENV['MYSQLPASSWORD'] ?? getenv('MYSQLPASSWORD') ?: '';
$banco   = $_ENV['DB_NAME']     ?? getenv('DB_NAME')
        ?: $_ENV['MYSQLDATABASE'] ?? getenv('MYSQLDATABASE') ?: 'sigespro';

$conn = new mysqli($host, $usuario, $senha, $banco, $porta);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
$conn->set_charset('utf8mb4');
?>
