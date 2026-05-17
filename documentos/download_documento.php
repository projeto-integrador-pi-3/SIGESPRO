<?php
require_once __DIR__ . '/../login/verifica_login.php';
require __DIR__ . '/../conexao.php';

$id = intval($_GET['id'] ?? 0);
if (!$id) {
    http_response_code(400);
    exit;
}

$stmt = $conn->prepare("SELECT nome, arquivo FROM documentos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if (!$row || !$row['arquivo']) {
    http_response_code(404);
    exit;
}

$url = str_replace('/image/upload/', '/raw/upload/', $row['arquivo']);

$data = file_get_contents($url);
if ($data === false) {
    http_response_code(502);
    exit;
}

$filename = preg_replace('/[^a-zA-Z0-9 _\-]/', '_', $row['nome']) . '.pdf';

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Length: ' . strlen($data));
echo $data;
