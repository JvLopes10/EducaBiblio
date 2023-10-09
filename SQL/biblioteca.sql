-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 08-Out-2023 às 01:15
-- Versão do servidor: 8.0.31
-- versão do PHP: 8.0.26

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
-- Estrutura da tabela `altor`
--

DROP TABLE IF EXISTS `altor`;
CREATE TABLE IF NOT EXISTS `altor` (
  `idAltor` int NOT NULL AUTO_INCREMENT,
  `NomeAltor` varchar(100) NOT NULL,
  PRIMARY KEY (`idAltor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno`
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
-- Estrutura da tabela `devolucao`
--

DROP TABLE IF EXISTS `devolucao`;
CREATE TABLE IF NOT EXISTS `devolucao` (
  `idDevolucao` int NOT NULL AUTO_INCREMENT,
  `DataDevolucao` date NOT NULL,
  `StatusDevolucao` varchar(45) NOT NULL,
  PRIMARY KEY (`idDevolucao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura da tabela `empestimo`
--

DROP TABLE IF EXISTS `empestimo`;
CREATE TABLE IF NOT EXISTS `empestimo` (
  `idEmpestimo` int NOT NULL AUTO_INCREMENT,
  `DataEmprestimo` date NOT NULL,
  `StatusEmprestimo` varchar(50) NOT NULL,
  PRIMARY KEY (`idEmpestimo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura da tabela `genero`
--

DROP TABLE IF EXISTS `genero`;
CREATE TABLE IF NOT EXISTS `genero` (
  `idGenero` int NOT NULL AUTO_INCREMENT,
  `NomeGenero` varchar(50) NOT NULL,
  `DidaticoGenero` varchar(45) NOT NULL,
  PRIMARY KEY (`idGenero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura da tabela `idioma`
--

DROP TABLE IF EXISTS `idioma`;
CREATE TABLE IF NOT EXISTS `idioma` (
  `idIdioma` int NOT NULL AUTO_INCREMENT,
  `Idioma` varchar(50) NOT NULL,
  PRIMARY KEY (`idIdioma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura da tabela `livro`
--

DROP TABLE IF EXISTS `livro`;
CREATE TABLE IF NOT EXISTS `livro` (
  `idLivro` int NOT NULL AUTO_INCREMENT,
  `NomeLivro` varchar(100) NOT NULL,
  `IBSMLivro` varchar(50) DEFAULT NULL,
  `LocalLivro` varchar(250) DEFAULT NULL,
  `Altor_idAltor` int NOT NULL,
  `Genero_idGenero` int NOT NULL,
  `Idioma_idIdioma` int NOT NULL,
  `FotoLivro` blob,
  `EditoraLivro` varchar(100) NOT NULL,
  PRIMARY KEY (`idLivro`),
  KEY `fk_Livro_Altor_idx` (`Altor_idAltor`),
  KEY `fk_Livro_Genero1_idx` (`Genero_idGenero`),
  KEY `fk_Livro_Idioma1_idx` (`Idioma_idIdioma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura da tabela `prof`
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
-- Estrutura da tabela `turma`
--

DROP TABLE IF EXISTS `turma`;
CREATE TABLE IF NOT EXISTS `turma` (
  `idTurma` int NOT NULL AUTO_INCREMENT,
  `AnoTurma` varchar(50) NOT NULL,
  `NomeTurma` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idTurma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `idUsuario` int NOT NULL AUTO_INCREMENT,
  `UserUsuario` varchar(100) NOT NULL,
  `NomeUsuario` varchar(100) NOT NULL,
  `EmailUsuario` varchar(100) NOT NULL,
  `SenhaUsuario` varchar(100) NOT NULL,
  `FotoUsuario` blob,
  PRIMARY KEY (`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `aluno`
--
ALTER TABLE `aluno`
  ADD CONSTRAINT `fk_Aluno_Turma1` FOREIGN KEY (`Turma_idTurma`) REFERENCES `turma` (`idTurma`);

--
-- Limitadores para a tabela `livro`
--
ALTER TABLE `livro`
  ADD CONSTRAINT `fk_Livro_Altor` FOREIGN KEY (`Altor_idAltor`) REFERENCES `altor` (`idAltor`),
  ADD CONSTRAINT `fk_Livro_Genero1` FOREIGN KEY (`Genero_idGenero`) REFERENCES `genero` (`idGenero`),
  ADD CONSTRAINT `fk_Livro_Idioma1` FOREIGN KEY (`Idioma_idIdioma`) REFERENCES `idioma` (`idIdioma`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
