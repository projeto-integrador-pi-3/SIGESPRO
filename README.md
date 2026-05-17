# SIGESPRO

Projeto Integrador III — UNIVESP

Portal interno de gestão de sistemas e procedimentos de TI da SMSUB/SP.

## Tecnologias

- PHP 8.4
- MySQL 8.0
- Cloudinary (armazenamento de arquivos)
- Google Maps Places API (autocomplete de endereço no módulo de contatos)
- TinyMCE (editor de texto rico nos módulos de procedimentos e templates)
- html2pdf.js (geração de PDF client-side no módulo de documentos)
- Docker (ambiente local)
- Railway (deploy)

## Rodar localmente (Mac/Linux)

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

Crie um arquivo `.env` na raiz do projeto com o conteúdo abaixo. As variáveis de banco já estão corretas para o Docker:

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

---

## Rodar localmente (Windows)

### Pré-requisitos

**1. Ative o WSL2**

O Docker Desktop no Windows exige o WSL2. Abra o PowerShell como administrador e execute:

```powershell
wsl --install
```

Reinicie o computador quando solicitado.

**2. Instale o Docker Desktop**

Baixe em [docker.com/products/docker-desktop](https://www.docker.com/products/docker-desktop/). Durante a instalação, mantenha marcada a opção _"Use WSL 2 instead of Hyper-V"_.

**3. Instale o Git**

Baixe em [git-scm.com](https://git-scm.com/). Na instalação, mantenha as opções padrão.

**4. Verifique a instalação**

Abra o PowerShell e confirme que os dois comandos retornam uma versão:

```powershell
docker --version
docker compose version
```

> Use sempre **PowerShell** para os comandos abaixo. O Prompt de Comando (CMD) não funciona com alguns deles.

### Passo a passo

**1. Clone o repositório**

```powershell
git clone https://github.com/projeto-integrador-pi-3/SIGESPRO.git
cd SIGESPRO
```

**2. Crie o arquivo `.env`**

Não crie o arquivo pelo Explorer — o Windows pode salvar como `.env.txt` sem avisar. Use o PowerShell:

```powershell
New-Item .env -ItemType File
notepad .env
```

O Notepad vai abrir. Cole o conteúdo abaixo, salve e feche:

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

```powershell
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

```powershell
docker compose down
```

Para apagar também os dados do banco:

```powershell
docker compose down -v
```

---

## Resolução de problemas

### `docker compose` não é reconhecido

Você tem uma versão antiga do Docker que usa `docker-compose` (com hífen). Atualize o Docker Desktop para a versão mais recente, ou substitua todos os comandos `docker compose` por `docker-compose`.

### Porta 3306 já está em uso

O container do banco usa a porta 3306. Se você tem MySQL instalado localmente (XAMPP, MySQL Workbench, etc.), haverá conflito.

**Solução:** pare o serviço MySQL local antes de subir os containers.

- **Windows:** pressione `Win + R`, digite `services.msc`, encontre _MySQL_ e clique em _Parar_.
- **XAMPP:** abra o painel do XAMPP e clique em _Stop_ na linha do MySQL.

### O banco sobe vazio (tabelas não criadas)

O `init.sql` só é executado na **primeira vez** que o volume do banco é criado. Se o volume já existia de uma execução anterior com erro, o banco fica vazio.

**Solução:** apague o volume e suba novamente:

```bash
docker compose down -v
docker compose up --build
```

### A página abre mas mostra erro de conexão com o banco

Verifique se o arquivo `.env` está na raiz do projeto (não dentro de nenhuma pasta) e se as variáveis de banco estão exatamente como no passo 2. Um `.env.txt` ou `.env ` (com espaço no nome) não será lido.

## Variáveis de ambiente

### Ambiente local (`.env`)

| Variável | Valor para Docker local |
|----------|------------------------|
| `DB_HOST` | `db` |
| `DB_PORT` | `3306` |
| `DB_USER` | `sigespro` |
| `DB_PASSWORD` | `sigespro` |
| `DB_NAME` | `sigespro` |
| `APP_URL` | `http://localhost:8000` |
| `CLOUDINARY_CLOUD_NAME` | _(solicitar ao time)_ |
| `CLOUDINARY_API_KEY` | _(solicitar ao time)_ |
| `CLOUDINARY_API_SECRET` | _(solicitar ao time)_ |

### Produção (Railway)

As variáveis de banco são injetadas automaticamente pelo plugin MySQL do Railway (`MYSQLHOST`, `MYSQLUSER`, `MYSQLPASSWORD`, `MYSQLDATABASE`, `MYSQLPORT`). Não é necessário configurá-las manualmente.

Configurar manualmente apenas:

| Variável | Descrição |
|----------|-----------|
| `APP_URL` | URL pública da aplicação |
| `CLOUDINARY_CLOUD_NAME` | Nome do cloud no Cloudinary |
| `CLOUDINARY_API_KEY` | Chave de API do Cloudinary |
| `CLOUDINARY_API_SECRET` | Secret do Cloudinary |

## Requisitos do Projeto Integrador III

- [x] **Framework web** — Aplicação web em PHP 8.4
- [x] **Banco de dados** — MySQL 8.0 via Railway
- [x] **JavaScript** — Fetch API para CRUD assíncrono em todos os módulos
- [x] **Nuvem** — Railway (hospedagem) + Cloudinary (armazenamento de arquivos)
- [x] **Controle de versão** — Git + GitHub com branches e pull requests
- [x] **API** — Cloudinary (upload de arquivos e PDFs gerados), Google Maps Places (autocomplete de endereço)
- [x] **Acessibilidade** — Labels vinculados a inputs, `aria-label` nos botões e `autocomplete` nos formulários
- [x] **Integração contínua** — GitHub Actions: verificação de sintaxe PHP e build Docker em todo PR para main
- [ ] **Testes** — Em desenvolvimento

## Estrutura de pastas

```
/
├── contatos/       # Módulo de contatos (subprefeituras, secretarias e fornecedores)
├── sistemas/       # Módulo de sistemas
├── procedimentos/  # Módulo de procedimentos
├── documentos/     # Módulo de documentos
├── admin/          # Módulo de usuários e administração
├── login/          # Autenticação (login, logout, verificação de sessão)
├── database/       # Scripts SQL de referência das tabelas e migrations
│   └── migrations/ # Migrations para atualizar ambientes existentes
├── docker/         # Ambiente local (Dockerfile, init.sql)
├── js/             # Scripts do frontend
├── .github/        # Workflows de integração contínua
├── Dockerfile      # Imagem de produção para deploy no Railway
└── nixpacks.toml   # Configuração do build no Railway
```
