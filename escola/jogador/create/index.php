<?php
  include('../../../banco/connection.php');
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../../create/styles.css">
    <link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="icon" type="image/png" href="../../../assets/logotipo.png" sizes="16x16">
    <title>Cadastro de Aluno</title>
    <script type="module" src="./index.js"></script>
</head>

<body>
    <header>
        <div>
            <h1>Liga Esportiva Curitiba</h1>
        </div>
        <img id="logoHeader" alt="Logo LEC" src="../../../assets/logotipo.png">
    </header>

    <main>
        <div id="formularioContainer">
            <div id="titulo">
                <h3>CADASTRO DE ALUNO</h3>
            </div>
            <div id="formulario">
                <form id="form" name="create_jogador">
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
                            <input type="date" id="birthdate" name="birthdate">
                            <span>Aqui vai a mensagem de erro....</span>
                        </div>
                    </div>


                    <div class="doubleContainer">
                        <div class="formInput">
                            <label for="nmrCamisa">Número da camisa</label>
                            <input type="number" id="nmrCamisa" name="nmrCamisa">
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

                    <div id="submmitContainer">
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