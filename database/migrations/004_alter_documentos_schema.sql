SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE documentos
  CHANGE COLUMN caminho_arquivo arquivo TEXT,
  ADD COLUMN categoria   VARCHAR(100) DEFAULT NULL AFTER nome,
  ADD COLUMN responsavel VARCHAR(100) DEFAULT NULL AFTER categoria,
  ADD COLUMN data_upload DATETIME DEFAULT CURRENT_TIMESTAMP AFTER responsavel,
  DROP FOREIGN KEY fk_documentos_procedimentos,
  DROP COLUMN procedimento_id,
  DROP COLUMN descricao;

SET FOREIGN_KEY_CHECKS = 1;
