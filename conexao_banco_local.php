<?php
$host = "localhost";
$usuario = "root";      // coloque seu usuário do MySQL
$senha = "";            // senha (deixe vazio se não tiver)
$banco = "sigespro";

$conn = new mysqli($host, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
?>
