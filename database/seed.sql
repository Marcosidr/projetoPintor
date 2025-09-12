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

-- Usuário admin inicial (senha: admin123)
INSERT INTO usuarios (nome,email,senha,tipo) VALUES (
  'Admin','admin@example.com',
  '$2y$10$g7Y.QmGzq0HLdA9b2pHGFu4dVZP8YCMGhxJkHC6nMrtxPV9QRLd0e','admin'
) ON DUPLICATE KEY UPDATE email=email;
