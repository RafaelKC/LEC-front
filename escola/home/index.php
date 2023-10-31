<?php
include('../../banco/connection.php');

$sql = "SELECT nome from tbescola";



$result = mysqli_query($connection, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../../create/styles.css">
    <link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="icon" type="image/png" href="../../assets/logotipo.png" sizes="16x16">
    <title>Cadastro de Aluno</title>
    <script type="module" src="./index.js"></script>
</head>

<body>
    <header>
        <div>
            <h1>Liga Esportiva Curitiba</h1>
        </div>
        <img id="logoHeader" alt="Logo LEC" src="../../assets/logotipo.png">
    </header>

    <main>
        <table class="tabela">
            <tr>
                <th>Escolas participantes:</th>

            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['nome'] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </main>