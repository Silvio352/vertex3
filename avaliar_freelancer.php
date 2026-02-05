<?php
session_start();
include 'config.php';

if ($_SESSION['tipo'] != 'cliente') { header("Location: dashboard.php"); exit(); }

$id_free = mysqli_real_escape_string($conn, $_GET['id']);
$res_free = mysqli_query($conn, "SELECT nome FROM usuarios WHERE id = '$id_free'");
$free = mysqli_fetch_assoc($res_free);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_cli = $_SESSION['user_id'];
    $estrelas = $_POST['estrelas'];
    $coment = mysqli_real_escape_string($conn, $_POST['comentario']);

    $sql = "INSERT INTO avaliacoes (id_freelancer, id_cliente, estrelas, comentario) 
            VALUES ('$id_free', '$id_cli', '$estrelas', '$coment')";

    if (mysqli_query($conn, $sql)) {
        notificarUsuario($conn, $id_free, 'avaliacao');
        echo "<script>alert('Avaliação enviada com sucesso!'); window.location.href='ver_perfil.php?id=$id_free';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliar Freelancer | Vertex</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="layout-container">
    <?php include 'sidebar.php'; ?>
    <div class="main-content">
        <div class="card" style="max-width: 500px; margin: auto;">
            <h2 style="text-align: center;">Avaliar: <?php echo $free['nome']; ?></h2>
            <form method="POST">
                <label>Sua Nota:</label>
                <select name="estrelas" required>
                    <option value="5">⭐⭐⭐⭐⭐ (Excelente)</option>
                    <option value="4">⭐⭐⭐⭐ (Muito Bom)</option>
                    <option value="3">⭐⭐⭐ (Bom)</option>
                    <option value="2">⭐⭐ (Regular)</option>
                    <option value="1">⭐ (Pobre)</option>
                </select>

                <label>Comentário:</label>
                <textarea name="comentario" style="height: 120px;" placeholder="Conte como foi trabalhar com este profissional..." required></textarea>

                <button type="submit" class="btn-action" style="width: 100%; margin-top: 10px;">PUBLICAR AVALIAÇÃO</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>