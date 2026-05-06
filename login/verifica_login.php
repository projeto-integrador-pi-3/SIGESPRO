<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['usuario_id'])) {
    require_once __DIR__ . '/../config.php';
    header("Location: " . BASE_URL . "/login/login_form.php");
    exit;
}
