<?php
require '../conexao.php';

$id = $_POST['id'] ?? '';

header('Content-Type: application/json; charset=utf-8');

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
