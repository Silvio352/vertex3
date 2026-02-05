<?php
session_start();
include 'config.php';

$id_servico = $_GET['id'];
$sql = "SELECT servicos.*, usuarios.nome, usuarios.escola_univ, usuarios.status_verificacao 
        FROM servicos 
        JOIN usuarios ON servicos.id_freelancer = usuarios.id 
        WHERE servicos.id = $id_servico";
$resultado = mysqli_query($conn, $sql);
$s = mysqli_fetch_assoc($resultado);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title><?php echo $s['titulo']; ?> | Vertex</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="navbar">
    <div class="logo">VERTEX</div>
    <div><a href="buscar_servicos.php" style="color: white;">Voltar</a></div>
</div>

<div style="max-width: 800px; margin: 50px auto; background: #112240; padding: 40px; border-radius: 15px;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
            <span style="color: var(--gold); font-weight: bold;"><?php echo $s['categoria']; ?></span>
            <h1 style="margin-top: 5px;"><?php echo $s['titulo']; ?></h1>
        </div>
        <div style="text-align: right;">
            <span style="font-size: 28px; color: #4ade80; font-weight: bold;"><?php echo $s['preco']; ?> €</span>
        </div>
    </div>

    <hr style="border: 0.5px solid #233554; margin: 30px 0;">

    <h3>Descrição do Serviço</h3>
    <p style="color: #ccd6f6; line-height: 1.8; white-space: pre-line;"><?php echo $s['descricao']; ?></p>

    <div style="background: #0a192f; padding: 20px; border-radius: 10px; margin-top: 30px; border: 1px dashed var(--gold);">
        <h4 style="margin-top: 0; color: var(--gold);">Informações do Profissional</h4>
        <p>👨‍🏫 Nome: <?php echo $s['nome']; ?></p>
        <p>🎓 Instituição: <?php echo $s['escola_univ']; ?></p>
        <p>✅ Status: <span style="color: #4ade80;"><?php echo $s['status_verificacao']; ?></span></p>
    </div>

    <div style="margin-top: 40px; text-align: center;">
        <p style="font-size: 13px; color: #8892b0; margin-bottom: 20px;">
            🔒 <b>Pagamento Seguro:</b> O valor será retido pela Vertex e só será libertado após a entrega do trabalho.
        </p>
        <a href="chat.php?id_servico=<?php echo $s['id']; ?>&id_destinatario=<?php echo $s['id_freelancer']; ?>" class="btn-action" style="text-align: center; width: 100%; display: block;">
            INICIAR NEGOCIAÇÃO / CHAT
        </a>
    </div>
</div>
</body>
</html>