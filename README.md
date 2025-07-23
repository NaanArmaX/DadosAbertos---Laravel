
# Dados Abertos - FullStack

Este repositório contém uma aplicação Laravel que consome e manipula dados abertos da **Câmara dos Deputados**. O sistema permite **visualizar deputados**, **filtrar por partido**, **cadastrar deputados fictícios**, **integrar notícias** e **gerenciar uma newsletter**.

## Documentação da API - Auth

#### Dashboard

```http
  GET /
```

####  Deputados

```http
  GET /deputados
```

Lista todos os deputados.

```http
  GET /deputados/{id}
```

Exibe detalhes de um deputado.

#### Deputados Fictícios (CRUD)

```http
  GET /criar
```

Formulário para cadastrar deputado fictício.

```http
  POST /salvar
```

```http
GET /deputados-fic/{id}
GET /deputados-fic/{id}/edit
PUT /deputados-fic/{id}
DELETE /deputados-fic/{id}
```

| Parâmetro            | Tipo     | Descrição                                       |
| :------------------- | :------- | :---------------------------------------------- |
| `nome`               | `string` | **Obrigatório**. Nome completo do deputado      |
| `partido`            | `string` | **Obrigatório**. Sigla do partido político      |
| `naturalidade`       | `string` | **Obrigatório**. Cidade/Estado de origem        |
| `email`              | `string` | **Obrigatório**. E-mail do deputado             |
| `data_nascimento`    | `string` | **Obrigatório**. Data de nascimento (YYYY-MM-DD)|
| `escolaridade`       | `string` | **Obrigatório**. Nível de escolaridade          |
| `legislatura`        | `string` | **Obrigatório**. Número da legislatura atual    |

#### Partidos

```http
  GET /partidos
```
Lista todos os partidos.

#### Noticias

```http
  GET /noticias
```
Lista todos os partidos.


## Deploy

Para fazer o deploy desse projeto rode





```bash
    git clone https://github.com/seu-usuario/dados-abertos-deputados.git
    cd dados-abertos-deputados
```

#### Cria o .env

```bash
    cp .env.example .env
```

#### Instala Dependências 

```bash
    composer install
    php artisan key:generate
    php artisan migrate
```

#### Roda os Containers

```bash
   docker-compose up --build
```

## Diagrama da Arquitetura

Abaixo está o diagrama representando a arquitetura atual do sistema, incluindo os principais serviços e suas interações.

```mermaid
 graph TD
    A[Usuário] -->|GET| B[DashboardController]
    A -->|Busca| C[DeputadoController]
    C -->|API Pública| D[Dados Abertos]
    A -->|Cadastro| E[DeputadoFicController]
    A -->|Notícias| F[NewsController]
    A -->|Newsletter| G[Subscriber & Mail]
  ```