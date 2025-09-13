🎨 CLPinturas – Sistema (MVC) de Orçamentos e Catálogo
📌 Objetivo

Aplicar arquitetura limpa em PHP 8 com separação clara (Controllers, Services, Repositories, Views, Core), evoluindo de código procedural legado para base sustentável.

🚀 Funcionalidades (atual)

✅ Site institucional: Home, Quem Somos, Serviços (persistido em tabela), Catálogo (estrutura preparada), Orçamento
✅ Sistema de usuários: registro, login, logout, painel admin (CRUD usuários, promover/demover admin, reset senha)
✅ Orçamentos: submissão via formulário (CSRF) e registro
✅ LoggerService: logs JSON line (auth, orçamento, ingestão via `/log` com token/admin)
✅ Estrutura modular MVC + mini-core (Router c/ middleware, Controller, Env, Session, Csrf, Auth, Response)
✅ Banco MySQL (usuários, orçamentos, serviços, catálogo) via seed
✅ Upload de catálogos (PDF/JPG/PNG) com validação (extensão, MIME, tamanho) e armazenamento em public/uploads/catalogo
✅ Suporte planejado para LOG_DRIVER (file ou db) – default file em dev; db em produção
✅ PHPMailer integrado
✅ Layout responsivo (Bootstrap 5 + ícones)
⚙️ Próximos passos: migrar logs p/ banco (opcional), CRUD catálogo com upload, níveis de log, interfaces de repositório.
� Catálogo: repositório + upload implementados; remover itens se necessário via painel admin.
�🛠️ Tecnologias
PHP 8+, MySQL (PDO), Composer
MVC + Services/Repositories + Middleware
Bootstrap 5, Bootstrap Icons (FontAwesome opcional)
PHPMailer

🗂️ Modelagem (parcial)
Tabelas atuais:
- usuarios (admin bool)
- orcamentos
- servicos (caracteristicas JSON)
- catalogos (arquivo + título)
Planejado:
- logs (arquivo JSONL atual → futura tabela)

### Catálogo

Endpoint público: `/catalogos`

Admin:
- Listagem / formulário: `GET /admin/catalogos`
- Upload: `POST /admin/catalogos` (campos: titulo, arquivo)
- Remoção: `POST /admin/catalogos/delete/{id}`

Validações de upload:
- Extensões permitidas: pdf, png, jpg, jpeg
- MIME checado via finfo: application/pdf, image/png, image/jpeg
- Tamanho máximo: 5MB
- Nome final seguro: slug + timestamp

Diretório de arquivos: `public/uploads/catalogo/`

Seed não inclui itens de catálogo (adicionar via painel).

### Logging

Variável de ambiente: `LOG_DRIVER`
- Valores aceitos: `file` (padrão), `db`.
- `file`: grava em `storage/logs/app-YYYY-MM-DD.log` (JSON lines).
- `db`: grava na tabela `logs` (ver `database/seed.sql`).

Tabela `logs` (ativada no seed):
```
id BIGINT PK, ts DATETIME, user_id INT NULL, acao VARCHAR(160), ctx JSON, ip VARCHAR(45), ua VARCHAR(255)
Índices: ts, acao, user_id
```

#### Construtor do LoggerService e Retrocompatibilidade
O serviço aceita múltiplas formas de inicialização:

| Uso | Efeito |
|-----|--------|
| `new LoggerService()` | Usa `LOG_DRIVER` (ou `file` se não definido) e diretório padrão `storage/logs` |
| `new LoggerService('file')` | Força driver file com diretório padrão |
| `new LoggerService('file', '/caminho/custom')` | Driver file em diretório custom |
| `new LoggerService('db')` | Driver banco (ignora diretório) |
| `new LoggerService('/caminho/antigo')` | (Retrocompat) Interpreta argumento como diretório e driver vem de `LOG_DRIVER` (ou `file`) |

Retrocompatibilidade: versões anteriores recebiam apenas o diretório no primeiro parâmetro. Para não quebrar testes/uso legado, se o primeiro argumento NÃO for `file` ou `db` e parecer um caminho, ele é tratado como diretório e o driver é carregado do ambiente.

Exemplos rápidos:
```php
$logger = new LoggerService();                 // file (default)
$loggerDb = new LoggerService('db');           // banco
$loggerCustomDir = new LoggerService('file', __DIR__.'/logs_tmp');
$loggerLegacy = new LoggerService(__DIR__.'/logs_legacy'); // tratado como diretório (driver do ambiente)
```

#### Migração para driver DB
1. Garantir criação da tabela (rodar seed ou script DDL).
2. Definir `LOG_DRIVER=db` no `.env`.
3. (Opcional) Manter arquivos antigos para histórico; ferramenta futura poderá importar JSONL em lote.

Futuro opcional: comando de import `php bin/import_logs.php` (não implementado ainda).

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

## 🔐 Segurança

Esta aplicação passou por uma fase de hardening para mitigar vetores comuns em apps PHP.

### Hash de Senhas (Argon2id + fallback)
Sempre que possível utilizamos `password_hash(..., PASSWORD_ARGON2ID)`. Se a extensão não estiver disponível no ambiente, cai automaticamente para `PASSWORD_DEFAULT` (BCrypt hoje). Recomenda-se manter Argon2id habilitado em produção.

### Lockout de Login
Após 5 tentativas falhas dentro de 15 minutos combinando email + IP o login é temporariamente bloqueado para aquele par. No sucesso as tentativas são limpas. Prevê mitigação de brute force simples.

### Reset Seguro de Senha
Fluxo:
1. Usuário solicita em `/forgot-password` informando email.
2. Token aleatório (32 bytes -> hex) é gerado; somente o hash SHA-256 é persistido (tabela `password_resets`).
3. Email envia link com `?token=RAW&email=...` (token em memória do usuário apenas).
4. Validação garante: não expirado (ex.: 60 min), não usado, hash coincide.
5. Consumo: senha redefinida (Argon2id) e registro marcado como usado (single-use).
6. Tokens antigos do mesmo email são invalidados antes de criar um novo.

Limpeza recomendada (cron horário):
```sql
DELETE FROM password_resets WHERE used_at IS NOT NULL OR expires_at < NOW();
```

### CSRF Tokens
Todos formulários POST sensíveis contêm `<input type="hidden" name="_csrf" ...>` gerado por `Csrf::token()` (session-bound). Controllers validam via `Csrf::validate()`. Em falha retornam HTTP 419 e interrompem execução. Abrange: login, registro, logout, CRUD admin, catálogo (upload/delete), orçamento, reset de senha.

### Security Headers Middleware
Middleware global injeta cabeçalhos (vide `app/Middleware/SecurityHeadersMiddleware.php`):
```
X-Frame-Options: SAMEORIGIN
X-Content-Type-Options: nosniff
Referrer-Policy: no-referrer-when-downgrade
Content-Security-Policy: default-src 'self' https://cdn.jsdelivr.net; ... (ver arquivo)
Strict-Transport-Security: max-age=63072000; includeSubDomains; preload (apenas se HTTPS)
```
Diretrizes CSP permitem CDN jsDelivr e inline styles mínimos (Bootstrap). Ajustar conforme novos assets.

### Rate Limit de Ingestão de Logs
Endpoint `/log` protegido por token/usuário admin + limitação de frequência (detalhes no service de logging) para evitar flood.

### Upload Seguro
Catálogo: valida extensão, MIME real via `finfo`, tamanho máximo (5MB) e renomeia arquivo com slug + timestamp para evitar colisão e path traversal.

### Próximas Melhorias Possíveis
- Adicionar SameSite=strict aos cookies de sessão (dependendo de onde a sessão é configurada).
- Headers adicionais: `Permissions-Policy`, `Cross-Origin-Opener-Policy` se for servir conteúdo embutido.
- Interface de auditoria dos resets e tentativas de login.

## 🧹 Limpeza e Manutenção
Crons recomendados (diário):
```sql
-- Limpa resets expirados ou usados
DELETE FROM password_resets WHERE used_at IS NOT NULL OR expires_at < NOW();
-- (Opcional) Limpa tentativas de login antigas (> 1 dia)
DELETE FROM login_attempts WHERE criado_em < (NOW() - INTERVAL 1 DAY);
```

Log rotation (driver file): remover arquivos em `storage/logs/` mais antigos que X dias conforme política interna.

## ✅ Cobertura de Testes de Segurança
- `PasswordResetServiceTest`: geração, validação, consumo single-use
- `AuthServiceLockoutTest`: bloqueio após 5 falhas e liberação após sucesso
- (Sugestão futura) Teste para middleware de security headers assegurando presença de CSP / X-Frame-Options.

## 📝 Variáveis de Ambiente Relacionadas
| Variável | Uso |
|----------|-----|
| LOG_DRIVER | file ou db para LoggerService |
| LOG_INGEST_TOKEN | Token de ingestão remota de logs |
| SMTP_HOST/PORT/USER/PASS | Envio de email de reset |
| MAIL_FROM / MAIL_FROM_NAME | Remetente dos emails |

Certifique-se de não commitar `.env`.

👨‍💻 Equipe
Marcos Inácio de Souza Rosa  
Vitor Hugo de Moraes

📅 Roadmap Próximo
1. Filtros e paginação de logs
2. Hardening rota /log (rate limit, tamanho ctx)
3. Persistir serviços/catalogo
4. Testes automatizados base

---

## 🖥️ Painel Moderno (Dashboard)

O painel (`/painel`) foi atualizado para uma interface moderna e responsiva com foco em usabilidade e segurança.

### Componentes Visuais
- Cards de métricas com ícones (Usuários, Admins, Orçamentos últimos dias, Logs Hoje)
- Gráfico (Chart.js) de orçamentos dos últimos 7 dias (barras)
- Lista de logs recentes (5 mais recentes)
- Tabela dinâmica de usuários com ações inline (CRUD completo) via API
- Modais para criar/editar usuários e toasts para feedback

### Arquitetura do Painel
| Camada | Arquivo | Função |
|--------|---------|--------|
| View principal | `app/Views/painel/dashboard.php` | Estrutura HTML, cards, tabela, modais e JSON dos dados do gráfico |
| Serviço de métricas | `app/Services/DashboardService.php` | Detecção dinâmica de colunas e agregações |
| API Usuários | `app/Controllers/AdminUserApiController.php` | Endpoints JSON seguros para CRUD |
| JS Dinâmico | `public/js/painel.js` | Fetch API, render tabela, modais, toasts, gráfico |
| Repositório | `app/Repositories/UsuarioRepository.php` | Operações PDO (prepared statements) |

### Endpoints API (Admin)
Todos requerem usuário logado com tipo `admin`. Respostas: `{ success: bool, message?: string, data?: any, errors?: string[] }`.

| Método | Rota | Descrição |
|--------|------|-----------|
| GET | `/api/admin/users` | Lista usuários (array) |
| POST | `/api/admin/users` | Cria novo (nome, email, senha, tipo) |
| POST | `/api/admin/users/update/{id}` | Atualiza campos enviados (nome, email, tipo, senha) |
| POST | `/api/admin/users/delete/{id}` | Remove usuário |
| POST | `/api/admin/users/reset/{id}` | Redefine senha para `reset123` |
| POST | `/api/admin/users/toggle/{id}` | Alterna tipo entre `user`/`admin` |

Campos aceitos (create/update):
| Campo | Regras |
|-------|--------|
| nome | obrigatório, 2–100 chars |
| email | obrigatório, formato válido, <=150 chars |
| senha | create: obrigatória >=6; update: opcional (>=6 se enviada) |
| tipo | `user` ou `admin` |

### Segurança Aplicada
- Checagem explícita de `Auth::checkAdmin()` em todos endpoints
- CSRF obrigatório (token em header/form `_csrf`)
- Preparação SQL via `PDO::prepare`
- Validação de comprimento e formato
- Sem uso de scripts inline (CSP permanece rígida)
- Dados do gráfico entregues via `<script type="application/json">` (não executável)

### Fluxo CRUD (Exemplo via curl)
```
# Listar
curl -b cookie.txt -c cookie.txt http://localhost:8000/api/admin/users

# Criar
curl -b cookie.txt -c cookie.txt -X POST -F "_csrf=TOKEN" -F "nome=Teste" -F "email=teste@example.com" -F "senha=abcdef" -F "tipo=user" http://localhost:8000/api/admin/users

# Atualizar
curl -b cookie.txt -c cookie.txt -X POST -F "_csrf=TOKEN" -F "tipo=admin" http://localhost:8000/api/admin/users/update/ID
```
(Substituir TOKEN/ID e garantir autenticação prévia no cookie.)

### Gráfico de Orçamentos
- Fonte: `DashboardService::getGraficoUltimos7Dias()`
- Intervalo: últimos 7 dias (dia atual incluído)
- Render: Chart.js (barras) em `painel.js`
- Extensível: adicionar segunda série (ex: orçamentos aprovados) basta incluir novo dataset JS + ajuste no serviço.

### Testes Cobertos
- `tests/AdminUserApiControllerTest.php`
	- List usuários
	- Create inválido (senha curta)
	- Create válido
	- Update tipo
	- Toggle admin
	- Reset senha
	- Delete

### Possíveis Extensões Futuras
- Paginação / busca incremental de usuários (offset + filtros)
- Filtro temporal para logs e orçamentos
- Export CSV (logs / usuários)
- Dashboard multi-série com comparativo semanas
- Rate limiting de mutações via camada de middleware

### Notas de CSP
Incluir host da CDN `https://cdn.jsdelivr.net` em `script-src` (já utilizado para Bootstrap/Chart.js). Para reforçar ainda mais:
1. Adicionar Subresource Integrity (SRI) aos assets externos
2. Remover qualquer dependência de `'unsafe-inline'` (já mitigado removendo scripts inline)
3. Usar nonce caso scripts críticos dinâmicos sejam necessários no futuro

---

## ✅ Pendências Atuais para Finalização

Estas são as tarefas restantes antes de considerar o ciclo atual “encerrado”. Cada uma inclui objetivo, ações sugeridas e critério de aceite.

### 1. Logs no Banco – Verificação / Correção
Objetivo: garantir que o `LoggerService` escreva na tabela `logs` sem fallback silencioso para arquivo.
Passos sugeridos:
- Confirmar `LOG_DRIVER=db` no `.env` (sem espaços ou BOM).
- `SELECT DATABASE();` para validar banco ativo.
- `SHOW TABLES LIKE 'logs';` e `SHOW CREATE TABLE logs;` para conferir estrutura.
- Inserção manual de teste (temporário): `INSERT INTO logs (ts, user_id, acao, ctx, ip, ua) VALUES (NOW(), NULL, 'diagnostic.test', JSON_OBJECT('ok',1), '127.0.0.1', 'cli');`
- Acessar painel e disparar uma ação (ex: criar usuário) -> verificar linha `acao` iniciando com `api.users.`
Critério de aceite: pelo menos 1 linha nova registrada após ação do painel; ausência de erros em PHP log.

### 2. Helper `debugApi` (Melhoria de DX)
Objetivo: centralizar logs estruturados de endpoints admin evitando repetição de chamada manual ao `LoggerService`.
Sugestão de assinatura:
```php
// Em LoggerService ou trait ApiDebugLogger
public function debugApi(string $grupo, string $etapa, array $dados = []): void
// Loga acao = "api.{grupo}.{etapa}" e ctx = $dados (merge ip/ua/user_id interno)
```
Integração: substituir chamadas atuais de dbg()/logger->log nas controllers por `$logger->debugApi('users','store.ok',[ 'id'=>$novoId ])`.
Critério de aceite: todas as rotas admin sensíveis usam helper; formato consistente `api.<grupo>.<etapa>`.

### 3. Limpeza de Instrumentação Temporária
Objetivo: remover ruído de desenvolvimento.
Escopo:
- Remover `console.debug` condicionais ou manter somente se `DEBUG` for definido via `localStorage` (já existe gate – apenas revisar excesso).
- Eliminar comentários "todo" já resolvidos e blocos de logs redundantes no `AdminUserApiController`.
Critério de aceite: nenhum console.log/debug aparece em ambiente normal (sem flag), código mais limpo sem perda de rastreabilidade essencial.

### 4. Diagnóstico “Logs não aparecendo” (Documentação)
Objetivo: adicionar à documentação de operação um mini playbook de diagnóstico.
Checklist a inserir futuramente na seção Logging:
1. Ver `.env` → `LOG_DRIVER=db`
2. Ver tabela existe → `SHOW TABLES LIKE 'logs'`
3. Teste script rápido → `php -r "require 'vendor/autoload.php';(new App\\Services\\LoggerService('db'))->log('probe','{}');"`
4. Conferir exceptions em `storage/logs/*` ou display_errors.
5. Conferir permissões de usuário MySQL para INSERT.
Critério de aceite: operador consegue isolar falha em < 5 minutos seguindo instruções.

### 5. (Opcional) Paginação / Visualização de Logs no Painel
Objetivo: permitir inspeção rápida sem acessar DB diretamente.
Escopo mínimo: rota `GET /api/admin/logs?limit=50&after=<id>` + listagem incremental na lateral.
Critério de aceite: lista carrega últimas N entradas e suporta “carregar mais”.

---
### Resumo Rápido
| ID | Tarefa | Status |
|----|--------|--------|
| 7  | Analisar logs retornados | Pendente (aguarda coleta) |
| 8  | Remover instrumentação | Pendente |
| 20 | Helper debugApi | Pendente |
| 23 | Diagnosticar logs não aparecendo | Pendente |

Quando as quatro acima forem concluídas, realizar commit final:  
`feat(logging): helper debugApi + limpeza instrumentação e docs de diagnóstico`

---