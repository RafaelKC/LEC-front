<?php
include('../../banco/connection.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css2?family=Inter:wght@300;500&display=swap' rel='stylesheet'>
    <link rel="stylesheet" href="../../styles/fomInput.css">
    <link rel="stylesheet" href="../../styles/base.css">
    <title>Document</title>
</head>

<body>
    <header>
        <div>
            <h1>Liga Esportiva Curitiba</h1>
        </div>
        <img id="logoHeader" alt="Logo LEC" src="../../assets/logotipo.png">
    </header>
    <main>
        <div id="formularioContainer">
            <div id="titulo">
                <h3>REGISTRO DE PARTIDA</h3>
            </div>
            <div id="formulario">
                <form id="form" action="index.php" method="post" name="create_partida">
                    <div id="nomeInput">
                        <div class="formInput">
                            <label for="nome">Selecione uma escola</label>
                            <select name="escola1" id="escola1">
                                <?php
                                $sql = "SELECT nome FROM LEC.TBEscola";
                                $result = mysqli_query($connection, $sql);
                                $resultCheck = mysqli_num_rows($result);
                                if ($resultCheck > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<option value="' . '">' . $row['nome'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="formInput">
                            <label for="nome">Selecione outra escola</label>
                            <select name="escola2" id="escola2">
                                <?php
                                $sql = "SELECT nome FROM LEC.TBEscola";
                                $result = mysqli_query($connection, $sql);
                                $resultCheck = mysqli_num_rows($result);
                                if ($resultCheck > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<option value="' . '">' . $row['nome'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="formInput">
                        <label for="data">Data da partida</label>
                        <input type="date" id="partidaData" name="partidaData">
                    </div>
                    <div id="submmitContainer">
                        <button type="submit" id="btn" name="create_partida"> Continuar </button>
                    </div>
    </main>
</body>

</html>

<?php
if (isset($_POST['create_partida'])) {
    $partidaId = uniqid();
    $EscolaMandante = mysqli_real_escape_string($connection, $_POST['escola1']);
    $EscolaVisitante = mysqli_real_escape_string($connection, $_POST['escola2']);
    $data = mysqli_real_escape_string($connection, $_POST['partidaData']);
    $duracaoMilessegundos = 5400;


    $sqlCreatePartida = "INSERT INTO TBPartida (id, data, duracaoMilessegundos, idMandante, idVisitante, idTemporada) VALUES ('$partidaId', '$data', $duracaoMilessegundos, '$EscolaMandante', '$EscolaVisitante', '31bfd9e1-7dc0-11ee-8657-02506150e648')";
;


    $createPartida = mysqli_query($connection, $sqlCreatePartida);

    if (!$createPartida) {
        echo '<b>Error</b>';
    }
}
?>