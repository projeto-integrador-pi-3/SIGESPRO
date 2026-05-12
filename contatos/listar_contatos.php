<?php
require '../conexao.php';

$sql = "SELECT * FROM contatos ORDER BY tipo ASC, nome ASC";
$result = $conn->query($sql);

$dados = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dados[] = $row;
    }
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($dados);
