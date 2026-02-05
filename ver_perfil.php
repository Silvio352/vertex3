<?php
session_start();
include 'config.php';

if (!isset($_GET['id'])) { header("Location: dashboard.php"); exit(); }

$id_freelancer = mysqli_real_escape_string($conn, $_GET['id']);

// 1. Busca dados do freelancer
$sql_user = "SELECT * FROM usuarios WHERE id = $id_freelancer";
$res_user = mysqli_query($conn, $sql_user);
$f = mysqli_fetch_assoc($res_user);

if (!$f) { die("Usuário não encontrado."); }

// 2. Busca o portfólio
$portfolio = mysqli_query($conn, "SELECT * FROM portfolio WHERE id_usuario = $id_freelancer ORDER BY id DESC");

// 3. Busca Avaliações e calcula a média de estrelas
$avaliacoes = mysqli_query($conn, "SELECT a.*, u.nome as nome_cliente, u.foto_perfil as foto_cliente 
                                   FROM avaliacoes a 
                                   JOIN usuarios u ON a.id_cliente = u.id 
                                   WHERE a.id_freelancer = $id_freelancer 
                                   ORDER BY a.data_avaliacao DESC");

$stats = mysqli_fetch_assoc(mysqli_query($conn, "SELECT AVG(estrelas) as media, COUNT(id) as total FROM avaliacoes WHERE id_freelancer = $id_freelancer"));
$media_estrelas = round($stats['media'], 1);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de <?php echo $f['nome']; ?> | Vertex</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .star-gold { color: #f59e0b; font-size: 1.2rem; }
        .star-gray { color: #233554; font-size: 1.2rem; }
        .review-card { background: #0a192f; padding: 15px; border-radius: 8px; margin-bottom: 10px; border: 1px solid #233554; }
    </style>
</head>
<body>
<div class="layout-container">
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="card" style="text-align: center;">
            <img src="uploads/perfis/<?php echo $f['foto_perfil']; ?>" style="width: 120px; height: 120px; border-radius: 50%; border: 4px solid var(--gold); object-fit: cover;">
            <h1><?php echo $f['nome']; ?></h1>

            <div style="margin-bottom: 10px;">
                <?php
                for($i=1; $i<=5; $i++) {
                    echo ($i <= $media_estrelas) ? '<span class="star-gold">★</span>' : '<span class="star-gray">★</span>';
                }
                echo " <small>($media_estrelas / 5)</small>";
                ?>
            </div>

            <p style="color: var(--gold); font-weight: bold;"><?php echo $f['profissao'] ?: 'Membro Vertex'; ?></p>
            <p style="color: var(--slate); font-size: 14px;"><?php echo $f['formacao']; ?> | <?php echo $f['escola_univ']; ?></p>

            <a href="chat.php?id_destinatario=<?php echo $f['id']; ?>&id_servico=0" class="btn-action" style="margin-top: 15px;">MANDAR MENSAGEM</a>
        </div>

        <div class="card">
            <h3 style="color: var(--gold);">Biografia Profissional</h3>
            <p><?php echo nl2br($f['biografia']) ?: 'Nenhuma biografia disponível.'; ?></p>
        </div>

        <h2 style="margin-top: 30px;">🎨 Portfólio</h2>
        <div class="portfolio-grid">
            <?php while($t = mysqli_fetch_assoc($portfolio)): ?>
                <div class="portfolio-item">
                    <img src="uploads/portfolio/<?php echo $t['imagem']; ?>">
                    <div style="padding: 10px;">
                        <h4 style="margin:0;"><?php echo $t['titulo']; ?></h4>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <h2 style="margin-top: 40px;">⭐ Avaliações dos Clientes</h2>
        <div class="card">
            <?php if(mysqli_num_rows($avaliacoes) > 0): ?>
                <?php while($a = mysqli_fetch_assoc($avaliacoes)): ?>
                    <div class="review-card">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                            <img src="uploads/perfis/<?php echo $a['foto_cliente']; ?>" width="30" height="30" style="border-radius: 50%;">
                            <strong><?php echo $a['nome_cliente']; ?></strong>
                            <div style="margin-left: auto;">
                                <?php for($i=1; $i<=5; $i++) echo ($i <= $a['estrelas']) ? '⭐' : '☆'; ?>
                            </div>
                        </div>
                        <p style="font-style: italic; color: var(--slate); font-size: 14px;">"<?php echo $a['comentario']; ?>"</p>
                        <small style="font-size: 10px; color: #444;"><?php echo date('d/m/Y', strtotime($a['data_avaliacao'])); ?></small>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Este freelancer ainda não recebeu avaliações.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>