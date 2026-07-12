# 🎮 Game Tracker

O **Game Tracker** é uma aplicação web desenvolvida em **PHP** para gerenciar sua biblioteca de jogos. O projeto permite organizar sua coleção, acompanhar o progresso de cada jogo e visualizar estatísticas por meio de um dashboard.

Além da aplicação web, o projeto disponibiliza uma **API REST** protegida por autenticação JWT, utilizada pelo aplicativo **Game Tracker Mobile**.

O principal objetivo deste projeto foi aprofundar conhecimentos em desenvolvimento backend, arquitetura de software e boas práticas utilizando PHP puro, sem frameworks.

---

# ✨ Funcionalidades

### Aplicação Web

* ✅ Cadastro de usuários
* ✅ Login e autenticação
* ✅ CRUD completo de jogos
* ✅ Dashboard com estatísticas
* ✅ Seção de destaques
* ✅ Validação de formulários
* ✅ Proteção contra CSRF
* ✅ Controle de acesso por usuário
* ✅ Organização dos jogos por status

### API REST

* ✅ Login com JWT
* ✅ Refresh Token
* ✅ Logout
* ✅ CRUD completo de jogos
* ✅ Proteção das rotas privadas
* ✅ Validação das requisições
* ✅ Controle de propriedade dos recursos (Ownership)

---

# 🏗 Arquitetura

O projeto foi desenvolvido utilizando uma arquitetura inspirada no padrão **MVC**, com separação clara de responsabilidades.

```
app/
├── Controllers/
├── Core/
├── Helpers/
├── Middlewares/
├── Models/
├── Services/
└── Views/

config/
public/
routes/
tests/
```

Essa organização facilita manutenção, testes e evolução do sistema.

---

# 🛠 Tecnologias Utilizadas

* PHP 8
* MySQL
* PDO
* HTML5
* CSS3
* JavaScript
* Composer
* PHPUnit
* JWT (JSON Web Token)

---

# 🚀 Principais Conceitos Aplicados

* Arquitetura MVC
* API REST
* Programação Orientada a Objetos
* Injeção de responsabilidades por camadas
* Autenticação JWT
* Refresh Tokens
* Middleware
* Validação de dados
* Proteção contra CSRF
* Testes unitários
* Separação de responsabilidades
* Organização em Services
* Manipulação de banco de dados com PDO

---

# ▶️ Executando o Projeto

## 1. Clone o repositório

```bash
git clone https://github.com/SalemiDeveloper/game_tracker.git
```

## 2. Entre na pasta

```bash
cd game_tracker
```

## 3. Configure o banco de dados

Edite o arquivo:

```
config/database.php
```

informando as credenciais do seu MySQL.

## 4. Inicie o servidor

```bash
php -S localhost:8000 -t public
```

## 5. Acesse

```
http://localhost:8000
```

---

# 🧪 Testes

O projeto possui testes automatizados utilizando PHPUnit.

Execute:

```bash
vendor/bin/phpunit
```

---

# 📱 Integração

Este projeto serve como backend para o **Game Tracker Mobile**, aplicação desenvolvida em React Native que consome esta API REST.

---

# 🎯 Objetivos do Projeto

Este projeto foi desenvolvido para consolidar conhecimentos em:

* Desenvolvimento Backend com PHP
* Arquitetura de Software
* APIs REST
* Autenticação JWT
* Testes automatizados
* Segurança em aplicações web
* Organização de projetos sem frameworks

---

# 🚀 Próximos Passos

* Melhorias na interface do usuário (UI/UX)
* Sistema de busca e filtros avançados
* Integração com API externa para capa de jogos
* Sistema de favoritos
* Paginação
* Dashboard com gráficos
* Deploy em produção

---

# 👨‍💻 Autor

Desenvolvido por **Pedro Salemi**.

Projeto criado com foco em estudos, boas práticas de desenvolvimento backend e construção de portfólio.
