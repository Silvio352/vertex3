<?php
session_start();
include 'config.php';
if ($_SESSION['user_id'] != 1) { die("Apenas o Dono pode aceder."); }

$solicitacoes = mysqli_query($conn, "SELECT s.*, u.nome as nome_antigo FROM solicitacoes_alteracao s 
                                     JOIN usuarios u ON s.id_usuario_alvo = u.id WHERE s.status = 'pendente'");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $s = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM solicitacoes_alteracao WHERE id = $id"));
    mysqli_query($conn, "UPDATE usuarios SET nome = '{$s['novo_nome']}', documento_id = '{$s['novo_documento']}' WHERE id = {$s['id_usuario_alvo']}");
    mysqli_query($conn, "UPDATE solicitacoes_alteracao SET status = 'aprovado' WHERE id = $id");
    header("Location: aprovar_mudancas.php");
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Segurança Crítica | Vertex</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="layout-container">
    <?php include 'sidebar.php'; ?>
    <div class="main-content">
        <h1>Pedidos de Alteração de Identidade</h1>
        <?php if(mysqli_num_rows($solicitacoes) == 0) echo "<p>Sem pedidos pendentes.</p>"; ?>

        <?php while($s = mysqli_fetch_assoc($solicitacoes)): ?>
            <div class="card">
                <p><strong>Usuário:</strong> <?php echo $s['nome_antigo']; ?></p>
                <p><strong>Quer mudar para:</strong> <?php echo $s['novo_nome']; ?> (ID: <?php echo $s['novo_documento']; ?>)</p>
                <a href="?id=<?php echo $s['id']; ?>" class="btn-action">Aprovar Mudança</a>
            </div>
        <?php endwhile; ?>
    </div>
</div>
</body>
</html>