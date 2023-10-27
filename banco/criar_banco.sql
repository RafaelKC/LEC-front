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
    UNIQUE (id),
    descricao VARCHAR(50) NOT NULL
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
    FOREIGN KEY (idEndereco)
        REFERENCES TBEndereco (id)
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
    FOREIGN KEY (idEndereco)
        REFERENCES TBEndereco (id)
);

-- N x N TbEscola and TBPatrocinador
CREATE TABLE IF NOT EXISTS TBEscolaPatrocinador (
    idEscola VARCHAR(36),
    idPatrocinador VARCHAR(36),
    FOREIGN KEY (idEscola)
        REFERENCES TBEscola (id),
    FOREIGN KEY (idPatrocinador)
        REFERENCES TBPatrocinador (id),
    PRIMARY KEY (idEscola , idPatrocinador)
);

CREATE TABLE IF NOT EXISTS TBCampeonato (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    Nome VARCHAR(150) NOT NULL,
    NumeroEquipes INT NOT NULL,
    UNIQUE (id)
);

-- N x N TbCampeonato and TBPatrocinador
CREATE TABLE IF NOT EXISTS TBCampeonatoPatrocinador (
    idCampeonato VARCHAR(36) NOT NULL,
    idPatrocinador VARCHAR(36) NOT NULL,
    FOREIGN KEY (idCampeonato)
        REFERENCES TBCampeonato (id),
    FOREIGN KEY (idPatrocinador)
        REFERENCES TBPatrocinador (id),
    PRIMARY KEY (idCampeonato , idPatrocinador)
);

CREATE TABLE IF NOT EXISTS TBJogador (
    id VARCHAR(36) PRIMARY KEY,
    idEscola VARCHAR(36) NOT NULL,
    idSexo VARCHAR(36) NOT NULL,
    cpf CHAR(11) NOT NULL,
    nome VARCHAR(150),
    numeroCamisa INT NOT NULL,
    dataNascimento DATE NOT NULL,
    nomeJogo VARCHAR(30) NOT NULL,
    FOREIGN KEY (idEscola)
        REFERENCES TBEscola (id),
    FOREIGN KEY (idSexo)
        REFERENCES TBSexo (id),
    UNIQUE (id)
);

CREATE TABLE IF NOT EXISTS TBTemporada (
    id VARCHAR(36) PRIMARY KEY,
    idCampeonato VARCHAR(36) NOT NULL,
    dataInicio DATE NOT NULL,
    dataFim DATE NOT NULL,
    UNIQUE (id),
    FOREIGN KEY (idCampeonato)
        REFERENCES TBCampeonato (id)
);

CREATE TABLE IF NOT EXISTS TBPartida (
    id VARCHAR(36) PRIMARY KEY,
    dataHora DATETIME NOT NULL,
    duracaoMilessegundos INT NOT NULL,
    mandanteId VARCHAR(36) NOT NULL,
    visitanteId VARCHAR(36) NOT NULL,
    idTemporada VARCHAR(36) NOT NULL,
    UNIQUE (id),
    FOREIGN KEY (idTemporada)
        REFERENCES TBTemporada (id),
    FOREIGN KEY (mandanteId)
        REFERENCES TBEscola (id),
    FOREIGN KEY (visitanteId)
        REFERENCES TBEscola (id)
);

CREATE TABLE IF NOT EXISTS TBGol (
    id VARCHAR(36) PRIMARY KEY,
    idPartida VARCHAR(36) NOT NULL,
    idJogadorMarcou VARCHAR(36) NOT NULL,
    idJogadorAssistencia VARCHAR(36) NULL,
    anulado BOOL NOT NULL,
    pnalti BOOL NOT NULL,
    contra BOOL NOT NULL,
    tempoEmMilissegundos INT NOT NULL,
    UNIQUE (id),
    FOREIGN KEY (idJogadorMarcou)
        REFERENCES TBJogador (id),
    FOREIGN KEY (idJogadorAssistencia)
        REFERENCES TBJogador (id),
    FOREIGN KEY (idPartida)
        REFERENCES TBPartida (id)
);

CREATE TABLE IF NOT EXISTS TBParticipacaoCampeonato (
    id VARCHAR(36) PRIMARY KEY,
    idCampeonato VARCHAR(36) NOT NULL,
    idEscola VARCHAR(36) NOT NULL,
    status INT NOT NULL,
    administrador BOOL NOT NULL,
    UNIQUE (id),
    FOREIGN KEY (idCampeonato)
        REFERENCES TBCampeonato (id),
    FOREIGN KEY (idEscola)
        REFERENCES TBEscola (id)
);

CREATE TABLE IF NOT EXISTS TBRemocao (
    sequencia INT,
    idParticipacao VARCHAR(36),
    tipo INT NOT NULL,
    aplicado BOOL NOT NULL,
    FOREIGN KEY (idParticipacao)
        REFERENCES TBParticipacaoCampeonato (id),
    PRIMARY KEY (idParticipacao , sequencia)
);

CREATE TABLE IF NOT EXISTS TBVoto (
    sequencia INT,
    idParticipacao VARCHAR(36),
    idParticipanteVotador VARCHAR(36),
    FOREIGN KEY (idParticipacao, sequencia)
        REFERENCES TBRemocao(idParticipacao , sequencia),
	FOREIGN KEY (idParticipanteVotador)
        REFERENCES TBParticipacaoCampeonato(id),
    PRIMARY KEY (idParticipacao , sequencia , idParticipanteVotador)
);

CREATE TABLE IF NOT EXISTS TBFalta (
    id VARCHAR(36) PRIMARY KEY,
    idPartida VARCHAR(36) NOT NULL,
    idJogadorSofreu VARCHAR(36) NOT NULL,
    idJogadorCometeu VARCHAR(36) NOT NULL,
    tempoPartidaMilissegundos INT NOT NULL,
    UNIQUE (id),
    FOREIGN KEY (idPartida)
        REFERENCES TBPartida (id),
    FOREIGN KEY (idJogadorSofreu)
        REFERENCES TBJogador (id),
    FOREIGN KEY (idJogadorCometeu)
        REFERENCES TBJogador (id)
);


SET @enderocoIdUm = UUID();
SET @enderocoIdDois = UUID();
SET @enderocoIdTres = UUID();
SET @enderocoIdQuatro = UUID();
SET @enderocoIdCinco = UUID();
SET @enderocoIdSeis = UUID();
SET @enderocoIdSete = UUID();
SET @enderocoIdOito = UUID();
SET @enderocoIdNove = UUID();
SET @enderocoIdDez = UUID();

-- Inserir dados na tabela TBEndereco
INSERT INTO TBEndereco (id, cep, logradouro, bairro, cidade, uf)
VALUES
    (@enderocoIdUm, '12345678', 'Rua A', 'Bairro A', 'Cidade A', 'PR'),
    (@enderocoIdDois, '23456789', 'Rua B', 'Bairro B', 'Cidade B', 'PR'),
    (@enderocoIdTres, '34567890', 'Rua C', 'Bairro C', 'Cidade C', 'PR'),
    (@enderocoIdQuatro, '45678901', 'Rua D', 'Bairro D', 'Cidade D', 'PR'),
    (@enderocoIdCinco, '56789012', 'Rua E', 'Bairro E', 'Cidade E', 'PR'),
    (@enderocoIdSeis, '67890123', 'Rua F', 'Bairro F', 'Cidade F', 'PR'),
    (@enderocoIdSete, '78901234', 'Rua G', 'Bairro G', 'Cidade G', 'PR'),
    (@enderocoIdOito, '89012345', 'Rua H', 'Bairro H', 'Cidade H', 'PR'),
    (@enderocoIdNove, '90123456', 'Rua I', 'Bairro I', 'Cidade I', 'PR'),
    (@enderocoIdDez, '01234567', 'Rua J', 'Bairro J', 'Cidade J', 'PR');


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
SET @escolaIdCinco = UUID();
SET @escolaIdSeis = UUID();
SET @escolaIdSete = UUID();
SET @escolaIdOito = UUID();
SET @escolaIdNove = UUID();
SET @escolaIdDez = UUID();

-- Inserir dados na tabela TBEscola
INSERT INTO TBEscola (id, nome, cnpj, email, senha, telefoneUm, telefoneDois, idEndereco)
VALUES
    (@escolaIdUm, 'Escola A', '12345678901234', 'escolaA@email.com', 'senha123', '1234567890', '9876543210', @enderocoIdUm),
    (@escolaIdDois, 'Escola B', '23456789012345', 'escolaB@email.com', 'senha456', '9876543210', '1234567890', @enderocoIdDois),
    (@escolaIdTres, 'Escola C', '34567890123456', 'escolaC@email.com', 'senha789', '1234567890', '9876543210', @enderocoIdTres),
    (@escolaIdQuatro, 'Escola D', '45678901234567', 'escolaD@email.com', 'senha012', '1234567890', '9876543210', @enderocoIdQuatro),
    (@escolaIdCinco, 'Escola E', '56789012345678', 'escolaE@email.com', 'senha345', '1234567890', '9876543210', @enderocoIdCinco),
    (@escolaIdSeis, 'Escola F', '67890123456789', 'escolaF@email.com', 'senha678', '1234567890', '9876543210', @enderocoIdSeis),
    (@escolaIdSete, 'Escola G', '78901234567890', 'escolaG@email.com', 'senha901', '1234567890', '9876543210', @enderocoIdSete),
    (@escolaIdOito, 'Escola H', '89012345678901', 'escolaH@email.com', 'senha234', '1234567890', '9876543210', @enderocoIdOito),
    (@escolaIdNove, 'Escola I', '90123456789012', 'escolaI@email.com', 'senha567', '1234567890', '9876543210', @enderocoIdNove),
    (@escolaIdDez, 'Escola J', '01234567890123', 'escolaJ@email.com', 'senha890', '1234567890', '9876543210', @enderocoIdDez);


SET @patrocinadorIdUm = UUID();
SET @patrocinadorIdDois = UUID();
SET @patrocinadorIdTres = UUID();
SET @patrocinadorIdQuatro = UUID();
SET @patrocinadorIdCinco = UUID();

-- Inserir dados na tabela TBPatrocinador
INSERT INTO TBPatrocinador (id, idEndereco, nome, cnpj, cpf, email, senha)
VALUES
    (@patrocinadorIdUm, @enderocoIdUm, 'Patrocinador A', NULL, '12345678901', 'patrocinadorA@email.com', 'senha123'),
    (@patrocinadorIdDois, @enderocoIdSete, 'Patrocinador B', '23456789012345', NULL, 'patrocinadorB@email.com', 'senha456'),
    (@patrocinadorIdTres, @enderocoIdNove, 'Patrocinador C', NULL, '34567890123', 'patrocinadorC@email.com', 'senha789'),
    (@patrocinadorIdQuatro, @enderocoIdOito, 'Patrocinador D', '45678901234567', NULL, 'patrocinadorD@email.com', 'senha012'),
    (@patrocinadorIdCinco, @enderocoIdQuatro, 'Patrocinador E', '56789012345678', NULL, 'patrocinadorE@email.com', 'senha345');


-- Inserir dados na tabela TBEscolaPatrocinador
INSERT INTO TBEscolaPatrocinador (idEscola, idPatrocinador)
VALUES
    (@escolaIdUm, @patrocinadorIdUm),
    (@escolaIdUm, @patrocinadorIdDois),
    (@escolaIdDois, @patrocinadorIdDois),
    (@escolaIdTres, @patrocinadorIdTres),
    (@escolaIdQuatro, @patrocinadorIdQuatro),
    (@escolaIdCinco, @patrocinadorIdCinco),
    (@escolaIdSeis, @patrocinadorIdUm),
    (@escolaIdSete, @patrocinadorIdDois),
    (@escolaIdOito, @patrocinadorIdTres),
    (@escolaIdNove, @patrocinadorIdQuatro),
    (@escolaIdDez, @patrocinadorIdCinco),
    (@escolaIdDois, @patrocinadorIdUm),
    (@escolaIdTres, @patrocinadorIdDois),
    (@escolaIdQuatro, @patrocinadorIdTres),
    (@escolaIdCinco, @patrocinadorIdQuatro);


SET @campeonatoIdUm = UUID();
SET @campeonatoIdDois = UUID();
SET @campeonatoIdTres = UUID();

-- Inserir dados na tabela TBCampeonato
INSERT INTO TBCampeonato (id, Nome, NumeroEquipes)
VALUES
    (@campeonatoIdUm, 'Campeonato A', 10),
    (@campeonatoIdDois, 'Campeonato B', 8),
    (@campeonatoIdTres, 'Campeonato C', 12);

-- Inserir dados na tabela TBCampeonatoPatrocinador
INSERT INTO TBCampeonatoPatrocinador (idCampeonato, idPatrocinador)
VALUES
    (@campeonatoIdUm, @patrocinadorIdUm),
    (@campeonatoIdUm, @patrocinadorIdDois),
    (@campeonatoIdDois, @patrocinadorIdTres),
    (@campeonatoIdDois, @patrocinadorIdQuatro),
    (@campeonatoIdDois, @patrocinadorIdDois),
    (@campeonatoIdTres, @patrocinadorIdUm),
    (@campeonatoIdTres, @patrocinadorIdCinco);

SET @jogadorIdUm = UUID();        SET @jogadorIdVinteUm= UUID();
SET @jogadorIdDois = UUID();      SET @jogadorIdVinteDoi = UUID();
SET @jogadorIdTres = UUID();      SET @jogadorIdVinteTres = UUID(); 
SET @jogadorIdQuatro = UUID();    SET @jogadorIdVinteQuatro = UUID();
SET @jogadorIdCinco = UUID();     SET @jogadorIdVinteCinco = UUID();
SET @jogadorIdSeis= UUID();       SET @jogadorIdVinteSeis = UUID();
SET @jogadorIdSete = UUID();      SET @jogadorIdVinteSete = UUID();
SET @jogadorIdOito= UUID();       SET @jogadorIdVinteOito = UUID();
SET @jogadorIdNove= UUID();       SET @jogadorIdVinteNove = UUID();
SET @jogadorIdDez = UUID();       SET @jogadorIdTrinta = UUID();
SET @jogadorIdOnze = UUID();      SET @jogadorIdTrintaUm = UUID();
SET @jogadorIdDoze = UUID();      SET @jogadorIdTrintaDois = UUID();
SET @jogadorIdTreze = UUID();     SET @jogadorIdTrintaTres = UUID(); 
SET @jogadorIdQuatorze = UUID();  SET @jogadorIdTrintaQuatro = UUID();
SET @jogadorIdQuinze = UUID();    SET @jogadorIdTrintaCinco = UUID();
SET @jogadorIdDezesseis = UUID(); SET @jogadorIdTrintaSeis = UUID();
SET @jogadorIdDezesere = UUID();  SET @jogadorIdTrintaSete = UUID();
SET @jogadorIdDezoito = UUID();   SET @jogadorIdTrintaOito = UUID();
SET @jogadorIdDezenove = UUID();  SET @jogadorIdTrintaNove = UUID();
SET @jogadorIdVinte = UUID();     SET @jogadorIdQuarenta = UUID();

-- Inserir dados na tabela TBJogador com jogadores previamente declarados
INSERT INTO TBJogador (id, idEscola, idSexo, cpf, nome, numeroCamisa, dataNascimento, nomeJogo)
VALUES
	(@jogadorIdUm, @escolaIdUm, @sexoIdUm, '12345678901', 'Jogador 1', 10, '2000-01-01', 'NomeJogo 1'),
    (@jogadorIdDois, @escolaIdDois, @sexoIdDois, '23456789012', 'Jogador 2', 11, '2001-01-01', 'NomeJogo 2'),
    (@jogadorIdTres, @escolaIdTres, @sexoIdTres, '34567890123', 'Jogador 3', 12, '2002-01-01', 'NomeJogo 3'),
    (@jogadorIdQuatro, @escolaIdQuatro, @sexoIdUm, '45678901234', 'Jogador 4', 13, '2003-01-01', 'NomeJogo 4'),
    (@jogadorIdCinco, @escolaIdCinco, @sexoIdDois, '56789012345', 'Jogador 5', 14, '2004-01-01', 'NomeJogo 5'),
    (@jogadorIdSeis, @escolaIdSeis, @sexoIdTres, '67890123456', 'Jogador 6', 15, '2005-01-01', 'NomeJogo 6'),
    (@jogadorIdSete, @escolaIdSete, @sexoIdUm, '78901234567', 'Jogador 7', 16, '2006-01-01', 'NomeJogo 7'),
    (@jogadorIdOito, @escolaIdOito, @sexoIdDois, '89012345678', 'Jogador 8', 17, '2007-01-01', 'NomeJogo 8'),
    (@jogadorIdNove, @escolaIdNove, @sexoIdTres, '90123456789', 'Jogador 9', 18, '2008-01-01', 'NomeJogo 9'),
    (@jogadorIdDez, @escolaIdDez, @sexoIdUm, '01234567890', 'Jogador 10', 19, '2009-01-01', 'NomeJogo 10'),
    (@jogadorIdOnze, @escolaIdUm, @sexoIdDois, '11234567890', 'Jogador 11', 20, '2010-01-01', 'NomeJogo 11'),
    (@jogadorIdDoze, @escolaIdDois, @sexoIdTres, '21234567890', 'Jogador 12', 21, '2011-01-01', 'NomeJogo 12'),
    (@jogadorIdTreze, @escolaIdTres, @sexoIdUm, '31234567890', 'Jogador 13', 22, '2012-01-01', 'NomeJogo 13'),
    (@jogadorIdQuatorze, @escolaIdQuatro, @sexoIdDois, '41234567890', 'Jogador 14', 23, '2013-01-01', 'NomeJogo 14'),
    (@jogadorIdQuinze, @escolaIdCinco, @sexoIdTres, '51234567890', 'Jogador 15', 24, '2014-01-01', 'NomeJogo 15'),
    (@jogadorIdDezesseis, @escolaIdSeis, @sexoIdUm, '61234567890', 'Jogador 16', 25, '2015-01-01', 'NomeJogo 16'),
    (@jogadorIdDezesere, @escolaIdSete, @sexoIdDois, '71234567890', 'Jogador 17', 26, '2016-01-01', 'NomeJogo 17'),
    (@jogadorIdDezoito, @escolaIdOito, @sexoIdTres, '81234567890', 'Jogador 18', 27, '2017-01-01', 'NomeJogo 18'),
    (@jogadorIdDezenove, @escolaIdNove, @sexoIdUm, '91234567890', 'Jogador 19', 28, '2018-01-01', 'NomeJogo 19'),
    (@jogadorIdVinte, @escolaIdDez, @sexoIdDois, '01234567891', 'Jogador 20', 29, '2019-01-01', 'NomeJogo 20'),
    (@jogadorIdVinteUm, @escolaIdUm, @sexoIdTres, '11234567891', 'Jogador 21', 30, '2020-01-01', 'NomeJogo 21'),
    (@jogadorIdVinteDoi, @escolaIdDois, @sexoIdUm, '21234567891', 'Jogador 22', 31, '2021-01-01', 'NomeJogo 22'),
    (@jogadorIdVinteTres, @escolaIdTres, @sexoIdDois, '31234567891', 'Jogador 23', 32, '2022-01-01', 'NomeJogo 23'),
    (@jogadorIdVinteQuatro, @escolaIdQuatro, @sexoIdTres, '41234567891', 'Jogador 24', 33, '2023-01-01', 'NomeJogo 24'),
    (@jogadorIdVinteCinco, @escolaIdCinco, @sexoIdUm, '51234567891', 'Jogador 25', 34, '2024-01-01', 'NomeJogo 25'),
    (@jogadorIdVinteSeis, @escolaIdSeis, @sexoIdDois, '61234567891', 'Jogador 26', 35, '2025-01-01', 'NomeJogo 26'),
    (@jogadorIdVinteSete, @escolaIdSete, @sexoIdTres, '71234567891', 'Jogador 27', 36, '2026-01-01', 'NomeJogo 27'),
    (@jogadorIdVinteOito, @escolaIdOito, @sexoIdUm, '81234567891', 'Jogador 28', 37, '2027-01-01', 'NomeJogo 28'),
    (@jogadorIdVinteNove, @escolaIdNove, @sexoIdDois, '91234567891', 'Jogador 29', 38, '2028-01-01', 'NomeJogo 29'),
    (@jogadorIdTrinta, @escolaIdDez, @sexoIdTres, '01234567892', 'Jogador 30', 39, '2029-01-01', 'NomeJogo 30'),
    (@jogadorIdTrintaUm, @escolaIdUm, @sexoIdUm, '11234567892', 'Jogador 31', 40, '2030-01-01', 'NomeJogo 31'),
    (@jogadorIdTrintaDois, @escolaIdDois, @sexoIdDois, '21234567892', 'Jogador 32', 41, '2031-01-01', 'NomeJogo 32'),
    (@jogadorIdTrintaTres, @escolaIdTres, @sexoIdTres, '31234567892', 'Jogador 33', 42, '2032-01-01', 'NomeJogo 33'),
    (@jogadorIdTrintaQuatro, @escolaIdQuatro, @sexoIdUm, '41234567892', 'Jogador 34', 43, '2033-01-01', 'NomeJogo 34'),
    (@jogadorIdTrintaCinco, @escolaIdCinco, @sexoIdDois, '51234567892', 'Jogador 35', 44, '2034-01-01', 'NomeJogo 35'),
    (@jogadorIdTrintaSeis, @escolaIdSeis, @sexoIdTres, '61234567892', 'Jogador 36', 45, '2035-01-01', 'NomeJogo 36'),
    (@jogadorIdTrintaSete, @escolaIdSete, @sexoIdUm, '71234567892', 'Jogador 37', 46, '2036-01-01', 'NomeJogo 37'),
    (@jogadorIdTrintaOito, @escolaIdOito, @sexoIdDois, '81234567892', 'Jogador 38', 47, '2037-01-01', 'NomeJogo 38'),
    (@jogadorIdTrintaNove, @escolaIdNove, @sexoIdTres, '91234567892', 'Jogador 39', 48, '2038-01-01', 'NomeJogo 39'),
    (@jogadorIdQuarenta, @escolaIdDez, @sexoIdUm, '01234567893', 'Jogador 40', 49, '2039-01-01', 'NomeJogo 40');

SET @temporadaIdUm = UUID();
SET @temporadaIdDois = UUID();
SET @temporadaIdTres = UUID();
SET @temporadaIdQuatro = UUID();
SET @temporadaIdCinco = UUID();
SET @temporadaIdSeis = UUID();
SET @temporadaIdSete = UUID();
SET @temporadaIdOito = UUID();

-- Inserir dados na tabela TBTemporada com temporadas e campeonatos previamente declarados
INSERT INTO TBTemporada (id, idCampeonato, dataInicio, dataFim)
VALUES
    (@temporadaIdUm, @campeonatoIdUm, '2023-01-01', '2023-12-31'),
    (@temporadaIdDois, @campeonatoIdUm, '2024-01-01', '2024-12-31'),
    (@temporadaIdTres, @campeonatoIdDois, '2023-01-01', '2023-12-31'),
    (@temporadaIdQuatro, @campeonatoIdDois, '2024-01-01', '2024-12-31'),
    (@temporadaIdCinco, @campeonatoIdTres, '2023-01-01', '2023-12-31'),
    (@temporadaIdSeis, @campeonatoIdTres, '2024-01-01', '2024-12-31'),
    (@temporadaIdSete, @campeonatoIdUm, '2025-01-01', '2025-12-31'),
    (@temporadaIdOito, @campeonatoIdDois, '2025-01-01', '2025-12-31');


SET @partidaIdUm = UUID();        SET @partidaIdVinteUm= UUID();
SET @partidaIdDois = UUID();      SET @partidaIdVinteDois = UUID();
SET @partidaIdTres = UUID();      SET @partidaIdVinteTres = UUID(); 
SET @partidaIdQuatro = UUID();    SET @partidaIdVinteQuatro = UUID();
SET @partidaIdCinco = UUID();     SET @partidaIdVinteCinco = UUID();
SET @partidaIdSeis= UUID();       SET @partidaIdVinteSeis = UUID();
SET @partidaIdSete = UUID();      SET @partidaIdVinteSete = UUID();
SET @partidaIdOito= UUID();       SET @partidaIdVinteOito = UUID();
SET @partidaIdNove= UUID();       SET @partidaIdVinteNove = UUID();
SET @partidaIdDez = UUID();       SET @partidaIdTrinta = UUID();
SET @partidaIdOnze = UUID();      SET @partidaIdTrintaUm = UUID();
SET @partidaIdDoze = UUID();      SET @partidaIdTrintaDois = UUID();
SET @partidaIdTreze = UUID();     SET @partidaIdTrintaTres = UUID(); 
SET @partidaIdQuatorze = UUID();  SET @partidaIdTrintaQuatro = UUID();
SET @partidaIdQuinze = UUID();    SET @partidaIdTrintaCinco = UUID();
SET @partidaIdDezesseis = UUID(); SET @partidaIdTrintaSeis = UUID();
SET @partidaIdDezesere = UUID();  SET @partidaIdTrintaSete = UUID();
SET @partidaIdDezoito = UUID();   SET @partidaIdTrintaOito = UUID();
SET @partidaIdDezenove = UUID();  SET @partidaIdTrintaNove = UUID();
SET @partidaIdVinte = UUID();     SET @partidaIdQuarenta = UUID();


-- Inserir dados na tabela TBPartida com partidas previamente declaradas
INSERT INTO TBPartida (id, dataHora, duracaoMilessegundos, mandanteId, visitanteId, idTemporada)
VALUES
    (@partidaIdUm, '2023-01-01 14:00:00', 7200, @escolaIdUm, @escolaIdDois, @temporadaIdUm),
    (@partidaIdDois, '2023-01-02 15:00:00', 7200, @escolaIdTres, @escolaIdQuatro, @temporadaIdUm),
    (@partidaIdTres, '2023-01-03 16:00:00', 7200, @escolaIdCinco, @escolaIdSeis, @temporadaIdDois),
    (@partidaIdQuatro, '2023-01-04 17:00:00', 7200, @escolaIdSete, @escolaIdOito, @temporadaIdDois),
    (@partidaIdCinco, '2023-01-05 18:00:00', 7200, @escolaIdNove, @escolaIdDez, @temporadaIdTres),
    (@partidaIdSeis, '2023-01-06 19:00:00', 7200, @escolaIdUm, @escolaIdDois, @temporadaIdTres),
    (@partidaIdSete, '2023-01-07 20:00:00', 7200, @escolaIdTres, @escolaIdQuatro, @temporadaIdQuatro),
    (@partidaIdOito, '2023-01-08 21:00:00', 7200, @escolaIdCinco, @escolaIdSeis, @temporadaIdQuatro),
    (@partidaIdNove, '2023-01-09 22:00:00', 7200, @escolaIdSete, @escolaIdOito, @temporadaIdCinco),
    (@partidaIdDez, '2023-01-10 23:00:00', 7200, @escolaIdNove, @escolaIdDez, @temporadaIdCinco),
    (@partidaIdOnze, '2023-01-11 14:00:00', 7200, @escolaIdUm, @escolaIdDois, @temporadaIdSeis),
    (@partidaIdDoze, '2023-01-12 15:00:00', 7200, @escolaIdTres, @escolaIdQuatro, @temporadaIdSeis),
    (@partidaIdTreze, '2023-01-13 16:00:00', 7200, @escolaIdCinco, @escolaIdSeis, @temporadaIdSete),
    (@partidaIdQuatorze, '2023-01-14 17:00:00', 7200, @escolaIdSete, @escolaIdOito, @temporadaIdSete),
    (@partidaIdQuinze, '2023-01-15 18:00:00', 7200, @escolaIdNove, @escolaIdDez, @temporadaIdOito),
    (@partidaIdDezesseis, '2023-01-16 19:00:00', 7200, @escolaIdUm, @escolaIdDois, @temporadaIdOito),
    (@partidaIdDezesere, '2023-01-17 20:00:00', 7200, @escolaIdTres, @escolaIdQuatro, @temporadaIdUm),
    (@partidaIdDezoito, '2023-01-18 21:00:00', 7200, @escolaIdCinco, @escolaIdSeis, @temporadaIdUm),
    (@partidaIdDezenove, '2023-01-19 22:00:00', 7200, @escolaIdSete, @escolaIdOito, @temporadaIdDois),
    (@partidaIdVinte, '2023-01-20 23:00:00', 7200, @escolaIdNove, @escolaIdDez, @temporadaIdDois),
    (@partidaIdVinteUm, '2023-01-20 23:00:00', 7200, @escolaIdNove, @escolaIdDez, @temporadaIdDois),
    (@partidaIdVinteDois, '2023-01-20 23:00:00', 7200, @escolaIdNove, @escolaIdDez, @temporadaIdDois),
    (@partidaIdVinteTres, '2023-01-20 23:00:00', 7200, @escolaIdNove, @escolaIdDez, @temporadaIdDois),
    (@partidaIdVinteQuatro, '2023-01-20 23:00:00', 7200, @escolaIdNove, @escolaIdDez, @temporadaIdDois),
    (@partidaIdVinteCinco, '2023-01-20 23:00:00', 7200, @escolaIdNove, @escolaIdDez, @temporadaIdDois),
    (@partidaIdVinteSeis, '2023-01-20 23:00:00', 7200, @escolaIdNove, @escolaIdDez, @temporadaIdDois),
    (@partidaIdVinteSete, '2023-01-20 23:00:00', 7200, @escolaIdNove, @escolaIdDez, @temporadaIdDois),
    (@partidaIdVinteOito, '2023-01-20 23:00:00', 7200, @escolaIdNove, @escolaIdDez, @temporadaIdDois),
    (@partidaIdVinteNove, '2023-01-20 23:00:00', 7200, @escolaIdNove, @escolaIdDez, @temporadaIdDois),
    (@partidaIdTrinta, '2023-01-20 23:00:00', 7200, @escolaIdNove, @escolaIdDez, @temporadaIdDois),
    (@partidaIdTrintaUm, '2023-01-20 23:00:00', 7200, @escolaIdNove, @escolaIdDez, @temporadaIdDois),
	(@partidaIdTrintaDois, '2023-02-01 15:00:00', 7200, @escolaIdTres, @escolaIdQuatro, @temporadaIdOito),
    (@partidaIdTrintaTres, '2023-02-02 16:00:00', 7200, @escolaIdCinco, @escolaIdSeis, @temporadaIdUm),
    (@partidaIdTrintaQuatro, '2023-02-03 17:00:00', 7200, @escolaIdSete, @escolaIdOito, @temporadaIdUm),
    (@partidaIdTrintaCinco, '2023-02-04 18:00:00', 7200, @escolaIdNove, @escolaIdDez, @temporadaIdDois),
    (@partidaIdTrintaSeis, '2023-02-05 19:00:00', 7200, @escolaIdUm, @escolaIdDois, @temporadaIdDois),
    (@partidaIdTrintaSete, '2023-02-06 20:00:00', 7200, @escolaIdTres, @escolaIdQuatro, @temporadaIdTres),
    (@partidaIdTrintaOito, '2023-02-07 21:00:00', 7200, @escolaIdCinco, @escolaIdSeis, @temporadaIdTres),
    (@partidaIdTrintaNove, '2023-02-08 22:00:00', 7200, @escolaIdSete, @escolaIdOito, @temporadaIdQuatro),
    (@partidaIdQuarenta, '2023-02-09 23:00:00', 7200, @escolaIdNove, @escolaIdDez, @temporadaIdQuatro);
   
-- Gerar 100 inserções aleatórias na tabela TBGol
DELIMITER //
CREATE PROCEDURE InsertRandomGoals()
BEGIN
    DECLARE i INT;
    SET i = 1;
    
    WHILE i <= 100 DO
        -- Selecionar um ID de partida aleatório
        SET @partidaId = (SELECT id FROM TBPartida ORDER BY RAND() LIMIT 1);
        -- Selecionar um ID de jogador que marcou gol aleatório
        SET @mandanteId = (SELECT mandanteId FROM TBPartida WHERE id = @partidaId LIMIT 1);
        SET @visitanteId = (SELECT visitanteId FROM TBPartida WHERE id = @partidaId LIMIT 1);
        SET @jogadorIdMarcou = (SELECT id FROM TBJogador WHERE idEscola = @mandanteId or idEscola = @visitanteId ORDER BY RAND() LIMIT 1);
        -- Selecionar um ID de jogador de assistência aleatório ou nulo
        SET @jogadorIdAssistencia = (SELECT id FROM TBJogador ORDER BY RAND() LIMIT 1);
        IF RAND() < 0.2 THEN
            SET @jogadorIdAssistencia = NULL;
        END IF;
        -- Gerar um ID de gol usando UUID
        SET @golId = UUID();
        -- Gerar valores aleatórios para os campos
        SET @anulado = (RAND() < 0.1);
        SET @pnalti = (RAND() < 0.3);
        SET @contra = (RAND() < 0.2);
        SET @tempoEmMilissegundos = FLOOR(RAND() * 9000) + 60000; -- Varie o tempo
        
        -- Inserir o registro na tabela TBGol
        INSERT INTO TBGol (id, idPartida, idJogadorMarcou, idJogadorAssistencia, anulado, pnalti, contra, tempoEmMilissegundos)
        VALUES (@golId, @partidaId, @jogadorIdMarcou, @jogadorIdAssistencia, @anulado, @pnalti, @contra, @tempoEmMilissegundos);
        
        SET i = i + 1;
    END WHILE;
END;
//
DELIMITER ;

-- Executar o procedimento para inserir 100 registros
CALL InsertRandomGoals();


INSERT INTO TBParticipacaoCampeonato (id, idCampeonato, idEscola, status, administrador)
SELECT
    UUID(), c.id AS idCampeonato, e.id AS idEscola, 1, TRUE
FROM
    TBCampeonato c
CROSS JOIN
    TBEscola e
UNION
SELECT
    UUID(), c.id AS idCampeonato, e.id AS idEscola, 1, FALSE
FROM
    TBCampeonato c
CROSS JOIN
    TBEscola e;
    
    
-- Inserir 30 faltas na tabela TBFalta com a restrição de jogadores de escolas diferentes
DELIMITER //
CREATE PROCEDURE InsertFaltasWithRestriction()
BEGIN
    DECLARE i INT;
    SET i = 1;

    WHILE i <= 30 DO
        -- Selecionar um ID de partida aleatório
        SET @partidaId = (SELECT id FROM TBPartida ORDER BY RAND() LIMIT 1);
        -- Selecionar um ID de jogador que sofreu a falta aleatório
        SET @jogadorIdSofreu = (SELECT id FROM TBJogador ORDER BY RAND() LIMIT 1);
        -- Selecionar um ID de jogador que cometeu a falta aleatório
        SET @jogadorIdCometeu = (SELECT id FROM TBJogador WHERE idEscola <> (SELECT idEscola FROM TBJogador WHERE id = @jogadorIdSofreu) ORDER BY RAND() LIMIT 1);
        -- Gerar um ID de falta usando UUID
        SET @faltaId = UUID();
        -- Gerar um tempo de partida em milissegundos
        SET @tempoPartidaMilissegundos = FLOOR(RAND() * 9000) + 60000;

        -- Inserir o registro na tabela TBFalta
        INSERT INTO TBFalta (id, idPartida, idJogadorSofreu, idJogadorCometeu, tempoPartidaMilissegundos)
        VALUES (@faltaId, @partidaId, @jogadorIdSofreu, @jogadorIdCometeu, @tempoPartidaMilissegundos);

        SET i = i + 1;
    END WHILE;
END;
//
DELIMITER ;

-- Executar o procedimento para inserir 30 faltas com a restrição de jogadores de escolas diferentes
CALL InsertFaltasWithRestriction();

-- Finalizado INSERS