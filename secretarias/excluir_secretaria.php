<?php
require '../conexao.php';

$id = $_POST['id'] ?? '';

if ($id) {
  $stmt = $conn->prepare("DELETE FROM secretarias WHERE id=?");
  $stmt->bind_param("i", $id);

  if ($stmt->execute()) {
    echo json_encode(['success' => true]);
  } else {
    echo json_encode(['success' => false, 'erro' => 'Erro ao excluir secretaria.']);
  }
} else {
  echo json_encode(['success' => false, 'erro' => 'ID não informado.']);
}
?>
