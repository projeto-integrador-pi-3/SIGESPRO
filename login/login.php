<?php
session_start();
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../conexao.php';

$email = trim($_POST['email']);
$senha = $_POST['senha'];

$stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $usuario = $result->fetch_assoc();

    if (password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_email'] = $usuario['email'];
        $_SESSION['usuario_perfil'] = $usuario['perfil'];

        header("Location: " . BASE_URL . "/index.php");
        exit;
    }
}

echo "<script>alert('E-mail ou senha incorretos'); window.location='login_form.php';</script>";
