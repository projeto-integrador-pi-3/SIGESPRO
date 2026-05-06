<?php
function cloudinary_upload($fileTmp, $originalName) {
    $cloudName = $_ENV['CLOUDINARY_CLOUD_NAME'] ?? getenv('CLOUDINARY_CLOUD_NAME');
    $apiKey    = $_ENV['CLOUDINARY_API_KEY']    ?? getenv('CLOUDINARY_API_KEY');
    $apiSecret = $_ENV['CLOUDINARY_API_SECRET'] ?? getenv('CLOUDINARY_API_SECRET');

    $timestamp = time();
    $folder    = 'sigespro';

    $signature = sha1("folder=$folder&timestamp=$timestamp" . $apiSecret);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.cloudinary.com/v1_1/$cloudName/auto/upload");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, [
        'file'      => new CURLFile($fileTmp, '', $originalName),
        'api_key'   => $apiKey,
        'timestamp' => $timestamp,
        'signature' => $signature,
        'folder'    => $folder,
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

function cloudinary_delete_by_url($url) {
    if (!preg_match('|cloudinary\.com/[^/]+/(\w+)/upload/(?:v\d+/)?(.+)$|', $url, $m)) {
        return false;
    }

    $resourceType = $m[1];
    $publicId     = $m[2];

    if ($resourceType === 'image') {
        $publicId = preg_replace('/\.[^.]+$/', '', $publicId);
    }

    $cloudName = $_ENV['CLOUDINARY_CLOUD_NAME'] ?? getenv('CLOUDINARY_CLOUD_NAME');
    $apiKey    = $_ENV['CLOUDINARY_API_KEY']    ?? getenv('CLOUDINARY_API_KEY');
    $apiSecret = $_ENV['CLOUDINARY_API_SECRET'] ?? getenv('CLOUDINARY_API_SECRET');

    $timestamp = time();
    $signature = sha1("public_id=$publicId&timestamp=$timestamp" . $apiSecret);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.cloudinary.com/v1_1/$cloudName/$resourceType/destroy");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, [
        'public_id' => $publicId,
        'api_key'   => $apiKey,
        'timestamp' => $timestamp,
        'signature' => $signature,
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}
?>
