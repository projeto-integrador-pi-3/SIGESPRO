<?php
include '../conexao.php';

$resultado = $conn->query("SELECT * FROM sistemas ORDER BY id DESC");

$sistemas = [];
while ($row = $resultado->fetch_assoc()) {
    $sistemas[] = $row;
}

echo json_encode($sistemas);
$conn->close();
?>
