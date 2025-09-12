🎨 CLPinturas – Sistema (MVC) de Orçamentos e Catálogo
📌 Objetivo

Aplicar arquitetura limpa em PHP 8 com separação clara (Controllers, Services, Repositories, Views, Core), evoluindo de código procedural legado para base sustentável.

🚀 Funcionalidades (atual)

✅ Site institucional: Home, Quem Somos, Serviços (mock), Catálogo (mock), Orçamento
✅ Sistema de usuários: registro, login, logout, painel admin (CRUD usuários, promover/demover admin, reset senha)
✅ Orçamentos: submissão via formulário (CSRF) e registro
✅ LoggerService: logs JSON line (auth, orçamento, ingestão via `/log` com token/admin)
✅ Estrutura modular MVC + mini-core (Router c/ middleware, Controller, Env, Session, Csrf, Auth, Response)
✅ Banco MySQL (usuários, orçamentos) + seed inicial
✅ PHPMailer integrado
✅ Layout responsivo (Bootstrap 5 + ícones)
⚙️ Próximos passos: filtros/paginação logs, hardening /log, persistência real de serviços/catalogo, testes automatizados.
🛠️ Tecnologias
PHP 8+, MySQL (PDO), Composer
MVC + Services/Repositories + Middleware
Bootstrap 5, Bootstrap Icons (FontAwesome opcional)
PHPMailer

🗂️ Modelagem (parcial)
Tabelas atuais:
- usuarios (admin bool)
- orcamentos
Futuras:
- servicos
- catalogos
- logs (atualmente arquivos JSONL em storage/logs)

📦 Instalação
1. Clone o repositório
2. composer install
3. Copie `.env.example` para `.env` e configure: DB_*, APP_DEBUG, LOG_INGEST_TOKEN
4. Importe `database/seed.sql`
5. Servidor dev: `php -S localhost:8000 -t public`

🧪 Testes
Agora com suite inicial PHPUnit (AuthService, OrcamentoService, LoggerService).

Executar:
```
composer install
vendor\\bin\\phpunit
```

Arquivos:
- `phpunit.xml.dist` (config)
- `tests/bootstrap.php`
- `tests/*Test.php`

Mocks: repositórios são simulados via classes anônimas (tipagem dos Services flexibilizada para facilitar injeção). Futuro: criar interfaces formais.

👨‍💻 Equipe
Marcos Inácio de Souza Rosa  
Vitor Hugo de Moraes

📅 Roadmap Próximo
1. Filtros e paginação de logs
2. Hardening rota /log (rate limit, tamanho ctx)
3. Persistir serviços/catalogo
4. Testes automatizados base