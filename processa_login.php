<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultado = mysqli_query($conn, $sql);
    $usuario = mysqli_fetch_assoc($resultado);

    // Verifica se o usuário existe e se a senha está correta
    if ($usuario && password_verify($senha, $usuario['senha'])) {

        // Criando as variáveis de sessão (O Crachá do Usuário)
        $_SESSION['user_id']   = $usuario['id'];
        $_SESSION['nome']      = $usuario['nome'];
        $_SESSION['tipo']      = $usuario['tipo_usuario'];
        $_SESSION['nivel']     = $usuario['nivel']; // Define se é admin ou usuario
        $_SESSION['foto_perfil'] = $usuario['foto_perfil']; // Guarda a foto de perfil

        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('E-mail ou senha incorretos.'); window.location.href='login.php';</script>";
    }
}
?>