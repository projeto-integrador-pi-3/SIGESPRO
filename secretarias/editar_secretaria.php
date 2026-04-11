<?php
require '../conexao.php';

$id = $_POST['id'] ?? '';
$nome = $_POST['nome'] ?? '';
$endereco = $_POST['endereco'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$email = $_POST['email'] ?? '';
$responsavel = $_POST['responsavel'] ?? '';

if ($id && $nome && $endereco && $telefone && $email && $responsavel) {
  $stmt = $conn->prepare("UPDATE secretarias SET nome=?, endereco=?, telefone=?, email=?, responsavel=? WHERE id=?");
  $stmt->bind_param("sssssi", $nome, $endereco, $telefone, $email, $responsavel, $id);

  if ($stmt->execute()) {
    echo json_encode(['success' => true]);
  } else {
    echo json_encode(['success' => false, 'erro' => 'Erro ao editar secretaria.']);
  }
} else {
  echo json_encode(['success' => false, 'erro' => 'Todos os campos são obrigatórios.']);
}
?>
