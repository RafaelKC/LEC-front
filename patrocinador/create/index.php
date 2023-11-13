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
            <h1><a class="homeLink" href="../../">Liga Esportiva Curitiba</a></h1>
        </div>
        <div class="logoHeader">
            <img id="logo" alt="Logo LEC" src="../../assets/logotipo.png">
        </div>
    </header>
    <main></main>
</body>
    

</html>