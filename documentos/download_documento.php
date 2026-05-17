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

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_TIMEOUT        => 30,
    CURLOPT_USERAGENT      => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',
]);
$data     = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlErr  = curl_error($ch);
curl_close($ch);

if ($httpCode !== 200 || !$data) {
    header('Content-Type: text/plain');
    echo "HTTP: $httpCode | URL: $url | cURL error: $curlErr";
    exit;
}

$filename = preg_replace('/[^a-zA-Z0-9 _\-]/', '_', $row['nome']) . '.pdf';
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Length: ' . strlen($data));
echo $data;
