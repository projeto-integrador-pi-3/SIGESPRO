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

### Pré-requisitos

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (inclui Docker Compose)
- Git

### Passo a passo

**1. Clone o repositório**

```bash
git clone https://github.com/projeto-integrador-pi-3/SIGESPRO.git
cd SIGESPRO
```

**2. Crie o arquivo `.env`**

Crie um arquivo `.env` na raiz do projeto com o conteúdo abaixo. Para rodar localmente, as variáveis de banco já estão preenchidas com os valores do Docker:

```env
DB_HOST=db
DB_PORT=3306
DB_USER=sigespro
DB_PASSWORD=sigespro
DB_NAME=sigespro

APP_URL=http://localhost:8000

CLOUDINARY_CLOUD_NAME=
CLOUDINARY_API_KEY=
CLOUDINARY_API_SECRET=
```

> As variáveis do Cloudinary são obrigatórias para testar o módulo de documentos. Solicite as credenciais do projeto ao time antes de subir o ambiente.

**3. Suba os containers**

```bash
docker compose up --build
```

O Docker irá subir a aplicação PHP e o banco MySQL. Na primeira execução, o `docker/init.sql` é aplicado automaticamente, criando todas as tabelas e o usuário admin padrão.

> Se você já rodou o projeto antes e o banco não inicializou corretamente, apague o volume antigo com `docker compose down -v` antes de subir novamente.

**4. Acesse o sistema**

Abra `http://localhost:8000` no navegador e faça login com:

| Campo | Valor |
|-------|-------|
| E-mail | `admin@sigespro.dev` |
| Senha | `admin123` |

> Este usuário existe apenas no ambiente local. Nunca suba credenciais de teste para produção.

**5. Parar os containers**

```bash
docker compose down
```

Para apagar também os dados do banco:

```bash
docker compose down -v
```

---

> O `docker-compose.yml` usa o `docker/Dockerfile` (servidor embutido do PHP). O `Dockerfile` na raiz é exclusivo para o deploy no Railway.

## Variáveis de ambiente

| Variável | Descrição |
|----------|-----------|
| `DB_HOST` | Host do banco de dados |
| `DB_PORT` | Porta do MySQL |
| `DB_USER` | Usuário do banco |
| `DB_PASSWORD` | Senha do banco |
| `DB_NAME` | Nome do banco |
| `APP_URL` | URL base da aplicação |
| `CLOUDINARY_CLOUD_NAME` | Nome do cloud no Cloudinary |
| `CLOUDINARY_API_KEY` | Chave de API do Cloudinary |
| `CLOUDINARY_API_SECRET` | Secret do Cloudinary |

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
