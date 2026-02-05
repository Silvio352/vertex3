<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['nivel'] != 'admin') { die("Acesso Negado"); }

$id_usuario = $_GET['id'];
$acao = $_GET['acao'];

if ($acao == 'aprovar') {
    $sql = "UPDATE usuarios SET status_verificacao = 'Verificado' WHERE id = $id_usuario";
} else {
    $sql = "DELETE FROM usuarios WHERE id = $id_usuario"; // Se rejeitar, apaga o cadastro
}

if (mysqli_query($conn, $sql)) {
    header("Location: admin.php");
}
?>