DROP DATABASE IF EXISTS LEC;

CREATE DATABASE LEC;
USE LEC;

CREATE TABLE IF NOT EXISTS TBEndereco (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    cep CHAR(8) NOT NULL,
    logradouro VARCHAR(100) NOT NULL,
    bairro VARCHAR(100) NOT NULL,
    cidade VARCHAR(100) NOT NULL,
    uf CHAR(2) NOT NULL,
    UNIQUE (id)
    );

CREATE TABLE IF NOT EXISTS TBSexo (
    id VARCHAR(36) PRIMARY KEY,
    descricao VARCHAR(50) NOT NULL,
    UNIQUE (id)
    );

CREATE TABLE IF NOT EXISTS TBPatrocinador (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    idEndereco VARCHAR(36) NOT NULL,
    nome VARCHAR(150) NOT NULL,
    cnpj CHAR(14),
    cpf CHAR(11),
    email VARCHAR(50) NOT NULL,
    senha VARCHAR(100) NOT NULL,
    UNIQUE (id),
    UNIQUE (cnpj),
    UNIQUE (cpf),
    UNIQUE (email),
    FOREIGN KEY (idEndereco) REFERENCES TBEndereco (id)
    );

CREATE TABLE IF NOT EXISTS TBCampeonato (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    UNIQUE (id)
    );

CREATE TABLE IF NOT EXISTS TBEscola (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    cnpj CHAR(14) NOT NULL,
    email VARCHAR(50) NOT NULL,
    senha VARCHAR(100) NOT NULL,
    telefoneUm VARCHAR(30) NOT NULL,
    telefoneDois VARCHAR(30),
    idEndereco VARCHAR(36) NOT NULL,
    UNIQUE (id),
    UNIQUE (cnpj),
    UNIQUE (email),
    FOREIGN KEY (idEndereco) REFERENCES TBEndereco (id)
    );

-- N x N TBPatrocinador e TbCampeonato
CREATE TABLE IF NOT EXISTS TBCampeonatoPatrocinador (
    idCampeonato VARCHAR(36) NOT NULL,
    idPatrocinador VARCHAR(36) NOT NULL,
    FOREIGN KEY (idCampeonato) REFERENCES TBCampeonato (id),
    FOREIGN KEY (idPatrocinador) REFERENCES TBPatrocinador (id),
    PRIMARY KEY (idCampeonato , idPatrocinador)
    );

-- N x N TbEscola e TBPatrocinador
CREATE TABLE IF NOT EXISTS TBEscolaPatrocinador (
    idEscola VARCHAR(36),
    idPatrocinador VARCHAR(36),
    FOREIGN KEY (idEscola)  REFERENCES TBEscola (id),
    FOREIGN KEY (idPatrocinador) REFERENCES TBPatrocinador (id),
    PRIMARY KEY (idEscola , idPatrocinador)
    );

CREATE TABLE IF NOT EXISTS TBTemporada (
    id VARCHAR(36) PRIMARY KEY,
    idCampeonato VARCHAR(36) NOT NULL,
    dataInicio DATE NOT NULL,
    dataFim DATE NOT NULL,
    UNIQUE (id),
    FOREIGN KEY (idCampeonato) REFERENCES TBCampeonato (id)
    );

CREATE TABLE IF NOT EXISTS TBPartida (
    id VARCHAR(36) PRIMARY KEY,
    data DATETIME NOT NULL,
    duracaoMilessegundos INT NOT NULL,
    idMandante VARCHAR(36) NOT NULL,
    idVisitante VARCHAR(36) NOT NULL,
    idTemporada VARCHAR(36) NOT NULL,
    UNIQUE (id),
    FOREIGN KEY (idTemporada) REFERENCES TBTemporada (id),
    FOREIGN KEY (idMandante) REFERENCES TBEscola (id),
    FOREIGN KEY (idVisitante) REFERENCES TBEscola (id)
    );

CREATE TABLE IF NOT EXISTS TBJogador (
    id VARCHAR(36) PRIMARY KEY,
    idEscola VARCHAR(36) NOT NULL,
    idSexo VARCHAR(36) NOT NULL,
    cpf CHAR(11) NOT NULL,
    nome VARCHAR(150) NOT NULL,
    sobrenome VARCHAR(150) NOT NULL,
    numeroCamisa INT NOT NULL,
    dataNascimento DATE NOT NULL,
    nomeJogo VARCHAR(30) NOT NULL,
    UNIQUE (id),
    UNIQUE (cpf),
    FOREIGN KEY (idEscola)  REFERENCES TBEscola (id),
    FOREIGN KEY (idSexo) REFERENCES TBSexo (id)
    );

CREATE TABLE IF NOT EXISTS TBGol (
    id VARCHAR(36) PRIMARY KEY,
    idPartida VARCHAR(36) NOT NULL,
    idJogadorMarcou VARCHAR(36) NOT NULL,
    idJogadorAssistencia VARCHAR(36) NULL,
    anulado BOOL NOT NULL,
    pnalti BOOL NOT NULL,
    tempoEmMilissegundos INT NOT NULL,
    UNIQUE (id),
    FOREIGN KEY (idJogadorMarcou) REFERENCES TBJogador (id),
    FOREIGN KEY (idJogadorAssistencia) REFERENCES TBJogador (id),
    FOREIGN KEY (idPartida)  REFERENCES TBPartida (id)
    );

CREATE TABLE IF NOT EXISTS TBParticipacaoCampeonato (
    id VARCHAR(36) PRIMARY KEY,
    idCampeonato VARCHAR(36) NOT NULL,
    idEscola VARCHAR(36) NOT NULL,
    status INT NOT NULL,
    administrador BOOL NOT NULL,
    UNIQUE (id),
    FOREIGN KEY (idCampeonato)  REFERENCES TBCampeonato (id),
    FOREIGN KEY (idEscola) REFERENCES TBEscola (id)
    );

CREATE TABLE IF NOT EXISTS TBRemocaoEscolaCampeonato (
    idParticipacaoCampeonato VARCHAR(36),
    sequencia INT,
    tipo INT NOT NULL,
    aplicado BOOL NOT NULL,
    FOREIGN KEY (idParticipacaoCampeonato) REFERENCES TBParticipacaoCampeonato (id),
    PRIMARY KEY (idParticipacaoCampeonato , sequencia)
    );

-- N x M TBRemocaoEscolaCampeonato e TBParticipacaoCampeonato
CREATE TABLE IF NOT EXISTS TBVoto (
    idParticipacao VARCHAR(36),
    sequencia INT,
    idParticipanteVotador VARCHAR(36),
    FOREIGN KEY (idParticipacao, sequencia) REFERENCES TBRemocaoEscolaCampeonato(idParticipacaoCampeonato , sequencia),
    FOREIGN KEY (idParticipanteVotador) REFERENCES TBParticipacaoCampeonato(id),
    PRIMARY KEY (idParticipacao , sequencia , idParticipanteVotador)
    );

CREATE TABLE IF NOT EXISTS TBFalta (
    id VARCHAR(36) PRIMARY KEY,
    idPartida VARCHAR(36) NOT NULL,
    idJogadorSofreu VARCHAR(36) NOT NULL,
    idJogadorCometeu VARCHAR(36) NOT NULL,
    tempoPartidaMilissegundos INT NOT NULL,
    UNIQUE (id),
    FOREIGN KEY (idPartida) REFERENCES TBPartida (id),
    FOREIGN KEY (idJogadorSofreu) REFERENCES TBJogador (id),
    FOREIGN KEY (idJogadorCometeu) REFERENCES TBJogador (id)
    );


-- Inserts

SET @enderocoIdUm = UUID();
SET @enderocoIdDois = UUID();
SET @enderocoIdTres = UUID();
SET @enderocoIdQuatro = UUID();
SET @enderocoIdCinco = UUID();

-- Inserir dados na tabela TBEndereco
INSERT INTO TBEndereco (id, cep, logradouro, bairro, cidade, uf)
VALUES
    (@enderocoIdUm, '12345678', 'Rua A', 'Bairro A', 'Cidade A', 'PR'),
    (@enderocoIdDois, '23456789', 'Rua B', 'Bairro B', 'Cidade B', 'PR'),
    (@enderocoIdTres, '34567890', 'Rua C', 'Bairro C', 'Cidade C', 'PR'),
    (@enderocoIdQuatro, '45678901', 'Rua D', 'Bairro D', 'Cidade D', 'PR'),
    (@enderocoIdCinco, '56789012', 'Rua E', 'Bairro E', 'Cidade E', 'PR');


SET @sexoIdUm = UUID();
SET @sexoIdDois = UUID();
SET @sexoIdTres = UUID();

-- Inserir dados na tabela TBSexo
INSERT INTO TBSexo (id, descricao)
VALUES
    (@sexoIdUm, 'Masculino'),
    (@sexoIdDois, 'Feminino'),
    (@sexoIdTres, 'Outro');


SET @escolaIdUm = UUID();
SET @escolaIdDois = UUID();
SET @escolaIdTres = UUID();
SET @escolaIdQuatro = UUID();

-- Inserir dados na tabela TBEscola
INSERT INTO TBEscola (id, nome, cnpj, email, senha, telefoneUm, telefoneDois, idEndereco)
VALUES
    (@escolaIdUm, 'Escola A', '12345678901234', 'escolaA@email.com', 'senha123', '1234567890', '9876543210', @enderocoIdUm),
    (@escolaIdDois, 'Escola B', '23456789012345', 'escolaB@email.com', 'senha456', '9876543210', '1234567890', @enderocoIdDois),
    (@escolaIdTres, 'Escola C', '34567890123456', 'escolaC@email.com', 'senha789', '1234567890', '9876543210', @enderocoIdTres),
    (@escolaIdQuatro, 'Escola D', '45678901234567', 'escolaD@email.com', 'senha012', '1234567890', '9876543210', @enderocoIdQuatro);


SET @patrocinadorIdUm = UUID();

-- Inserir dados na tabela TBPatrocinador
INSERT INTO TBPatrocinador (id, idEndereco, nome, cnpj, cpf, email, senha)
VALUES
    (@patrocinadorIdUm, @enderocoIdUm, 'Patrocinador A', NULL, '12345678901', 'patrocinadorA@email.com', 'senha123');


-- Inserir dados na tabela TBEscolaPatrocinador
INSERT INTO TBEscolaPatrocinador (idEscola, idPatrocinador)
VALUES
    (@escolaIdUm, @patrocinadorIdUm),
    (@escolaIdDois, @patrocinadorIdUm);


SET @campeonatoIdUm = UUID();

-- Inserir dados na tabela TBCampeonato
INSERT INTO TBCampeonato (id, Nome)
VALUES
    (@campeonatoIdUm, 'Campeonato A');

-- Inserir dados na tabela TBCampeonatoPatrocinador
INSERT INTO TBCampeonatoPatrocinador (idCampeonato, idPatrocinador)
VALUES (@campeonatoIdUm, @patrocinadorIdUm);

SET @jogadorIdUm = UUID();
SET @jogadorIdDois = UUID();
SET @jogadorIdTres = UUID();
SET @jogadorIdQuatro = UUID();
SET @jogadorIdCinco = UUID();
SET @jogadorIdSeis= UUID();
SET @jogadorIdSete = UUID();
SET @jogadorIdOito= UUID();


-- Inserir dados na tabela TBJogador com jogadores previamente declarados
INSERT INTO TBJogador (id, idEscola, idSexo, cpf, nome, sobrenome, numeroCamisa, dataNascimento, nomeJogo)
VALUES
    (@jogadorIdUm, @escolaIdUm, @sexoIdUm, '12345678901', 'Jogador', '1', 10, '2000-01-01', 'NomeJogo 1'),
    (@jogadorIdDois, @escolaIdUm, @sexoIdDois, '23456789012', 'Jogador','2', 11, '2001-01-01', 'NomeJogo 2'),
    (@jogadorIdTres, @escolaIdDois, @sexoIdTres, '34567890123', 'Jogador','3', 12, '2002-01-01', 'NomeJogo 3'),
    (@jogadorIdQuatro, @escolaIdDois, @sexoIdUm, '45678901234', 'Jogador 4', 'sobrenome', 13, '2003-01-01', 'NomeJogo 4'),
    (@jogadorIdCinco, @escolaIdTres, @sexoIdDois, '56789012345', 'Jogador 5', 'sobrenome', 14, '2004-01-01', 'NomeJogo 5'),
    (@jogadorIdSeis, @escolaIdTres, @sexoIdTres, '67890123456', 'Jogador 6', 'sobrenome',15, '2005-01-01', 'NomeJogo 6'),
    (@jogadorIdSete, @escolaIdQuatro, @sexoIdUm, '78901234567', 'Jogador 7', 'sobrenome',16, '2006-01-01', 'NomeJogo 7'),
    (@jogadorIdOito, @escolaIdQuatro, @sexoIdDois, '89012345678', 'Jogador 8', 'sobrenome',17, '2007-01-01', 'NomeJogo 8');

SET @temporadaIdUm = UUID();

-- Inserir dados na tabela TBTemporada com temporadas e campeonatos previamente declarados
INSERT INTO TBTemporada (id, idCampeonato, dataInicio, dataFim)
VALUES
    (@temporadaIdUm, @campeonatoIdUm, '2023-01-01', '2023-12-31');


SET @partidaIdUm = UUID();
SET @partidaIdDois = UUID();
SET @partidaIdTres = UUID();
SET @partidaIdQuatro = UUID();
SET @partidaIdCinco = UUID();
SET @partidaIdSeis = UUID();
SET @partidaIdSete = UUID();
SET @partidaIdOito = UUID();
SET @partidaIdNove = UUID();
SET @partidaIdDez = UUID();
SET @partidaIdOnze = UUID();
SET @partidaIdDoze = UUID();

-- Inserir dados na tabela TBPartida com partidas previamente declaradas
INSERT INTO TBPartida (id, data, duracaoMilessegundos, idMandante, idVisitante, idTemporada)
VALUES
    (@partidaIdUm, '2023-01-01 14:00:00', 7200, @escolaIdUm, @escolaIdDois, @temporadaIdUm),
    (@partidaIdDois, '2023-01-02 15:00:00', 7200, @escolaIdUm, @escolaIdTres, @temporadaIdUm),
    (@partidaIdTres, '2023-01-03 16:00:00', 7200, @escolaIdUm, @escolaIdQuatro, @temporadaIdUm),
    (@partidaIdQuatro, '2023-01-04 17:00:00', 7200, @escolaIdDois, @escolaIdTres, @temporadaIdUm),
    (@partidaIdCinco, '2023-01-05 18:00:00', 7200, @escolaIdDois, @escolaIdQuatro, @temporadaIdUm),
    (@partidaIdSeis, '2023-01-06 19:00:00', 7200, @escolaIdQuatro, @escolaIdTres,  @temporadaIdUm),
    (@partidaIdSete, '2023-01-06 20:00:00', 7200, @escolaIdDois, @escolaIdUm,  @temporadaIdUm),
    (@partidaIdOito, '2023-01-06 20:00:00', 7200, @escolaIdTres, @escolaIdUm,  @temporadaIdUm),
    (@partidaIdNove, '2023-01-06 20:00:00', 7200, @escolaIdQuatro, @escolaIdUm,  @temporadaIdUm),
    (@partidaIdDez, '2023-01-06 20:00:00', 7200, @escolaIdQuatro, @escolaIdDois,  @temporadaIdUm),
    (@partidaIdOnze, '2023-01-06 20:00:00', 7200, @escolaIdDois, @escolaIdTres,  @temporadaIdUm),
    (@partidaIdDoze, '2023-01-06 20:00:00', 7200, @escolaIdTres, @escolaIdQuatro,  @temporadaIdUm);


INSERT INTO TBGol (id, idPartida, idJogadorMarcou, idJogadorAssistencia, anulado, pnalti, tempoEmMilissegundos)
VALUES
    (UUID(), @partidaIdUm,  @jogadorIdUm,  @jogadorIdDois, FALSE, FALSE, 45000),      -- Partida 1 -- Escola 1
    (UUID(), @partidaIdUm,  @jogadorIdUm,  NULL, FALSE, FALSE, 45000),                -- Partida 1 -- Escola 1
    (UUID(), @partidaIdTres,  @jogadorIdDois, NULL, FALSE, TRUE, 55000),              -- Partida 3 -- Escola 1
    (UUID(), @partidaIdTres,  @jogadorIdUm, NULL, FALSE, TRUE, 55000),                -- Partida 3 -- Escola 1
    (UUID(), @partidaIdTres,  @jogadorIdUm, @jogadorIdDois, TRUE, FALSE, 70000),      -- Partida 3 -- Escola 1 -- Anulado
    (UUID(), @partidaIdTres,  @jogadorIdUm, NULL, TRUE, FALSE, 70000),                -- Partida 3 -- Escola 1 -- Anulado
    (UUID(), @partidaIdTres,  @jogadorIdSete, @jogadorIdOito, FALSE, FALSE, 70000),   -- Partida 3 -- Escola 4
    (UUID(), @partidaIdTres,  @jogadorIdSete, @jogadorIdOito, FALSE, FALSE, 70000),   -- Partida 3 -- Escola 4
    (UUID(), @partidaIdQuatro, @jogadorIdTres, NULL, FALSE, FALSE, 30000),            -- Partida 4 -- Escola 2
    (UUID(), @partidaIdQuatro, @jogadorIdTres, NULL, FALSE, FALSE, 37000),            -- Partida 4 -- Escola 2
    (UUID(), @partidaIdQuatro, @jogadorIdSeis, @jogadorIdCinco, FALSE, FALSE, 48000), -- Partida 4 -- Escola 3
    (UUID(), @partidaIdQuatro, @jogadorIdSeis, NULL, FALSE, FALSE, 42000), -- Partida 4 -- Escola 3
    (UUID(), @partidaIdCinco, @jogadorIdTres,  null, FALSE, FALSE, 62000),            -- Partida 5 -- Escola 2
    (UUID(), @partidaIdCinco, @jogadorIdQuatro, NULL, FALSE, TRUE, 67000),            -- Partida 5 -- Escola 2
    (UUID(), @partidaIdCinco, @jogadorIdQuatro, NULL, TRUE, TRUE, 67000),             -- Partida 5 -- Escola 2  -- Anulado
    (UUID(), @partidaIdCinco, @jogadorIdQuatro, NULL, TRUE, TRUE, 67000),             -- Partida 5 -- Escola 2  -- Anulado
    (UUID(), @partidaIdCinco, @jogadorIdQuatro, NULL, TRUE, TRUE, 67000),             -- Partida 5 -- Escola 2  -- Anulado
    (UUID(), @partidaIdSeis, @jogadorIdSete, @jogadorIdOito, FALSE, FALSE, 54000),    -- Partida 6 -- Escola 4
    (UUID(), @partidaIdSeis, @jogadorIdSete, @jogadorIdOito, FALSE, FALSE, 54000),    -- Partida 6 -- Escola 4
    (UUID(), @partidaIdSeis, @jogadorIdCinco, NULL, FALSE, FALSE, 38000),             -- Partida 6 -- Escola 3
    (UUID(), @partidaIdSeis, @jogadorIdCinco, NULL, TRUE, FALSE, 38000),             -- Partida 6 -- Escola 3 -- Anulado
    (UUID(), @partidaIdSete, @jogadorIdUm, @jogadorIdDois, FALSE, FALSE, 38000),      -- Partida 7 -- Escola 1
    (UUID(), @partidaIdSete, @jogadorIdUm, NULL, TRUE, FALSE, 38000),                 -- Partida 7 -- Escola 1 -- Anulado
    (UUID(), @partidaIdOito, @jogadorIdCinco, @jogadorIdSeis, FALSE, FALSE, 38000),   -- Partida 8 -- Escola 3
    (UUID(), @partidaIdOito, @jogadorIdCinco, @jogadorIdSeis, TRUE, FALSE, 38000),    -- Partida 8 -- Escola 3 -- Anulado
    (UUID(), @partidaIdOito, @jogadorIdSeis, @jogadorIdCinco, FALSE, FALSE, 38000),   -- Partida 8 -- Escola 3
    (UUID(), @partidaIdNove, @jogadorIdUm, NULL, FALSE, FALSE, 38000),                -- Partida 9 -- Escola 1
    (UUID(), @partidaIdNove, @jogadorIdUm, NULL, TRUE, FALSE, 38000),                -- Partida 9 -- Escola 1 -- Anulado
    (UUID(), @partidaIdDez, @jogadorIdSete, @jogadorIdOito, FALSE, FALSE, 38000),     -- Partida 10 -- Escola 4
    (UUID(), @partidaIdDez, @jogadorIdSete, NULL, FALSE, FALSE, 38000),               -- Partida 10 -- Escola 4
    (UUID(), @partidaIdDez, @jogadorIdSete, NULL, TRUE, FALSE, 38000),               -- Partida 10 -- Escola 4 -- Anulado
    (UUID(), @partidaIdOnze, @jogadorIdTres, NULL, FALSE, FALSE, 38000),              -- Partida 11 -- Escola 2
    (UUID(), @partidaIdOnze, @jogadorIdTres, NULL, FALSE, FALSE, 38000);              -- Partida 11 -- Escola 2



INSERT INTO TBParticipacaoCampeonato (id, idCampeonato, idEscola, status, administrador)
VALUES
    (UUID(), @campeonatoIdUm, @escolaIdUm, 0, FALSE),
    (UUID(), @campeonatoIdUm, @escolaIdDois, 0, TRUE),
    (UUID(), @campeonatoIdUm, @escolaIdTres, 1, FALSE);

INSERT INTO TBFalta (id, idPartida, idJogadorSofreu, idJogadorCometeu, tempoPartidaMilissegundos)
VALUES
    (UUID(), @partidaIdUm, @jogadorIdUm, @jogadorIdDois, 60000),
    (UUID(), @partidaIdDois, @jogadorIdDois, @jogadorIdUm, 62000),
    (UUID(), @partidaIdTres, @jogadorIdTres, @jogadorIdCinco, 57000),
    (UUID(), @partidaIdQuatro, @jogadorIdQuatro, @jogadorIdTres, 69000),
    (UUID(), @partidaIdCinco, @jogadorIdCinco, @jogadorIdQuatro, 63000),
    (UUID(), @partidaIdSeis, @jogadorIdDois, @jogadorIdTres, 72000),
    (UUID(), @partidaIdSeis, @jogadorIdUm, @jogadorIdTres, 6500),
    (UUID(), @partidaIdDois, @jogadorIdUm, @jogadorIdDois, 61000),
    (UUID(), @partidaIdUm, @jogadorIdTres, @jogadorIdQuatro, 64000);

-- Finalizado INSERS

-- Selects

-- 1.	Quantos partidas tiveram mais de x (2) quantidade de gols válidos;
USE LEC;
SELECT COUNT(*) as partidasComMaisDe2Gols
FROM (SELECT COUNT(*) as gols FROM TBGol
      WHERE anulado = FALSE
      GROUP BY idPartida) as golsPorPartida
WHERE golsPorPartida.gols > 2;

-- 2.	Top 3 equipes com mais vitórias;
USE LEC;
SELECT e.nome, ganhadores.qtdVitorias FROM TBEscola e
                                               JOIN (SELECT COUNT(*) as qtdVitorias,
                                                            CASE
                                                                WHEN golsMandantes > golsVisitantes THEN p.idMandante
                                                                WHEN golsVisitantes > golsMandantes THEN p.idVisitante
                                                                ELSE NULL
                                                                END as idVencedor
                                                     FROM TBPartida p
                                                              JOIN (SELECT p.id, IFNULL(golsVisitantes.gols, 0) as golsVisitantes, IFNULL(golsMandantes.gols, 0) as golsMandantes
                                                                    FROM TBPartida p
                                                                             LEFT JOIN (SELECT p.id, COUNT(g.id) as gols FROM TBGol g
                                                                                                                                  JOIN TBJogador j ON g.idJogadorMarcou = j.id
                                                                                                                                  RIGHT JOIN TBPartida p ON g.idPartida = p.id
                                                                                        WHERE g.anulado IS NULL OR g.anulado = FALSE
                                                                                            AND p.idMandante = j.idEscola
                                                                                        GROUP BY p.id, p.idMandante) golsMandantes ON golsMandantes.id = p.id
                                                                             LEFT JOIN (SELECT p.id, COUNT(g.id) as gols FROM TBGol g
                                                                                                                                  JOIN TBJogador j ON g.idJogadorMarcou = j.id
                                                                                                                                  RIGHT JOIN TBPartida p ON g.idPartida = p.id
                                                                                        WHERE g.anulado IS NULL OR g.anulado = FALSE
                                                                                            AND p.idVisitante = j.idEscola
                                                                                        GROUP BY p.id, p.idVisitante) golsVisitantes ON golsVisitantes.id = p.id) as golsPartida
                                                                   ON golsPartida.id = p.id
                                                     GROUP BY idVencedor) ganhadores on ganhadores.idVencedor = e.id
ORDER BY ganhadores.qtdVitorias DESC LIMIT 3;

-- 3.	Top 3 equipes com mais derrotas;
USE LEC;
SELECT e.nome, perdedores.qtdDerrotas FROM TBEscola e
                                               JOIN (SELECT COUNT(*) as qtdDerrotas,
                                                            CASE
                                                                WHEN golsMandantes > golsVisitantes THEN p.idVisitante
                                                                WHEN golsVisitantes > golsMandantes THEN p.idMandante
                                                                ELSE NULL
                                                                END as idPerdedor
                                                     FROM TBPartida p
                                                              JOIN (SELECT p.id, IFNULL(golsVisitantes.gols, 0) as golsVisitantes, IFNULL(golsMandantes.gols, 0) as golsMandantes
                                                                    FROM TBPartida p
                                                                             LEFT JOIN (SELECT p.id, COUNT(g.id) as gols FROM TBGol g
                                                                                                                                  JOIN TBJogador j ON g.idJogadorMarcou = j.id
                                                                                                                                  RIGHT JOIN TBPartida p ON g.idPartida = p.id
                                                                                        WHERE g.anulado IS NULL OR g.anulado = FALSE
                                                                                            AND p.idMandante = j.idEscola
                                                                                        GROUP BY p.id, p.idMandante) golsMandantes ON golsMandantes.id = p.id
                                                                             LEFT JOIN (SELECT p.id, COUNT(g.id) as gols FROM TBGol g
                                                                                                                                  JOIN TBJogador j ON g.idJogadorMarcou = j.id
                                                                                                                                  RIGHT JOIN TBPartida p ON g.idPartida = p.id
                                                                                        WHERE g.anulado IS NULL OR g.anulado = FALSE
                                                                                            AND p.idVisitante = j.idEscola
                                                                                        GROUP BY p.id, p.idVisitante) golsVisitantes ON golsVisitantes.id = p.id) as golsPartida
                                                                   ON golsPartida.id = p.id
                                                     GROUP BY idPerdedor) perdedores on perdedores.idPerdedor = e.id
ORDER BY perdedores.qtdDerrotas DESC LIMIT 3;

-- 4.	Top 3 jogadores com mais assistências
USE LEC;
SELECT j.nomeJogo, COUNT(*) as assistencias FROM TBGol g
                                                     JOIN TBJogador j ON j.id = g.idJogadorAssistencia
WHERE g.anulado = FALSE
GROUP BY g.idJogadorAssistencia
ORDER BY assistencias DESC LIMIT 3;

-- 5.	Top 3 jogadores com mais gols válidos;
USE LEC;
SELECT j.nomeJogo, COUNT(*) as golsValidos FROM TBGol g
                                                    JOIN TBJogador j ON j.id = g.idJogadorMarcou
WHERE g.anulado = FALSE
GROUP BY g.idJogadorMarcou
ORDER BY golsValidos DESC LIMIT 3;

-- 6.	Top 3 jogadores com mais gols inválidos;
USE LEC;
SELECT j.nomeJogo, COUNT(*) as golsAnulados FROM TBGol g
                                                     JOIN TBJogador j ON j.id = g.idJogadorMarcou
WHERE g.anulado = TRUE
GROUP BY g.idJogadorMarcou
ORDER BY golsAnulados DESC LIMIT 3;

-- 7.	Time que levou mais gols no campeonato;
USE LEC;
SELECT e.nome, e.id, (golsMandanteTomou.totalGols + golsVisitanteTomou.totalGols) as totalGols FROM TBEscola e
                                                                                                        JOIN (SELECT golsVisitantesTomou.idVisitante, SUM(golsVisitantesTomou.gols) as totalGols FROM (SELECT p.id, p.idVisitante, COUNT(g.id) as gols FROM TBGol g
                                                                                                                                                                                                                                                                JOIN TBJogador j ON g.idJogadorMarcou = j.id
                                                                                                                                                                                                                                                                RIGHT JOIN TBPartida p ON g.idPartida = p.id
                                                                                                                                                                                                       WHERE g.anulado IS NULL OR g.anulado = FALSE
                                                                                                                                                                                                           AND p.idMandante = j.idEscola
                                                                                                                                                                                                       GROUP BY p.id, p.idMandante) as golsVisitantesTomou
                                                                                                              GROUP BY golsVisitantesTomou.idVisitante) as golsVisitanteTomou on golsVisitanteTomou.idVisitante = e.id
                                                                                                        JOIN (SELECT golsMandanteTomou.idMandante, SUM(golsMandanteTomou.gols) as totalGols FROM (SELECT p.id, p.idMandante, COUNT(g.id) as gols FROM TBGol g
                                                                                                                                                                                                                                                          JOIN TBJogador j ON g.idJogadorMarcou = j.id
                                                                                                                                                                                                                                                          RIGHT JOIN TBPartida p ON g.idPartida = p.id
                                                                                                                                                                                                  WHERE g.anulado IS NULL OR g.anulado = FALSE
                                                                                                                                                                                                      AND p.idMandante = j.idEscola
                                                                                                                                                                                                  GROUP BY p.id, p.idMandante) as golsMandanteTomou
                                                                                                              GROUP BY golsMandanteTomou.idMandante) as golsMandanteTomou on golsMandanteTomou.idMandante = e.id
ORDER BY totalGols DESC LIMIT 1;

-- 8.	Partida com mais gols válidos;
USE LEC;
SELECT eM.Nome as escolaMandante, eV.Nome as escolaVisitante, p.data, COUNT(*) totalGols FROM TBGol g
                                                                                                  JOIN TBPartida p ON p.id = g.idPartida
                                                                                                  JOIN TBEscola eM ON eM.id = p.idMandante
                                                                                                  JOIN TBEscola eV ON eV.id = p.idVisitante
WHERE g.anulado = FALSE
GROUP BY g.idPartida
ORDER BY totalGols DESC LIMIT 1;

-- 9.	Escola que mais empatou;
USE LEC;
SELECT e.Nome, (IFNULL(empatesMandantes.quantidadeEmpatada, 0) + IFNULL(empatesVisitante.quantidadeEmpatada, 0)) as QuantidadeEmpatada
FROM TBEscola e
         LEFT JOIN (SELECT p.idMandante, COUNT(*) quantidadeEmpatada FROM TBPartida p
                                                                              JOIN (SELECT p.id
                                                                                    FROM TBPartida p
                                                                                             JOIN (SELECT p.id, IFNULL(golsVisitantes.gols, 0) as golsVisitantes, IFNULL(golsMandantes.gols, 0) as golsMandantes
                                                                                                   FROM TBPartida p
                                                                                                            LEFT JOIN (SELECT p.id, COUNT(g.id) as gols FROM TBGol g
                                                                                                                                                                 JOIN TBJogador j ON g.idJogadorMarcou = j.id
                                                                                                                                                                 RIGHT JOIN TBPartida p ON g.idPartida = p.id
                                                                                                                       WHERE g.anulado IS NULL OR g.anulado = FALSE
                                                                                                                           AND p.idMandante = j.idEscola
                                                                                                                       GROUP BY p.id, p.idMandante) golsMandantes ON golsMandantes.id = p.id
                                                                                                            LEFT JOIN (SELECT p.id, COUNT(g.id) as gols FROM TBGol g
                                                                                                                                                                 JOIN TBJogador j ON g.idJogadorMarcou = j.id
                                                                                                                                                                 RIGHT JOIN TBPartida p ON g.idPartida = p.id
                                                                                                                       WHERE g.anulado IS NULL OR g.anulado = FALSE
                                                                                                                           AND p.idVisitante = j.idEscola
                                                                                                                       GROUP BY p.id, p.idVisitante) golsVisitantes ON golsVisitantes.id = p.id) as golsPartida
                                                                                                  ON golsPartida.id = p.id
                                                                                    WHERE golsMandantes = golsVisitantes) partidasEmpatadas ON partidasEmpatadas.id = p.id
                    GROUP BY p.idMandante) as empatesMandantes ON empatesMandantes.idMandante = e.id
         LEFT JOIN (SELECT p.idVisitante, COUNT(*) quantidadeEmpatada FROM TBPartida p
                                                                               JOIN (SELECT p.id
                                                                                     FROM TBPartida p
                                                                                              JOIN (SELECT p.id, IFNULL(golsVisitantes.gols, 0) as golsVisitantes, IFNULL(golsMandantes.gols, 0) as golsMandantes
                                                                                                    FROM TBPartida p
                                                                                                             LEFT JOIN (SELECT p.id, COUNT(g.id) as gols FROM TBGol g
                                                                                                                                                                  JOIN TBJogador j ON g.idJogadorMarcou = j.id
                                                                                                                                                                  RIGHT JOIN TBPartida p ON g.idPartida = p.id
                                                                                                                        WHERE g.anulado IS NULL OR g.anulado = FALSE
                                                                                                                            AND p.idMandante = j.idEscola
                                                                                                                        GROUP BY p.id, p.idMandante) golsMandantes ON golsMandantes.id = p.id
                                                                                                             LEFT JOIN (SELECT p.id, COUNT(g.id) as gols FROM TBGol g
                                                                                                                                                                  JOIN TBJogador j ON g.idJogadorMarcou = j.id
                                                                                                                                                                  RIGHT JOIN TBPartida p ON g.idPartida = p.id
                                                                                                                        WHERE g.anulado IS NULL OR g.anulado = FALSE
                                                                                                                            AND p.idVisitante = j.idEscola
                                                                                                                        GROUP BY p.id, p.idVisitante) golsVisitantes ON golsVisitantes.id = p.id) as golsPartida
                                                                                                   ON golsPartida.id = p.id
                                                                                     WHERE golsMandantes = golsVisitantes) partidasEmpatadas ON partidasEmpatadas.id = p.id
                    GROUP BY p.idVisitante) as empatesVisitante ON empatesVisitante.idVisitante = e.Id
ORDER BY QuantidadeEmpatada DESC LIMIT 1;

-- 10.	Nome de todos os campeonatos;
USE LEC;
SELECT c.nome FROM TBCampeonato c;


-- 11.	Todas as partidas com mais de x (2) gols;
USE LEC;
SELECT eM.nome as NomeMandante, eV.nome as NomeVisitante, p.data, partidasComMaisDe2Gols.golsTotais
FROM (
         SELECT g.idPartida, COUNT(*) as golsTotais
         FROM TBGol g
         WHERE g.anulado = FALSE
         GROUP BY g.idPartida
         HAVING golsTotais > 2
     ) AS partidasComMaisDe2Gols
         JOIN TBPartida p ON p.id = partidasComMaisDe2Gols.idPartida
         JOIN TBEscola eM ON eM.id = p.idMandante
         JOIN TBEscola eV ON eV.id = p.idVisitante;

-- 12.	Jogador com mais faltas feitas;
USE LEC;
SELECT j.nomeJogo, f.idJogadorCometeu, COUNT(*) as totalFaltasFeitas FROM TBFalta f
                                                                              JOIN TBJogador j ON j.id = f.idJogadorCometeu
GROUP BY f.idJogadorCometeu
ORDER BY totalFaltasFeitas DESC LIMIT 1;

-- 13.	Empates de equipes específicas
SELECT p.id as idPartidade, p.data, e.id as idEscola, e.nome, partidasGols.golsMandantes, partidasGols.golsVisitantes
FROM TBPartida p
         JOIN (SELECT e.id, e.nome FROM TBEscola e
               WHERE e.nome LIKE '%ESCOLA D%') e ON e.id = p.idMandante OR e.id = p.idVisitante
         JOIN (SELECT p.id, IFNULL(golsVisitantes.gols, 0) as golsVisitantes, IFNULL(golsMandantes.gols, 0) as golsMandantes
               FROM TBPartida p
                        LEFT JOIN (SELECT p.id, COUNT(g.id) as gols FROM TBGol g
                                                                             JOIN TBJogador j ON g.idJogadorMarcou = j.id
                                                                             RIGHT JOIN TBPartida p ON g.idPartida = p.id
                                   WHERE g.anulado IS NULL OR g.anulado = FALSE
                                       AND p.idMandante = j.idEscola
                                   GROUP BY p.id, p.idMandante) golsMandantes ON golsMandantes.id = p.id
                        LEFT JOIN (SELECT p.id, COUNT(g.id) as gols FROM TBGol g
                                                                             JOIN TBJogador j ON g.idJogadorMarcou = j.id
                                                                             RIGHT JOIN TBPartida p ON g.idPartida = p.id
                                   WHERE g.anulado IS NULL OR g.anulado = FALSE
                                       AND p.idVisitante = j.idEscola
                                   GROUP BY p.id, p.idVisitante) golsVisitantes ON golsVisitantes.id = p.id
               WHERE IFNULL(golsVisitantes.gols, 0) = IFNULL(golsMandantes.gols, 0)) as partidasGols ON partidasGols.id = p.id;

-- 14.	Vitórias de equipes específicas;
USE LEC;
SELECT p.id as idPartida, e.id as idEscola, e.nome as nomeEscola FROM TBPartida p
                                                                          JOIN (SELECT e.id, e.nome FROM TBEscola e
                                                                                WHERE e.nome LIKE '%ESCOLA D%') as e ON e.id = p.idMandante OR e.id = p.idVisitante
                                                                          JOIN (SELECT p.id,
                                                                                       CASE
                                                                                           WHEN golsMandantes > golsVisitantes THEN p.idMandante
                                                                                           WHEN golsVisitantes > golsMandantes THEN p.idVisitante
                                                                                           ELSE NULL
                                                                                           END as idVencedor
                                                                                FROM TBPartida p
                                                                                         JOIN (SELECT p.id, IFNULL(golsVisitantes.gols, 0) as golsVisitantes, IFNULL(golsMandantes.gols, 0) as golsMandantes
                                                                                               FROM TBPartida p
                                                                                                        LEFT JOIN (SELECT p.id, COUNT(g.id) as gols FROM TBGol g
                                                                                                                                                             JOIN TBJogador j ON g.idJogadorMarcou = j.id
                                                                                                                                                             RIGHT JOIN TBPartida p ON g.idPartida = p.id
                                                                                                                   WHERE g.anulado IS NULL OR g.anulado = FALSE
                                                                                                                       AND p.idMandante = j.idEscola
                                                                                                                   GROUP BY p.id, p.idMandante) golsMandantes ON golsMandantes.id = p.id
                                                                                                        LEFT JOIN (SELECT p.id, COUNT(g.id) as gols FROM TBGol g
                                                                                                                                                             JOIN TBJogador j ON g.idJogadorMarcou = j.id
                                                                                                                                                             RIGHT JOIN TBPartida p ON g.idPartida = p.id
                                                                                                                   WHERE g.anulado IS NULL OR g.anulado = FALSE
                                                                                                                       AND p.idVisitante = j.idEscola
                                                                                                                   GROUP BY p.id, p.idVisitante) golsVisitantes ON golsVisitantes.id = p.id) as golsPartida
                                                                                              ON golsPartida.id = p.id) vencedoresPartidas ON vencedoresPartidas.id = p.id
WHERE vencedoresPartidas.idVencedor = e.id;


-- 15.	Derrotas de equipes específicas;
USE LEC;
SELECT p.id as idPartida, e.id as idEscola, e.nome as nomeEscola FROM TBPartida p
                                                                          JOIN (SELECT e.id, e.nome FROM TBEscola e
                                                                                WHERE e.nome LIKE '%ESCOLA D%') as e ON e.id = p.idMandante OR e.id = p.idVisitante
                                                                          JOIN (SELECT p.id,
                                                                                       CASE
                                                                                           WHEN golsMandantes > golsVisitantes THEN p.idVisitante
                                                                                           WHEN golsVisitantes > golsMandantes THEN p.idMandante
                                                                                           ELSE NULL
                                                                                           END as idPerdedor
                                                                                FROM TBPartida p
                                                                                         JOIN (SELECT p.id, IFNULL(golsVisitantes.gols, 0) as golsVisitantes, IFNULL(golsMandantes.gols, 0) as golsMandantes
                                                                                               FROM TBPartida p
                                                                                                        LEFT JOIN (SELECT p.id, COUNT(g.id) as gols FROM TBGol g
                                                                                                                                                             JOIN TBJogador j ON g.idJogadorMarcou = j.id
                                                                                                                                                             RIGHT JOIN TBPartida p ON g.idPartida = p.id
                                                                                                                   WHERE g.anulado IS NULL OR g.anulado = FALSE
                                                                                                                       AND p.idMandante = j.idEscola
                                                                                                                   GROUP BY p.id, p.idMandante) golsMandantes ON golsMandantes.id = p.id
                                                                                                        LEFT JOIN (SELECT p.id, COUNT(g.id) as gols FROM TBGol g
                                                                                                                                                             JOIN TBJogador j ON g.idJogadorMarcou = j.id
                                                                                                                                                             RIGHT JOIN TBPartida p ON g.idPartida = p.id
                                                                                                                   WHERE g.anulado IS NULL OR g.anulado = FALSE
                                                                                                                       AND p.idVisitante = j.idEscola
                                                                                                                   GROUP BY p.id, p.idVisitante) golsVisitantes ON golsVisitantes.id = p.id) as golsPartida
                                                                                              ON golsPartida.id = p.id) perdedoresPartidas ON perdedoresPartidas.id = p.id
WHERE perdedoresPartidas.idPerdedor = e.id;


-- 16.	Consultar quais as organizações apoiadoras de um campeonato;
USE LEC;
SELECT p.id, p.nome FROM TBCampeonatoPatrocinador cp
                             JOIN (SELECT * FROM TBCampeonato c
                                   WHERE c.nome LIKE '%Campeonato A%') as campeonato ON campeonato.id = cp.idCampeonato
                             JOIN TBPatrocinador p ON p.id = cp.idPatrocinador;

-- 17.	Consultar quais as organizações apoiadoras de uma escola
USE LEC;
SELECT p.id, p.nome FROM TBEscolaPatrocinador ep
                             JOIN (SELECT e.id, e.nome FROM TBEscola e
                                   WHERE e.nome LIKE '%ESCOLA A%') as escola ON escola.id = ep.idEscola
                             JOIN TBPatrocinador p ON p.id = ep.idPatrocinador;

-- 18.	Quantidade total de partidas de uma equipe;
USE LEC;
SELECT COUNT(*) FROM TBPartida p
                         JOIN (SELECT e.id, e.nome FROM TBEscola e
                               WHERE e.nome LIKE '%ESCOLA B%') as e ON e.id = p.idMandante OR e.id = p.idVisitante
GROUP BY e.id;

-- 19.	Jogadores com mais faltas sofridas;
USE LEC;
SELECT j.nomeJogo, f.idJogadorSofreu, COUNT(*) as totalFaltasSofridas FROM TBFalta f
                                                                               JOIN TBJogador j ON j.id = f.idJogadorSofreu
GROUP BY f.idJogadorSofreu
ORDER BY totalFaltasSofridas DESC LIMIT 1;

-- 20.	Jogador com mais gols válidos de uma escola;
USE LEC;
SELECT j.nomeJogo as nomeJogador, j.id as idJogador, e.nome as nomeEscola, COUNT(*) as totalGols FROM TBEscola e
                                                                                                          JOIN TBJogador as j ON j.idEscola = e.id
                                                                                                          JOIN TBGol as g ON g.idJogadorMarcou = j.id
WHERE e.nome LIKE '%ESCOLA C%' AND g.anulado = FALSE
GROUP BY j.id
ORDER BY totalGols DESC LIMIT 1;

-- 21.	Jogadores que não marcaram gols (diferença entre conjuntos oriundos);
USE LEC;
SELECT j.id, j.nome, j.idEscola FROM TBJogador j
WHERE j.id NOT IN (SELECT DISTINCT g.idJogadorMarcou as id FROM TBGol g
                   WHERE g.anulado = FALSE);

-- 22.	Quantas partidas terminaram em empate (acesso a três tabelas).
USE LEC;
SELECT COUNT(*) as totalPartidasEmpatadas FROM (SELECT p.id,
                                                       CASE
                                                           WHEN golsMandantes > golsVisitantes THEN p.idMandante
                                                           WHEN golsVisitantes > golsMandantes THEN p.idVisitante
                                                           ELSE NULL
                                                           END as idVencedor
                                                FROM TBPartida p
                                                         JOIN (SELECT p.id, IFNULL(golsVisitantes.gols, 0) as golsVisitantes, IFNULL(golsMandantes.gols, 0) as golsMandantes
                                                               FROM TBPartida p
                                                                        LEFT JOIN (SELECT p.id, COUNT(g.id) as gols FROM TBGol g
                                                                                                                             JOIN TBJogador j ON g.idJogadorMarcou = j.id
                                                                                                                             RIGHT JOIN TBPartida p ON g.idPartida = p.id
                                                                                   WHERE g.anulado IS NULL OR g.anulado = FALSE
                                                                                       AND p.idMandante = j.idEscola
                                                                                   GROUP BY p.id, p.idMandante) golsMandantes ON golsMandantes.id = p.id
                                                                        LEFT JOIN (SELECT p.id, COUNT(g.id) as gols FROM TBGol g
                                                                                                                             JOIN TBJogador j ON g.idJogadorMarcou = j.id
                                                                                                                             RIGHT JOIN TBPartida p ON g.idPartida = p.id
                                                                                   WHERE g.anulado IS NULL OR g.anulado = FALSE
                                                                                       AND p.idVisitante = j.idEscola
                                                                                   GROUP BY p.id, p.idVisitante) golsVisitantes ON golsVisitantes.id = p.id) as golsPartida
                                                              ON golsPartida.id = p.id) as resultadosPartidas
WHERE resultadosPartidas.idVencedor IS NULL;
