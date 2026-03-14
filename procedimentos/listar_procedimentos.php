<?php
require '../conexao.php';

$result = $conn->query("SELECT id, titulo, resumo, tipo, descricao FROM procedimentos ORDER BY id DESC");
$dados = [];

while ($row = $result->fetch_assoc()) {
    $dados[] = $row;
}

echo json_encode($dados);
?>
