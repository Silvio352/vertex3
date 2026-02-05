-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28-Dez-2025 às 16:34
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `vertex_db`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacoes`
--

CREATE TABLE `avaliacoes` (
  `id` int(11) NOT NULL,
  `id_freelancer` int(11) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `estrelas` int(11) DEFAULT NULL CHECK (`estrelas` >= 1 and `estrelas` <= 5),
  `comentario` text DEFAULT NULL,
  `data_avaliacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `avaliacoes`
--

INSERT INTO `avaliacoes` (`id`, `id_freelancer`, `id_cliente`, `estrelas`, `comentario`, `data_avaliacao`) VALUES
(1, 1, 2, 5, 'bOM TRABALHO', '2025-12-26 00:31:04');

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensagens`
--

CREATE TABLE `mensagens` (
  `id` int(11) NOT NULL,
  `id_remetente` int(11) DEFAULT NULL,
  `id_destinatario` int(11) DEFAULT NULL,
  `id_servico` int(11) DEFAULT NULL,
  `mensagem` text DEFAULT NULL,
  `anexo` varchar(255) DEFAULT NULL,
  `data_envio` timestamp NOT NULL DEFAULT current_timestamp(),
  `arquivo` varchar(255) DEFAULT NULL,
  `lida` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `mensagens`
--

INSERT INTO `mensagens` (`id`, `id_remetente`, `id_destinatario`, `id_servico`, `mensagem`, `anexo`, `data_envio`, `arquivo`, `lida`) VALUES
(1, 2, 1, 2, 'Olá', NULL, '2025-12-25 14:00:00', NULL, 0),
(2, 2, 1, 2, 'Hollaaaaa', NULL, '2025-12-25 14:02:52', NULL, 0),
(3, 1, 2, 2, 'Funcionando perfeitamente', NULL, '2025-12-25 14:03:24', NULL, 1),
(4, 2, 1, 2, 'That\'s good', NULL, '2025-12-25 14:03:50', NULL, 0),
(5, 1, 2, 2, 'Anexado', NULL, '2025-12-25 20:47:46', '1766695666_FTI Cartão De Credito Multicaixa Particulares.pdf', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `portfolio`
--

CREATE TABLE `portfolio` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `link_projeto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `servicos`
--

CREATE TABLE `servicos` (
  `id` int(11) NOT NULL,
  `id_freelancer` int(11) DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `categoria` varchar(100) DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `servicos`
--

INSERT INTO `servicos` (`id`, `id_freelancer`, `titulo`, `categoria`, `preco`, `descricao`) VALUES
(1, 1, 'Faço trabalhos escolares', 'Academico', 5000.00, 'Blablabla'),
(2, 1, 'programação', 'Programacao', 500000.00, 'Faço sites');

-- --------------------------------------------------------

--
-- Estrutura da tabela `solicitacoes_alteracao`
--

CREATE TABLE `solicitacoes_alteracao` (
  `id` int(11) NOT NULL,
  `id_usuario_alvo` int(11) DEFAULT NULL,
  `id_solicitante` int(11) DEFAULT NULL,
  `novo_nome` varchar(255) DEFAULT NULL,
  `novo_documento` varchar(50) DEFAULT NULL,
  `status` enum('pendente','aprovado','rejeitado') DEFAULT 'pendente',
  `data_pedido` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `solicitacoes_projeto`
--

CREATE TABLE `solicitacoes_projeto` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `orcamento_estimado` decimal(10,2) DEFAULT NULL,
  `prazo_entrega` date DEFAULT NULL,
  `data_publicacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('aberto','fechado') DEFAULT 'aberto'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `codigo_usuario` varchar(10) DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `documento_id` varchar(50) DEFAULT NULL,
  `escola_univ` varchar(100) DEFAULT NULL,
  `num_aluno` varchar(50) DEFAULT NULL,
  `tipo_usuario` enum('freelancer','cliente') DEFAULT NULL,
  `status_verificacao` varchar(20) DEFAULT 'Pendente',
  `nivel` enum('usuario','admin') DEFAULT 'usuario',
  `foto_perfil` varchar(255) DEFAULT 'default_avatar.png',
  `doc_frente` varchar(255) DEFAULT NULL,
  `doc_verso` varchar(255) DEFAULT NULL,
  `foto_documento` varchar(255) DEFAULT NULL,
  `profissao` varchar(100) DEFAULT NULL,
  `formacao` varchar(100) DEFAULT NULL,
  `biografia` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_freelancer` (`id_freelancer`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Índices para tabela `mensagens`
--
ALTER TABLE `mensagens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_remetente` (`id_remetente`),
  ADD KEY `id_destinatario` (`id_destinatario`),
  ADD KEY `id_servico` (`id_servico`);

--
-- Índices para tabela `portfolio`
--
ALTER TABLE `portfolio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices para tabela `servicos`
--
ALTER TABLE `servicos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_freelancer` (`id_freelancer`);

--
-- Índices para tabela `solicitacoes_alteracao`
--
ALTER TABLE `solicitacoes_alteracao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario_alvo` (`id_usuario_alvo`),
  ADD KEY `id_solicitante` (`id_solicitante`);

--
-- Índices para tabela `solicitacoes_projeto`
--
ALTER TABLE `solicitacoes_projeto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `mensagens`
--
ALTER TABLE `mensagens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `portfolio`
--
ALTER TABLE `portfolio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `servicos`
--
ALTER TABLE `servicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `solicitacoes_alteracao`
--
ALTER TABLE `solicitacoes_alteracao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `solicitacoes_projeto`
--
ALTER TABLE `solicitacoes_projeto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD CONSTRAINT `avaliacoes_ibfk_1` FOREIGN KEY (`id_freelancer`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `avaliacoes_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `usuarios` (`id`);

--
-- Limitadores para a tabela `mensagens`
--
ALTER TABLE `mensagens`
  ADD CONSTRAINT `mensagens_ibfk_1` FOREIGN KEY (`id_remetente`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `mensagens_ibfk_2` FOREIGN KEY (`id_destinatario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `mensagens_ibfk_3` FOREIGN KEY (`id_servico`) REFERENCES `servicos` (`id`);

--
-- Limitadores para a tabela `portfolio`
--
ALTER TABLE `portfolio`
  ADD CONSTRAINT `portfolio_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Limitadores para a tabela `servicos`
--
ALTER TABLE `servicos`
  ADD CONSTRAINT `servicos_ibfk_1` FOREIGN KEY (`id_freelancer`) REFERENCES `usuarios` (`id`);

--
-- Limitadores para a tabela `solicitacoes_alteracao`
--
ALTER TABLE `solicitacoes_alteracao`
  ADD CONSTRAINT `solicitacoes_alteracao_ibfk_1` FOREIGN KEY (`id_usuario_alvo`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `solicitacoes_alteracao_ibfk_2` FOREIGN KEY (`id_solicitante`) REFERENCES `usuarios` (`id`);

--
-- Limitadores para a tabela `solicitacoes_projeto`
--
ALTER TABLE `solicitacoes_projeto`
  ADD CONSTRAINT `solicitacoes_projeto_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
