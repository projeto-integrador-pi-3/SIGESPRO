# Troubleshooting — SIGESPRO API

## Erro 500 com corpo vazio em produção

**Sintoma**
```
HTTP/2 500
content-type: application/json; charset=utf-8
content-length: 0
```

**Ambiente afetado**
Railway (PHP 8.4)

**Causa raiz investigada**

O PHP 8.1+ ativou o modo estrito do MySQLi por padrão (`MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT`), fazendo com que erros de conexão e de query lancem exceções automaticamente.

Duas hipóteses em investigação:

1. **Tabela inexistente no banco de produção**
   A tabela `subprefeituras` pode não ter sido criada no banco MySQL do Railway ainda.
   Verificar com o responsável pelo banco de dados.

2. **Exceção não capturada**
   O bloco `catch` pode não estar capturando todos os tipos de erro do PHP 8.x.
   Usar `catch (\Throwable $e)` em vez de `catch (Exception $e)` cobre tanto `Exception` quanto `Error`.

**Passos para diagnosticar**

1. Verificar se a tabela existe no banco do Railway via MySQL Workbench:
   ```sql
   SHOW TABLES LIKE 'subprefeituras';
   ```

2. Se a tabela não existir, criá-la com o schema em `docker/init.sql`.

3. Se a tabela existir, verificar os logs do Railway:
   - Painel do Railway → serviço da aplicação → aba **Logs**
   - Procurar por mensagens de erro PHP após requisições à `/api/subprefeituras.php`

4. Testar localmente com Docker para confirmar que o endpoint funciona:
   ```bash
   docker compose up --build
   curl http://localhost:8000/api/subprefeituras.php
   ```

**Schema esperado da tabela**

```sql
CREATE TABLE subprefeituras (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  nome        VARCHAR(100) NOT NULL,
  endereco    VARCHAR(200),
  telefone    VARCHAR(20),
  email       VARCHAR(100),
  responsavel VARCHAR(100),
  area        VARCHAR(10)
);
```

**Status**
- [ ] Verificar se tabela existe no banco de produção (Railway)
- [ ] Mergear PR #18 (`catch \Throwable`) e validar em produção
