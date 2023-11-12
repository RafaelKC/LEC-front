<?php
include("../../banco/connection.php")
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css2?family=Inter:wght@300;500&display=swap' rel='stylesheet'>
    <link rel="stylesheet" href="../../styles/fomInput.css">
    <link rel="stylesheet" href="../../styles/base.css">
    <script type="module" src="script.js"></script>
    <title>Document</title>
</head>

<body>
    <header>
        <div>
            <h1><a class="homeLink" href="../..">Liga Esportiva Curitiba</a></h1>
        </div>
        <div class="logoHeader">
            <img id="logo" alt="Logo LEC" src="../../assets/logotipo.png">
        </div>
    </header>
    <main>
        <div class="formularioContainer">
            <div class="titulo">
                <h3>Cadastro de campeonato</h1>
            </div>
            <div id="formulario">
                <form id="form" action="index.php" method="post" name="create_campeonato">
                    <div class="formInput">
                        <label for="campeonatoNome">Nome do campeonato:</label>
                        <input type="text" id="campeonatoNome" name="campeonatoNome">
                        <span>Aqui vai a mensagem de erro....</span>
                    </div>
                    <div class="submmitContainer">
                        <button type="submit" id="btn" name="create_campeonato"> Cadastrar </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php
    if (isset($_POST['create_campeonato'])) {
        $campeonatoId = uniqid();
        $nome = mysqli_real_escape_string($connection, $_POST['campeonatoNome']);


        $sqlCreateCampeonato = "INSERT INTO TBCampeonato (id, nome) VALUES ('$campeonatoId', '$nome')";


        $create_campeonato = mysqli_query($connection, $sqlCreateCampeonato);

        if (!$create_campeonato) {
            echo '<b>Error</b>';
        }
    }

    ?>