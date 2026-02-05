<?php
session_start();
include 'config.php';
$meu_id = $_SESSION['user_id'];

// Processar Upload de Novo Trabalho
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
    $desc = mysqli_real_escape_string($conn, $_POST['descricao']);

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $nome_img = time() . "_port_" . $_SESSION['user_id'] . "." . $ext;
        move_uploaded_file($_FILES['imagem']['tmp_name'], "uploads/portfolio/" . $nome_img);

        mysqli_query($conn, "INSERT INTO portfolio (id_usuario, titulo, descricao, imagem) VALUES ($meu_id, '$titulo', '$desc', '$nome_img')");
    }
}

$meus_trabalhos = mysqli_query($conn, "SELECT * FROM portfolio WHERE id_usuario = $meu_id");
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Portfólio | Vertex</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="layout-container">
    <?php include 'sidebar.php'; ?>
    <div class="main-content">
        <h1>🎨 Meu Portfólio Profissional</h1>

        <div class="card">
            <h3>Adicionar Novo Trabalho</h3>
            <form method="POST" enctype="multipart/form-data">
                <input type="text" name="titulo" placeholder="Título do Projeto (Ex: Website para Advocacia)" required>
                <textarea name="descricao" placeholder="Breve descrição do que você fez..."></textarea>
                <label>Imagem do Trabalho:</label>
                <input type="file" name="imagem" accept="image/*" required>
                <button type="submit" class="btn-action">PUBLICAR NO MEU PERFIL</button>
            </form>
        </div>

        <h2>Trabalhos Publicados</h2>
        <div class="portfolio-grid">
            <?php while($t = mysqli_fetch_assoc($meus_trabalhos)): ?>
                <div class="portfolio-item">
                    <img src="uploads/portfolio/<?php echo $t['imagem']; ?>">
                    <div style="padding: 15px;">
                        <h4 style="margin: 0; color: var(--gold);"><?php echo $t['titulo']; ?></h4>
                        <p style="font-size: 12px; color: var(--slate);"><?php echo $t['descricao']; ?></p>
                        <a href="excluir_portfolio.php?id=<?php echo $t['id']; ?>" style="color: #f87171; font-size: 11px;">Excluir</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>
</body>
</html>