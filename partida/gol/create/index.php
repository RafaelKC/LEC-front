<?php
include('../../../banco/connection.php');

$gameId = isset($_GET['gameId']) ? $_GET['gameId'] : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;500&display=swap');
    </style>

    <link rel="stylesheet" href="../../../styles/base.css">
    <link rel="stylesheet" href="../../../styles/fomInput.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="icon" type="image/png" href="assets/logotipo.png" sizes="16x16">
    <title>Adicionar Gols</title>
    <script type="module" src="./index.js"></script>
</head>

<body>
    <header>
        <div>
            <h1><a class="homeLink" href="../../../">Liga Esportiva Curitiba</a></h1>
            <?php
            if (isset($_SESSION['user'])) {
                echo '<h3>' . $_SESSION['user']['nome'] . '</h3>';
            }
            ?>
        </div>
        <div class="logoHeader">
            <img id="logo" alt="Logo LEC" src="../../../assets/logotipo.png">
        </div>
    </header>
    <main>
        <div class="formularioContainer">
            <div class="titulo">
                <h3>Adicionar Gols</h3>
            </div>
            <div id="formulario">
                <form id="form" action="index.php" method="post" name="add_gols">


                    <input type="hidden" name="gameId" value="<?php echo $gameId; ?>">
                    <div class="formInput">
                        <label for="idJogadorMarcou">Jogador que Marcou:</label>
                        <select name="idJogadorMarcou" id="idJogadorMarcou">
                            <?php
                            $sql = "SELECT id, nome FROM LEC.TBJogador";
                            $result = mysqli_query($connection, $sql);
                            $resultCheck = mysqli_num_rows($result);
                            if ($resultCheck > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<option value="' . $row['id'] . '">' . $row['nome'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                        <div class="formInput">
                            <label for="idJogadorAssistencia">Jogador de Assistência:</label>
                            <select name="idJogadorAssistencia">
                                <option value="">Nenhum</option>
                                <?php
                                $sql = "SELECT id, nome FROM LEC.TBJogador";
                                $result = mysqli_query($connection, $sql);
                                $resultCheck = mysqli_num_rows($result);
                                if ($resultCheck > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<option value="' . $row['id'] . '">' . $row['nome'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="formInput">
                            <label for="anulado">Anulado:</label>
                            <select name="anulado" required>
                                <option value="0">Não</option>
                                <option value="1">Sim</option>
                            </select>
                        </div>
                        <div class="formInput">
                            <label for="pnalti">Penalti:</label>
                            <select name="pnalti" required>
                                <option value="0">Não</option>
                                <option value="1">Sim</option>
                            </select>
                        </div>
                        <input type="hidden" name="tempoEmMilissegundos" value=38000>
                        <input type="hidden" name="idPartida" value="<?php echo $gameId; ?>">


                        <div class="submmitContainer">
                            <button id="btn" type="submit" name="add_gols">Adicionar Gol</button>
                        </div>
                </form>
            </div>
        </div>
    </main>
</body>

</html>

<?php
if (isset($_POST['add_gols'])) {
    $golId = uniqid();
    $idPartida = mysqli_real_escape_string($connection, $_POST['gameId']);
    $idJogadorMarcou = mysqli_real_escape_string($connection, $_POST['idJogadorMarcou']);
    $idJogadorAssistencia = mysqli_real_escape_string($connection, $_POST['idJogadorAssistencia']);
    echo "idJogadorAssistencia: $idJogadorAssistencia"; // Add this line for debugging
    if ($idJogadorAssistencia === 'null') {
        $idJogadorAssistencia = null;
    }
    $anulado = mysqli_real_escape_string($connection, $_POST['anulado']);
    $penalti = mysqli_real_escape_string($connection, $_POST['pnalti']);
    $tempo = mysqli_real_escape_string($connection, $_POST['tempoEmMilissegundos']);


    $sqlAddGols = "INSERT INTO TBGol(id, idPartida, idJogadorMarcou, idJogadorAssistencia, anulado, pnalti, tempoEmMilissegundos)
            VALUES
                ('$golId', '$idPartida', '$idJogadorMarcou' ,'$idJogadorAssistencia', '$anulado', '$penalti', '$tempo');";

    $addGols = mysqli_query($connection, $sqlAddGols);

    if (!$addGols) {
        echo '<b>Error</b>';
    }
}
mysqli_close($connection);

?>