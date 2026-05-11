# SIGESPRO

Projeto Integrador III — UNIVESP

Portal interno de gestão de sistemas e procedimentos de TI da SMSUB/SP.

## Tecnologias

- PHP 8.4
- MySQL 8.0
- Cloudinary (armazenamento de arquivos)
- Docker (ambiente local)
- Railway (deploy)

## Rodar localmente

**Pré-requisitos:** Docker e Docker Compose instalados.

```bash
docker compose up --build
```

Acesse em: `http://localhost:8000`

> O `docker-compose.yml` usa o `docker/Dockerfile` (ambiente local com Apache). O `Dockerfile` na raiz é exclusivo para o deploy no Railway.

## Variáveis de ambiente

Crie um arquivo `.env` na raiz com as seguintes variáveis:

```env
DB_HOST=
DB_PORT=
DB_USER=
DB_PASSWORD=
DB_NAME=

APP_URL=http://localhost:8000

CLOUDINARY_CLOUD_NAME=
CLOUDINARY_API_KEY=
CLOUDINARY_API_SECRET=
```

## API

Base URL: `https://sigespro-production.up.railway.app`

| Método | Endpoint | Descrição |
|--------|----------|-----------|
| GET | `/api/index.php` | Documentação da API |
| GET | `/api/subprefeituras.php` | Lista todas as subprefeituras |
| GET | `/api/subprefeituras.php?id={id}` | Retorna uma subprefeitura pelo ID |

**Exemplo de resposta:**

```json
{
  "success": true,
  "total": 2,
  "data": [
    {
      "id": "1",
      "nome": "Sé",
      "endereco": "Praça do Patriarca, 78 - Centro",
      "telefone": "(11) 3392-0100",
      "email": "ti.se@prefeitura.sp.gov.br",
      "responsavel": "Carlos Souza",
      "area": "TI"
    }
  ]
}
```

## Requisitos do Projeto Integrador III

- [x] **Framework web** — Aplicação web em PHP 8.4
- [x] **Banco de dados** — MySQL 8.0 via Railway
- [x] **JavaScript** — Fetch API para CRUD em todos os módulos
- [x] **Nuvem** — Railway (hospedagem) + Cloudinary (arquivos)
- [x] **Controle de versão** — Git + GitHub com branches e pull requests
- [x] **API** — API REST própria em `/api/` + consumo da API Cloudinary
- [x] **Acessibilidade** — Labels vinculados a inputs, `aria-label` nos botões e `autocomplete` nos formulários
- [x] **Integração contínua** — GitHub Actions: verificação de sintaxe PHP e build Docker em todo PR para main
- [ ] **Testes** — Em desenvolvimento

## Estrutura de pastas

```
/
├── api/            # Endpoints públicos da API REST
├── sistemas/       # Módulo de sistemas
├── subprefeituras/ # Módulo de subprefeituras
├── secretarias/    # Módulo de secretarias
├── procedimentos/  # Módulo de procedimentos
├── documentos/     # Módulo de documentos
├── admin/          # Módulo de usuários e administração
├── login/          # Autenticação (login, logout, verificação de sessão)
├── database/       # Scripts SQL de criação das tabelas
├── docker/         # Ambiente local (Dockerfile, init.sql)
├── js/             # Scripts do frontend
├── .github/        # Workflows de integração contínua
├── Dockerfile      # Imagem de produção para deploy no Railway
└── nixpacks.toml   # Configuração do build no Railway
```
