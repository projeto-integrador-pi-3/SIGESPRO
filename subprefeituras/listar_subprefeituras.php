<?php
require '../conexao.php';

$sql = "SELECT * FROM subprefeituras ORDER BY nome ASC";
$result = $conn->query($sql);

$dados = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $dados[] = $row;
    }
}

echo json_encode($dados);
?>
