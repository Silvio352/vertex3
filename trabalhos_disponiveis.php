<?php
session_start();
include 'config.php';
// Busca projetos abertos de clientes
$sql = "SELECT p.*, u.nome as cliente_nome FROM solicitacoes_projeto p 
        JOIN usuarios u ON p.id_cliente = u.id 
        WHERE p.status = 'aberto' ORDER BY p.data_publicacao DESC";
$resultado = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Projetos Disponíveis | Vertex</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="layout-container">
    <?php include 'sidebar.php'; ?>
    <div class="main-content">
        <h1>🚀 Oportunidades de Trabalho</h1>
        <p>Responda a estas solicitações para ganhar dinheiro.</p>

        <?php while($p = mysqli_fetch_assoc($resultado)): ?>
            <div class="card" style="border-left: 5px solid var(--gold);">
                <div style="display: flex; justify-content: space-between;">
                    <h3><?php echo $p['titulo']; ?></h3>
                    <span style="color: #4ade80; font-weight: bold;"><?php echo number_format($p['orcamento_estimado'], 2); ?> €/AOA</span>
                </div>
                <p style="font-size: 14px; color: #8892b0;">Publicado por: <b><?php echo $p['cliente_nome']; ?></b> | Prazo: <?php echo date('d/m/Y', strtotime($p['prazo_entrega'])); ?></p>
                <p><?php echo $p['descricao']; ?></p>

                <a href="chat.php?id_servico=0&id_destinatario=<?php echo $p['id_cliente']; ?>&prop=<?php echo urlencode($p['titulo']); ?>" class="btn-action">ENVIAR PROPOSTA</a>
            </div>
        <?php endwhile; ?>
    </div>
</div>
</body>
</html>