<?php
session_start();
include 'config.php';
if ($_SESSION['nivel'] != 'admin') { exit(); }

$id_alvo = $_GET['id'];
$u = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM usuarios WHERE id = $id_alvo"));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $novo_nivel = $_POST['nivel'];
    $novo_nome = $_POST['nome'];
    $novo_doc = $_POST['documento_id'];

    if ($novo_nome != $u['nome'] || $novo_doc != $u['documento_id']) {
        mysqli_query($conn, "INSERT INTO solicitacoes_alteracao (id_usuario_alvo, id_solicitante, novo_nome, novo_documento) 
                             VALUES ($id_alvo, {$_SESSION['user_id']}, '$novo_nome', '$novo_doc')");
        $alerta = "Pedido de alteração enviado ao Proprietário.";
    }

    mysqli_query($conn, "UPDATE usuarios SET nivel = '$novo_nivel' WHERE id = $id_alvo");
    echo "<script>alert('Nível atualizado! $alerta'); window.location.href='admin.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuário | Vertex</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="layout-container">
    <?php include 'sidebar.php'; ?>
    <div class="main-content">
        <div class="card" style="max-width: 600px; margin: auto;">
            <h2>Ajustar Perfil: <?php echo $u['nome']; ?></h2>
            <form method="POST">
                <label>Nível de Acesso:</label>
                <select name="nivel">
                    <option value="usuario" <?php if($u['nivel'] == 'usuario') echo 'selected'; ?>>Utilizador Comum</option>
                    <option value="admin" <?php if($u['nivel'] == 'admin') echo 'selected'; ?>>Admin (Moderador)</option>
                </select>

                <label>Nome Completo:</label>
                <input type="text" name="nome" value="<?php echo $u['nome']; ?>">

                <label>Nº Documento:</label>
                <input type="text" name="documento_id" value="<?php echo $u['documento_id']; ?>">

                <button type="submit" class="btn-action" style="width:100%">Guardar Alterações</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>