<?php
  include('../../banco/connection.php');

    session_start();
    if (isset($_SESSION['user'])) {
        header('Location: ../../');
    }
?>


<!DOCTYPE html>
<html lang="en">
    
    <head>
        <link rel="stylesheet" href="../../styles/fomInput.css">
        <link rel="stylesheet" href="../../styles/base.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
        <link rel="icon" type="image/png" href="../../assets/logotipo.png" sizes="16x16">
        <script type="module" src="script.js"></script>
        <title>Cadastro de Escola</title>
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
                <h3>CADASTRO DE ESCOLA</h3>
            </div>
            <div id="formulario">
                <form id="form" action="index.php" method="post" name="cadastro_escola">
                    <div id="nomeInput">
                        <div class="formInput">
                            <label for="nome">Nome </label>
                            <input type="text" id="nome" name="nome" value="">
                            <span>Aqui vai a mensagem de erro....</span>
                        </div>
                    </div>

                    <div id="emailCnpj">
                        <div class="formInput">
                            <label for="cnpj">CNPJ</label>
                            <input type="text" id="cnpj" name="cnpj" value="">
                            <span>Aqui vai a mensagem de erro....</span>
                        </div>

                        <div class="formInput">
                            <label for="email">Email</label>
                            <input type="text" id="email" name="email" value="">
                            <span>Aqui vai a mensagem de erro....</span>
                        </div>
                    </div>


                    <div id="foneContainer">
                        <div class="formInput">
                            <label for="mainTelefone">Telefone 1</label>
                            <input type="text" id="mainTelefone" name="mainTelefone" value="">
                            <span>Aqui vai a mensagem de erro....</span>
                        </div>

                        <div class="formInput">
                            <label for="secondaryTelefone">Telefone 2</label>
                            <input type="text" id="secondaryTelefone" name="secondaryTelefone" value="">
                            <span>Aqui vai a mensagem de erro....</span>
                        </div>
                    </div>

                    <div id="endereco">
                        <div class="formInput">
                            <label for="cep">CEP</label>
                            <input type="text" id="cep" name="cep" value="">
                            <span>Aqui vai a mensagem de erro....</span>
                        </div>

                        <div class="formInput">
                            <label for="logradouro">Logradouro</label>
                            <input type="text" id="logradouro" name="logradouro" value="">
                            <span>Aqui vai a mensagem de erro....</span>
                        </div>

                        <div class="formInput">
                            <label for="numeroEndereco">Numero</label>
                            <input type="number" id="numeroEndereco" name="numeroEndereco" value="">
                            <span>Aqui vai a mensagem de erro....</span>
                        </div>

                        <div class="formInput">
                            <label for="bairro">Bairro</label>
                            <input type="text" id="bairro" name="bairro" value="">
                            <span>Aqui vai a mensagem de erro....</span>
                        </div>

                        <div class="formInput">
                            <label for="cidade">Cidade</label>
                            <input type="text" id="cidade" name="cidade" value="">
                            <span>Aqui vai a mensagem de erro....</span>
                        </div>

                        <div class="formInput">
                            <label for="estado">Estado</label>
                            <input type="text" id="estado" name="estado" value="">
                            <span>Aqui vai a mensagem de erro....</span>
                        </div>

                    </div>

                    <div id="senhasForm">
                        <div class="formInput">
                            <label for="senha">Senha</label>
                            <input type="password" id="senha" name="senha" value="">
                            <span>Aqui vai a mensagem de erro....</span>
                        </div>

                        <div class="formInput">
                            <label for="confirmarSenha">Confirmar Senha</label>
                            <input type="password" id="confirmarSenha" name="confirmarSenha" value="">
                            <span>Aqui vai a mensagem de erro....</span>
                        </div>
                    </div>


                    <div id="footer">
                        <div id="passTips">
                            <ul>
                                <li>A senha deve ter ao mínimo 8 caracteres</li>
                                <li>A senha deve ter ao menos um caracter maiúsculo</li>
                                <li>A senha deve ter ao menos um caracter minusculo</li>
                                <li>A senha deve ter ao menos um caracter numérico</li>
                                <li>A senha deve ter ao menos um caracter especial</li>
                            </ul>
                        </div>
                        <div id="submmitContainer">
                            <button type="submit" id="btn" name="cadastro_escola"> Continuar </button>
                        </div>
                    </div>


                </form>
            </div>

        </div>
        <div id="capivaraFoto">
            <img alt="Capivara Mascote" src="../../assets/capivara mascote.png">
        </div>
    </main>

    <script type="module" src="script.js"></script>
</body>

</html>



<?php
        
        if(isset($_POST['cadastro_escola'])) {
            $escolaId = uniqid();
            $nome = mysqli_real_escape_string($connection, $_POST['nome']);
            $cnpj = mysqli_real_escape_string($connection, $_POST['cnpj']);
            $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
            $email = mysqli_real_escape_string($connection, $_POST['email']);
            $mainTelefone = mysqli_real_escape_string($connection, $_POST['mainTelefone']);
            $mainTelefone = preg_replace('/[^0-9]/', '', $mainTelefone);
            $secondaryTelefone = mysqli_real_escape_string($connection, $_POST['secondaryTelefone']);
            $secondaryTelefone = preg_replace('/[^0-9]/', '', $secondaryTelefone);
            $senha = mysqli_real_escape_string($connection, $_POST['senha']);
            $confirmarSenha = mysqli_real_escape_string($connection, $_POST['confirmarSenha']);

        
            $enderecoId = uniqid();
            $cep = mysqli_real_escape_string($connection, $_POST['cep']);
            $cep = preg_replace('/[^0-9]/', '', $cep);
            $logradouro = mysqli_real_escape_string($connection, $_POST['logradouro']);
            $numeroEndereco = mysqli_real_escape_string($connection, $_POST['numeroEndereco']);
            $bairro = mysqli_real_escape_string($connection, $_POST['bairro']);
            $cidade = mysqli_real_escape_string($connection, $_POST['cidade']);
            $estado = mysqli_real_escape_string($connection, $_POST['estado']);


            $sqlCreateEndereco = "INSERT INTO TBEndereco (id, cep, logradouro, bairro, cidade, uf)
                                    VALUES
                                        ('$enderecoId', '$cep', '$logradouro', '$bairro', '$cidade', '$estado');";

            $sqlCreateEscola = "INSERT INTO TBEscola (id, nome, cnpj, email, senha, telefoneUm, telefoneDois, idEndereco)
                                    VALUES
                                        ('$escolaId', '$nome', '$cnpj', '$email', '$senha', '$mainTelefone', '$secondaryTelefone', '$enderecoId');";

            $createEndereco = mysqli_query($connection, $sqlCreateEndereco);
            $createEscola = mysqli_query($connection, $sqlCreateEscola);

            if (!$createEndereco and !$createEscola ) {
                echo '<b>Error</b>';
            }
        }
        mysqli_close($connection);
?>