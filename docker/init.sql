SET NAMES utf8mb4;

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
('Sé',            'Praça do Patriarca, 78 - Centro',          '(11) 3392-0100', 'ti.se@prefeitura.sp.gov.br',            'Carlos Souza',   'TI'),
('Pinheiros',     'R. Cristiano Viana, 700 - Pinheiros',      '(11) 3088-0200', 'ti.pinheiros@prefeitura.sp.gov.br',     'Ana Lima',       'TI'),
('Santana',       'Av. Engenheiro Caetano Álvares, 600',       '(11) 3399-0300', 'ti.santana@prefeitura.sp.gov.br',       'Marcos Pereira', 'CPDU'),
('Lapa',          'R. Guaicurus, 1000 - Lapa',                '(11) 3832-0400', 'ti.lapa@prefeitura.sp.gov.br',          'Fernanda Costa', 'TI'),
('Vila Mariana',  'R. Domingos de Morais, 2564 - V. Mariana', '(11) 5586-0500', 'ti.vilamariana@prefeitura.sp.gov.br',   'Roberto Silva',  'CPDU');
