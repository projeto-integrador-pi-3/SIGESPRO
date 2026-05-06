<?php
require_once __DIR__ . '/../env_loader.php';
require_once __DIR__ . '/../cloudinary_helper.php';

if (!empty($_FILES['file']['name'])) {
    $result = cloudinary_upload($_FILES['file']['tmp_name'], basename($_FILES['file']['name']));

    if (isset($result['secure_url'])) {
        echo json_encode(['location' => $result['secure_url']]);
    } else {
        http_response_code(500);
        echo json_encode(['erro' => 'Falha no upload para a nuvem.']);
    }
}
?>
