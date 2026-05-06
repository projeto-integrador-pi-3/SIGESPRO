<?php
require '../conexao.php';
require '../cloudinary_helper.php';

$id = $_POST['id'] ?? '';

if ($id) {
    $stmt = $conn->prepare("SELECT arquivo FROM documentos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();

    if ($row) {
        cloudinary_delete_by_url($row['arquivo']);
    }

    $stmt2 = $conn->prepare("DELETE FROM documentos WHERE id = ?");
    $stmt2->bind_param("i", $id);
    $stmt2->execute();

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'erro' => 'ID não informado.']);
}
?>
