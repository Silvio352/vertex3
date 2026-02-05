<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

$user_id = $_SESSION['user_id'];
$res = mysqli_query($conn, "SELECT * FROM usuarios WHERE id = '$user_id'");
$user = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .info-group { margin-bottom: 15px; border-bottom: 1px solid #233554; padding-bottom: 10px; }
        .info-label { color: var(--gold); font-size: 12px; font-weight: bold; text-transform: uppercase; }
        .info-value { font-size: 16px; color: white; margin-top: 5px; }
    </style>
</head>
<body>
<div class="layout-container">
    <?php include 'sidebar.php'; ?>
    <div class="main-content">
        <div class="auth-container" style="margin-top: 0; max-width: 600px;">
            <div style="text-align: center; margin-bottom: 30px;">
                <img src="uploads/perfis/<?php echo $user['foto_perfil']; ?>" style="width: 120px; height: 120px; border-radius: 50%; border: 3px solid var(--gold); object-fit: cover;">
                <h2 style="color: var(--gold); margin-top: 10px;"><?php echo $user['nome']; ?></h2>
                <span style="background: #233554; padding: 5px 15px; border-radius: 20px; font-size: 12px;">
                        ID: #<?php echo $user['codigo_usuario']; ?>
                    </span>
            </div>

            <div class="info-group">
                <div class="info-label">E-mail</div>
                <div class="info-value"><?php echo $user['email']; ?></div>
            </div>

            <div class="info-group">
                <div class="info-label">Tipo de Conta</div>
                <div class="info-value"><?php echo ucfirst($user['tipo_usuario']); ?></div>
            </div>

            <div class="info-group">
                <div class="info-label">Status de Verificação</div>
                <div class="info-value" style="color: <?php echo ($user['status_verificacao'] == 'aprovado') ? '#4ade80' : '#f87171'; ?>">
                    <?php echo strtoupper($user['status_verificacao']); ?>
                </div>
            </div>

            <a href="configuracoes.php" class="btn-action" style="text-align:center; text-decoration:none; display:block;">Editar Perfil</a>
        </div>
    </div>
</div>
</body>
</html>