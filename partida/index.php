<?php
    include('../banco/connection.php');
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
    <title>Cadastro de Aluno</title>
    <script type="module" src="./index.js"></script>
</head>

<body>
    <header>
        <div>
            <h1>Liga Esportiva Curitiba</h1>
        </div>
        <div class="logoHeader">
            <img id="logo" alt="Logo LEC" src="../assets/logotipo.png">
        </div>
    </header>
    <main>
        <?php
        if (isset($_GET['id'])) {
            $gameId = $_GET['id'];

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
                        <caption>Estatísticas do jogo</caption>
                        <tr>
                            <th>Jogo</th>
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
                            <th>Tempo de jogo (ms)</th>
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
                                        <?php echo $goal['tempoEmMilissegundos']; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            die("Query failed: " . mysqli_error($connection));
                        }
                        ?>
                    </table>
                    <div id="extraContainer">
                        <a href="/LEC-front/partida/gol/create?id=<?php echo $gameId; ?>">
                            <button id="golsBtn">Clique aqui para adicionar gols</button>
                        </a>
                    </div>
                    <?php
                } else {
                    echo "Não encontramos esse jogo :(.";
                }
            } else {
                die("Query failed: " . mysqli_error($connection));
            }
        } else {
            echo "Nenhum id de jogo encontrado.";
        }
        ?>

    </main>

</body>

</html>