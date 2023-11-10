<?php
include('../../banco/connection.php');
$campeonatoSelecionado = false;

if (isset($_POST['select_campeonato'])) {
    $campeonatoSelecionado = true;
    $selectedCampeonatoId = mysqli_real_escape_string($connection, $_POST['campeonato']);

}
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
        <div id="campeonatoContainer">
            <div id="titulo">
                <h3>SELECIONE O CAMPEONATO</h3>
            </div>
            <div id="campeonatoForm">
                <form id="campeonatoSelectForm" action="index.php" method="post" name="select_campeonato">
                    <div class="formInput">
                        <label for="campeonato">Selecione o Campeonato:</label>
                        <select name="campeonato" id="campeonato">
                            <?php
                            $sqlCampeonato = "SELECT id, nome FROM LEC.TBCampeonato";
                            $resultCampeonato = mysqli_query($connection, $sqlCampeonato);
                            $resultCheckCampeonato = mysqli_num_rows($resultCampeonato);
                            if ($resultCheckCampeonato > 0) {
                                while ($rowCampeonato = mysqli_fetch_assoc($resultCampeonato)) {
                                    echo '<option value="' . $rowCampeonato['id'] . '">' . $rowCampeonato['nome'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div id="submmitContainer">
                        <button type="submit" id="selectCampeonatoBtn" name="select_campeonato">Selecionar
                            Campeonato</button>
                    </div>
                </form>
            </div>
        </div>

        <?php
        if (isset($_POST['select_campeonato'])) {
            $selectedCampeonatoId = mysqli_real_escape_string($connection, $_POST['campeonato']);

            // Agora você pode usar $selectedCampeonatoId para obter informações sobre o campeonato selecionado
        }
        ?>
        <div id="formularioContainer" <?php echo $campeonatoSelecionado ? '' : 'style="display: none;"'; ?>>
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