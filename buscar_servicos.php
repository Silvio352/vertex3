<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

$meu_id = $_SESSION['user_id'];
$busca = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : "";

// SQL que traz o serviço e os dados do freelancer/cliente que postou
$sql = "SELECT s.*, u.nome as autor_nome, u.foto_perfil, u.codigo_usuario 
        FROM servicos s 
        JOIN usuarios u ON s.id_freelancer = u.id";

if (!empty($busca)) {
    $sql .= " WHERE s.titulo LIKE '%$busca%' OR s.descricao LIKE '%$busca%'";
}
$sql .= " ORDER BY s.id DESC";
$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace | Vertex</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .grid-marketplace { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px; }
        .card-servico { display: flex; flex-direction: column; justify-content: space-between; border: 1px solid #233554; }
        .btn-edit { color: var(--gold); font-size: 13px; text-decoration: none; font-weight: bold; }
        .btn-del { color: #f87171; font-size: 13px; text-decoration: none; font-weight: bold; }
        .price { color: #4ade80; font-weight: bold; font-size: 1.1rem; }
    </style>
</head>
<body>
<div class="layout-container">
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <header style="margin-bottom: 30px;">
            <h1>🛒 Marketplace Vertex</h1>
            <form method="GET" style="display: flex; gap: 10px; margin-top: 15px;">
                <input type="text" name="q" placeholder="Procurar serviços ou projetos..." value="<?php echo $busca; ?>" style="margin: 0;">
                <button type="submit" class="btn-action" style="width: auto; padding: 0 25px;">Buscar</button>
            </form>
        </header>

        <div class="grid-marketplace">
            <?php if (mysqli_num_rows($resultado) > 0): ?>
                <?php while ($s = mysqli_fetch_assoc($resultado)): ?>
                    <div class="card card-servico">
                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                <h3 style="margin: 0; color: var(--gold);"><?php echo $s['titulo']; ?></h3>
                                <span class="price"><?php echo number_format($s['preco'], 2); ?> AOA</span>
                            </div>
                            <p style="font-size: 14px; color: var(--slate); margin: 15px 0;">
                                <?php echo (strlen($s['descricao']) > 120) ? substr($s['descricao'], 0, 120)."..." : $s['descricao']; ?>
                            </p>
                        </div>

                        <div style="border-top: 1px solid #233554; padding-top: 15px; margin-top: 10px;">
                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                                <img src="uploads/perfis/<?php echo $s['foto_perfil']; ?>" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
                                <div>
                                    <div style="font-size: 13px; font-weight: bold; color: white;"><?php echo $s['autor_nome']; ?></div>
                                    <div style="font-size: 10px; color: var(--gold);">ID: #<?php echo $s['codigo_usuario']; ?></div>
                                </div>
                            </div>

                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <a href="chat.php?id_destinatario=<?php echo $s['id_freelancer']; ?>&id_servico=<?php echo $s['id']; ?>" class="btn-approve" style="text-decoration: none; padding: 8px 15px;">Contactar</a>

                                <?php if ($s['id_freelancer'] == $meu_id || $_SESSION['nivel'] == 'admin'): ?>
                                    <div style="display: flex; gap: 10px;">
                                        <a href="editar_servico.php?id=<?php echo $s['id']; ?>" class="btn-edit">Editar</a>
                                        <a href="acoes_servico.php?acao=apagar&id=<?php echo $s['id']; ?>" class="btn-del" onclick="return confirm('Eliminar esta publicação permanentemente?')">Eliminar</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Nenhum serviço encontrado para "<?php echo htmlspecialchars($busca); ?>".</p>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>