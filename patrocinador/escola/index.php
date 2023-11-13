<?php

include('../../banco/connection.php');
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['type'] == 'ESCOLA' || empty($_GET['idEscola'])) {
    header('Location: ../../');
}

$idPatrocinador = $_SESSION['user']['id'];
$idEscola = $_GET['idEscola'];

$remover = isset($_GET['remover']);

$sqlCreate = "INSERT INTO TBEscolaPatrocinador (idEscola, idPatrocinador)
                VALUES
                    ('$idEscola', '$idPatrocinador');";

$sqlDelete = "DELETE FROM TBEscolaPatrocinador WHERE idEscola = '$idEscola' AND idPatrocinador = '$idPatrocinador';";

$sqlDefinitivo = $remover ? $sqlDelete : $sqlCreate;

echo $sqlDefinitivo;

mysqli_query($connection, $sqlDefinitivo);
header('Location: ../../escola?id='.$idEscola);
