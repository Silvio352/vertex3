<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$mensagem = "";
$erro = "";

// 1. BUSCAR DADOS ATUAIS
$res = mysqli_query($conn, "SELECT * FROM usuarios WHERE id = '$user_id'");
$user = mysqli_fetch_assoc($res);

// 2. PROCESSAR TROCA DE CARGO (Cliente <-> Freelancer)
if (isset($_POST['trocar_cargo'])) {
    // Define que o usuário solicitou uma troca
    $novo_pedido = ($user['tipo_usuario'] == 'cliente') ? 'quere_ser_freelancer' : 'quere_ser_cliente';
    mysqli_query($conn, "UPDATE usuarios SET status_verificacao = '$novo_pedido' WHERE id = '$user_id'");
    header("Location: configuracoes.php?sucesso=Solicitação enviada! Aguarde a aprovação do Admin.");
    exit();
}

// 3. PROCESSAR ELIMINAÇÃO DE CONTA
if (isset($_POST['eliminar_conta'])) {
    // Apagar fotos do servidor para não ocupar espaço
    if ($user['foto_perfil'] != 'default.png') {
        @unlink("uploads/perfis/" . $user['foto_perfil']);
    }

    if (mysqli_query($conn, "DELETE FROM usuarios WHERE id = '$user_id'")) {
        session_destroy();
        header("Location: login.php?sucesso=A sua conta foi eliminada permanentemente.");
        exit();
    }
}

// 4. ATUALIZAR DADOS BÁSICOS
if (isset($_POST['atualizar_dados'])) {
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    if (mysqli_query($conn, "UPDATE usuarios SET nome = '$nome', email = '$email' WHERE id = '$user_id'")) {
        $_SESSION['nome'] = $nome;
        $mensagem = "Dados atualizados com sucesso!";
        $user['nome'] = $nome;
        $user['email'] = $email;
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações | Vertex</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="layout-container">
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <h1>⚙️ Configurações de Conta</h1>

        <?php if(isset($_GET['sucesso']) || $mensagem): ?>
            <div style="background: rgba(74, 222, 128, 0.2); color: #4ade80; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <?php echo $mensagem ?: $_GET['sucesso']; ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <h3>Perfil Geral</h3>
            <form method="POST">
                <label>Nome Completo:</label>
                <input type="text" name="nome" value="<?php echo $user['nome']; ?>" required>

                <label>E-mail:</label>
                <input type="email" name="email" value="<?php echo $user['email']; ?>" required>

                <button type="submit" name="atualizar_dados" class="btn-action">Guardar Alterações</button>
            </form>
        </div>

        <div class="card" style="border-left: 5px solid var(--gold);">
            <h3>🔄 Trocar Tipo de Conta</h3>
            <p>Atualmente você é um <strong><?php echo ucfirst($user['tipo_usuario']); ?></strong>.</p>
            <p style="font-size: 13px; color: var(--slate);">Ao trocar, as suas funcionalidades no menu lateral serão alteradas.</p>

            <form method="POST">
                <button type="submit" name="trocar_cargo" class="btn-action"
                        style="background: transparent; border: 1px solid var(--gold); color: var(--gold);">
                    Quero ser <?php echo ($user['tipo_usuario'] == 'cliente') ? 'Freelancer' : 'Cliente'; ?>
                </button>
            </form>
        </div>

        <div class="card" style="border: 1px solid #ef4444; background: rgba(239, 68, 68, 0.05);">
            <h3 style="color: #ef4444;">⚠️ Zona de Perigo</h3>
            <p>Ao eliminar a sua conta, todos os seus dados, mensagens e portfólio serão apagados para sempre.</p>

            <form method="POST" onsubmit="return confirm('TEM A CERTEZA? Esta ação não pode ser desfeita e a sua conta será apagada permanentemente!');">
                <button type="submit" name="eliminar_conta" class="btn-delete" style="width: 100%; padding: 15px;">
                    ELIMINAR MINHA CONTA AGORA
                </button>
            </form>
        </div>

    </div>
</div>
</body>
</html>