<?php
include '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $area = $_POST['area'];
    $responsavel = $_POST['responsavel'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $local = $_POST['local'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("INSERT INTO sistemas (nome, area, responsavel, email, telefone, local, status)
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $nome, $area, $responsavel, $email, $telefone, $local, $status);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "id" => $conn->insert_id]);
    } else {
        echo json_encode(["success" => false, "erro" => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
