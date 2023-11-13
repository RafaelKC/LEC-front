<?php
    include('../../../banco/connection.php');

    session_start();
    if (!isset($_SESSION['user']) || empty($_GET['idJogador'])) {
        header('Location: ../../');
    }

    $idjogador = $_GET['idJogador'];
    $sqlGetJogador = "SELECT * FROM TBJogador WHERE id = '$idjogador'";
    $resultJogador = mysqli_query($connection, $sqlGetJogador);
    $jogador = mysqli_fetch_assoc($resultJogador);

    if(isset($_POST['update_jogador'])) {
        $idjogador = mysqli_real_escape_string($connection, $_POST['idJogador']);
        $nome = mysqli_real_escape_string($connection, $_POST['nome']);
        $sobrenome = mysqli_real_escape_string($connection, $_POST['sobrenome']);
        $numeroCamisa = mysqli_real_escape_string($connection, $_POST['numeroCamisa']);
        $nomeDeJogo = mysqli_real_escape_string($connection, $_POST['nomeDeJogo']);

        $sqlUpdateJogador = "
            UPDATE TBJogador
            SET nome = '$nome', sobrenome = '$sobrenome', numeroCamisa = $numeroCamisa, nomeJogo = '$nomeDeJogo'
            WHERE id = '$idjogador';
        ";

        $updateJogador = mysqli_query($connection, $sqlUpdateJogador);

        if(!$sqlUpdateJogador){
            echo '<b>Error</b>';
        } else {
            header('Location: ../../?id='.$_SESSION['user']['id']);
            exit();
        }
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../../../styles/fomInput.css">
    <link rel="stylesheet" href="../../../styles/base.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="icon" type="image/png" href="../../../assets/logotipo.png" sizes="16x16">
    <title>Cadastro de Aluno</title>
    <script type="module" src="script.js"></script>
</head>

<body>
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
                <h3>CADASTRO DE ALUNO</h3>
            </div>
            <div id="formulario">
                <form id="form" action="index.php" method="post" name="update_jogador">
                    <div id="nomeInput">
                        <div class="formInput">
                            <label for="nome">Nome </label>
                            <input type="text" id="nome" name="nome" value="<?php echo $jogador['nome'];?>">
                            <span>Aqui vai a mensagem de erro....</span>
                        </div>

                        <div class="formInput">
                            <label for="sobrenome">Sobrenome </label>
                            <input type="text" id="sobrenome" name="sobrenome" value="<?php echo $jogador['sobrenome'];?>">
                            <span>Aqui vai a mensagem de erro....</span>
                        </div>
                    </div>

                    <div class="doubleContainer">
                        <div class="formInput">
                            <label for="nmrCamisa">Número da camisa</label>
                            <input type="number" id="nmrCamisa" name="numeroCamisa" value="<?php echo $jogador['numeroCamisa'];?>">
                            <span>Aqui vai a mensagem de erro....</span>
                        </div>
                        <div class="formInput">
                            <label for="nomeDeJogo">Nome de jogo</label>
                            <input type="text" id="nomeDeJogo" name="nomeDeJogo" value="<?php echo $jogador['nomeJogo'];?>">
                            <span>Aqui vai a mensagem de erro....</span>
                        </div>
                    </div>

                    <input type="hidden" name="idJogador" value="<?php echo $jogador['id'];?>">

                    <div class="submmitContainer">
                        <button type="submit" id="btn" name="update_jogador"> Continuar </button>
                    </div>
            </div>


            </form>
        </div>

        </div>
        <div id="capivaraFoto">
            <img alt="Capivara Mascote" src="../../../assets/capivara mascote.png">
        </div>
    </main>
</body>

</html>