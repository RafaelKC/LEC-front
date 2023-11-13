<?php
    include('../banco/connection.php');
    include('../utils/functions/formatMilissegundos.php');
    session_start();
    if (!isset($_GET['id'])) {
        header('Location: ../');
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
    <link rel="stylesheet" href="../styles/base.css">
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="icon" type="image/png" href="../assets/logotipo.png" sizes="16x16">
    <title>Estatísticas da Partida</title>
    <script type="module" src="./index.js"></script>
</head>

<body>
    <header>
        <div>
            <div>
                <h1><a class="homeLink" href="../">Liga Esportiva Curitiba</a></h1>
                <?php
                if (isset($_SESSION['user'])) {
                    echo '<h3>' . $_SESSION['user']['nome'] . '</h3>';
                }
                ?>
            </div>
        </div>
        <div class="logoHeader">
            <img id="logo" alt="Logo LEC" src="../assets/logotipo.png">
        </div>
    </header>
    <main>
        <?php
        if (isset($_GET['id'])) {
            $gameId = $_GET['id'];

            $userId = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;
            $sqlIsSchoolAdmin = "SELECT COUNT(*) AS count
                    FROM TBEscola Escola
                    JOIN TBParticipacaoCampeonato Participacao ON Escola.id = Participacao.idEscola
                    JOIN TBCampeonato Campeonato ON Participacao.idCampeonato = Campeonato.id
                    WHERE Escola.id = '$userId'
                    AND Participacao.administrador = 1
                    AND Campeonato.id = (
                        SELECT Temporada.idCampeonato
                        FROM TBPartida P
                        JOIN TBTemporada Temporada ON P.idTemporada = Temporada.id
                        WHERE P.id = '$gameId'
                    )
                    LIMIT 1";

            $resultIsSchoolAdmin = mysqli_query($connection, $sqlIsSchoolAdmin);
            $isSchoolAdmin = $resultIsSchoolAdmin ? (mysqli_fetch_assoc($resultIsSchoolAdmin)['count'] > 0) : false;

            $sqlGameDetails = "SELECT
            CONCAT(Mandante.nome, ' x ', Visitante.nome) AS NomePartida,
            P.data AS DataHoraPartida,
            P.id as PartidaID,
            P.duracaoMilessegundos AS DuracaoMilliseconds,
            1 AS TemporadaID,
            Campeonato.nome AS CampeonatoNome,
            Mandante.nome AS NomeMandante,
            Visitante.nome AS NomeVisitante
        FROM TBPartida P
        JOIN TBEscola Mandante ON P.idMandante = Mandante.id
        JOIN TBEscola Visitante ON P.idVisitante = Visitante.id
        JOIN TBTemporada Temporada ON P.idTemporada = Temporada.id
        JOIN TBCampeonato Campeonato ON Temporada.idCampeonato = Campeonato.id
        WHERE P.id = '$gameId'";

            $resultGameDetails = mysqli_query($connection, $sqlGameDetails);

            if ($resultGameDetails) {
                $gameDetails = mysqli_fetch_assoc($resultGameDetails);

                if ($gameDetails) {
                    ?>

                    <table class="tabelaEstatisticas">
                        <caption>Estatísticas da Partida</caption>
                        <tr>
                            <th>Partida</th>
                            <th>Data e Hora</th>
                            <th>Campeonato</th>
                            <th>Mandante</th>
                            <th>Visitante</th>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $gameDetails['NomePartida']; ?>
                            </td>
                            <td>
                                <?php echo $gameDetails['DataHoraPartida']; ?>
                            </td>
                            <td>
                                <?php echo $gameDetails['CampeonatoNome']; ?>
                            </td>
                            <td>
                                <?php echo $gameDetails['NomeMandante']; ?>
                            </td>
                            <td>
                                <?php echo $gameDetails['NomeVisitante']; ?>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <table class="tabelaEstatisticas">
                        <caption>Estatísticas de Gols</caption>
                        <tr>
                            <th>Marcador</th>
                            <th>Assistência</th>
                            <th>Anulado</th>
                            <th>Penalti</th>
                            <th>Tempo da partida</th>
                            <th>Ações</th>
                        </tr>
                        <?php
                        $sqlGoals = "SELECT
                                    G.*,
                                    JM.nome AS MarcouNome,
                                    JA.nome AS AssistenciaNome
                                FROM TBGol G
                                LEFT JOIN TBJogador JM ON G.idJogadorMarcou = JM.id
                                LEFT JOIN TBJogador JA ON G.idJogadorAssistencia = JA.id
                                WHERE G.idPartida = '$gameId'";
                        $resultGoals = mysqli_query($connection, $sqlGoals);

                        if ($resultGoals) {
                            while ($goal = mysqli_fetch_assoc($resultGoals)) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $goal['MarcouNome']; ?>
                                    </td>
                                    <td>
                                        <?php echo $goal['AssistenciaNome']; ?>
                                    </td>
                                    <td>
                                        <?php echo ($goal['anulado'] ? 'Sim' : 'Não'); ?>
                                    </td>
                                    <td>
                                        <?php echo ($goal['pnalti'] ? 'Sim' : 'Não'); ?>
                                    </td>
                                    <td>
                                        <?php echo formatMilliseconds($goal['tempoEmMilissegundos']); ?>
                                    </td>
                                    <?php
                                    if ($isSchoolAdmin) {
                                        echo '
                                        <td>
                                            <a href="gol/delete?idGol='.$goal['id'].'&idPartida='.$gameId.'">Deletar</a>
                                        </td>';
                                    }
                                    ?>
                                </tr>
                                <?php
                            }
                        } else {
                            die("Query failed: " . mysqli_error($connection));
                        }
                        ?>
                    </table>

                    <?php
                    if ($isSchoolAdmin) {
                        echo '
                        <div id="extraContainer">
                            <a href="/LEC-front/partida/gol/create?idPartida='.$gameId.'">
                                <button id="golsBtn">Clique aqui para adicionar gols</button>
                            </a>
                            <form method="post" action="deletePartida.php">
                                <input type="hidden" name="gameId" value="' . $gameDetails['PartidaID'] . '">
                                <button type="submit" id="golsBtn">Deletar Partida</button>
                            </form>
                        </div>';
                    }

                    ?>

                    <?php
                } else {
                    echo "Não encontramos essa partida :(.";
                }
            } else {
                die("Query failed: " . mysqli_error($connection));
            }
        }
        ?>

    </main>

</body>

</html>
