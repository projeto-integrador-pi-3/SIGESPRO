<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require '../conexao.php';

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['usuario_perfil']) || $_SESSION['usuario_perfil'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['success' => false, 'erro' => 'Acesso negado. Somente administradores podem excluir contatos.']);
    exit;
}

$id = $_POST['id'] ?? '';

if (!$id) {
    echo json_encode(['success' => false, 'erro' => 'ID inválido']);
    exit;
}

$stmt = $conn->prepare("DELETE FROM contatos WHERE id=?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'erro' => 'Erro ao excluir contato']);
}

$stmt->close();
