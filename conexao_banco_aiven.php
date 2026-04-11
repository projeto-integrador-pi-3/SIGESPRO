<?php
$host = "mysql-sigespro-sigespro.l.aivencloud.com";
$porta = "20522";
$usuario = "";      // coloque seu usuário do MySQL
$senha = "";            // senha (deixe vazio se não tiver)
$banco = "sigespro";

$ssl_ca = realpath(__DIR__ . "/ca.pem");

$conn = mysqli_init();
mysqli_ssl_set($conn, NULL, NULL, $ssl_ca, NULL, NULL);

if (!mysqli_real_connect($conn, $host, $usuario, $senha, $banco, $porta, NULL, MYSQLI_CLIENT_SSL)) {
    die("Erro ao conectar ao MySQL: " . mysqli_connect_error());
}

?>
