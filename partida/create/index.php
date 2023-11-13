<?php
include('../../banco/connection.php');
$campeonatoSelecionado = false;

session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['type'] == 'PATROCINADOR') {
    header('Location: ../');
}
?>

<?php
if (isset($_POST['create_partida'])) {
    $partidaId = uniqid();
    $EscolaMandante = mysqli_real_escape_string($connection, $_POST['escola1']);
    $EscolaVisitante = mysqli_real_escape_string($connection, $_POST['escola2']);
    $temporada = mysqli_real_escape_string($connection, $_POST['temporada']);
    $data = mysqli_real_escape_string($connection, $_POST['partidaData']);
    $duracaoMilessegundos = mysqli_real_escape_string($connection, $_POST['duracao']);;


    $sqlCreatePartida = "INSERT INTO TBPartida (id, data, duracaoMilessegundos, idMandante, idVisitante, idTemporada) VALUES ('$partidaId', '$data', $duracaoMilessegundos, '$EscolaMandante', '$EscolaVisitante', '$temporada')";
    ;


    $createPartida = mysqli_query($connection, $sqlCreatePartida);

    if (!$createPartida) {
        echo '<b>Error</b>';
    } else {
        header('Location: ../../');
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css2?family=Inter:wght@300;500&display=swap' rel='stylesheet'>
    <link rel="stylesheet" href="../../styles/base.css">
    <link rel="stylesheet" href="../../styles/fomInput.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" type="image/png" href="../../assets/logotipo.png" sizes="16x16">

    <script src="script.js"></script>

    <title>Document</title>
</head>

<body>
    <header>
        <div>
            <h1><a class="homeLink" href="../../">Liga Esportiva Curitiba</a></h1>
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
            <img id="logo" alt="Logo LEC" src="../../assets/logotipo.png">
        </div>
    </header>
    <main>
        <div class="preCadastroContainer">

            <div class="formularioContainer">
                <div class="titulo">
                    <h3>SELECIONE O CAMPEONATO</h3>
                </div>
                <div>
                    <div>
                        <div class="formInput">
                            <label for="campeonatoInput">Selecione o Campeonato</label>
                            <select name="campeonato" id="campeonatoInput" selected="<?php echo $_GET['idCampeonato']?>">
                                <?php
                                $idEscoa = $_SESSION['user']['id'];

                                $sqlCampeonato = "
                                SELECT c.id, c.nome FROM TBCampeonato c
                                JOIN TBParticipacaoCampeonato pc ON c.id = pc.idCampeonato
                                WHERE pc.idEscola = '$idEscoa'
                                AND pc.administrador = TRUE;
                                ";

                                $resultCampeonato = mysqli_query($connection, $sqlCampeonato);
                                $resultCheckCampeonato = mysqli_num_rows($resultCampeonato);
                                if ($resultCheckCampeonato > 0) {
                                    while ($rowCampeonato = mysqli_fetch_assoc($resultCampeonato)) {
                                        if ($rowCampeonato['id'] == $_GET['idCampeonato']) {
                                            echo '<option selected value="' . $rowCampeonato['id'] . '">' . $rowCampeonato['nome'] . '</option>';
                                        } else {
                                            echo '<option value="' . $rowCampeonato['id'] . '">' . $rowCampeonato['nome'] . '</option>';
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="submmitContainer">
                            <button type="button" onclick="setInputsPrecadastro()">Selecionar Campeonato</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="formularioContainer" <?php echo isset($_GET['idCampeonato']) ? '' : 'style="display: none;"'; ?>>
                <div class="titulo">
                    <h3>SELECIONE UMA TEMPORADA</h3>
                </div>
                <div>
                    <div>
                        <div class="formInput">
                            <label for="temporadaInput">Selecione um temporada:</label>
                            <select name="temporada" id="temporadaInput" selected="<?php echo $_GET['idTemporada']?>">
                                <?php
                                $idCamepeonato = $_GET['idCampeonato'];

                                $sqlTemporada = "SELECT * FROM LEC.TBTemporada WHERE idCampeonato = '$idCamepeonato';";
                                $resultTemporada = mysqli_query($connection, $sqlTemporada);
                                $resultCheckTemporada = mysqli_num_rows($resultTemporada);
                                if ($resultCheckTemporada > 0) {
                                    while ($rowTemporada = mysqli_fetch_assoc($resultTemporada)) {
                                        if ($rowTemporada['id'] == $_GET['idTemporada']) {
                                            echo '<option selected value="' . $rowTemporada['id'] . '">' . $rowTemporada['dataInicio'] . ' - ' . $rowTemporada['dataFim']. '</option>';
                                        } else {
                                            echo '<option value="' . $rowTemporada['id'] . '">' . $rowTemporada['dataInicio'] . ' - ' . $rowTemporada['dataFim']. '</option>';
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="submmitContainer">
                            <button type="button" onclick="setInputsPrecadastro()">Selecionar
                                Temporada</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="formularioContainer" <?php echo isset($_GET['idCampeonato']) && isset($_GET['idTemporada']) ? '' : 'style="display: none;"'; ?>>
            <div class="titulo">
                <h3>REGISTRO DE PARTIDA</h3>
            </div>
            <div id="formulario">
                <form id="form" class="mainForm" action="index.php" method="post" name="create_partida">
                    <div id="nomeInput">
                        <div class="formInput">
                            <label for="escola1">Selecione uma escola</label>
                            <select name="escola1" id="escola1">
                                <?php
                                $idCamepeonato = $_GET['idCampeonato'];

                                $sql = "
                                    SELECT e.nome, e.id FROM TBEscola e
                                    JOIN TBParticipacaoCampeonato pc ON e.id = pc.idEscola
                                    WHERE pc.idCampeonato = '$idCamepeonato';
                                ";
                                $result = mysqli_query($connection, $sql);
                                $resultCheck = mysqli_num_rows($result);
                                if ($resultCheck > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<option value="'. $row['id'] .'">' . $row['nome'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="formInput">
                            <label for="escola2">Selecione outra escola</label>
                            <select name="escola2" id="escola2">
                                <?php
                                $idCamepeonato = $_GET['idCampeonato'];
                                $sql = "
                                    SELECT e.nome, e.id FROM TBEscola e
                                    JOIN TBParticipacaoCampeonato pc ON e.id = pc.idEscola
                                    WHERE pc.idCampeonato = '$idCamepeonato';
                                ";
                                $result = mysqli_query($connection, $sql);
                                $resultCheck = mysqli_num_rows($result);
                                if ($resultCheck > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<option value="'. $row['id'] .'">' . $row['nome'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="formInput">
                            <label for="duracao">Duração em Milissegundos</label>
                            <input type="number" id="duracao" name="duracao">
                        </div>
                    </div>

                    <div class="formInput">
                        <label for="partidaData">Data da partida</label>
                        <input type="datetime-local" id="partidaData" name="partidaData">
                    </div>
                    <div class="submmitContainer">
                        <button type="submit" id="btn" name="create_partida"> Continuar </button>
                    </div>

                    <input type="hidden" name="temporada" value="<?php echo $_GET['idTemporada'];?>">
                </form>
    </main>
</body>

</html>


<?php
    if (isset($_GET['idCampeonato']) && isset($_GET['idTemporada'])) {
        echo '
            <script>
                const form = document.querySelector("#form.mainForm");
                const escola1 = document.getElementById("escola1");
                const escola2 = document.getElementById("escola2");
                form.addEventListener("submit", (ev) => {
                    const escola1Value = escola1.value;
                    const escola2Value = escola2.value;
            
                    console.log(escola1Value)
                    console.log(escola2Value)
            
                    if (escola1Value === escola2Value) {
                        ev.preventDefault();
                        alert("Escolha diferentes escolas");
                    }
                });
            </script>
        ';
    }
?>
