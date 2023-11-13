<?php
    include('../../../banco/connection.php');

    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: ../../');
    }

    if(isset($_POST['create_jogador'])) {
        $jogadorId = uniqid();
        $nome = mysqli_real_escape_string($connection, $_POST['nome']);
        $sobrenome = mysqli_real_escape_string($connection, $_POST['sobrenome']);
        $sexo = mysqli_real_escape_string($connection, $_POST['sexo']);
        $birthdate = mysqli_real_escape_string($connection, $_POST['birthdate']);
        $numeroCamisa = mysqli_real_escape_string($connection, $_POST['numeroCamisa']);
        $nomeDeJogo = mysqli_real_escape_string($connection, $_POST['nomeDeJogo']);
        $cpf = mysqli_real_escape_string($connection, $_POST['cpf']);
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        $idEscola = mysqli_real_escape_string($connection, $_POST['escola']);

        $sqlCreateJogador = "INSERT INTO TBJogador(id, idSexo, cpf, nome, sobrenome, dataNascimento, numeroCamisa, nomeJogo, idEscola)
                VALUES
                    ('$jogadorId', '$sexo', '$cpf' ,'$nome', '$sobrenome','$birthdate', '$numeroCamisa', '$nomeDeJogo', '$idEscola');";

        $createJogador = mysqli_query($connection, $sqlCreateJogador);

        if(!$createJogador){
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
                <form id="form" action="index.php" method="post" name="create_jogador">
                    <div id="nomeInput">
                        <div class="formInput">
                            <label for="nome">Nome </label>
                            <input type="text" id="nome" name="nome" value="">
                            <span>Aqui vai a mensagem de erro....</span>
                        </div>

                        <div class="formInput">
                            <label for="sobrenome">Sobrenome </label>
                            <input type="text" id="sobrenome" name="sobrenome" value="">
                            <span>Aqui vai a mensagem de erro....</span>
                        </div>
                    </div>


                    <div class="doubleContainer">
                        <div class="formInput">
                            <label for="sexo">Sexo</label>
                            <select name="sexo" id="sexo">
                            <?php
                                $sql = "SELECT * FROM LEC.TBSexo";
                                $result = mysqli_query($connection, $sql);
                                $resultCheck = mysqli_num_rows($result);
                                if($resultCheck > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo '<option value="'.$row['id'].'">'.$row['descricao'].'</option>';
                                }
                            }
                            ?>
                            </select>
                        </div>
                        <div class="formInput">
                            <label for="data de nascimento">Data de nascimento:</label>
                            <input type="date" id="data de nascimento" name="birthdate">
                            <span>Aqui vai a mensagem de erro....</span>
                        </div>
                    </div>


                    <div class="doubleContainer">
                        <div class="formInput">
                            <label for="nmrCamisa">Número da camisa</label>
                            <input type="number" id="nmrCamisa" name="numeroCamisa">
                            <span>Aqui vai a mensagem de erro....</span>
                        </div>
                        <div class="formInput">
                            <label for="nomeDeJogo">Nome de jogo</label>
                            <input type="text" id="nomeDeJogo" name="nomeDeJogo">
                            <span>Aqui vai a mensagem de erro....</span>
                        </div>
                    </div>

                    <div class="formInput">
                        <label for="cpf">CPF</label>
                        <input type="text" id="cpf" name="cpf" value="">
                        <span>Aqui vai a mensagem de erro....</span>
                    </div>

                    <div class="formInput">
                        <input type="hidden" name="escola" id="escola" value="<?php echo $_SESSION['user']['id'] ?>" />
                    </div>

                    <div class="submmitContainer">
                        <button type="submit" id="btn" name="create_jogador"> Continuar </button>
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