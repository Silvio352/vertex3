<?php
session_start();
include 'config.php';

if ($_SESSION['nivel'] != 'admin' && $_SESSION['nivel'] != 'moderador') { die("Acesso Negado"); }

$id_alvo = $_GET['id'];
$acao = $_GET['acao'];

// SEGURANÇA: Moderador não pode apagar ou alterar um ADMIN
$check_admin = mysqli_query($conn, "SELECT nivel FROM usuarios WHERE id = '$id_alvo'");
$alvo = mysqli_fetch_assoc($check_admin);

if ($alvo['nivel'] == 'admin' && $_SESSION['nivel'] == 'moderador') {
    die("Erro: Um moderador não pode alterar um Administrador!");
}

if ($acao == 'aprovar_troca') {
    $u = mysqli_fetch_assoc(mysqli_query($conn, "SELECT status_verificacao FROM usuarios WHERE id = '$id_alvo'"));
    $novo_tipo = ($u['status_verificacao'] == 'quere_ser_freelancer') ? 'freelancer' : 'cliente';
    mysqli_query($conn, "UPDATE usuarios SET tipo_usuario = '$novo_tipo', status_verificacao = 'aprovado' WHERE id = '$id_alvo'");
}

if ($acao == 'aprovar') {
    mysqli_query($conn, "UPDATE usuarios SET status_verificacao = 'aprovado' WHERE id = '$id_alvo'");
} elseif ($acao == 'apagar') {
    mysqli_query($conn, "DELETE FROM usuarios WHERE id = '$id_alvo'");
}

header("Location: dashboard.php");
?>