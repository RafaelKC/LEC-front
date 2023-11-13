<?php
include('../../../banco/connection.php');

session_start();
ob_start();
if (!isset($_SESSION['user']) || !isset($_GET['idJogador']) || $_SESSION['user']['type'] == 'PATROCINADOR') {
    header('Location: ../../');
}

$idJogador = $_GET['idJogador'];
$sql = "DELETE FROM TBJogador WHERE id = '$idJogador' AND idEscola = '". $_SESSION['user']['id'] ."'";

echo $sql;

$result = $resultGoals = mysqli_query($connection, $sql);

header("Location: ../../?id=".$_SESSION['user']['id']);
?>
