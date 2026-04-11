<?php
require '../conexao.php';

$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';
$perfil = $_POST['perfil'] ?? '';

if ($nome && $email && $senha && $perfil) {
  $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
  $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, perfil) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $nome, $email, $senhaHash, $perfil);

  if ($stmt->execute()) {
    echo json_encode(['success' => true]);
  } else {
    echo json_encode(['success' => false, 'erro' => 'Erro ao salvar usuário.']);
  }
} else {
  echo json_encode(['success' => false, 'erro' => 'Todos os campos são obrigatórios.']);
}
