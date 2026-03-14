<?php
require '../conexao.php';

$sql = "SELECT * FROM documentos ORDER BY data_upload DESC";
$result = $conn->query($sql);
$docs = [];

while ($row = $result->fetch_assoc()) {
  $docs[] = $row;
}

echo json_encode($docs);
?>
