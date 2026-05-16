<?php
require_once '../login/verifica_login.php';
require '../conexao.php';

$result = $conn->query("SELECT id, nome, categoria, conteudo, created_at, updated_at FROM templates_documentos ORDER BY nome ASC");

$dados = [];
while ($row = $result->fetch_assoc()) {
    $dados[] = $row;
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($dados);
