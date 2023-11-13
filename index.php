    <?php
    include('./banco/connection.php');

    session_start();

    $sql = "SELECT
        CONCAT(Mandante.nome, ' x ', Visitante.nome) AS NomePartida,
        P.data AS DataHoraPartida,
        P.id as PartidaID,
        P.duracaoMilessegundos AS DuracaoMilliseconds,
        CONCAT(Temporada.dataInicio, ' - ', Temporada.dataFim) AS TemporadaID,
        Campeonato.nome AS CampeonatoNome
    FROM TBPartida P
    JOIN TBEscola Mandante ON P.idMandante = Mandante.id
    JOIN TBEscola Visitante ON P.idVisitante = Visitante.id
    JOIN TBTemporada Temporada ON P.idTemporada = Temporada.id
    JOIN TBCampeonato Campeonato ON Temporada.idCampeonato = Campeonato.id
    ORDER BY P.data DESC;";







    $result = mysqli_query($connection, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($connection));
    }

    $sqlEscolasParticipantes = "SELECT id, nome FROM TBEscola";
    $resultEscolasParticipantes = mysqli_query($connection, $sqlEscolasParticipantes);

    if (!$resultEscolasParticipantes) {
        die("Query failed: " . mysqli_error($connection));
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


        <link rel="stylesheet" href="./styles/base.css">
        <link rel="stylesheet" href="styles.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
        <link rel="icon" type="image/png" href="assets/logotipo.png" sizes="16x16">
        <title>Cadastro de Aluno</title>
    </head>

    <body>
        <header>
            <div>
                <h1><a class="homeLink" href="./">Liga Esportiva Curitiba</a></h1>
                <?php
                if (isset($_SESSION['user'])) {
                    if ($_SESSION['user']['type'] == 'PATROCINADOR') {
                        echo '<h3>' . $_SESSION['user']['nome'] . '</h3>';
                    } else {
                        echo '<h3><a href="./escola?id='. $_SESSION['user']['id'].'">' . $_SESSION['user']['nome'] . '</a></h3>';
                    }
                }
                ?>
            </div>
            <div class="options">
                <?php
                if (!isset($_SESSION['user'])) {
                    echo '<a class="headerSegundario" href="/LEC-front/login">Login</a>';
                    echo '<a class="headerSegundario" href="/LEC-front/escola/create/">Cadastrar escola</a>';
                    echo '<a class="headerSegundario">Cadastrar patrocinador </a>';
                } else {
                    echo '<a class="headerSegundario" href="/LEC-front/sair">Sair</a>';
                }
                echo '<a class="headerSegundario" href="/LEC-front/sobre">Sobre</a>';
                ?>
            </div>
            <div class="logoHeader">
                <img id="logo" alt="Logo LEC" src="assets/logotipo.png">
            </div>
        </header>

        <main>
            <div class="tables">
                <table class="tabela" style="flex: 1;">
                    <caption>
                        Lista de partidas
                    </caption>
                    <tr>
                        <th>Pastidas:</th>
                        <th>Data dos partidas:</th>
                        <th>Campeonato:</th>
                        <th>Temporada:</th>
                        <th>Ações:</th>
                    </tr>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['NomePartida'] . "</td>";
                        echo "<td>" . $row['DataHoraPartida'] . "</td>";
                        echo "<td>" . $row['CampeonatoNome'] . "</td>";
                        echo "<td>" . $row['TemporadaID'] . "</td>";
                        echo '<td><a class="partidaBtn" href="./partida?id=' . $row['PartidaID'] . '">Ver mais</a></td>';
                        echo "</tr>";
                    }
                    ?>
                </table>
                <table class="tabela" >
                    <caption>
                        Escolas participantes
                    </caption>
                    <tr>
                        <th>Nome da Escola</th>
                    </tr>
                    <?php
                    while ($row = mysqli_fetch_assoc($resultEscolasParticipantes)) {
                        echo "<tr>";
                        echo "<td><a href='./escola?id=".$row['id']."'>" . $row['nome'] . "</a></td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
        </main>