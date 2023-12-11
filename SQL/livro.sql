-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 11/12/2023 às 00:10
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
-- Estrutura para tabela `livro`
--

DROP TABLE IF EXISTS `livro`;
CREATE TABLE IF NOT EXISTS `livro` (
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
  `EditoraLivro` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `EdicaoLivro` varchar(100) DEFAULT NULL,
  `CaminhoFotoLivro` varchar(255) DEFAULT NULL,
  `Quantidadelivros` int NOT NULL,
  PRIMARY KEY (`idLivro`),
  KEY `fk_Livro_Altor_idx` (`autor_idAutor`),
  KEY `fk_Livro_Genero1_idx` (`Genero_idGenero`),
  KEY `fk_Livro_Idioma1_idx` (`Idioma_idIdioma`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `livro`
--
ALTER TABLE `livro`
  ADD CONSTRAINT `fk_Livro_Altor` FOREIGN KEY (`autor_idAutor`) REFERENCES `autor` (`idAutor`),
  ADD CONSTRAINT `fk_Livro_Genero1` FOREIGN KEY (`Genero_idGenero`) REFERENCES `genero` (`idGenero`),
  ADD CONSTRAINT `fk_Livro_Idioma1` FOREIGN KEY (`Idioma_idIdioma`) REFERENCES `idioma` (`idIdioma`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
