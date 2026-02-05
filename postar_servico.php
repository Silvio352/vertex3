<?php
session_start();
if ($_SESSION['tipo'] != 'freelancer') { header("Location: dashboard.php"); }
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Postar Serviço | Vertex</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h2 style="color: var(--gold);">O que você oferece?</h2>
    <form action="salvar_servico.php" method="POST">
        <input type="text" name="titulo" placeholder="Título do Serviço (Ex: Resolução de Exercícios de Cálculo)" required>

        <select name="categoria">
            <option value="Academico">Trabalhos Acadêmicos</option>
            <option value="Programacao">Programação / IT</option>
            <option value="Design">Design e Artes</option>
            <option value="Escrita">Tradução e Escrita</option>
        </select>

        <input type="number" name="preco" placeholder="Preço Base (Ex: 50.00)" step="0.01" required>

        <textarea name="descricao" placeholder="Descreva detalhadamente sua experiência e o que entrega..." style="width: 100%; height: 150px; background: #0a192f; color: white; border: 1px solid #233554; padding: 10px; border-radius: 4px;"></textarea>

        <button type="submit">PUBLICAR SERVIÇO</button>
    </form>
</div>
</body>
</html>
