<?php
require '../conexao.php';

$nome = $_POST['nome'] ?? '';
$categoria = $_POST['categoria'] ?? '';
$responsavel = $_POST['responsavel'] ?? '';

if ($_FILES['arquivo']['error'] === UPLOAD_ERR_OK) {
  $arquivoTmp = $_FILES['arquivo']['tmp_name'];
  $nomeArquivo = basename($_FILES['arquivo']['name']);
  $destino = __DIR__ . "/uploads/" . $nomeArquivo;

  if (move_uploaded_file($arquivoTmp, $destino)) {
    $sql = "INSERT INTO documentos (nome, categoria, responsavel, arquivo, data_upload) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nome, $categoria, $responsavel, $nomeArquivo);
    $stmt->execute();
    echo json_encode(['success' => true]);
  } else {
    echo json_encode(['success' => false, 'erro' => 'Falha ao mover o arquivo.']);
  }
} else {
  echo json_encode(['success' => false, 'erro' => 'Erro no upload.']);
}
?>
