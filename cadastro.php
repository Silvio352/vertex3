<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta | Vertex</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="auth-page">
<div class="auth-container">
    <h2 style="text-align:center; color: var(--gold); margin-bottom: 20px;">CRIAR CONTA VERTEX</h2>

    <?php if(isset($_GET['erro'])): ?>
        <div style="color: #f87171; background: rgba(248, 113, 113, 0.1); padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center; font-size: 14px;">
            <?php echo htmlspecialchars($_GET['erro']); ?>
        </div>
    <?php endif; ?>

    <form action="processa_cadastro.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="nome" placeholder="Nome Completo" required>
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="password" name="senha" placeholder="Palavra-passe" required>

        <label>Foto de Perfil:</label>
        <input type="file" name="foto_perfil" accept="image/*" required>

        <label>Documento Identificação (Frente):</label>
        <input type="file" name="doc_frente" accept="image/*" required>

        <label>Documento Identificação (Verso):</label>
        <input type="file" name="doc_verso" accept="image/*" required>

        <select name="tipo">
            <option value="cliente">Cliente</option>
            <option value="freelancer">Freelancer</option>
        </select>
        <button type="submit" class="btn-action">REGISTAR</button>
    </form>