<?php
include('../banco/connection.php');
$campeonatoSelecionado = false;

session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['type'] == 'PATROCINADOR') {
    header('Location: ../');
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css2?family=Inter:wght@300;500&display=swap' rel='stylesheet'>
    <link rel="stylesheet" href="../styles/base.css">
    <link rel="stylesheet" href="../styles/fomInput.css">
    <link rel="stylesheet" href="./styles.css">
    <link rel="icon" type="image/png" href="../assets/logotipo.png" sizes="16x16">

    <script src="script.js"></script>

    <title>Document</title>
</head>

<body>
    <header>
        <div>
            <h1>Liga Esportiva Curitiba</h1>
            <?php
            if (isset($_SESSION['user'])) {
                echo '<h3>'.$_SESSION['user']['nome'].'</h3>';
            }
            ?>
        </div>
        <div class="options">
            <?php
            if (!isset($_SESSION['user'])) {
                echo '<a class="headerSegundario" href="/LEC-front/login">Login</a>';
                echo '<a class="headerSegundario" href="/LEC-front/escola/create/">Cadastrar escola</a>';
                echo '<a class="headerSegundario">Cadastrar patrocinador </a>';
            } else {
                echo '<a class="headerSegundario" href="/LEC-front/sair">Sair</a>';
            }
            echo '<a class="headerSegundario" href="/LEC-front">Home</a>';
            ?>
        </div>
        <div class="logoHeader">
            <img id="logo" alt="Logo LEC" src="../assets/logotipo.png">
        </div>
    </header>
    <main>
        <div class="preCadastroContainer">

            <div id="formularioContainer">
                <div id="titulo">
                    <h3>SELECIONE O CAMPEONATO</h3>
                </div>
                <div id="campeonatoForm">
                    <div id="campeonatoSelectForm">
                        <div class="formInput">
                            <label for="campeonato">Selecione o Campeonato:</label>
                            <select name="campeonato" id="campeonatoInput">
                                <?php
                                $idCamepeonato = $_GET['idCampeonato'];
                                $sqlCampeonato = "
                                SELECT c.id, c.nome FROM TBCampeonato c
                                JOIN TBParticipacaoCampeonato pc ON c.id = pc.idCampeonato
                                WHERE pc.idEscola = '$idCamepeonato'
                                AND pc.administrador = TRUE;
                                ";
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
                            <button onclick="setInputsPrecadastro()">Selecionar Campeonato</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="formularioContainer" <?php echo isset($_GET['idCampeonato']) ? '' : 'style="display: none;"'; ?>>
                <div id="titulo">
                    <h3>SELECIONE UMA TEMPORADA</h3>
                </div>
                <div>
                    <div>
                        <div class="formInput">
                            <label for="temporada">Selecione um temporada:</label>
                            <select name="temporada" id="temporadaInput">
                                <?php
                                $idCamepeonato = $_GET['idCampeonato'];

                                $sqlTemporada = "SELECT * FROM LEC.TBTemporada WHERE idCampeonato = '$idCamepeonato';";
                                $resultTemporada = mysqli_query($connection, $sqlTemporada);
                                $resultCheckTemporada = mysqli_num_rows($resultTemporada);
                                if ($resultCheckTemporada > 0) {
                                    while ($rowTemporada = mysqli_fetch_assoc($resultTemporada)) {
                                        echo '<option value="' . $rowTemporada['id'] . '">' . $rowTemporada['dataInicio'] . ' - ' . $rowTemporada['dataFim']. '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div id="submmitContainer">
                            <button onclick="setInputsPrecadastro()">Selecionar
                                Temporada</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="formularioContainer" <?php echo isset($_GET['idCampeonato']) && isset($_GET['idTemporada']) ? '' : 'style="display: none;"'; ?>>
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