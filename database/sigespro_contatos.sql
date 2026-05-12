CREATE TABLE IF NOT EXISTS `contatos` (
  `id`              int          NOT NULL AUTO_INCREMENT,
  `nome`            varchar(100) NOT NULL,
  `endereco`        text,
  `telefone`        varchar(50)  DEFAULT NULL,
  `email`           varchar(100) DEFAULT NULL,
  `responsavel`     varchar(100) DEFAULT NULL,
  `tipo`            enum('subprefeitura','secretaria','fornecedor') NOT NULL,
  `area`            varchar(10)  DEFAULT NULL,
  `numero_sei`      varchar(50)  DEFAULT NULL,
  `numero_contrato` varchar(50)  DEFAULT NULL,
  `vigencia_inicio` date         DEFAULT NULL,
  `vigencia_fim`    date         DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
