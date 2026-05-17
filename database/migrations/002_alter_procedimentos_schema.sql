SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE procedimentos
  CHANGE COLUMN nome titulo VARCHAR(100) NOT NULL,
  ADD COLUMN resumo TEXT AFTER titulo,
  DROP FOREIGN KEY fk_procedimentos_sistemas,
  DROP COLUMN sistema_id;

SET FOREIGN_KEY_CHECKS = 1;
