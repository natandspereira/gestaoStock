-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25/08/2025 às 17:06
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db_gestao_stock`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `cadastro_categoria`
--
-- Criação: 07/08/2025 às 22:06
-- Última atualização: 25/08/2025 às 15:04
--

CREATE TABLE `cadastro_categoria` (
  `categoria_id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cadastro_clientes`
--
-- Criação: 10/08/2025 às 19:34
--

CREATE TABLE `cadastro_clientes` (
  `clientes_id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cpf_cnpj` varchar(18) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `rua` varchar(255) DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `data_cadastro` datetime DEFAULT current_timestamp(),
  `imagem_url` varchar(255) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cadastro_equipamento`
--
-- Criação: 11/08/2025 às 22:50
--

CREATE TABLE `cadastro_equipamento` (
  `equipamentos_id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `patrimonio` varchar(50) DEFAULT NULL,
  `qt_atual` int(11) DEFAULT 0,
  `qt_minima` int(11) DEFAULT 0,
  `valor_custo` decimal(10,2) DEFAULT NULL,
  `valor_venda` decimal(10,2) DEFAULT NULL,
  `valor_aluguel` decimal(10,2) DEFAULT NULL,
  `valor_manutencao` decimal(10,2) DEFAULT NULL,
  `imagem_url` varchar(255) DEFAULT NULL,
  `data_cadastro` datetime DEFAULT current_timestamp(),
  `categoria_id` int(11) DEFAULT NULL,
  `fornecedor_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cadastro_fornecedor`
--
-- Criação: 11/08/2025 às 22:50
--

CREATE TABLE `cadastro_fornecedor` (
  `fornecedor_id` int(11) NOT NULL,
  `razao_social` varchar(255) NOT NULL,
  `nome_fantasia` varchar(255) DEFAULT NULL,
  `cnpj` varchar(18) NOT NULL,
  `inscricao_estadual` varchar(50) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `data_cadastro` datetime DEFAULT current_timestamp(),
  `observacoes` text DEFAULT NULL,
  `imagem_url` varchar(255) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cadastro_fornecedor`
--

INSERT INTO `cadastro_fornecedor` (`fornecedor_id`, `razao_social`, `nome_fantasia`, `cnpj`, `inscricao_estadual`, `telefone`, `email`, `endereco`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `cep`, `data_cadastro`, `observacoes`, `imagem_url`, `usuario_id`) VALUES
(3, 'teste', 'teste', '31552082000100', 'teste', '11777777777', 'teste@teste.com', 'Rua Deputado Luiz de França Vergetti', '000', 'teste', 'Barro Duro', 'Maceió', 'AL', '57045500', '2025-08-12 20:48:24', 'aaaaaaaaaaaaaaaaaaaaa', 'uploads/cliente_689bd2c853415.jpg', 21);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cadastro_grupo`
--
-- Criação: 11/08/2025 às 22:50
--

CREATE TABLE `cadastro_grupo` (
  `grupos_id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cadastro_tarefas`
--
-- Criação: 11/08/2025 às 22:51
--

CREATE TABLE `cadastro_tarefas` (
  `tarefas_id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `prazo` date NOT NULL,
  `quantidade_reparos` int(11) DEFAULT 0,
  `status` enum('Pendente','Em andamento','Concluída') NOT NULL,
  `data_conclusao` datetime DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `data_criacao` datetime DEFAULT current_timestamp(),
  `categoria_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `equipamentos_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cadastro_tecnico`
--
-- Criação: 11/08/2025 às 22:52
--

CREATE TABLE `cadastro_tecnico` (
  `tecnico_id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `rua` varchar(100) DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `tp_tecnico` enum('Eletricista','Hidráulico','Mecânico','TI') NOT NULL,
  `imagem_url` varchar(255) DEFAULT NULL,
  `hab_qualificacao` text DEFAULT NULL,
  `data_cadastro` datetime DEFAULT current_timestamp(),
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `contas_pagar`
--
-- Criação: 11/08/2025 às 22:52
--

CREATE TABLE `contas_pagar` (
  `pagar_id` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `data_vencimento` datetime NOT NULL,
  `data_pagamento` datetime DEFAULT NULL,
  `status_pagamento` enum('Pendente','Pago','Atrasado') NOT NULL,
  `forma_pagamento` enum('Dinheiro','Cartão','Transferência','Cheque','Boleto','Pix') NOT NULL,
  `observacoes` text DEFAULT NULL,
  `fornecedor_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `contas_receber`
--
-- Criação: 11/08/2025 às 22:52
--

CREATE TABLE `contas_receber` (
  `receber_id` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `data_emisao` datetime NOT NULL,
  `data_vencimento` datetime NOT NULL,
  `data_recebimento` datetime DEFAULT NULL,
  `status_recebimento` enum('Pendente','Pago','Atrasado') NOT NULL,
  `forma_recebimento` enum('Dinheiro','Cartão','Transferência','Cheque','Boleto','Pix') NOT NULL,
  `observacoes` text DEFAULT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `financeiro`
--
-- Criação: 11/08/2025 às 22:53
--

CREATE TABLE `financeiro` (
  `financeiro_id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `equipamentos_id` int(11) DEFAULT NULL,
  `pagar_id` int(11) DEFAULT NULL,
  `receber_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--
-- Criação: 02/07/2025 às 19:41
-- Última atualização: 25/08/2025 às 15:05
--

CREATE TABLE `usuarios` (
  `usuario_id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `matricula` varchar(50) DEFAULT NULL,
  `imagem_url` varchar(255) DEFAULT NULL,
  `data_cadastro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `cadastro_categoria`
--
ALTER TABLE `cadastro_categoria`
  ADD PRIMARY KEY (`categoria_id`),
  ADD KEY `fk_usuario_categoria` (`usuario_id`);

--
-- Índices de tabela `cadastro_clientes`
--
ALTER TABLE `cadastro_clientes`
  ADD PRIMARY KEY (`clientes_id`),
  ADD UNIQUE KEY `cpf_cnpj` (`cpf_cnpj`),
  ADD KEY `usuario_id` (`usuario_id`) USING BTREE;

--
-- Índices de tabela `cadastro_equipamento`
--
ALTER TABLE `cadastro_equipamento`
  ADD PRIMARY KEY (`equipamentos_id`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD UNIQUE KEY `patrimonio` (`patrimonio`),
  ADD KEY `categoria_id` (`categoria_id`),
  ADD KEY `fornecedor_id` (`fornecedor_id`),
  ADD KEY `usuario_id` (`usuario_id`) USING BTREE;

--
-- Índices de tabela `cadastro_fornecedor`
--
ALTER TABLE `cadastro_fornecedor`
  ADD PRIMARY KEY (`fornecedor_id`),
  ADD UNIQUE KEY `cnpj` (`cnpj`),
  ADD KEY `usuario_id` (`usuario_id`) USING BTREE;

--
-- Índices de tabela `cadastro_grupo`
--
ALTER TABLE `cadastro_grupo`
  ADD PRIMARY KEY (`grupos_id`),
  ADD KEY `usuario_id` (`usuario_id`) USING BTREE;

--
-- Índices de tabela `cadastro_tarefas`
--
ALTER TABLE `cadastro_tarefas`
  ADD PRIMARY KEY (`tarefas_id`),
  ADD KEY `categoria_id` (`categoria_id`),
  ADD KEY `equipamentos_id` (`equipamentos_id`),
  ADD KEY `usuario_id` (`usuario_id`) USING BTREE;

--
-- Índices de tabela `cadastro_tecnico`
--
ALTER TABLE `cadastro_tecnico`
  ADD PRIMARY KEY (`tecnico_id`),
  ADD KEY `usuario_id` (`usuario_id`) USING BTREE;

--
-- Índices de tabela `contas_pagar`
--
ALTER TABLE `contas_pagar`
  ADD PRIMARY KEY (`pagar_id`),
  ADD KEY `fornecedor_id` (`fornecedor_id`),
  ADD KEY `usuario_id` (`usuario_id`) USING BTREE;

--
-- Índices de tabela `contas_receber`
--
ALTER TABLE `contas_receber`
  ADD PRIMARY KEY (`receber_id`),
  ADD KEY `cliente_id` (`cliente_id`),
  ADD KEY `usuario_id` (`usuario_id`) USING BTREE;

--
-- Índices de tabela `financeiro`
--
ALTER TABLE `financeiro`
  ADD PRIMARY KEY (`financeiro_id`),
  ADD KEY `equipamentos_id` (`equipamentos_id`),
  ADD KEY `pagar_id` (`pagar_id`),
  ADD KEY `receber_id` (`receber_id`),
  ADD KEY `usuario_id` (`usuario_id`) USING BTREE;

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `matricula` (`matricula`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cadastro_categoria`
--
ALTER TABLE `cadastro_categoria`
  MODIFY `categoria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `cadastro_clientes`
--
ALTER TABLE `cadastro_clientes`
  MODIFY `clientes_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de tabela `cadastro_equipamento`
--
ALTER TABLE `cadastro_equipamento`
  MODIFY `equipamentos_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `cadastro_fornecedor`
--
ALTER TABLE `cadastro_fornecedor`
  MODIFY `fornecedor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `cadastro_grupo`
--
ALTER TABLE `cadastro_grupo`
  MODIFY `grupos_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `cadastro_tarefas`
--
ALTER TABLE `cadastro_tarefas`
  MODIFY `tarefas_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `cadastro_tecnico`
--
ALTER TABLE `cadastro_tecnico`
  MODIFY `tecnico_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de tabela `contas_pagar`
--
ALTER TABLE `contas_pagar`
  MODIFY `pagar_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `contas_receber`
--
ALTER TABLE `contas_receber`
  MODIFY `receber_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `financeiro`
--
ALTER TABLE `financeiro`
  MODIFY `financeiro_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `cadastro_categoria`
--
ALTER TABLE `cadastro_categoria`
  ADD CONSTRAINT `cadastro_categoria_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`),
  ADD CONSTRAINT `fk_usuario_categoria` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`);

--
-- Restrições para tabelas `cadastro_clientes`
--
ALTER TABLE `cadastro_clientes`
  ADD CONSTRAINT `cadastro_clientes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`);

--
-- Restrições para tabelas `cadastro_equipamento`
--
ALTER TABLE `cadastro_equipamento`
  ADD CONSTRAINT `cadastro_equipamento_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `cadastro_categoria` (`categoria_id`),
  ADD CONSTRAINT `cadastro_equipamento_ibfk_2` FOREIGN KEY (`fornecedor_id`) REFERENCES `cadastro_fornecedor` (`fornecedor_id`),
  ADD CONSTRAINT `cadastro_equipamento_ibfk_3` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`);

--
-- Restrições para tabelas `cadastro_fornecedor`
--
ALTER TABLE `cadastro_fornecedor`
  ADD CONSTRAINT `cadastro_fornecedor_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`);

--
-- Restrições para tabelas `cadastro_grupo`
--
ALTER TABLE `cadastro_grupo`
  ADD CONSTRAINT `cadastro_grupo_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`);

--
-- Restrições para tabelas `cadastro_tarefas`
--
ALTER TABLE `cadastro_tarefas`
  ADD CONSTRAINT `cadastro_tarefas_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `cadastro_categoria` (`categoria_id`),
  ADD CONSTRAINT `cadastro_tarefas_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`),
  ADD CONSTRAINT `cadastro_tarefas_ibfk_3` FOREIGN KEY (`equipamentos_id`) REFERENCES `cadastro_equipamento` (`equipamentos_id`);

--
-- Restrições para tabelas `cadastro_tecnico`
--
ALTER TABLE `cadastro_tecnico`
  ADD CONSTRAINT `cadastro_tecnico_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`);

--
-- Restrições para tabelas `contas_pagar`
--
ALTER TABLE `contas_pagar`
  ADD CONSTRAINT `contas_pagar_ibfk_1` FOREIGN KEY (`fornecedor_id`) REFERENCES `cadastro_fornecedor` (`fornecedor_id`),
  ADD CONSTRAINT `contas_pagar_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`);

--
-- Restrições para tabelas `contas_receber`
--
ALTER TABLE `contas_receber`
  ADD CONSTRAINT `contas_receber_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `cadastro_clientes` (`clientes_id`),
  ADD CONSTRAINT `contas_receber_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`);

--
-- Restrições para tabelas `financeiro`
--
ALTER TABLE `financeiro`
  ADD CONSTRAINT `financeiro_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`),
  ADD CONSTRAINT `financeiro_ibfk_2` FOREIGN KEY (`equipamentos_id`) REFERENCES `cadastro_equipamento` (`equipamentos_id`),
  ADD CONSTRAINT `financeiro_ibfk_3` FOREIGN KEY (`pagar_id`) REFERENCES `contas_pagar` (`pagar_id`),
  ADD CONSTRAINT `financeiro_ibfk_4` FOREIGN KEY (`receber_id`) REFERENCES `contas_receber` (`receber_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
