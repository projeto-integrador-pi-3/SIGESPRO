<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

$baseUrl = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api';

echo json_encode([
    'name'    => 'SIGESPRO API',
    'version' => '1.0',
    'endpoints' => [
        [
            'method'      => 'GET',
            'url'         => $baseUrl . '/subprefeituras.php',
            'description' => 'Lista todas as subprefeituras',
        ],
        [
            'method'      => 'GET',
            'url'         => $baseUrl . '/subprefeituras.php?id={id}',
            'description' => 'Retorna uma subprefeitura pelo ID',
        ],
    ],
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
