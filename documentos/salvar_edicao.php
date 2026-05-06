<?php
require '../conexao.php';
require '../cloudinary_helper.php';

$id          = $_POST['id']          ?? '';
$nome        = $_POST['nome']        ?? '';
$categoria   = $_POST['categoria']   ?? '';
$responsavel = $_POST['responsavel'] ?? '';

$stmt = $conn->prepare("SELECT arquivo FROM documentos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$doc = $stmt->get_result()->fetch_assoc();

if (!$doc) {
    header("Location: documentos.php");
    exit;
}

$arquivoAtual = $doc['arquivo'];

if (!empty($_FILES['arquivo']['name'])) {
    $result = cloudinary_upload($_FILES['arquivo']['tmp_name'], basename($_FILES['arquivo']['name']));

    if (isset($result['secure_url'])) {
        cloudinary_delete_by_url($arquivoAtual);
        $arquivoFinal = $result['secure_url'];
    } else {
        $arquivoFinal = $arquivoAtual;
    }
} else {
    $arquivoFinal = $arquivoAtual;
}

$stmt2 = $conn->prepare("UPDATE documentos SET nome=?, categoria=?, responsavel=?, arquivo=? WHERE id=?");
$stmt2->bind_param("ssssi", $nome, $categoria, $responsavel, $arquivoFinal, $id);
$stmt2->execute();

header("Location: documentos.php");
exit;
?>
