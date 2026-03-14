<?php
require '../conexao.php';

$sql = "SELECT * FROM secretarias ORDER BY id DESC";
$result = $conn->query($sql);
$secretarias = [];

while ($row = $result->fetch_assoc()) {
  $secretarias[] = $row;
}

echo json_encode($secretarias);
?>
