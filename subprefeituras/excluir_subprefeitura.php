<?php
require '../conexao.php';

$id = $_POST['id'] ?? '';

if($id) {
    $stmt = $conn->prepare("DELETE FROM subprefeituras WHERE id=?");
    $stmt->bind_param("i", $id);

    if($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'erro' => 'Erro ao excluir registro']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'erro' => 'ID inválido']);
}
?>
