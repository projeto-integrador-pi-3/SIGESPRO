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

// Normaliza raw/upload (legado) para image/upload
$url = str_replace('/raw/upload/', '/image/upload/', $row['arquivo']);

// Insere fl_attachment para forçar download no browser
$nomeArquivo = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $row['nome']);
$url = str_replace('/image/upload/', '/image/upload/fl_attachment:' . $nomeArquivo . '/', $url);

header('Location: ' . $url);
exit;
