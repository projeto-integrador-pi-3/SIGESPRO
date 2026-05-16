<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require '../conexao.php';
require '../cloudinary_helper.php';

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'erro' => 'Não autenticado.']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

$pdfBase64  = $input['pdf_base64']  ?? '';
$nome       = trim($input['nome']   ?? '');
$categoria  = trim($input['categoria'] ?? '');
$responsavel = trim($_SESSION['usuario_nome'] ?? '');

if (!$pdfBase64 || !$nome || !$categoria) {
    echo json_encode(['success' => false, 'erro' => 'Dados incompletos.']);
    exit;
}

$filename = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $nome) . '_' . date('Ymd_His') . '.pdf';
$result   = cloudinary_upload_base64($pdfBase64, $filename);

if (empty($result['secure_url'])) {
    echo json_encode(['success' => false, 'erro' => 'Erro ao enviar para o Cloudinary.']);
    exit;
}

$url  = $result['secure_url'];
$stmt = $conn->prepare("INSERT INTO documentos (nome, categoria, responsavel, arquivo, data_upload) VALUES (?, ?, ?, ?, NOW())");
$stmt->bind_param("ssss", $nome, $categoria, $responsavel, $url);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'url' => $url]);
} else {
    echo json_encode(['success' => false, 'erro' => 'Erro ao registrar documento.']);
}

$stmt->close();
