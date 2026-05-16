<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require '../conexao.php';

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['usuario_perfil']) || $_SESSION['usuario_perfil'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['success' => false, 'erro' => 'Acesso negado.']);
    exit;
}

$id        = (int)($_POST['id']        ?? 0);
$nome      = trim($_POST['nome']       ?? '');
$categoria = trim($_POST['categoria']  ?? '');
$conteudo  = trim($_POST['conteudo']   ?? '');

if (!$id || !$nome || !$categoria || !$conteudo) {
    echo json_encode(['success' => false, 'erro' => 'Todos os campos são obrigatórios.']);
    exit;
}

$stmt = $conn->prepare("UPDATE templates_documentos SET nome=?, categoria=?, conteudo=? WHERE id=?");
$stmt->bind_param("sssi", $nome, $categoria, $conteudo, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'erro' => 'Erro ao atualizar template.']);
}

$stmt->close();
