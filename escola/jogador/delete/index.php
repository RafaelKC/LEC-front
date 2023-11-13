<?php
include('../../../banco/connection.php');

session_start();
ob_start();
if (!isset($_SESSION['user']) || !isset($_GET['idJogador']) || $_SESSION['user']['type'] == 'PATROCINADOR') {
    header('Location: ../../');
}

$idJogador = $_GET['idJogador'];

$sqlDeleteFalta = "DELETE FROM TBFalta WHERE idJogadorSofreu = '$idJogador' OR idJogadorCometeu = '$idJogador';";
$sqlDeleteGol = "DELETE FROM TBGol WHERE idJogadorAssistencia = '$idJogador' OR idJogadorMarcou = '$idJogador';";
$sqlDeleteJogador = "DELETE FROM TBJogador WHERE id = '$idJogador';";

$resultFalta = $resultGoals = mysqli_query($connection, $sqlDeleteFalta);
$resultGol = $resultGoals = mysqli_query($connection, $sqlDeleteGol);
$resultJogador = $resultGoals = mysqli_query($connection, $sqlDeleteJogador);

header("Location: ../../?id=".$_SESSION['user']['id']);
?>
