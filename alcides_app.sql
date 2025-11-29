-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 29-Nov-2025 às 01:56
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `alcides_app`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `alunos`
--

CREATE TABLE `alunos` (
  `id` int(11) NOT NULL,
  `ra` varchar(20) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nome_completo` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT 1,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `alunos`
--

INSERT INTO `alunos` (`id`, `ra`, `senha`, `nome_completo`, `email`, `foto_perfil`, `ativo`, `criado_em`) VALUES
(1, '2025', '123', 'Marcio Motta', 'marcio@teste.com', NULL, 1, '2025-11-28 12:41:02'),
(2, '2025001', '123', 'Pedro Henrique', 'pedro@teste.com', NULL, 1, '2025-11-28 12:53:49'),
(3, '2025002', '123', 'Ana Silva', 'ana@teste.com', NULL, 1, '2025-11-28 12:53:49');

-- --------------------------------------------------------

--
-- Estrutura da tabela `avisos`
--

CREATE TABLE `avisos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `corpo` text NOT NULL,
  `prioridade` enum('normal','alta') DEFAULT 'normal',
  `id_turma_alvo` int(11) DEFAULT NULL,
  `data_envio` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `avisos`
--

INSERT INTO `avisos` (`id`, `titulo`, `corpo`, `prioridade`, `id_turma_alvo`, `data_envio`) VALUES
(1, 'Bem-vindo!', 'O ano letivo começou. Baixe o calendário.', 'normal', NULL, '2025-11-28 12:41:02'),
(2, 'Boas vindas!', 'O ano letivo começou. Acesse o portal.', 'normal', NULL, '2025-11-28 12:53:49'),
(3, 'ALERTA DE TEMPESTADE', 'As aulas de hoje foram suspensas.', 'alta', NULL, '2025-11-28 12:53:49'),
(4, 'Material Extra', 'A apostila de BD já está na copiadora.', 'normal', 1, '2025-11-28 12:53:49');

-- --------------------------------------------------------

--
-- Estrutura da tabela `avisos_lidos`
--

CREATE TABLE `avisos_lidos` (
  `id_aviso` int(11) NOT NULL,
  `id_aluno` int(11) NOT NULL,
  `data_leitura` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `chat_nadd`
--

CREATE TABLE `chat_nadd` (
  `id` int(11) NOT NULL,
  `id_aluno` int(11) NOT NULL,
  `remetente` enum('ALUNO','NADD') NOT NULL,
  `tipo_mensagem` enum('TEXTO','IMAGEM','AUDIO') DEFAULT 'TEXTO',
  `mensagem` text DEFAULT NULL,
  `url_arquivo` varchar(255) DEFAULT NULL,
  `duracao_audio` int(11) DEFAULT NULL,
  `lida` tinyint(1) DEFAULT 0,
  `data_envio` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `chat_nadd`
--

INSERT INTO `chat_nadd` (`id`, `id_aluno`, `remetente`, `tipo_mensagem`, `mensagem`, `url_arquivo`, `duracao_audio`, `lida`, `data_envio`) VALUES
(1, 1, 'ALUNO', 'TEXTO', 'Olá, preciso de ajuda com meu boleto.', NULL, NULL, 0, '2025-02-10 17:00:00'),
(2, 1, 'NADD', 'TEXTO', 'Boa tarde Marcio! Qual a dúvida?', NULL, NULL, 0, '2025-02-10 17:05:00'),
(3, 1, 'ALUNO', 'TEXTO', 'Não recebi no email.', NULL, NULL, 0, '2025-02-10 17:06:00'),
(4, 2, 'ALUNO', 'TEXTO', 'Olá NADD, meu atestado já foi analisado?', NULL, NULL, 0, '2025-11-28 22:43:12'),
(5, 2, 'NADD', 'TEXTO', 'Sim, Ana. Pode retirar na secretaria. Assunto encerrado.', NULL, NULL, 0, '2025-11-28 23:43:12'),
(6, 3, 'ALUNO', 'TEXTO', 'Olá, Tem prova na sexta?', NULL, NULL, 0, '2025-11-28 22:44:41'),
(7, 3, 'NADD', 'TEXTO', 'Não, na próxima sexta não tem aula.', NULL, NULL, 0, '2025-11-28 23:44:41');

-- --------------------------------------------------------

--
-- Estrutura da tabela `disciplines`
--

CREATE TABLE `disciplines` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `professor` varchar(100) DEFAULT NULL,
  `sala` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `disciplines`
--

INSERT INTO `disciplines` (`id`, `nome`, `professor`, `sala`) VALUES
(1, 'Lógica de Programação', 'Prof. Girafales', 'Lab 01'),
(2, 'Lógica de Programação', 'Prof. Girafales', 'Lab 01'),
(3, 'Banco de Dados', 'Prof. Xavier', 'Lab 03'),
(4, 'Engenharia de Software', 'Profa. Minerva', 'Sala 102'),
(5, 'Anatomia', 'Dr. House', 'Sala 200');

-- --------------------------------------------------------

--
-- Estrutura da tabela `matriculas`
--

CREATE TABLE `matriculas` (
  `id` int(11) NOT NULL,
  `id_aluno` int(11) NOT NULL,
  `id_disciplina` int(11) NOT NULL,
  `ano_semestre` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `matriculas`
--

INSERT INTO `matriculas` (`id`, `id_aluno`, `id_disciplina`, `ano_semestre`) VALUES
(1, 1, 1, '2025/1'),
(2, 1, 2, '2025/1'),
(3, 1, 3, '2025/1'),
(4, 2, 4, '2025/1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `provas`
--

CREATE TABLE `provas` (
  `id` int(11) NOT NULL,
  `id_disciplina` int(11) NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `data_prova` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `provas`
--

INSERT INTO `provas` (`id`, `id_disciplina`, `titulo`, `descricao`, `data_prova`) VALUES
(1, 1, 'Prova A1', 'Conteúdo: Variáveis e Loops', '2025-03-10 11:00:00'),
(2, 2, 'Prova Prática', 'Criar um MER completo', '2025-03-15 13:00:00'),
(3, 3, 'Seminário', 'Apresentação em grupo (Scrum)', '2025-03-20 22:00:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `solicitacoes`
--

CREATE TABLE `solicitacoes` (
  `id` int(11) NOT NULL,
  `id_aluno` int(11) NOT NULL,
  `setor` enum('FINANCEIRO','SECRETARIA','FALE_CONOSCO') NOT NULL,
  `assunto` varchar(100) DEFAULT NULL,
  `mensagem` text NOT NULL,
  `anexo_url` varchar(255) DEFAULT NULL,
  `status` enum('PENDENTE','EM_ANALISE','RESOLVIDO') DEFAULT 'PENDENTE',
  `resposta_escola` text DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_resposta` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `solicitacoes`
--

INSERT INTO `solicitacoes` (`id`, `id_aluno`, `setor`, `assunto`, `mensagem`, `anexo_url`, `status`, `resposta_escola`, `data_criacao`, `data_resposta`) VALUES
(1, 1, 'SECRETARIA', 'Atestado de Matrícula', 'Preciso para o passe livre.', NULL, 'PENDENTE', NULL, '2025-11-28 12:53:49', NULL),
(2, 1, 'FINANCEIRO', 'Desconto Pontualidade', 'Gostaria de saber se tenho direito.', NULL, 'RESOLVIDO', NULL, '2025-01-20 13:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tokens_dispositivos`
--

CREATE TABLE `tokens_dispositivos` (
  `id` int(11) NOT NULL,
  `id_aluno` int(11) NOT NULL,
  `token_fcm` text NOT NULL,
  `plataforma` enum('android','ios') DEFAULT 'android',
  `data_atualizacao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `turmas`
--

CREATE TABLE `turmas` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `ano_semestre` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `turmas`
--

INSERT INTO `turmas` (`id`, `nome`, `ano_semestre`) VALUES
(1, 'Técnico Info', '2025/1'),
(2, 'Técnico Informática - Manhã', '2025/1'),
(3, 'Técnico Enfermagem - Noite', '2025/1');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `alunos`
--
ALTER TABLE `alunos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ra` (`ra`);

--
-- Índices para tabela `avisos`
--
ALTER TABLE `avisos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_turma_alvo` (`id_turma_alvo`);

--
-- Índices para tabela `avisos_lidos`
--
ALTER TABLE `avisos_lidos`
  ADD PRIMARY KEY (`id_aviso`,`id_aluno`),
  ADD KEY `id_aluno` (`id_aluno`);

--
-- Índices para tabela `chat_nadd`
--
ALTER TABLE `chat_nadd`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_aluno` (`id_aluno`);

--
-- Índices para tabela `disciplines`
--
ALTER TABLE `disciplines`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `matriculas`
--
ALTER TABLE `matriculas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_aluno` (`id_aluno`),
  ADD KEY `id_disciplina` (`id_disciplina`);

--
-- Índices para tabela `provas`
--
ALTER TABLE `provas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_disciplina` (`id_disciplina`);

--
-- Índices para tabela `solicitacoes`
--
ALTER TABLE `solicitacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_aluno` (`id_aluno`);

--
-- Índices para tabela `tokens_dispositivos`
--
ALTER TABLE `tokens_dispositivos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_aluno` (`id_aluno`);

--
-- Índices para tabela `turmas`
--
ALTER TABLE `turmas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `alunos`
--
ALTER TABLE `alunos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `avisos`
--
ALTER TABLE `avisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `chat_nadd`
--
ALTER TABLE `chat_nadd`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `disciplines`
--
ALTER TABLE `disciplines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `matriculas`
--
ALTER TABLE `matriculas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `provas`
--
ALTER TABLE `provas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `solicitacoes`
--
ALTER TABLE `solicitacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tokens_dispositivos`
--
ALTER TABLE `tokens_dispositivos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `turmas`
--
ALTER TABLE `turmas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `avisos`
--
ALTER TABLE `avisos`
  ADD CONSTRAINT `avisos_ibfk_1` FOREIGN KEY (`id_turma_alvo`) REFERENCES `turmas` (`id`);

--
-- Limitadores para a tabela `avisos_lidos`
--
ALTER TABLE `avisos_lidos`
  ADD CONSTRAINT `avisos_lidos_ibfk_1` FOREIGN KEY (`id_aviso`) REFERENCES `avisos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `avisos_lidos_ibfk_2` FOREIGN KEY (`id_aluno`) REFERENCES `alunos` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `chat_nadd`
--
ALTER TABLE `chat_nadd`
  ADD CONSTRAINT `chat_nadd_ibfk_1` FOREIGN KEY (`id_aluno`) REFERENCES `alunos` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `matriculas`
--
ALTER TABLE `matriculas`
  ADD CONSTRAINT `matriculas_ibfk_1` FOREIGN KEY (`id_aluno`) REFERENCES `alunos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `matriculas_ibfk_2` FOREIGN KEY (`id_disciplina`) REFERENCES `disciplines` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `provas`
--
ALTER TABLE `provas`
  ADD CONSTRAINT `provas_ibfk_1` FOREIGN KEY (`id_disciplina`) REFERENCES `disciplines` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `solicitacoes`
--
ALTER TABLE `solicitacoes`
  ADD CONSTRAINT `solicitacoes_ibfk_1` FOREIGN KEY (`id_aluno`) REFERENCES `alunos` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `tokens_dispositivos`
--
ALTER TABLE `tokens_dispositivos`
  ADD CONSTRAINT `tokens_dispositivos_ibfk_1` FOREIGN KEY (`id_aluno`) REFERENCES `alunos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
