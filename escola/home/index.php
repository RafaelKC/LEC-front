<?php
include('../../banco/connection.php');

$sql = "SELECT
    CONCAT(Mandante.nome, ' x ', Visitante.nome) AS NomePartida,
    P.data AS DataHoraPartida,
    P.duracaoMilessegundos AS DuracaoMilliseconds,
    1 AS TemporadaID,
    Campeonato.nome AS CampeonatoNome
FROM TBPartida P
JOIN TBEscola Mandante ON P.idMandante = Mandante.id
JOIN TBEscola Visitante ON P.idVisitante = Visitante.id
JOIN TBTemporada Temporada ON P.idTemporada = Temporada.id
JOIN TBCampeonato Campeonato ON Temporada.idCampeonato = Campeonato.id;";






$result = mysqli_query($connection, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$sqlEscolasParticipantes = "SELECT id, nome FROM TBEscola";
$resultEscolasParticipantes = mysqli_query($connection, $sqlEscolasParticipantes);

if (!$resultEscolasParticipantes) {
    die("Query failed: " . mysqli_error($conn));
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;500&display=swap');
    </style>

   
    <link rel="stylesheet" href="styles.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="icon" type="image/png" href="../../assets/logotipo.png" sizes="16x16">
    <title>Cadastro de Aluno</title>
    <script type="module" src="./index.js"></script>
</head>

<body>
    <header>
        <div>
            <h1>Liga Esportiva Curitiba</h1>
        </div>
        <div>
            <a href="/LEC-front/escola/create/">Cadastrar escola</a>
            <img id="logoHeader" alt="Logo LEC" src="../../assets/logotipo.png">
        </div>

    </header>

    <main>
        <div style="display: flex; width: 100%;">
            <table class="tabela" style="flex: 1;">
                <caption>
                    Lista de jogos
                </caption>
                <tr>
                    <th>Jogos:</th>
                    <th>Data dos jogos:</th>
                    <th>Campeonato:</th>
                    <th>Temporada:</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['NomePartida'] . "</td>";
                    echo "<td>" . $row['DataHoraPartida'] . "</td>";
                    echo "<td>" . $row['CampeonatoNome'] . "</td>";
                    echo "<td>" . $row['TemporadaID'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
            <table class="tabela" style="flex: 1;">
                <caption>
                    Escolas participantes
                </caption>
                <tr>
                    <th>Nome da Escola</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($resultEscolasParticipantes)) {
                    echo "<tr>";
                    echo "<td>" . $row['nome'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </main>