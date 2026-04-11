<?php
include '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $area = $_POST['area'];
    $responsavel = $_POST['responsavel'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $local = $_POST['local'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE sistemas SET nome = ?, area = ?, responsavel = ?, email = ?, telefone = ?, local = ?, status = ? WHERE id = ?");
    $stmt->bind_param("sssssssi", $nome, $area, $responsavel, $email, $telefone, $local, $status, $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "erro" => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
