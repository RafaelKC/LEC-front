<?php
include('../../../banco/connection.php');
session_start();
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
                <form id="form" action="process_goals.php" method="post">

                    <div class="formInput">
                        <label for="idJogadorMarcou">Jogador que Marcou:</label>

                        <input type="text" name="idJogadorMarcou">
                    </div>
                    <div class="formInput">
                        <label for="idJogadorAssistencia">Jogador de Assistência:</label>

                        <input type="text" name="idJogadorAssistencia">
                    </div>
                    <div class="formInput">
                        <label for="anulado">Anulado:</label>
                        <select name="anulado">
                            <option value="0">Não</option>
                            <option value="1">Sim</option>
                        </select>
                    </div>
                    <div class="formInput">
                        <label for="pnalti">Penalti:</label>
                        <select name="pnalti">
                            <option value="0">Não</option>
                            <option value="1">Sim</option>
                        </select>
                    </div>
                    <div class="formInput">
                        <label for="tempoEmMilissegundos">Tempo de Jogo (ms):</label>
                        <input type="number" name="tempoEmMilissegundos">
                    </div>
                    <input type="hidden" name="idPartida" value="<?php echo $_GET['id']; ?>">










                    <div class="submmitContainer">
                        <button id="btn" type="submit">Adicionar Gol</button>
                    </div>

                </form>
            </div>
        </div>




    </main>
</body>

</html>