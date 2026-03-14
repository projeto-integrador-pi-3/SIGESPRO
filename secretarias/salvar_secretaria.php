<?php
require '../conexao.php';

$nome = $_POST['nome'] ?? '';
$endereco = $_POST['endereco'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$email = $_POST['email'] ?? '';
$responsavel = $_POST['responsavel'] ?? '';

if ($nome && $endereco && $telefone && $email && $responsavel) {
  $stmt = $conn->prepare("INSERT INTO secretarias (nome, endereco, telefone, email, responsavel) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $nome, $endereco, $telefone, $email, $responsavel);

  if ($stmt->execute()) {
    echo json_encode(['success' => true]);
  } else {
    echo json_encode(['success' => false, 'erro' => 'Erro ao salvar secretaria.']);
  }
} else {
  echo json_encode(['success' => false, 'erro' => 'Todos os campos são obrigatórios.']);
}
?>
