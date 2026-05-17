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

$apiSecret = $_ENV['CLOUDINARY_API_SECRET'] ?? getenv('CLOUDINARY_API_SECRET');

// Normaliza raw/upload (legado) para image/upload
$rawUrl = str_replace('/raw/upload/', '/image/upload/', $row['arquivo']);

// Gera URL de entrega assinada (necessário para recursos com acesso restrito)
$url = cloudinary_signed_delivery_url($rawUrl, $apiSecret);

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_TIMEOUT        => 30,
    CURLOPT_USERAGENT      => 'Mozilla/5.0',
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

function cloudinary_signed_delivery_url(string $url, string $apiSecret): string {
    if (!preg_match('|cloudinary\.com/([^/]+)/(\w+)/upload/(v\d+/)?(.+)$|', $url, $m)) {
        return $url;
    }

    $cloudName    = $m[1];
    $resourceType = $m[2];
    $version      = rtrim($m[3] ?? '', '/');
    $fileWithExt  = $m[4];

    // Para image, o public_id não inclui extensão na assinatura
    $publicId = ($resourceType === 'image')
        ? preg_replace('/\.[^.]+$/', '', $fileWithExt)
        : $fileWithExt;

    $toSign = ($version ? $version . '/' : '') . $publicId;
    $sig    = substr(strtr(base64_encode(sha1($toSign . $apiSecret, true)), '+/', '-_'), 0, 8);

    $versionPath = $version ? $version . '/' : '';
    return "https://res.cloudinary.com/$cloudName/$resourceType/upload/s--$sig--/$versionPath$fileWithExt";
}
