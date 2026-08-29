-- Garante que o banco de dados existe 
CREATE DATABASE IF NOT EXISTS ordemServico 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;


-- Seleciona o banco criado 
USE ordemServico;

-- Cria a tabela de users
CREATE TABLE IF NOT EXISTS user (
    `id_user` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(150) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP, 
    `ativo` TINYINT(1) NOT NULL DEFAULT 1
);

-- Cria a tabela de serviços
CREATE TABLE IF NOT EXISTS service (
    `id_service` INT AUTO_INCREMENT PRIMARY KEY,
    `description` VARCHAR(45) NOT NULL,
    `price` DECIMAL(11,3) NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `finished_at` DATETIME DEFAULT NULL,
    `commission` DECIMAL(11,3) DEFAULT NULL,
    `user_id_user` BIGINT NOT NULL,
    FOREIGN KEY (`user_id_user`) REFERENCES `user`(`id_user`) ON DELETE CASCADE
);

