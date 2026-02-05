# 🚀 VERTEX - Sistema de Marketplace Freelancer (v1.0)

O **Vertex** é uma plataforma robusta de intermediação de serviços, desenvolvida em PHP e MySQL. Com um design focado na experiência do utilizador e um sistema de moderação completo, é a solução ideal para quem deseja gerir a sua própria comunidade de freelancers e clientes.

---

## 💎 Destaques do Sistema
* **Design Dark Mode:** Interface moderna, elegante e responsiva.
* **Duplo Perfil:** Sistema inteligente de troca de cargo (Cliente/Freelancer) com aprovação administrativa.
* **Verificação de Identidade:** Upload de documentos (Frente/Verso) para garantir a segurança da plataforma.
* **Chat Interno:** Comunicação em tempo real com suporte a envio de anexos.
* **Privacidade:** Geração automática de IDs de 8 dígitos para ocultar dados sensíveis dos utilizadores.
* **Segurança:** Proteção contra SQL Injection e criptografia de senhas (BCRYPT).

---

## 🛠️ Requisitos de Instalação
Para rodar o Vertex, o seu servidor deve ter:
* **PHP:** Versão 8.0 ou superior.
* **Banco de Dados:** MySQL 5.7+ ou MariaDB.
* **Servidor:** Apache ou Nginx (XAMPP/WAMP para testes locais).

---

## 🚀 Como Instalar (Passo a Passo)

1. **Subir os Ficheiros:**
   Extraia o conteúdo do ficheiro `.zip` para a sua pasta de destino (`htdocs` no XAMPP ou `public_html` na sua hospedagem).

2. **Configurar a Base de Dados:**
   - Aceda ao seu **phpMyAdmin**.
   - Crie um banco de dados chamado `vertex_db`.
   - Clique em **Importar** e selecione o arquivo `database.sql` incluído neste pacote.

3. **Configurar a Conexão:**
   - Abra o ficheiro `config.php` num editor de texto.
   - Atualize as informações de `host`, `usuario`, `senha` e `banco` conforme as suas credenciais.

4. **Permissões de Pastas:**
   Certifique-se de que as seguintes pastas têm permissão de escrita (CHMOD 777):
   - `uploads/perfis/`
   - `uploads/documentos/`
   - `uploads/chat/`

---

## 📂 Estrutura de Arquivos
* `config.php` - Configurações globais de banco de dados.
* `dashboard.php` - Painel principal dinâmico.
* `admin.php` - Ferramentas exclusivas para Administradores e Moderadores.
* `chat.php` - Sistema de mensagens privadas.
* `buscar_servicos.php` - O Marketplace público.
* `css/` - Estilização CSS personalizada.
* `includes/` - Componentes reutilizáveis (Sidebar, Header).

---

## 🛡️ Níveis de Acesso
1. **Administrador:** Controlo total sobre usuários, moderação de documentos e gestão de cargos.
2. **Moderador:** Pode aprovar usuários comuns e moderar o Marketplace (não pode afetar administradores).
3. **Usuário (Cliente/Freelancer):** Publica ou contrata serviços e utiliza o chat.

---

## 📄 Termos de Uso
Este software é fornecido com **código aberto** para personalização. 
- É proibida a revenda deste script sem autorização prévia.
- O autor não se responsabiliza por modificações feitas no código que possam comprometer a segurança após a entrega.

---

## 📞 Suporte
Em caso de dúvidas técnicas, consulte a documentação completa incluída no pacote ou contacte o suporte através do portal da Hotmart.

---
**Desenvolvido por: [Seu Nome ou Nome da sua Empresa]**
