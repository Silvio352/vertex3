<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="layout-container">
    <?php include 'sidebar.php'; ?>
    <div class="main-content">

        <?php
        $res_aviso = mysqli_query($conn, "SELECT mensagem FROM mensagens WHERE id_servico = 0 ORDER BY data_envio DESC LIMIT 1");
        if($aviso = mysqli_fetch_assoc($res_aviso)): ?>
            <div class="label-alerta">
                ⚠️ AVISO DA ADMINISTRAÇÃO: <?php echo $aviso['mensagem']; ?>
            </div>
        <?php endif; ?>

        <h1>Bem-vindo, <?php echo $_SESSION['nome']; ?></h1>

        <?php if ($_SESSION['nivel'] == 'admin' || $_SESSION['nivel'] == 'moderador'): ?>
            <div class="card">
                <h3>👥 Gestão de Utilizadores (Rápida)</h3>
                <div class="table-container">
                    <table>
                        <tr>
                            <th>Nome</th>
                            <th>Nível</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                        <?php
                        $usuarios = mysqli_query($conn, "SELECT * FROM usuarios WHERE id != '".$_SESSION['user_id']."' ORDER BY id DESC LIMIT 5");
                        while($u = mysqli_fetch_assoc($usuarios)): ?>
                            <tr>
                                <td><?php echo $u['nome']; ?></td>
                                <td><?php echo $u['nivel']; ?></td>
                                <td><?php echo $u['status_verificacao']; ?></td>
                                <td>
                                    <a href="acoes_admin.php?acao=aprovar&id=<?php echo $u['id']; ?>" class="btn-approve">Aprovar</a>
                                    <a href="acoes_admin.php?acao=apagar&id=<?php echo $u['id']; ?>" class="btn-delete" onclick="return confirm('Apagar?')">Apagar</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </table>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>
</body>
</html>