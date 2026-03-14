<?php
require '../conexao.php';

$nome = $_POST['nome'] ?? '';
$endereco = $_POST['endereco'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$email = $_POST['email'] ?? '';
$responsavel = $_POST['responsavel'] ?? '';
$area = $_POST['area'] ?? '';

if($nome && $endereco && $telefone && $email && $responsavel && $area) {
    $stmt = $conn->prepare("INSERT INTO subprefeituras (nome, endereco, telefone, email, responsavel, area) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nome, $endereco, $telefone, $email, $responsavel, $area);

    if($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'erro' => 'Erro ao salvar registro']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'erro' => 'Todos os campos são obrigatórios']);
}
?>
