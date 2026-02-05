<?php
session_start();
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $meu_id = $_SESSION['user_id'];

    // Verifica se o trabalho pertence mesmo ao usuário logado antes de apagar
    $res = mysqli_query($conn, "SELECT imagem FROM portfolio WHERE id = $id AND id_usuario = $meu_id");
    if ($t = mysqli_fetch_assoc($res)) {
        unlink("uploads/portfolio/" . $t['imagem']); // Apaga o arquivo da pasta
        mysqli_query($conn, "DELETE FROM portfolio WHERE id = $id");
    }
}
header("Location: meu_portfolio.php");
?>