<?php
require '../conexao.php';

$id = $_POST['id'];
$nome = $_POST['nome'];
$categoria = $_POST['categoria'];
$responsavel = $_POST['responsavel'];

$res = $conn->query("SELECT arquivo FROM documentos WHERE id = $id");
$doc = $res->fetch_assoc();
$arquivoAtual = $doc['arquivo'];

// Se enviou novo arquivo
if (!empty($_FILES['arquivo']['name'])) {
  $novoArquivo = time() . "_" . $_FILES['arquivo']['name'];
  $destino = __DIR__ . "/uploads/" . $novoArquivo;

  // Move novo arquivo
  if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $destino)) {
    // Deleta o antigo
    $caminhoAntigo = __DIR__ . "/uploads/" . $arquivoAtual;
    if (file_exists($caminhoAntigo)) unlink($caminhoAntigo);
  }

  $arquivoFinal = $novoArquivo;
} else {
  $arquivoFinal = $arquivoAtual;
}

$conn->query("
  UPDATE documentos 
  SET nome='$nome', categoria='$categoria', responsavel='$responsavel', arquivo='$arquivoFinal' 
  WHERE id = $id
");

header("Location: documentos.php");
exit;
?>
