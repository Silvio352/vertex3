<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $tipo = $_POST['tipo'];

    // 1. Verificar se e-mail já existe
    $check = mysqli_query($conn, "SELECT id FROM usuarios WHERE email = '$email'");
    if (mysqli_num_rows($check) > 0) {
        header("Location: cadastro.php?erro=E-mail já registado!");
        exit();
    }

    // 2. Função para processar Uploads
    function subirFicheiro($file, $destino) {
        if (!isset($file) || $file['error'] != 0) return "default.png";

        $extensao = pathinfo($file['name'], PATHINFO_EXTENSION);
        $novo_nome = uniqid() . "." . $extensao; // Nome único para evitar sobreposição
        move_uploaded_file($file['tmp_name'], $destino . $novo_nome);
        return $novo_nome;
    }

    // Processar os 3 ficheiros
    $foto_perfil = subirFicheiro($_FILES['foto_perfil'], "uploads/perfis/");
    $doc_frente  = subirFicheiro($_FILES['doc_frente'], "uploads/documentos/");
    $doc_verso   = subirFicheiro($_FILES['doc_verso'], "uploads/documentos/");

    // 3. Inserir no Banco de Dados
    // Importante: A sua tabela 'usuarios' deve ter as colunas doc_frente e doc_verso

    $codigo_random = rand(100000, 99999999); // Gera entre 6 e 8 dígitos
// No seu INSERT, adicione a coluna codigo_usuario e a variável $codigo_random

    $sql = "INSERT INTO usuarios (
                nome, email, senha, tipo_usuario, nivel, 
                foto_perfil, doc_frente, doc_verso, status_verificacao
            ) VALUES (
                '$nome', '$email', '$senha', '$tipo', 'usuario', 
                '$foto_perfil', '$doc_frente', '$doc_verso', 'pendente'
            )";

    if (mysqli_query($conn, $sql)) {
        header("Location: login.php?sucesso=Conta criada! Aguarde a aprovação dos documentos.");
    } else {
        header("Location: cadastro.php?erro=Erro ao salvar no banco: " . mysqli_error($conn));
    }
}