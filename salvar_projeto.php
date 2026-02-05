<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_cli = $_SESSION['user_id'];
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
    $desc = mysqli_real_escape_string($conn, $_POST['descricao']);
    $orc = $_POST['orcamento'];
    $prazo = $_POST['prazo'];

    $sql = "INSERT INTO solicitacoes_projeto (id_cliente, titulo, descricao, orcamento_estimado, prazo_entrega) 
            VALUES ($id_cli, '$titulo', '$desc', $orc, '$prazo')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Projeto publicado! Freelancers entrarão em contacto.'); window.location.href='dashboard.php';</script>";
    }
}
?>