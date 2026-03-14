<?php
// Detectar dinamicamente o caminho base do projeto
$host = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');

// Caminho relativo (sem http://)
define('BASE_URL', 'http://localhost/projeto_integrador_ii');
?>