<?php
// Mantido para compatibilidade com links antigos — redireciona para a URL do Cloudinary
require_once __DIR__ . '/../login/verifica_login.php';
require __DIR__ . '/../conexao.php';

$id = intval($_GET['id'] ?? 0);
if (!$id) { http_response_code(400); exit; }

$stmt = $conn->prepare("SELECT arquivo FROM documentos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if (!$row || !$row['arquivo']) { http_response_code(404); exit; }

header('Location: ' . $row['arquivo']);
exit;
