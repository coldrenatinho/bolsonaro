-- Criar banco de dados
CREATE DATABASE IF NOT EXISTS peticao_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE peticao_db;

-- Tabela de assinaturas
CREATE TABLE IF NOT EXISTS assinaturas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    cpf VARCHAR(11) NOT NULL UNIQUE,
    telefone VARCHAR(20) NOT NULL,
    cidade VARCHAR(100) NOT NULL,
    estado CHAR(2) NOT NULL,
    mensagem TEXT,
    newsletter TINYINT(1) DEFAULT 0,
    data_assinatura DATETIME NOT NULL,
    ip_address VARCHAR(45),
    INDEX idx_cpf (cpf),
    INDEX idx_email (email),
    INDEX idx_data (data_assinatura)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de galeria de imagens
CREATE TABLE IF NOT EXISTS galeria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(255) NOT NULL,
    original_name VARCHAR(255),
    descricao VARCHAR(500),
    upload_date DATETIME NOT NULL,
    aprovado TINYINT(1) DEFAULT 0,
    INDEX idx_aprovado (aprovado),
    INDEX idx_data (upload_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de doações (opcional)
CREATE TABLE IF NOT EXISTS doacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255),
    email VARCHAR(255),
    valor DECIMAL(10,2) NOT NULL,
    metodo_pagamento VARCHAR(50) DEFAULT 'PIX',
    status VARCHAR(20) DEFAULT 'pendente',
    data_doacao DATETIME NOT NULL,
    INDEX idx_status (status),
    INDEX idx_data (data_doacao)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de configurações
CREATE TABLE IF NOT EXISTS configuracoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    chave VARCHAR(100) UNIQUE NOT NULL,
    valor TEXT,
    descricao VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Inserir configurações padrão
INSERT INTO configuracoes (chave, valor, descricao) VALUES
('chave_pix', 'sua-chave-pix@email.com', 'Chave PIX para doações'),
('meta_assinaturas', '10000', 'Meta de assinaturas'),
('peticao_ativa', '1', 'Petição está ativa (1) ou encerrada (0)'),
('email_contato', 'contato@peticao.com.br', 'Email de contato');
