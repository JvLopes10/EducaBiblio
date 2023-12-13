-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 13/12/2023 às 14:11
-- Versão do servidor: 8.2.0
-- Versão do PHP: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `biblioteca`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `aluno`
--

DROP TABLE IF EXISTS `aluno`;
CREATE TABLE IF NOT EXISTS `aluno` (
  `idAluno` int NOT NULL AUTO_INCREMENT,
  `NomeAluno` varchar(100) NOT NULL,
  `EmailAluno` varchar(100) DEFAULT NULL,
  `ObsAluno` varchar(250) DEFAULT NULL,
  `Turma_idTurma` int NOT NULL,
  PRIMARY KEY (`idAluno`),
  KEY `fk_Aluno_Turma1_idx` (`Turma_idTurma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura para tabela `autor`
--

DROP TABLE IF EXISTS `autor`;
CREATE TABLE IF NOT EXISTS `autor` (
  `idAutor` int NOT NULL AUTO_INCREMENT,
  `NomeAutor` varchar(100) NOT NULL,
  PRIMARY KEY (`idAutor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura para tabela `devolucao`
--

DROP TABLE IF EXISTS `devolucao`;
CREATE TABLE IF NOT EXISTS `devolucao` (
  `idDevolucao` int NOT NULL AUTO_INCREMENT,
  `DataDevolucao` date NOT NULL,
  `DataDevolvida` date DEFAULT NULL,
  `StatusDevolucao` int NOT NULL,
  `emprestimo_idEmprestimo` int NOT NULL,
  PRIMARY KEY (`idDevolucao`),
  KEY `fk_devolucao_empestimo1_idx` (`emprestimo_idEmprestimo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura para tabela `emprestimo`
--

DROP TABLE IF EXISTS `emprestimo`;
CREATE TABLE IF NOT EXISTS `emprestimo` (
  `idEmprestimo` int NOT NULL AUTO_INCREMENT,
  `DataEmprestimo` date NOT NULL,
  `StatusEmprestimo` int NOT NULL,
  `livro_idLivro` int NOT NULL,
  `usuario_idUsuario` int NOT NULL,
  `prof_idProf` int DEFAULT NULL,
  `aluno_idAluno` int DEFAULT NULL,
  `Quantidade_emp` int NOT NULL,
  PRIMARY KEY (`idEmprestimo`),
  KEY `fk_empestimo_livro1_idx` (`livro_idLivro`),
  KEY `fk_empestimo_usuario1_idx` (`usuario_idUsuario`),
  KEY `fk_empestimo_prof1_idx` (`prof_idProf`),
  KEY `fk_empestimo_aluno1_idx` (`aluno_idAluno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura para tabela `genero`
--

DROP TABLE IF EXISTS `genero`;
CREATE TABLE IF NOT EXISTS `genero` (
  `idGenero` int NOT NULL AUTO_INCREMENT,
  `NomeGenero` varchar(50) NOT NULL,
  PRIMARY KEY (`idGenero`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;

--
-- Despejando dados para a tabela `genero`
--

INSERT INTO `genero` (`idGenero`, `NomeGenero`) VALUES
(1, 'Autoajuda'),
(2, 'Biografia'),
(3, 'Clássico'),
(4, 'Conto'),
(5, 'Fantasia'),
(6, 'Ficção científica'),
(7, 'Poesia'),
(8, 'Romance'),
(9, 'Outro');

-- --------------------------------------------------------

--
-- Estrutura para tabela `idioma`
--

DROP TABLE IF EXISTS `idioma`;
CREATE TABLE IF NOT EXISTS `idioma` (
  `idIdioma` int NOT NULL AUTO_INCREMENT,
  `Idioma` varchar(50) NOT NULL,
  PRIMARY KEY (`idIdioma`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Despejando dados para a tabela `idioma`
--

INSERT INTO `idioma` (`idIdioma`, `Idioma`) VALUES
(1, 'Português'),
(2, 'Inglês'),
(3, 'Espanhol');

-- --------------------------------------------------------

--
-- Estrutura para tabela `livro`
--

DROP TABLE IF EXISTS `livro`;
-- Definições de esquema e tabelas...

CREATE TABLE IF NOT EXISTS `biblioteca`.`livro` (
  `idLivro` int NOT NULL AUTO_INCREMENT,
  `NomeLivro` varchar(100) NOT NULL,
  `IBSMLivro` varchar(50) DEFAULT NULL,
  `LocalLivro` varchar(250) DEFAULT NULL,
  `PrateleiraLivro` varchar(100) DEFAULT NULL,
  `ColunaLivro` varchar(100) DEFAULT NULL,
  `autor_idAutor` int NOT NULL,
  `Genero_idGenero` int NOT NULL,
  `Idioma_idIdioma` int NOT NULL,
  `FotoLivro` blob,
  `EditoraLivro` varchar(100) DEFAULT NULL,
  `EdicaoLivro` varchar(100) DEFAULT NULL,
  `CaminhoFotoLivro` varchar(255) DEFAULT NULL,
  `Quantidadelivros` int NOT NULL,
  `DidaticoLivro` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`idLivro`),
  KEY `fk_Livro_Altor_idx` (`autor_idAutor`),
  KEY `fk_Livro_Genero1_idx` (`Genero_idGenero`),
  KEY `fk_Livro_Idioma1_idx` (`Idioma_idIdioma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Restrições para tabelas `livro`
--
ALTER TABLE `livro`
  ADD CONSTRAINT `fk_Livro_Genero1` FOREIGN KEY (`Genero_idGenero`) REFERENCES `genero` (`idGenero`),
  ADD CONSTRAINT `fk_Livro_Idioma1` FOREIGN KEY (`Idioma_idIdioma`) REFERENCES `idioma` (`idIdioma`),
  ADD CONSTRAINT `fk_Livro_Altor` FOREIGN KEY (`autor_idAutor`) REFERENCES `autor` (`idAutor`);

-- --------------------------------------------------------

--
-- Estrutura para tabela `prof`
--

DROP TABLE IF EXISTS `prof`;
CREATE TABLE IF NOT EXISTS `prof` (
  `idProf` int NOT NULL AUTO_INCREMENT,
  `NomeProf` varchar(100) NOT NULL,
  `EmailProf` varchar(100) NOT NULL,
  `MateriaProf` varchar(50) DEFAULT NULL,
  `ObsProf` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`idProf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura para tabela `recomendacao`
--

DROP TABLE IF EXISTS `recomendacao`;
CREATE TABLE IF NOT EXISTS `recomendacao` (
  `idRec` int NOT NULL AUTO_INCREMENT,
  `LivroRec` varchar(150) NOT NULL,
  `AutorRec` varchar(150) NOT NULL,
  `CatRec` varchar(150) NOT NULL,
  `ImgRec` blob NOT NULL,
  `CamRec` varchar(200) NOT NULL,
  PRIMARY KEY (`idRec`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `recomendacao`
--

INSERT INTO `recomendacao` (`idRec`, `LivroRec`, `AutorRec`, `CatRec`, `ImgRec`, `CamRec`) VALUES
(1, 'Nome', 'Autor', 'Categoria', '', 'Caminho'),
(2, 'Nome', 'Autor', 'Categoria', '', 'Caminho'),
(3, 'Nome', 'Autor', 'Categoria', '', 'Caminho');

-- --------------------------------------------------------

--
-- Estrutura para tabela `turma`
--

DROP TABLE IF EXISTS `turma`;
CREATE TABLE IF NOT EXISTS `turma` (
  `IdTurma` int NOT NULL AUTO_INCREMENT,
  `AnoTurma` varchar(50) NOT NULL,
  `NomeTurma` varchar(50) DEFAULT NULL,
  `AnodeInicio` int DEFAULT NULL,
  PRIMARY KEY (`IdTurma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `idUsuario` int NOT NULL AUTO_INCREMENT,
  `UserUsuario` varchar(100) NOT NULL,
  `NomeUsuario` varchar(100) NOT NULL,
  `EmailUsuario` varchar(100) NOT NULL,
  `SenhaUsuario` varchar(100) NOT NULL,
  `FotoUsuario` blob,
  `CamFoto` varchar(200) NOT NULL,
  PRIMARY KEY (`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `aluno`
--
ALTER TABLE `aluno`
  ADD CONSTRAINT `fk_Aluno_Turma1` FOREIGN KEY (`Turma_idTurma`) REFERENCES `turma` (`IdTurma`);

--
-- Restrições para tabelas `devolucao`
--
ALTER TABLE `devolucao`
  ADD CONSTRAINT `fk_devolucao_empestimo1` FOREIGN KEY (`emprestimo_idEmprestimo`) REFERENCES `emprestimo` (`idEmprestimo`);

--
-- Restrições para tabelas `emprestimo`
--
ALTER TABLE `emprestimo`
  ADD CONSTRAINT `fk_empestimo_aluno1` FOREIGN KEY (`aluno_idAluno`) REFERENCES `aluno` (`idAluno`),
  ADD CONSTRAINT `fk_empestimo_livro1` FOREIGN KEY (`livro_idLivro`) REFERENCES `livro` (`idLivro`),
  ADD CONSTRAINT `fk_empestimo_prof1` FOREIGN KEY (`prof_idProf`) REFERENCES `prof` (`idProf`),
  ADD CONSTRAINT `fk_empestimo_usuario1` FOREIGN KEY (`usuario_idUsuario`) REFERENCES `usuario` (`idUsuario`);

--
-- Restrições para tabelas `livro`
--
ALTER TABLE `livro`
  ADD CONSTRAINT `fk_livro_autor1` FOREIGN KEY (`autor_idAutor1`) REFERENCES `autor` (`idAutor`),
  ADD CONSTRAINT `fk_Livro_Genero1` FOREIGN KEY (`Genero_idGenero`) REFERENCES `genero` (`idGenero`),
  ADD CONSTRAINT `fk_Livro_Idioma1` FOREIGN KEY (`Idioma_idIdioma`) REFERENCES `idioma` (`idIdioma`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
