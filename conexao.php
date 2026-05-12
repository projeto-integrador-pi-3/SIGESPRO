<?php
require_once __DIR__ . '/env_loader.php';

if (!function_exists('_env')) {
    function _env(string $key): ?string {
        if (isset($_ENV[$key]) && $_ENV[$key] !== '') return $_ENV[$key];
        $v = getenv($key);
        if ($v !== false && $v !== '') return $v;
        if (isset($_SERVER[$key]) && $_SERVER[$key] !== '') return $_SERVER[$key];
        return null;
    }
}

$host    = _env('DB_HOST')     ?? _env('MYSQLHOST')     ?? 'localhost';
$porta   = (int)(_env('DB_PORT') ?? _env('MYSQLPORT')   ?? 3306);
$usuario = _env('DB_USER')     ?? _env('MYSQLUSER')     ?? 'root';
$senha   = _env('DB_PASSWORD') ?? _env('MYSQLPASSWORD') ?? '';
$banco   = _env('DB_NAME')     ?? _env('MYSQLDATABASE') ?? 'sigespro';

$conn = new mysqli($host, $usuario, $senha, $banco, $porta);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
$conn->set_charset('utf8mb4');
