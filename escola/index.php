<?php
    include('../banco/connection.php');
    session_start();

    if (empty($_GET['id'])) {
        header('Location: ../');
    }

    $escolaAtual = false;
    $userAtualPatrocinador = false;
    $jaPatrocina = false;
    $idEscola = $_GET['id'];

    if (isset($_SESSION['user']) && $_SESSION['user']['type'] == 'ESCOLA') {
        $escolaAtual = $_SESSION['user']['id'] == $idEscola;
    } elseif (isset($_SESSION['user']) && $_SESSION['user']['type'] == 'PATROCINADOR') {
        $userAtualPatrocinador = TRUE;
        $idPatrocinador = $_SESSION['user']['id'];
    }


    if ($userAtualPatrocinador) {
        $sqlGetPatrocinadorEscola = "SELECT * FROM LEC.TBEscolaPatrocinador WHERE idPatrocinador = '$idPatrocinador' AND idEscola = '$idEscola';";
        $resultadoPatrocinadorEscola = mysqli_query($connection, $sqlGetPatrocinadorEscola);
        $resultPatrocinadorEscolaCheck = mysqli_num_rows($resultadoPatrocinadorEscola);
        if ($resultPatrocinadorEscolaCheck > 0) {
            $jaPatrocina = true;
        }
    }

    $sqlGetEscola = "SELECT * FROM TBEscola WHERE id = '$idEscola'";

    $resultado = mysqli_query($connection, $sqlGetEscola);
    $resultEscolaCheck = mysqli_num_rows($resultado);

    if ($resultEscolaCheck != 1) {
        header('Location: ../');
    }

    $escola = mysqli_fetch_assoc($resultado);
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
        <link rel="stylesheet" href="styles.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
        <link rel="icon" type="image/png" href="../assets/logotipo.png" sizes="16x16">
        <title><?php echo $escola['nome']; ?></title>
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
                        echo '<h3><a href="./?id='. $_SESSION['user']['id'].'">' . $_SESSION['user']['nome'] . '</a></h3>';
                    }
                }
                ?>
            </div>
            <div class="options">
                <a class="headerSegundario" href="/LEC-front">Início</a>
                <a class="headerSegundario">Jogadores</a>
                <a class="headerSegundario">Campeonatos</a>
                <a class="headerSegundario">Partidas</a>
                <a class="headerSegundario" href="/LEC-front/sobre">Sobre</a>
            </div>
            <div class="logoHeader">
                <img id="logo" alt="Logo LEC" src="../assets/logotipo.png">
            </div>
        </header>

        <main id="main">
            <div class="escolaNome">
                <h1>
                    <?php
                        echo $escola['nome'];
                    ?>
                </h1>
            </div>

            <div class="container">
                <?php

                if($userAtualPatrocinador) {
                    echo '<div>';
                    if ($jaPatrocina) {
                        echo "<a href='../patrocinador/escola?idEscola=". $idEscola ."&remover=true' class='patrocinadorBtn deixarPatrocinar'>Deixar de Patrocinar</a>";
                    } else {
                        echo "<a href='../patrocinador/escola?idEscola=". $idEscola ."' class='patrocinadorBtn'>Começar a Patrocinar</a>";
                    }
                    echo '</div>';
                } else {
                    echo $userAtualPatrocinador;
                }
                ?>

                <div class="sectionsHeader">
                    <h2>Partidas</h2>
                </div>

                <table class="tabela">
                    <tr>
                        <th>Pastidas</th>
                        <th>Data</th>
                        <th>Campeonato</th>
                        <th>Temporada</th>
                        <th>Ações</th>
                    </tr>
                    <?php
                        $sqlPartidas = "SELECT
                                    CONCAT(Mandante.nome, ' x ', Visitante.nome) AS NomePartida,
                                    P.data AS DataHoraPartida,
                                    P.id as PartidaID,
                                    P.duracaoMilessegundos AS DuracaoMilliseconds,
                                    1 AS TemporadaID,
                                    Campeonato.nome AS CampeonatoNome
                                FROM TBPartida P
                                JOIN TBEscola Mandante ON P.idMandante = Mandante.id
                                JOIN TBEscola Visitante ON P.idVisitante = Visitante.id
                                JOIN TBTemporada Temporada ON P.idTemporada = Temporada.id
                                JOIN TBCampeonato Campeonato ON Temporada.idCampeonato = Campeonato.id
                                WHERE Mandante.id = '$idEscola' OR
                                Visitante.id = '$idEscola'
                                ORDER BY P.data DESC;";


                    $resultEscola = mysqli_query($connection, $sqlPartidas);

                        while ($row = mysqli_fetch_assoc($resultEscola)) {
                            echo "<tr>";
                            echo "<td>" . $row['NomePartida'] . "</td>";
                            echo "<td>" . $row['DataHoraPartida'] . "</td>";
                            echo "<td>" . $row['CampeonatoNome'] . "</td>";
                            echo "<td>" . $row['TemporadaID'] . "</td>";
                            echo '<td><a class="partidaBtn" href="../partida?id=' . $row['PartidaID'] . '">Ver mais</a></td>';
                            echo "</tr>";
                        }
                    ?>
                </table>

                <div class="sectionsHeader">
                    <h2>Jogadores</h2>
                </div>

                <?php
                    if ($escolaAtual) {
                        echo '
                            <div class="acoes">
                                <h4><a class="acoes" href="./jogador/create/index.php">Adicionar</a></h4>
                            </div>      
                        ';
                    }
                ?>

                <table class="tabela">
                    <tr>
                        <th>Nome</th>
                        <th>Total de gols válidos</th>
                        <th>Número</th>
                        <?php
                            if($escolaAtual) {
                                echo '<th>Ações</th>';
                            }
                        ?>
                    </tr>
                    <?php
                    $sqlJogador = "
                        SELECT j.nomeJogo, COUNT(g.id) as golsValidos, j.numeroCamisa, j.id FROM TBGol g
                        RIGHT JOIN TBJogador j ON j.id = g.idJogadorMarcou
                        WHERE (g.anulado = FALSE OR g.anulado IS NULL)
                        AND j.idEscola = '$idEscola'
                        GROUP BY j.id
                        ORDER BY golsValidos DESC;
                    ";


                    $resultJogador = mysqli_query($connection, $sqlJogador);

                    while ($row = mysqli_fetch_assoc($resultJogador)) {
                        echo "<tr>";
                        echo "<td>" . $row['nomeJogo'] . "</td>";
                        echo "<td>" . $row['golsValidos'] . "</td>";
                        echo "<td>" . $row['numeroCamisa'] . "</td>";
                        if ($escolaAtual) {
                            $idJogador = $row['id'];

                            echo "<td>
                                    <a href='./jogador/delete?idJogador=$idJogador' class='acoes'>Delete</a>
                                    <a href='./jogador/update?idJogador=$idJogador' class='acoes'>Update</a>
                                </td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </table>

            </div>
        </main>
    </body>
</html>