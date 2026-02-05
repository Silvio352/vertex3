<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "vertex_db";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}

// FUNÇÃO DE NOTIFICAÇÃO (E-mail e Sistema)
function notificarUsuario($conn, $id_destinatario, $tipo) {
    $id_destinatario = mysqli_real_escape_string($conn, $id_destinatario);

    // Busca dados do destinatário
    $res = mysqli_query($conn, "SELECT email, nome FROM usuarios WHERE id = '$id_destinatario'");
    $user = mysqli_fetch_assoc($res);

    if ($user) {
        $to = $user['email'];
        $nome = $user['nome'];
        $assunto = ($tipo == 'mensagem') ? "Nova Mensagem no Vertex" : "Nova Avaliação Recebida";

        $msg = "Olá, $nome!\n\n";
        $msg .= ($tipo == 'mensagem')
            ? "Você recebeu uma nova mensagem. Faça login na Vertex para responder."
            : "Excelente notícia! Alguém avaliou o seu trabalho. Confira o seu perfil.";
        $msg .= "\n\nLink: http://localhost/vertex/login.php\n\nAtenciosamente,\nEquipe Vertex";

        $headers = "From: no-reply@vertex.com";

        // O '@' evita erros caso o servidor local não suporte envio de e-mail
        @mail($to, $assunto, $msg, $headers);
    }
}
?>

