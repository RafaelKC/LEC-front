<?php
include("../../../banco/connection.php");


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css2?family=Inter:wght@300;500&display=swap' rel='stylesheet'>
    <link rel="stylesheet" href="../../../styles/fomInput.css">
    <link rel="stylesheet" href="../../../styles/base.css">
    <script type="module" src="script.js"></script>
    <title>Document</title>
</head>
<header>
    <div>
        <h1><a class="homeLink" href="../../../">Liga Esportiva Curitiba</a></h1>
    </div>
    <div class="logoHeader">
            <img id="logo" alt="Logo LEC" src="../../../assets/logotipo.png">
    </div>
</header>
<main>
    <div class="formularioContainer">


        <div class="titulo">
            <h3>Cadastro de temporada</h1>
        </div>
        <div id="formulario">
            <form id="form" action="index.php" method="post" name="create_temporada" onsubmit="return validateForm()">
                <div class="formInput">
                    <label for="idCampeonato">Selecione o campeonato:</label>
                    <select id="idCampeonato" name="idCampeonato">

                        <?php
                        $sqlSelectCampeonatos = "SELECT id, nome FROM TBCampeonato";
                        $resultCampeonatos = mysqli_query($connection, $sqlSelectCampeonatos);

                        while ($rowCampeonato = mysqli_fetch_assoc($resultCampeonatos)) {
                            echo "<option value='{$rowCampeonato['id']}'>{$rowCampeonato['nome']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="formInput">
                    <label for="dataInicio">Data de início da temporada:</label>
                    <input type="date" id="dataInicio" name="dataInicio">
                </div>
                <div class="formInput">
                    <label for="dataFim">Data de término da temporada:</label>
                    <input type="date" id="dataFim" name="dataFim">
                </div>
                <div class="submmitContainer">
                    <button type="submit" id="btn" name="create_temporada"> Cadastrar Temporada </button>
                </div>
            </form>
        </div>
    </div>

</main>


</html>

<?php

if (isset($_POST['create_temporada'])) {
    $temporadaId = uniqid();
    $idCampeonato = mysqli_real_escape_string($connection, $_POST['idCampeonato']);
    $dataInicio = mysqli_real_escape_string($connection, $_POST['dataInicio']);
    $dataFim = mysqli_real_escape_string($connection, $_POST['dataFim']);

    $sqlCreateTemporada = "INSERT INTO TBTemporada (id, idCampeonato, dataInicio, dataFim) VALUES ('$temporadaId', '$idCampeonato', '$dataInicio', '$dataFim')";

    $create_temporada = mysqli_query($connection, $sqlCreateTemporada);

    if (!$create_temporada) {
        echo '<b>Error ao cadastrar a temporada</b>';
    }
}
?>