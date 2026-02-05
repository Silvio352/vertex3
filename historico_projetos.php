<?php
session_start();
include 'config.php';
$meu_id = $_SESSION['user_id'];

// Busca freelancers que o cliente contactou (baseado nas mensagens)
$sql = "SELECT DISTINCT u.id, u.nome, u.foto_perfil, u.profissao, s.titulo as servico_nome, MAX(m.data_envio) as ultima_interacao
        FROM mensagens m
        JOIN usuarios u ON (m.id_destinatario = u.id)
        JOIN servicos s ON (m.id_servico = s.id)
        WHERE m.id_remetente = $meu_id
        GROUP BY u.id ORDER BY ultima_interacao DESC";

$historico = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Projetos | Vertex</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="layout-container">
    <?php include 'sidebar.php'; ?>
    <div class="main-content">
        <h1>📄 Histórico de Contratações</h1>
        <div class="card">
            <div class="table-container">
                <table>
                    <thead>
                    <tr>
                        <th>Profissional</th>
                        <th>Serviço</th>
                        <th>Último Contato</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while($h = mysqli_fetch_assoc($historico)): ?>
                        <tr>
                            <td>
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <img src="uploads/perfis/<?php echo $h['foto_perfil']; ?>" width="35" height="35" style="border-radius:50%">
                                    <?php echo $h['nome']; ?>
                                </div>
                            </td>
                            <td><?php echo $h['servico_nome']; ?></td>
                            <td><?php echo date('d/m/H:i', strtotime($h['ultima_interacao'])); ?></td>
                            <td>
                                <a href="ver_perfil.php?id=<?php echo $h['id']; ?>" style="color:var(--gold); margin-right:10px;">Perfil</a>
                                <a href="avaliar_freelancer.php?id=<?php echo $h['id']; ?>" class="btn-action" style="padding:5px 10px; font-size:12px;">Avaliar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>