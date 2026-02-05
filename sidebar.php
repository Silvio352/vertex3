<?php
// Lógica de Contagem de Notificações e ID
$id_logado = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
$nao_lidas = 0;
$user_sidebar = ['codigo_usuario' => '000000', 'nome' => 'Usuário'];

if ($id_logado > 0 && isset($conn)) {
    // Busca notificações
    $res_count = mysqli_query($conn, "SELECT COUNT(id) as total FROM mensagens WHERE id_destinatario = '$id_logado' AND lida = 0");
    if ($res_count) { $nao_lidas = mysqli_fetch_assoc($res_count)['total']; }

    // Busca Código do Usuário
    $res_user = mysqli_query($conn, "SELECT codigo_usuario, nome, foto_perfil FROM usuarios WHERE id = '$id_logado'");
    if ($res_user) { $user_sidebar = mysqli_fetch_assoc($res_user); }
}
?>
<div class="sidebar" id="sidebar">
    <div style="text-align: center; margin-bottom: 25px; padding-bottom: 20px; border-bottom: 1px solid #233554;">
        <h2 style="color: var(--gold); margin-bottom: 15px;">VERTEX</h2>
        <img src="uploads/perfis/<?php echo $user_sidebar['foto_perfil']; ?>" style="width: 75px; height: 75px; border-radius: 50%; border: 2px solid var(--gold); object-fit: cover;">
        <p style="font-size: 15px; margin: 10px 0 2px 0; font-weight: bold; color: white;"><?php echo explode(' ', $user_sidebar['nome'])[0]; ?></p>
        <small style="color: var(--gold); letter-spacing: 1px;">ID: #<?php echo $user_sidebar['codigo_usuario']; ?></small>
    </div>

    <nav style="display: flex; flex-direction: column; gap: 5px;">
        <a href="dashboard.php">🏠 Painel Principal
            <?php if($nao_lidas > 0): ?><span style="background:#f87171; color:white; border-radius:50%; padding:2px 7px; font-size:10px; float:right;"><?php echo $nao_lidas; ?></span><?php endif; ?>
        </a>
        <a href="perfil.php">👤 Meu Perfil</a>
        <a href="buscar_servicos.php">🛒 Marketplace</a>

        <?php if ($_SESSION['tipo'] == 'cliente'): ?>
            <a href="publicar_projeto.php" style="color: #4ade80;">📢 Publicar Projeto</a>
        <?php endif; ?>

        <?php if ($_SESSION['nivel'] == 'admin' || $_SESSION['nivel'] == 'moderador'): ?>
            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #233554;">
                <p style="font-size: 10px; color: var(--gold); margin-left: 10px; margin-bottom: 5px;">ADMINISTRAÇÃO</p>
                <a href="admin.php">👥 Gestão de Usuários</a>
            </div>
        <?php endif; ?>

        <a href="configuracoes.php">⚙️ Configurações</a>
        <a href="logout.php" style="color: #f87171; border: 1px solid rgba(248,113,113,0.3); margin-top: 20px; text-align: center;">🚪 Terminar Sessão</a>
    </nav>
</div>