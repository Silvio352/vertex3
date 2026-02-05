<?php
session_start();
include 'config.php';

// Segurança: Só o Admin pode apagar
if ($_SESSION['nivel'] != 'admin') {
    header("Location: dashboard.php");
    exit();
}

// Apaga todas as mensagens que possuem id_servico = 0 (Avisos Globais)
$sql = "DELETE FROM mensagens WHERE id_servico = 0";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Todos os avisos foram removidos!'); window.location.href='admin.php';</script>";
} else {
    echo "Erro ao remover avisos: " . mysqli_error($conn);
}
?>