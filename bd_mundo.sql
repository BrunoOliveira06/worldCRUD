CREATE DATABASE IF NOT EXISTS bd_mundo;
USE bd_mundo;

CREATE TABLE IF NOT EXISTS paises (
    id_pais INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL UNIQUE,
    continente VARCHAR(50) NOT NULL,
    populacao BIGINT NOT NULL,
    idioma VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS cidades (
    id_cidade INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    populacao BIGINT NOT NULL,
    id_pais INT NOT NULL,
    FOREIGN KEY (id_pais) REFERENCES paises(id_pais)
        ON DELETE RESTRICT -- Segurança
);

INSERT INTO paises (nome, continente, populacao, idioma) VALUES
('Brasil', 'América do Sul', 214000000, 'Português'),
('Canadá', 'América do Norte', 38000000, 'Inglês/Francês'),
('Japão', 'Ásia', 125000000, 'Japonês');

INSERT INTO cidades (nome, populacao, id_pais) VALUES
('São Paulo', 12300000, 1),
('Rio de Janeiro', 6700000, 1),
('Toronto', 2900000, 2),
('Vancouver', 675000, 2),
('Tóquio', 13900000, 3),
('Osaka', 2700000, 3);
