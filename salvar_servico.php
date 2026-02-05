<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_free = $_SESSION['user_id'];
    $titulo = $_POST['titulo'];
    $cat = $_POST['categoria'];
    $preco = $_POST['preco'];
    $desc = $_POST['descricao'];

    $sql = "INSERT INTO servicos (id_freelancer, titulo, categoria, preco, descricao) 
            VALUES ('$id_free', '$titulo', '$cat', '$preco', '$desc')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Serviço publicado com sucesso!'); window.location.href='dashboard.php';</script>";
    }
}
?>