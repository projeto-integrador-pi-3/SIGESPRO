<?php
require '../conexao.php';

$id = $_POST['id'] ?? '';
$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';
$perfil = $_POST['perfil'] ?? '';

if ($id && $nome && $email && $perfil) {
  if ($senha) {
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE usuarios SET nome=?, email=?, senha=?, perfil=? WHERE id=?");
    $stmt->bind_param("ssssi", $nome, $email, $senhaHash, $perfil, $id);
  } else {
    $stmt = $conn->prepare("UPDATE usuarios SET nome=?, email=?, perfil=? WHERE id=?");
    $stmt->bind_param("sssi", $nome, $email, $perfil, $id);
  }

  if ($stmt->execute()) {
    echo json_encode(['success' => true]);
  } else {
    echo json_encode(['success' => false, 'erro' => 'Erro ao atualizar usuário.']);
  }
} else {
  echo json_encode(['success' => false, 'erro' => 'Campos obrigatórios ausentes.']);
}
