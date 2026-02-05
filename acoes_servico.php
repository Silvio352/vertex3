<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) { exit(); }

$id_servico = mysqli_real_escape_string($conn, $_GET['id']);
$meu_id = $_SESSION['user_id'];
$meu_nivel = $_SESSION['nivel'];

// Verifica se o serviço pertence ao usuário ou se ele é admin
$check = mysqli_query($conn, "SELECT id_freelancer FROM servicos WHERE id = '$id_servico'");
$dados = mysqli_fetch_assoc($check);

if ($dados['id_freelancer'] == $meu_id || $meu_nivel == 'admin') {
    if ($_GET['acao'] == 'apagar') {
        mysqli_query($conn, "DELETE FROM servicos WHERE id = '$id_servico'");
        header("Location: buscar_servicos.php?sucesso=Serviço eliminado.");
    }
} else {
    header("Location: buscar_servicos.php?erro=Sem permissão.");
}
?>