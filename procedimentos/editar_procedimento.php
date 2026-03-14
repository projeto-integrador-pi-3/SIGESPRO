<?php
require '../conexao.php';

$id = $_POST['id'] ?? '';
$titulo = $_POST['titulo'] ?? '';
$resumo = $_POST['resumo'] ?? '';
$tipo = $_POST['tipo'] ?? '';
$descricao = $_POST['descricao'] ?? '';

if ($id && $titulo && $resumo && $tipo && $descricao) {
    $stmt = $conn->prepare("UPDATE procedimentos SET titulo = ?, resumo = ?, tipo = ?, descricao = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $titulo, $resumo, $tipo, $descricao, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'erro' => 'Erro ao atualizar procedimento']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'erro' => 'Todos os campos são obrigatórios']);
}
?>
