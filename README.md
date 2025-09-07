🎨 CLPinturas – Sistema de Orçamento e Catálogo de Serviços
📌 Objetivo

Este projeto foi desenvolvido para aplicar, de forma prática, os conhecimentos adquiridos ao longo do curso, criando um sistema completo em PHP orientado a objetos, com banco de dados MySQL e boas práticas de arquitetura.
O sistema é funcional, responsivo e atende a um propósito real: simular um site institucional para uma empresa de pinturas, incluindo catálogo de serviços, orçamento e registro de interações do usuário.

🚀 Funcionalidades

✅ Página institucional com seções Home, Quem Somos, Serviços, Catálogo e Orçamento
✅ Sistema de logs profissionais que registra ações do usuário (cliques e páginas acessadas)
✅ Cadastro e gerenciamento de serviços e tintas
✅ Estrutura modularizada e reutilizável (POO com encapsulamento)
✅ Banco de dados relacional MySQL com chaves primárias e estrangeiras
✅ Uso de ENUM para status de registros (ex: tipo de usuário, status de orçamento)
✅ Integração de biblioteca externa via Composer
✅ Interface moderna utilizando Bootstrap 5 + CSS customizado
🛠️ Tecnologias Utilizadas
PHP 8+ (Orientado a Objetos)
MySQL
Composer
Arquitetura MVC
Bootstrap 5
FontAwesome / Bootstrap Icons
AOS.js (animações)

🗂️ Modelagem de Dados
Número de tabelas: 3+
Relacionamentos: chaves primárias e estrangeiras aplicadas
Uso de ENUM: para status de registros
DER: [Link para o diagrama aqui]

📦 Instalação e Execução
Clone este repositório:
git clone https://github.com/seu-usuario/projeto-pintor.git
Instale as dependências via Composer:
composer install
Configure o arquivo .env com os dados do banco de dados.
Importe o script SQL disponível em /database/script.sql.

Inicie o servidor local:
php -S localhost:8000 -t public

👨‍💻 Integrantes
Marcos inácio de Souza rosa 
Vitor Hugo de Moraes
📅 Apresentação
Data: 18 e 19 de Setembro
Ordem: a ser divulgada