<?php
    include('../../../banco/connection.php');

    session_start();
    ob_start();
    if (!isset($_SESSION['user']) || !isset($_GET['idGol'])) {
        header('Location: ../');
    }

    $idGol = $_GET['idGol'];
    $sql = "DELETE FROM TBGol WHERE id = '$idGol'";

    $result = $resultGoals = mysqli_query($connection, $sql);

    if (!isset($_GET['idPartida'])) {
        header('Location: ../../');
    } else {
        header("Location: ../../?id=".$_GET['idPartida']);
    }
?>
