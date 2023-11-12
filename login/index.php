<?php
    include('../banco/connection.php');
    session_start();

    if (isset($_SESSION['user'])) {
        header('Location: ../');
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../styles/fomInput.css">
    <link rel="stylesheet" href="../styles/base.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css2?family=Inter:wght@300;500&display=swap' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="icon" type="image/png" href="../assets/logotipo.png" sizes="16x16">
    <title>Login de Escola</title>
    <script type="module" src="script.js"></script>
</head>

<body>
    <header>
        <div>
            <h1>Liga Esportiva Curitiba</h1>
        </div>
        <div class="logoHeader">
            <img id="logo" alt="Logo LEC" src="../assets/logotipo.png">
        </div>
    </header>

    <main>
        <div class="formularioContainer">
            <div class="titulo">
                <h3>LOGIN</h3>
            </div>

            <div id="formulario">
                <form id="form" action="index.php" method="post" name="login">
                    <div class="formInput">
                        <label for="email">Email </label>
                        <input type="email" id="email" name="email" value="">
                        <span>Aqui vai a mensagem de erro....</span>
                    </div>

                    <div class="formInput">
                        <label for="senha">Senha </label>
                        <input type="password" id="senha" name="senha" value="">
                        <span>Aqui vai a mensagem de erro....</span>
                    </div>

                    <div class="submmitContainer">
                        <button type="submit" id="btn" name="login"> Continuar </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <div id="capivaraFoto">
        <img alt="Capivara Mascote" src="../assets/capivara%20mascote.png">
    </div>
</body>

</html>

<?php

if (isset($_POST['login'])) {
    $senha = mysqli_real_escape_string($connection, $_POST['senha']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);


    $sqlEscola = "SELECT * FROM LEC.TBEscola WHERE email = '$email' AND senha = '$senha';";
    $resultEscola = mysqli_query($connection, $sqlEscola);

    $resultEscolaCheck = mysqli_num_rows($resultEscola);
    $escola = mysqli_fetch_assoc($resultEscola);

    $sqlPatrocinador = "SELECT * FROM LEC.TBPatrocinador WHERE email = '$email' AND senha = '$senha';";
    $resultPatrocinador = mysqli_query($connection, $sqlPatrocinador);

    $resultPatrocinadorCheck = mysqli_num_rows($resultPatrocinador);
    $patrocinador = mysqli_fetch_assoc($resultPatrocinador);

    if ($resultEscolaCheck == 1) {
        $escola['type'] = 'ESCOLA';
        $_SESSION['user'] = $escola;
    } elseif ($resultPatrocinadorCheck == 1) {
        echo 'patrocinador';
        $patrocinador['type'] = 'PATROCINADOR';
        $_SESSION['user'] = $patrocinador;
    } else {
        echo '
            <script>
                const senha = document.getElementById("senha");
                const email = document.getElementById("email");
            
                function setAllFail() {
                    errorInput(email, "Email ou senha Inválidos." )
                    errorInput(senha, "Email ou senha Inválidos." )
                }
            
                function errorInput(input, message){
                    const formItem = input.parentElement
                    const textMessage = formItem.querySelector("span")
            
                    textMessage.innerText = message
            
                    formItem.className = "formInput error"
                }
            
            
                setAllFail()
            </script>
            ';
    }

    if ($resultPatrocinadorCheck == 1 || $resultEscolaCheck == 1) {
        session_write_close();
        header('Location: ../');
    }
}
mysqli_close($connection);
?>