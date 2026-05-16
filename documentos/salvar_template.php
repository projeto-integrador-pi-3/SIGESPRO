<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require '../conexao.php';

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['usuario_perfil']) || $_SESSION['usuario_perfil'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['success' => false, 'erro' => 'Acesso negado.']);
    exit;
}

$nome      = trim($_POST['nome']      ?? '');
$categoria = trim($_POST['categoria'] ?? '');
$conteudo  = trim($_POST['conteudo']  ?? '');

if (!$nome || !$categoria || !$conteudo) {
    echo json_encode(['success' => false, 'erro' => 'Todos os campos são obrigatórios.']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO templates_documentos (nome, categoria, conteudo) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nome, $categoria, $conteudo);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'id' => $stmt->insert_id]);
} else {
    echo json_encode(['success' => false, 'erro' => 'Erro ao salvar template.']);
}

$stmt->close();
