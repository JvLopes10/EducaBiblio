-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 25-Out-2023 às 14:25
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb3;

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura da tabela `devolucao`
--

DROP TABLE IF EXISTS `devolucao`;
CREATE TABLE IF NOT EXISTS `devolucao` (
  `idDevolucao` int NOT NULL AUTO_INCREMENT,
  `DataDevolucao` date NOT NULL,
  `StatusDevolucao` int NOT NULL,
  `empestimo_idEmpestimo` int NOT NULL,
  PRIMARY KEY (`idDevolucao`),
  KEY `fk_devolucao_empestimo1_idx` (`empestimo_idEmpestimo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura da tabela `empestimo`
--

DROP TABLE IF EXISTS `empestimo`;
CREATE TABLE IF NOT EXISTS `empestimo` (
  `idEmpestimo` int NOT NULL AUTO_INCREMENT,
  `DataEmprestimo` date NOT NULL,
  `StatusEmprestimo` int NOT NULL,
  `livro_idLivro` int NOT NULL,
  `usuario_idUsuario` int NOT NULL,
  `prof_idProf` int NOT NULL,
  `aluno_idAluno` int NOT NULL,
  `Quantidade_emp` int NOT NULL,
  PRIMARY KEY (`idEmpestimo`),
  KEY `fk_empestimo_livro1_idx` (`livro_idLivro`),
  KEY `fk_empestimo_usuario1_idx` (`usuario_idUsuario`),
  KEY `fk_empestimo_prof1_idx` (`prof_idProf`),
  KEY `fk_empestimo_aluno1_idx` (`aluno_idAluno`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura da tabela `idioma`
--

DROP TABLE IF EXISTS `idioma`;
CREATE TABLE IF NOT EXISTS `idioma` (
  `idIdioma` int NOT NULL AUTO_INCREMENT,
  `Idioma` varchar(50) NOT NULL,
  PRIMARY KEY (`idIdioma`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Extraindo dados da tabela `idioma`
--

INSERT INTO `idioma` (`idIdioma`, `Idioma`) VALUES
(1, 'Português'),
(2, 'Inglês'),
(3, 'Espanhol');

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
  `EditoraLivro` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `EdicaoLivro` varchar(100) DEFAULT NULL,
  `CaminhoFotoLivro` varchar(255) DEFAULT NULL,
  `Quantidadelivros` int NOT NULL,
  PRIMARY KEY (`idLivro`),
  KEY `fk_Livro_Altor_idx` (`Altor_idAltor`),
  KEY `fk_Livro_Genero1_idx` (`Genero_idGenero`),
  KEY `fk_Livro_Idioma1_idx` (`Idioma_idIdioma`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura da tabela `recomendacao`
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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `recomendacao`
--

INSERT INTO `recomendacao` (`idRec`, `LivroRec`, `AutorRec`, `CatRec`, `ImgRec`, `CamRec`) VALUES
(1, 'x', 'x', 'x', '', 'x'),
(2, 'x', 'x', 'x', '', 'x'),
(3, 'x', 'x', 'x', '', 'x');

-- --------------------------------------------------------

--
-- Estrutura da tabela `turma`
--

DROP TABLE IF EXISTS `turma`;
CREATE TABLE IF NOT EXISTS `turma` (
  `AnodeInicio` int NOT NULL AUTO_INCREMENT,
  `AnoTurma` varchar(50) NOT NULL,
  `NomeTurma` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`AnodeInicio`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `UserUsuario`, `NomeUsuario`, `EmailUsuario`, `SenhaUsuario`, `FotoUsuario`) VALUES
(4, 'Murilo', 'Murilo Soares Maciel', 'Murilo.maciel@aluno.ce.gov.br', 'cr701201', NULL);

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `aluno`
--
ALTER TABLE `aluno`
  ADD CONSTRAINT `fk_Aluno_Turma1` FOREIGN KEY (`Turma_idTurma`) REFERENCES `turma` (`AnodeInicio`);

--
-- Limitadores para a tabela `devolucao`
--
ALTER TABLE `devolucao`
  ADD CONSTRAINT `fk_devolucao_empestimo1` FOREIGN KEY (`empestimo_idEmpestimo`) REFERENCES `empestimo` (`idEmpestimo`);

--
-- Limitadores para a tabela `empestimo`
--
ALTER TABLE `empestimo`
  ADD CONSTRAINT `fk_empestimo_aluno1` FOREIGN KEY (`aluno_idAluno`) REFERENCES `aluno` (`idAluno`),
  ADD CONSTRAINT `fk_empestimo_livro1` FOREIGN KEY (`livro_idLivro`) REFERENCES `livro` (`idLivro`),
  ADD CONSTRAINT `fk_empestimo_prof1` FOREIGN KEY (`prof_idProf`) REFERENCES `prof` (`idProf`),
  ADD CONSTRAINT `fk_empestimo_usuario1` FOREIGN KEY (`usuario_idUsuario`) REFERENCES `usuario` (`idUsuario`);

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
