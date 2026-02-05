<?php
session_start();
// Se já estiver logado, vai direto para o dashboard
if (isset($_SESSION['user_id'])) { header("Location: dashboard.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Vertex</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="auth-page">
<div class="auth-container">
    <h2 style="text-align:center; color: var(--gold); margin-bottom: 20px;">VERTEX LOGIN</h2>

    <?php if(isset($_GET['erro'])): ?>
        <div style="color: #f87171; background: rgba(248, 113, 113, 0.1); padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center; font-size: 14px;">
            <?php echo htmlspecialchars($_GET['erro']); ?>
        </div>
    <?php endif; ?>

    <?php if(isset($_GET['sucesso'])): ?>
        <div style="color: #4ade80; background: rgba(74, 222, 128, 0.1); padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center; font-size: 14px;">
            <?php echo htmlspecialchars($_GET['sucesso']); ?>
        </div>
    <?php endif; ?>

    <form action="processa_login.php" method="POST">
        <label style="font-size: 14px; color: var(--slate);">E-mail</label>
        <input type="email" name="email" placeholder="Seu e-mail" required>

        <label style="font-size: 14px; color: var(--slate);">Palavra-passe</label>
        <input type="password" name="senha" placeholder="Sua senha" required>

        <button type="submit" class="btn-action" style="margin-top: 10px;">ENTRAR</button>
    </form>

    <p style="text-align:center; margin-top:20px; font-size:14px; color: var(--slate);">
        Novo por aqui? <a href="cadastro.php" style="color:var(--gold); text-decoration: none;">Crie uma conta</a>
    </p>
</div>
</body>
</html>