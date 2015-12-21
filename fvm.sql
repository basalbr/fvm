/*
Navicat MySQL Data Transfer

Source Server         : LOCALHOST
Source Server Version : 50624
Source Host           : localhost:3306
Source Database       : fvm

Target Server Type    : MYSQL
Target Server Version : 50624
File Encoding         : 65001

Date: 2015-12-21 17:28:36
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cnae
-- ----------------------------
DROP TABLE IF EXISTS `cnae`;
CREATE TABLE `cnae` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) DEFAULT NULL,
  `codigo` varchar(10) DEFAULT NULL,
  `id_tabela_simples_nacional` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tabela_simples_nacional` (`id_tabela_simples_nacional`),
  CONSTRAINT `fk_tabela_simples_nacional` FOREIGN KEY (`id_tabela_simples_nacional`) REFERENCES `tabela_simples_nacional` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of cnae
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------

-- ----------------------------
-- Table structure for natureza_juridica
-- ----------------------------
DROP TABLE IF EXISTS `natureza_juridica`;
CREATE TABLE `natureza_juridica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) DEFAULT NULL,
  `representante` varchar(255) DEFAULT NULL,
  `qualificacao` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of natureza_juridica
-- ----------------------------

-- ----------------------------
-- Table structure for pessoa_fisica
-- ----------------------------
DROP TABLE IF EXISTS `pessoa_fisica`;
CREATE TABLE `pessoa_fisica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cpf` varchar(255) DEFAULT NULL,
  `rg` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telefone` varchar(255) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `ramal` varchar(255) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `bairro` varchar(255) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `cep` varchar(255) DEFAULT NULL,
  `id_cidade` int(11) DEFAULT NULL,
  `nacionalidade` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pessoa_fisica_usuairo` (`id_usuario`),
  CONSTRAINT `fk_pessoa_fisica_usuairo` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pessoa_fisica
-- ----------------------------

-- ----------------------------
-- Table structure for pessoa_juridica
-- ----------------------------
DROP TABLE IF EXISTS `pessoa_juridica`;
CREATE TABLE `pessoa_juridica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cnpj` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `responsavel` varchar(255) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `inscricao_estadual` varchar(255) DEFAULT NULL,
  `inscricao_municipal` varchar(255) DEFAULT NULL,
  `iptu` varchar(255) DEFAULT NULL,
  `qtde_funcionarios` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `id_natureza_juridica` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `bairro` varchar(255) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `cep` varchar(255) DEFAULT NULL,
  `id_cidade` int(11) DEFAULT NULL,
  `nome_fantasia` varchar(255) DEFAULT NULL,
  `razao_social` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pessoa_juridica_natureza_juridica` (`id_natureza_juridica`),
  KEY `fk_pessoa_juridica_usuario` (`id_usuario`),
  CONSTRAINT `fk_pessoa_juridica_natureza_juridica` FOREIGN KEY (`id_natureza_juridica`) REFERENCES `natureza_juridica` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_pessoa_juridica_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pessoa_juridica
-- ----------------------------

-- ----------------------------
-- Table structure for pessoa_juridica_cnae
-- ----------------------------
DROP TABLE IF EXISTS `pessoa_juridica_cnae`;
CREATE TABLE `pessoa_juridica_cnae` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pessoa_juridica` int(11) DEFAULT NULL,
  `id_cnae` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pessoa_juridica_cnae_cnae` (`id_cnae`),
  KEY `fk_pessoa_juridica_cnae_pessoa_juridica` (`id_pessoa_juridica`),
  CONSTRAINT `fk_pessoa_juridica_cnae_cnae` FOREIGN KEY (`id_cnae`) REFERENCES `cnae` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_pessoa_juridica_cnae_pessoa_juridica` FOREIGN KEY (`id_pessoa_juridica`) REFERENCES `pessoa_juridica` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pessoa_juridica_cnae
-- ----------------------------

-- ----------------------------
-- Table structure for tabela_simples_nacional
-- ----------------------------
DROP TABLE IF EXISTS `tabela_simples_nacional`;
CREATE TABLE `tabela_simples_nacional` (
  `id` int(11) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tabela_simples_nacional
-- ----------------------------

-- ----------------------------
-- Table structure for tipo_tributacao
-- ----------------------------
DROP TABLE IF EXISTS `tipo_tributacao`;
CREATE TABLE `tipo_tributacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `has_tabela` char(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tipo_tributacao
-- ----------------------------

-- ----------------------------
-- Table structure for usuario
-- ----------------------------
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `telefone` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of usuario
-- ----------------------------
