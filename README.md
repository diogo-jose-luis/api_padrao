# API Padrão

API REST desenvolvida em **Laravel 12** com autenticação **Laravel Sanctum**, pensada como base reutilizável para projetos que precisam de gestão de utilizadores, cargos e departamentos. Inclui respostas JSON padronizadas, validação de dados, upload de fotografia de perfil e documentação interativa com **Swagger (OpenAPI 3.0)**.

## Funcionalidades

- Autenticação com token Bearer (registo, login, logout e perfil autenticado)
- CRUD completo de **utilizadores**, **cargos** e **departamentos**
- Relacionamento de utilizadores com cargo e departamento
- Upload de fotografia de perfil (armazenamento público)
- Respostas JSON consistentes (`success`, `message`, `data`)
- Tratamento centralizado de erros de validação, autenticação e recursos não encontrados
- Documentação Swagger para testar endpoints no navegador
- Seeders com dados iniciais para desenvolvimento

## Tecnologias

| Tecnologia | Versão |
|------------|--------|
| PHP | ^8.2 |
| Laravel | ^12.0 |
| Laravel Sanctum | ^4.0 |
| L5-Swagger (OpenAPI) | ^11.0 |
| SQLite (padrão) / MySQL | — |

## Requisitos

- PHP >= 8.2
- Composer
- Extensões PHP: `openssl`, `pdo`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`
- MySQL ou MariaDB (opcional; o projeto usa SQLite por defeito)

## Instalação

```bash
# Clonar o repositório
git clone https://github.com/SEU_USUARIO/api_padrao.git
cd api_padrao

# Instalar dependências
composer install

# Configurar ambiente
cp .env.example .env
php artisan key:generate

# Base de dados (SQLite — ficheiro criado automaticamente)
touch database/database.sqlite
php artisan migrate

# Dados iniciais (opcional)
php artisan db:seed

# Ligação simbólica para fotografias públicas
php artisan storage:link

# Documentação Swagger
composer swagger
```

### MySQL (opcional)

No ficheiro `.env`, ajuste as variáveis de base de dados:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=api_padrao
DB_USERNAME=root
DB_PASSWORD=
```

Depois execute `php artisan migrate --seed`.

### Servidor de desenvolvimento

```bash
php artisan serve
```

A API ficará disponível em `http://127.0.0.1:8000`.

Confirme que `APP_URL` no `.env` corresponde ao URL em uso:

```env
APP_URL=http://127.0.0.1:8000
```

## Documentação Swagger

Com o servidor a correr, aceda à documentação interativa:

| Recurso | URL |
|---------|-----|
| Página inicial | `http://127.0.0.1:8000/` |
| Swagger UI | `http://127.0.0.1:8000/api/documentation` |

### Testar endpoints protegidos

1. Execute `POST /api/login` (ou `/api/register`) no Swagger.
2. Copie o valor de `data.token` da resposta.
3. Clique em **Authorize** e insira: `Bearer {seu_token}`.
4. Execute os endpoints protegidos normalmente.

No dropdown **Servers**, prefira **"Servidor atual"** (`/api`) para que os pedidos usem o mesmo host e porta da documentação.

Para regenerar a documentação após alterações:

```bash
composer swagger
# ou
php artisan l5-swagger:generate
```

## Endpoints

Prefixo base: `/api`

### Autenticação (público)

| Método | Endpoint | Descrição |
|--------|----------|-----------|
| `POST` | `/register` | Registar utilizador e obter token |
| `POST` | `/login` | Login com email e password |

### Autenticação (protegido — Bearer token)

| Método | Endpoint | Descrição |
|--------|----------|-----------|
| `POST` | `/logout` | Revogar o token atual |
| `GET` | `/me` | Utilizador autenticado |

### Utilizadores (protegido)

| Método | Endpoint | Descrição |
|--------|----------|-----------|
| `GET` | `/users` | Listar utilizadores |
| `POST` | `/users` | Criar utilizador |
| `GET` | `/users/{id}` | Detalhes do utilizador |
| `PUT` | `/users/{id}` | Atualizar utilizador |
| `DELETE` | `/users/{id}` | Remover utilizador |

### Cargos (protegido)

| Método | Endpoint | Descrição |
|--------|----------|-----------|
| `GET` | `/positions` | Listar cargos |
| `POST` | `/positions` | Criar cargo |
| `GET` | `/positions/{id}` | Detalhes do cargo |
| `PUT` | `/positions/{id}` | Atualizar cargo |
| `DELETE` | `/positions/{id}` | Remover cargo |

### Departamentos (protegido)

| Método | Endpoint | Descrição |
|--------|----------|-----------|
| `GET` | `/departments` | Listar departamentos |
| `POST` | `/departments` | Criar departamento |
| `GET` | `/departments/{id}` | Detalhes do departamento |
| `PUT` | `/departments/{id}` | Atualizar departamento |
| `DELETE` | `/departments/{id}` | Remover departamento |

## Formato das respostas

### Sucesso

```json
{
  "success": true,
  "message": "Login efetuado com sucesso.",
  "data": {
    "token": "1|xxxxxxxx",
    "user": { }
  }
}
```

### Erro de validação (422)

```json
{
  "success": false,
  "message": "Dados de validação inválidos.",
  "errors": {
    "email": ["The email field is required."]
  }
}
```

### Não autenticado (401)

```json
{
  "success": false,
  "message": "Não autenticado."
}
```

## Utilizador de teste (seeder)

Após `php artisan db:seed`:

| Campo | Valor |
|-------|-------|
| Email | `diogo.luis.job@hotmail.com` |
| Password | `123456789` |

## Estrutura do projeto

```
app/
├── Http/
│   ├── Controllers/     # Auth, User, Position, Department
│   ├── Requests/        # Validação de formulários
│   └── Resources/       # Transformação das respostas JSON
├── Models/
├── OpenApi/             # Schemas e metadados Swagger
└── Traits/              # ApiResponse, HandlesUserPhoto
routes/
└── api.php              # Rotas da API
database/
├── migrations/
└── seeders/
```

## Autenticação

A API utiliza **Laravel Sanctum** com tokens pessoais. Envie o token no cabeçalho de cada pedido protegido:

```
Authorization: Bearer {token}
Accept: application/json
Content-Type: application/json
```

## Licença

Este projeto está licenciado sob a [MIT License](https://opensource.org/licenses/MIT).

## Autor

**Diogo Luis**

- Email: [diogo.luis.job@hotmail.com](mailto:diogo.luis.job@hotmail.com)
- Telefone: +244 936 551 407
