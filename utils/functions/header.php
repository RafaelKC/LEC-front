<?php
    function formatMilliseconds($linkImg, $linkHome, $headerOptions) {
        return '
            <header>
                <div>
                    <h1><a class="homeLink" href="'. $linkHome.'">Liga Esportiva Curitiba</a></h1>
                <div>
                
                <div class="options">
                ';

                    while ($option = $headerOptions) {
                        if ($option['show']) {
                            echo "<a class='headerSegundario' href='".$option['link']."'>".$option['nome']."</a>";
                        }
                    };
        echo     '
                </div>
            </header>
        ';
    }

    ?>
<header>
    <div>
        <h1><a class="homeLink" href="./">Liga Esportiva Curitiba</a></h1>
        <?php
        if (isset($_SESSION['user'])) {
            if ($_SESSION['user']['type'] == 'PATROCINADOR') {
                echo '<h3>' . $_SESSION['user']['nome'] . '</h3>';
            } else {
                echo '<h3><a href="./escola?id='. $_SESSION['user']['id'].'">' . $_SESSION['user']['nome'] . '</a></h3>';
            }
        }
        ?>
    </div>
    <div class="options">
        <?php
        if (!isset($_SESSION['user'])) {
            echo '<a class="headerSegundario" href="/LEC-front/login">Login</a>';
            echo '<a class="headerSegundario" href="/LEC-front/escola/create/">Cadastrar escola</a>';
            echo '<a class="headerSegundario">Cadastrar patrocinador </a>';
        } else {
            echo '<a class="headerSegundario" href="/LEC-front/sair">Sair</a>';
        }
        echo '<a class="headerSegundario" href="/LEC-front/sobre">Sobre</a>';
        ?>
    </div>
    <div class="logoHeader">
        <img id="logo" alt="Logo LEC" src="assets/logotipo.png">
    </div>
</header>
