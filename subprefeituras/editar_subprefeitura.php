<?php
require '../conexao.php';

$id = $_POST['id'] ?? '';
$nome = $_POST['nome'] ?? '';
$endereco = $_POST['endereco'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$email = $_POST['email'] ?? '';
$responsavel = $_POST['responsavel'] ?? '';
$area = $_POST['area'] ?? '';

if($id && $nome && $endereco && $telefone && $email && $responsavel && $area) {
    $stmt = $conn->prepare("UPDATE subprefeituras SET nome=?, endereco=?, telefone=?, email=?, responsavel=?, area=? WHERE id=?");
    $stmt->bind_param("ssssssi", $nome, $endereco, $telefone, $email, $responsavel, $area, $id);

    if($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'erro' => 'Erro ao editar registro']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'erro' => 'Campos obrigatórios ausentes']);
}
?>
