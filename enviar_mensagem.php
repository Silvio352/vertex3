<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_remetente = $_SESSION['user_id'];
    $id_destinatario = $_POST['id_destinatario'];
    $id_servico = $_POST['id_servico'];
    $msg = mysqli_real_escape_string($conn, $_POST['mensagem']);
    $nome_ficheiro = NULL;

    // Lógica de Upload
    if (isset($_FILES['ficheiro']) && $_FILES['ficheiro']['error'] == 0) {
        $extensao = pathinfo($_FILES['ficheiro']['name'], PATHINFO_EXTENSION);
        $nome_ficheiro = time() . "_" . basename($_FILES['ficheiro']['name']); // Nome único
        $caminho_final = "uploads/" . $nome_ficheiro;

        move_uploaded_file($_FILES['ficheiro']['tmp_name'], $caminho_final);
    }

    $sql = "INSERT INTO mensagens (id_remetente, id_destinatario, id_servico, mensagem, arquivo) 
            VALUES ($id_remetente, $id_destinatario, $id_servico, '$msg', '$nome_ficheiro')";

    if (mysqli_query($conn, $sql)) {
        header("Location: chat.php?id_servico=$id_servico&id_destinatario=$id_destinatario");
    }
}
?>