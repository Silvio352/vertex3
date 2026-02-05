<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Vertex | Freelance de Elite</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="navbar">
    <div class="logo">VERTEX</div>
</div>

<div class="container">
    <h2 style="text-align: center; color: var(--gold);">Cadastro Vertex</h2>

    <form action="processa_cadastro.php" method="POST" enctype="multipart/form-data">

        <label style="font-size: 12px; color: var(--gold);">Foto de Perfil (Profissional):</label>
        <input type="file" name="foto_perfil" accept="image/*" required>

        <input type="text" name="nome" placeholder="Nome Completo" required>
        <input type="email" name="email" placeholder="E-mail Institucional" required>
        <input type="password" name="senha" placeholder="Crie uma Senha" required>

        <hr style="border: 0.5px solid #233554; margin: 20px 0;">

        <label style="font-size: 12px; color: var(--gold);">Foto do Documento (BI/Identidade):</label>
        <input type="file" name="foto_doc" accept="image/*" required>

        <input type="text" name="documento_id" placeholder="Nº do Documento" required>
        <input type="text" name="escola_univ" placeholder="Escola ou Universidade" required>
        <input type="text" name="num_aluno" placeholder="Nº de Aluno" required>

        <select name="tipo_usuario">
            <option value="cliente">Sou Cliente</option>
            <option value="freelancer">Sou Freelancer</option>
        </select>

        <button type="submit">FINALIZAR E ENVIAR PARA ANÁLISE</button>
    </form>

    <div style="text-align: center; margin-top: 20px;">
        <p style="font-size: 14px; color: #8892b0;">Já possui uma conta?</p>
        <a href="login.php" style="color: var(--gold); text-decoration: none; font-weight: bold; border: 1px solid var(--gold); padding: 10px 20px; border-radius: 4px; display: inline-block;">FAZER LOGIN</a>
    </div>
</div>