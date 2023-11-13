<?php
include('../banco/connection.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user']) && isset($_POST['gameId'])) {
        $userId = $_SESSION['user']['id'];
        $gameId = $_POST['gameId'];


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

        if ($isSchoolAdmin) {

            $sqlDeleteGoals = "DELETE FROM TBGol WHERE idPartida = '$gameId'";
            $sqlDeleteFaltas = "DELETE FROM TBFalta WHERE idPartida = '$gameId'";

            $resultDeleteGoals = mysqli_query($connection, $sqlDeleteGoals);
            $resultDeleteFaltas = mysqli_query($connection, $sqlDeleteFaltas);

            if ($resultDeleteGoals && $resultDeleteFaltas) {

                $sqlDeleteGame = "DELETE FROM TBPartida WHERE id = '$gameId'";
                echo $sqlDeleteGame;
                $resultDeleteGame = mysqli_query($connection, $sqlDeleteGame);

                if ($resultDeleteGame) {

                    header('Location: ../'); 
                    exit();
                } else {
                    die("Falha ao excluir a partida: " . mysqli_error($connection));
                }
            } else {
                die("Falha ao excluir os gols da partida: " . mysqli_error($connection));
            }
        } else {

            echo "Você não tem permissão para excluir esta partida.";
        }
    }
} else {

    header('Location: ../');
    exit();
}
?>
