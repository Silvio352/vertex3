<?php
session_start();
include 'config.php'; // ISTO É O QUE ESTAVA A FALTAR

if (!isset($_SESSION['user_id']) || $_SESSION['tipo'] != 'cliente') {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Publicar Projeto | Vertex</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="layout-container">
    <?php include 'sidebar.php'; ?>
    <div class="main-content">
        <div class="card" style="max-width: 700px; margin: auto;">
            <h2>Do que você precisa?</h2>
            <p>Descreva o seu projeto para atrair os melhores freelancers.</p>

            <form action="salvar_projeto.php" method="POST">
                <label>Título Curto (Ex: Tradução de texto de Inglês)</label>
                <input type="text" name="titulo" placeholder="Ex: Resolver lista de exercícios de Física" required>

                <label>Descrição Detalhada</label>
                <textarea name="descricao" style="height: 150px;" placeholder="Explique o que deve ser feito..." required></textarea>

                <div style="display: flex; gap: 20px;">
                    <div style="flex: 1;">
                        <label>Orçamento (AOA/€)</label>
                        <input type="number" name="orcamento" step="0.01" required>
                    </div>
                    <div style="flex: 1;">
                        <label>Prazo de Entrega</label>
                        <input type="date" name="prazo" required>
                    </div>
                </div>

                <button type="submit" class="btn-action" style="width: 100%; margin-top: 20px;">PUBLICAR SOLICITAÇÃO</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
