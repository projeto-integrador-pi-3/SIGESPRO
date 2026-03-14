<?php
require '../conexao.php';

$titulo = $_POST['titulo'] ?? '';
$resumo = $_POST['resumo'] ?? '';
$tipo = $_POST['tipo'] ?? '';
$descricao = $_POST['descricao'] ?? '';

if($titulo && $resumo && $tipo && $descricao) {
    $stmt = $conn->prepare("INSERT INTO procedimentos (titulo, resumo, tipo, descricao) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $titulo, $resumo, $tipo, $descricao);

    if($stmt->execute()) {
        echo json_encode(['success' => true, 'id' => $stmt->insert_id]);
    } else {
        echo json_encode(['success' => false, 'erro' => 'Erro ao salvar procedimento']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'erro' => 'Todos os campos são obrigatórios']);
}
?>
