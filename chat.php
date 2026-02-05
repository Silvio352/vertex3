<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

$meu_id = $_SESSION['user_id'];
$id_destinatario = mysqli_real_escape_string($conn, $_GET['id_destinatario']);
$id_servico = isset($_GET['id_servico']) ? mysqli_real_escape_string($conn, $_GET['id_servico']) : 0;

// 0.No chat.php, dentro da lógica de processar o POST da mensagem:
$anexo_nome = "";

if (isset($_FILES['anexo']) && $_FILES['anexo']['error'] == 0) {
    $ext = pathinfo($_FILES['anexo']['name'], PATHINFO_EXTENSION);
    $anexo_nome = "anexo_" . uniqid() . "." . $ext;
    move_uploaded_file($_FILES['anexo']['tmp_name'], "uploads/chat/" . $anexo_nome);
}

// Atualize o seu INSERT de mensagens para incluir a coluna 'anexo'
// Exemplo: INSERT INTO mensagens (..., mensagem, anexo) VALUES (..., '$msg', '$anexo_nome')

// 1. MARCAR COMO LIDAS as mensagens que eu recebi nesta conversa
mysqli_query($conn, "UPDATE mensagens SET lida = 1 WHERE id_destinatario = '$meu_id' AND id_remetente = '$id_destinatario'");

// 2. ENVIAR MENSAGEM
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['mensagem'])) {
    $msg_texto = mysqli_real_escape_string($conn, $_POST['mensagem']);

    $sql_send = "INSERT INTO mensagens (id_remetente, id_destinatario, id_servico, mensagem, lida) 
                 VALUES ('$meu_id', '$id_destinatario', '$id_servico', '$msg_texto', 0)";

    if (mysqli_query($conn, $sql_send)) {
        notificarUsuario($conn, $id_destinatario, 'mensagem');
        header("Location: chat.php?id_destinatario=$id_destinatario&id_servico=$id_servico");
        exit();
    }
}

// 3. BUSCAR HISTÓRICO DO CHAT
$conversa = mysqli_query($conn, "SELECT * FROM mensagens WHERE 
    (id_remetente = '$meu_id' AND id_destinatario = '$id_destinatario') OR 
    (id_remetente = '$id_destinatario' AND id_destinatario = '$meu_id') 
    ORDER BY data_envio ASC");

$res_dest = mysqli_query($conn, "SELECT nome, foto_perfil FROM usuarios WHERE id = '$id_destinatario'");
$dest = mysqli_fetch_assoc($res_dest);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat com <?php echo $dest['nome']; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="layout-container">
    <?php include 'sidebar.php'; ?>
    <div class="main-content">
        <div class="card" style="max-width: 800px; margin: auto; display: flex; flex-direction: column; height: 80vh;">
            <div style="display: flex; align-items: center; gap: 15px; padding-bottom: 15px; border-bottom: 1px solid #233554;">
                <img src="uploads/perfis/<?php echo $dest['foto_perfil']; ?>" width="45" height="45" style="border-radius: 50%;">
                <h2 style="margin: 0;"><?php echo $dest['nome']; ?></h2>
            </div>

            <div style="flex: 1; overflow-y: auto; padding: 20px 0;" id="chat-box">
                <?php while($m = mysqli_fetch_assoc($conversa)): ?>
                    <div style="margin-bottom: 15px; text-align: <?php echo ($m['id_remetente'] == $meu_id) ? 'right' : 'left'; ?>;">
                        <div style="display: inline-block; padding: 12px 18px; border-radius: 15px; max-width: 70%;
                                background: <?php echo ($m['id_remetente'] == $meu_id) ? 'var(--gold)' : '#233554'; ?>;
                                color: <?php echo ($m['id_remetente'] == $meu_id) ? '#0a192f' : 'white'; ?>;">
                            <?php echo $m['mensagem']; ?>
                            <div style="font-size: 9px; opacity: 0.7; margin-top: 5px;">
                                <?php echo date('H:i', strtotime($m['data_envio'])); ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            <form method="POST" enctype="multipart/form-data" style="display: flex; gap: 10px;">
                <input type="text" name="mensagem" placeholder="Mensagem...">
                <input type="file" name="anexo" style="width: auto;">
                <button type="submit" class="btn-action">Enviar</button>
            </form>

            <form method="POST" style="display: flex; gap: 10px; padding-top: 15px;">
                <input type="text" name="mensagem" placeholder="Escreva sua mensagem..." required autocomplete="off">
                <button type="submit" class="btn-action" style="width: auto;">Enviar</button>
            </form>
        </div>
    </div>
</div>
<script>
    var objDiv = document.getElementById("chat-box");
    objDiv.scrollTop = objDiv.scrollHeight;
</script>
</body>
</html>