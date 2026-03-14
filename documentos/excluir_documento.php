<?php
require '../conexao.php';

$id = $_POST['id'] ?? '';

if ($id) {
  $res = $conn->query("SELECT arquivo FROM documentos WHERE id = $id");
  if ($res && $row = $res->fetch_assoc()) {
    $arquivo = __DIR__ . "/uploads/" . $row['arquivo'];
    if (file_exists($arquivo)) unlink($arquivo);
  }

  $conn->query("DELETE FROM documentos WHERE id = $id");
  echo json_encode(['success' => true]);
} else {
  echo json_encode(['success' => false, 'erro' => 'ID não informado.']);
}
?>
