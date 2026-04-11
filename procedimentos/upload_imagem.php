<?php

if (!defined('BASE_URL')) {
    include_once __DIR__ . '../config.php';
}

$targetDir = __DIR__ . "/uploads/";

if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

if (!empty($_FILES['file']['name'])) {
    $fileName = uniqid() . "_" . basename($_FILES['file']['name']);
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
        echo json_encode(["location" => BASE_URL . "/procedimentos/uploads/" . $fileName]);
    } else {
        http_response_code(500);
        echo json_encode(["erro" => "Falha ao mover imagem"]);
    }
}
?>
