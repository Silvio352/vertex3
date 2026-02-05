<?php
session_start();
include 'config.php';

// Só admin ou moderador podem enviar avisos
if ($_SESSION['nivel'] != 'admin' && $_SESSION['nivel'] != 'moderador') {
    die("Acesso negado.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $aviso = mysqli_real_escape_string($conn, $_POST['aviso']);
    $meu_id = $_SESSION['user_id'];

    // Seleciona todos os usuários exceto eu
    $usuarios = mysqli_query($conn, "SELECT id FROM usuarios WHERE id != '$meu_id'");

    while ($u = mysqli_fetch_assoc($usuarios)) {
        $dest_id = $u['id'];
        // id_servico = 0 marca como mensagem geral/global
        mysqli_query($conn, "INSERT INTO mensagens (id_remetente, id_destinatario, id_servico, mensagem, lida) 
                             VALUES ('$meu_id', '$dest_id', 0, '$aviso', 0)");
    }

    echo "<script>alert('Mensagem enviada a todos!'); window.location.href='admin.php';</script>";
}
?>