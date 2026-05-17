ALTER TABLE contatos
  ADD COLUMN responsavel_financeiro VARCHAR(100) DEFAULT NULL AFTER responsavel,
  ADD COLUMN valor_contrato         VARCHAR(50)  DEFAULT NULL AFTER numero_sei;
