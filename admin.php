<?php
session_start();
include 'config.php';
if ($_SESSION['nivel'] != 'admin') { header("Location: dashboard.php"); exit(); }

$usuarios = mysqli_query($conn, "SELECT * FROM usuarios");
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Vertex</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="layout-container">
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <h1 style="margin-top: 0;">Gestão de Utilizadores</h1>

        <div class="card">
            <h3 style="color: var(--gold); margin-top: 0;">📢 Enviar Mensagem Global</h3>
            <form action="enviar_global.php" method="POST">
                <textarea name="aviso" placeholder="Escreva um aviso para todos..." required style="min-height: 100px;"></textarea>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <button type="submit" class="btn-action">Enviar para Todos</button>
                    <a href="limpar_avisos.php" onclick="return confirm('Apagar avisos?')" style="color: #f87171; text-align: center; text-decoration: none; font-size: 14px;">🗑️ Limpar Avisos Atuais</a>
                </div>
            </form>
        </div>

        <div class="card">
            <h3 style="margin-top: 0;">Lista de Membros</h3>
            <div class="table-container">
                <table>
                    <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nome</th>
                        <th>Tipo</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while($u = mysqli_fetch_assoc($usuarios)): ?>
                        <tr>
                            <td><img src="uploads/perfis/<?php echo $u['foto_perfil']; ?>" width="35" height="35" style="border-radius:50%; object-fit:cover;"></td>
                            <td style="white-space: nowrap;"><?php echo $u['nome']; ?></td>
                            <td><?php echo strtoupper($u['tipo_usuario']); ?></td>
                            <td><span style="font-size: 11px;"><?php echo $u['status_verificacao']; ?></span></td>
                            <td>
                                <a href="editar_usuario.php?id=<?php echo $u['id']; ?>" style="color:var(--gold); text-decoration:none; font-weight: bold;">⚙️ Editar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <p style="font-size: 12px; color: #8892b0; margin-top: 15px; display: block;" class="mobile-only">💡 Deslize para o lado para ver mais dados na tabela.</p>
        </div>
    </div>
</div>
</body>
</html>