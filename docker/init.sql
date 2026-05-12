SET NAMES utf8mb4;

-- Usuários
CREATE TABLE IF NOT EXISTS usuarios (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  nome       VARCHAR(100) NOT NULL,
  email      VARCHAR(100) NOT NULL UNIQUE,
  senha      VARCHAR(255) NOT NULL,
  perfil     ENUM('admin','usuario') NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Usuário padrão para desenvolvimento: admin@sigespro.dev / admin123
INSERT INTO usuarios (nome, email, senha, perfil) VALUES
('Admin', 'admin@sigespro.dev', '$2y$12$Tye0Xq/6qCXBvWy1UjQy9.QdIXGVvQ4Q1a1Xie0g0Bb8grb03R/yi', 'admin');

-- Subprefeituras
CREATE TABLE IF NOT EXISTS subprefeituras (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  nome        VARCHAR(100) NOT NULL,
  endereco    VARCHAR(200),
  telefone    VARCHAR(20),
  email       VARCHAR(100),
  responsavel VARCHAR(100),
  area        VARCHAR(10)
);

INSERT INTO subprefeituras (nome, endereco, telefone, email, responsavel, area) VALUES
('Sé',           'Praça do Patriarca, 78 - Centro',          '(11) 3392-0100', 'ti.se@prefeitura.sp.gov.br',          'Carlos Souza',   'TI'),
('Pinheiros',    'R. Cristiano Viana, 700 - Pinheiros',      '(11) 3088-0200', 'ti.pinheiros@prefeitura.sp.gov.br',   'Ana Lima',       'TI'),
('Santana',      'Av. Engenheiro Caetano Álvares, 600',       '(11) 3399-0300', 'ti.santana@prefeitura.sp.gov.br',     'Marcos Pereira', 'CPDU'),
('Lapa',         'R. Guaicurus, 1000 - Lapa',                '(11) 3832-0400', 'ti.lapa@prefeitura.sp.gov.br',        'Fernanda Costa', 'TI'),
('Vila Mariana', 'R. Domingos de Morais, 2564 - V. Mariana', '(11) 5586-0500', 'ti.vilamariana@prefeitura.sp.gov.br', 'Roberto Silva',  'CPDU');

-- Secretarias
CREATE TABLE IF NOT EXISTS secretarias (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  nome        VARCHAR(100) NOT NULL,
  endereco    VARCHAR(200),
  telefone    VARCHAR(20),
  email       VARCHAR(100),
  responsavel VARCHAR(100)
);

-- Sistemas
CREATE TABLE IF NOT EXISTS sistemas (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  nome        VARCHAR(100) NOT NULL,
  area        VARCHAR(100),
  responsavel VARCHAR(100),
  email       VARCHAR(100),
  telefone    VARCHAR(50),
  local       VARCHAR(255),
  status      ENUM('Ativo','Inativo')
);

-- Procedimentos
CREATE TABLE IF NOT EXISTS procedimentos (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  nome       VARCHAR(100) NOT NULL,
  descricao  TEXT,
  tipo       VARCHAR(50),
  sistema_id INT,
  CONSTRAINT fk_procedimentos_sistemas FOREIGN KEY (sistema_id) REFERENCES sistemas (id) ON DELETE RESTRICT
);

-- Documentos
CREATE TABLE IF NOT EXISTS documentos (
  id              INT AUTO_INCREMENT PRIMARY KEY,
  nome            VARCHAR(100) NOT NULL,
  descricao       TEXT,
  caminho_arquivo TEXT,
  procedimento_id INT,
  CONSTRAINT fk_documentos_procedimentos FOREIGN KEY (procedimento_id) REFERENCES procedimentos (id)
);

-- Contatos (subprefeituras, secretarias e fornecedores unificados)
CREATE TABLE IF NOT EXISTS contatos (
  id               INT AUTO_INCREMENT PRIMARY KEY,
  nome             VARCHAR(100) NOT NULL,
  endereco         TEXT,
  telefone         VARCHAR(50),
  email            VARCHAR(100),
  responsavel      VARCHAR(100),
  tipo             ENUM('subprefeitura','secretaria','fornecedor') NOT NULL,
  area             VARCHAR(10)  DEFAULT NULL,
  numero_sei       VARCHAR(50)  DEFAULT NULL,
  numero_contrato  VARCHAR(50)  DEFAULT NULL,
  vigencia_inicio  DATE         DEFAULT NULL,
  vigencia_fim     DATE         DEFAULT NULL
);
