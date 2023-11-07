<?php
include('../../banco/connection.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../../styles/fomInput.css">
    <link rel="stylesheet" href="../../styles/base.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css2?family=Inter:wght@300;500&display=swap' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="icon" type="image/png" href="../../assets/logotipo.png" sizes="16x16">
    <title>Login de Escola</title>
    <script type="module" src="script.js"></script>
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

                    <div id="submmitContainer">
                        <button type="submit" id="btn" name="login"> Continuar </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <div id="capivaraFoto">
        <img alt="Capivara Mascote" src="../../assets/capivara mascote.png">
    </div>
</body>

</html>


<?php

if (isset($_POST['login'])) {
    $senha = mysqli_real_escape_string($connection, $_POST['senha']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);


    $sql = "SELECT * FROM LEC.TBEscola WHERE email = '$email' AND senha = '$senha';";
    $result = mysqli_query($connection, $sql);

    $resultCheck = mysqli_num_rows($result);
    $user = mysqli_fetch_assoc($result);

    if ($resultCheck == 1 and $connection->query($sql)) {
        echo $user['id'];
    }
    echo '<script type="text/javascript">
                setAllFail()
            </script>';
}
mysqli_close($connection);
?>