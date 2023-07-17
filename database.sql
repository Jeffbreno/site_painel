-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 22-Jun-2023 às 21:28
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
-- Banco de dados: `database`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `depoimentos`
--

DROP TABLE IF EXISTS `depoimentos`;
CREATE TABLE IF NOT EXISTS `depoimentos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mensagem` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `depoimentos`
--

INSERT INTO `depoimentos` (`id`, `nome`, `mensagem`, `data`) VALUES
(1, 'CADASTRO 1', 'CADASTRO DE DEPOIMENTO 1', '2023-06-22 16:15:14'),
(2, 'CADASTRO 2', 'CADASTRO DE DEPOIMENTO 2', '2023-06-22 17:51:22');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
