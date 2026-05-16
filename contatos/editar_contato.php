<?php
require '../conexao.php';

$id          = $_POST['id']          ?? '';
$tipo        = $_POST['tipo']        ?? '';
$nome        = $_POST['nome']        ?? '';
$endereco    = $_POST['endereco']    ?? '';
$telefone    = $_POST['telefone']    ?? '';
$email       = $_POST['email']       ?? '';
$responsavel = $_POST['responsavel'] ?? '';

$area                  = $tipo === 'subprefeitura' ? ($_POST['area']                   ?? '') : null;
$numero_sei            = $tipo === 'fornecedor'    ? ($_POST['numero_sei']              ?? '') : null;
$responsavel_financeiro = $tipo === 'fornecedor'   ? ($_POST['responsavel_financeiro']  ?? '') : null;
$valor_contrato        = $tipo === 'fornecedor'    ? ($_POST['valor_contrato']          ?? '') : null;
$vigencia_inicio       = $tipo === 'fornecedor'    ? ($_POST['vigencia_inicio']         ?: null) : null;
$vigencia_fim          = $tipo === 'fornecedor'    ? ($_POST['vigencia_fim']            ?: null) : null;

header('Content-Type: application/json; charset=utf-8');

if (!$id || !$tipo || !$nome) {
    echo json_encode(['success' => false, 'erro' => 'Campos obrigatórios ausentes']);
    exit;
}

$stmt = $conn->prepare("UPDATE contatos SET tipo=?, nome=?, endereco=?, telefone=?, email=?, responsavel=?, responsavel_financeiro=?, area=?, numero_sei=?, valor_contrato=?, vigencia_inicio=?, vigencia_fim=? WHERE id=?");
$stmt->bind_param("ssssssssssssi", $tipo, $nome, $endereco, $telefone, $email, $responsavel, $responsavel_financeiro, $area, $numero_sei, $valor_contrato, $vigencia_inicio, $vigencia_fim, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'erro' => 'Erro ao editar contato']);
}

$stmt->close();
