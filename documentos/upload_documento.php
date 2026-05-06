<?php
require '../conexao.php';
require '../cloudinary_helper.php';

$nome        = $_POST['nome']        ?? '';
$categoria   = $_POST['categoria']   ?? '';
$responsavel = $_POST['responsavel'] ?? '';

if ($_FILES['arquivo']['error'] === UPLOAD_ERR_OK) {
    $result = cloudinary_upload($_FILES['arquivo']['tmp_name'], basename($_FILES['arquivo']['name']));

    if (isset($result['secure_url'])) {
        $url  = $result['secure_url'];
        $sql  = "INSERT INTO documentos (nome, categoria, responsavel, arquivo, data_upload) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nome, $categoria, $responsavel, $url);
        $stmt->execute();
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'erro' => 'Falha no upload para a nuvem.']);
    }
} else {
    echo json_encode(['success' => false, 'erro' => 'Erro no upload.']);
}
?>
