-- Tabelas básicas
CREATE TABLE IF NOT EXISTS usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(120) NOT NULL,
  email VARCHAR(160) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL,
  tipo ENUM('user','admin') NOT NULL DEFAULT 'user',
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS orcamentos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(120) NOT NULL,
  email VARCHAR(160) NOT NULL,
  telefone VARCHAR(60) NOT NULL,
  servico VARCHAR(160) NOT NULL,
  mensagem TEXT NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de serviços (conteúdo anteriormente mockado em código)
CREATE TABLE IF NOT EXISTS servicos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(120) NOT NULL,
  icone VARCHAR(60) NOT NULL,
  descricao TEXT NOT NULL,
  caracteristicas JSON NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed inicial dos serviços atuais
INSERT INTO servicos (titulo, icone, descricao, caracteristicas) VALUES
("Pintura Residencial","bi bi-house-door","Transforme sua casa com cores vibrantes e acabamento perfeito.", JSON_ARRAY("Paredes internas e externas","Acabamento premium","Consultoria de cores")),
("Pintura Comercial","bi bi-building","Destaque sua empresa com um ambiente renovado e acolhedor.", JSON_ARRAY("Salas e escritórios","Fachadas comerciais","Rapidez na execução")),
("Textura e Grafiato","bi bi-brush","Acabamentos modernos e diferenciados para valorizar seu espaço.", JSON_ARRAY("Textura acrílica","Grafiato resistente","Aplicação profissional")),
("Impermeabilização","bi bi-droplet-half","Proteja seu imóvel contra infiltrações e umidade.", JSON_ARRAY("Áreas externas","Lajes e telhados","Produtos de alta durabilidade")),
("Restauração","bi bi-tools","Recupere paredes e superfícies danificadas com qualidade.", JSON_ARRAY("Correção de trincas","Massa corrida e nivelamento","Repintura completa")),
("Acabamentos Especiais","bi bi-bricks","Serviços exclusivos que trazem sofisticação ao seu ambiente.", JSON_ARRAY("Efeitos decorativos","Cimento queimado","Revestimentos criativos")),
("Pintura Eletrostática","bi bi-lightning-charge","Acabamento durável e uniforme para metais e superfícies industriais.", JSON_ARRAY("Estruturas metálicas","Portões e grades","Cabines especializadas")),
("Pintura Ecológica","bi bi-tree","Utilizamos tintas sustentáveis que respeitam o meio ambiente.", JSON_ARRAY("Tintas à base de água","Baixo odor","Certificação ambiental")),
("Tratamento Antimofo e Antiumidade","bi bi-sun","Elimine manchas e bolores garantindo a saúde da sua família.", JSON_ARRAY("Produtos fungicidas","Ambientes úmidos","Prevenção de infiltrações")),
("Design de Ambientes","bi bi-palette","Auxílio na escolha de cores e texturas para harmonizar seu espaço.", JSON_ARRAY("Consultoria personalizada","Tendências atuais","Paleta de cores")),
("Pintura Industrial","bi bi-building-fill","Serviços especializados para indústrias e galpões.", JSON_ARRAY("Pisos industriais","Sinalização de segurança","Revestimentos protetivos")),
("Pintura de Portas e Janelas","bi bi-door-open","Renove portas e esquadrias com acabamentos modernos.", JSON_ARRAY("Madeira e metal","Laqueação","Durabilidade garantida"))
ON DUPLICATE KEY UPDATE titulo = titulo;

-- Tabela de catálogos (ex: arquivos PDF de tintas, texturas, etc.)
CREATE TABLE IF NOT EXISTS catalogos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(160) NOT NULL,
  arquivo VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- (Opcional) seed inicial vazio para catalogos - inserir conforme uploads reais


-- Tabela de logs (migração do arquivo JSONL). Descomente esta seção para ativar persistência em banco.
CREATE TABLE IF NOT EXISTS logs (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  ts DATETIME NOT NULL,
  user_id INT NULL,
  acao VARCHAR(160) NOT NULL,
  ctx JSON NULL,
  ip VARCHAR(45) NULL,
  ua VARCHAR(255) NULL,
  INDEX (ts), INDEX (acao), INDEX (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de reset de senha
CREATE TABLE IF NOT EXISTS password_resets (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(160) NOT NULL,
  token_hash CHAR(64) NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  expires_at DATETIME NOT NULL,
  used_at DATETIME NULL,
  ip VARCHAR(45) NULL,
  user_agent VARCHAR(255) NULL,
  INDEX (email),
  UNIQUE KEY uniq_token_hash (token_hash)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de tentativas de login para lockout
CREATE TABLE IF NOT EXISTS login_attempts (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(160) NULL,
  ip VARCHAR(45) NULL,
  sucesso TINYINT(1) NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX (email), INDEX (ip), INDEX (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Usuário admin inicial (senha: admin123)
INSERT INTO usuarios (nome,email,senha,tipo) VALUES (
  'Admin','marcos@example.com',
  '$2y$10$g7Y.QmGzq0HLdA9b2pHGFu4dVZP8YCMGhxJkHC6nMrtxPV9QRLd0e','admin'
) ON DUPLICATE KEY UPDATE email=email;
