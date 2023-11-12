<?php
    session_start();
    include('../banco/connection.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500&display=swap"
      rel="stylesheet"
    /><link rel="stylesheet" href="../styles/base.css">
    <link rel="stylesheet" href="styles.css" />
  </head>
  <body>
    <header>
        <div>
            <h1><a class="homeLink" href="../">Liga Esportiva Curitiba</a></h1>
            <?php
            if (isset($_SESSION['user'])) {
                echo '<h3>' . $_SESSION['user']['nome'] . '</h3>';
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
            echo '<a class="headerSegundario" href="/LEC-front">Home</a>';
            ?>
        </div>
        <div class="logoHeader">
            <img id="logo" alt="Logo LEC" src="../assets/logotipo.png">
        </div>
    </header>
    <main>
      <section id="sobre" class="section">
        <div class="container">
          <div class="section-header">
            <h2>Sobre a Liga Esportiva Curitiba</h2>
          </div>
          <div class="section-content">
            <p>
              Bem-vindo ao Liga Esportiva Curitiba, a plataforma líder em
              competições escolares e eventos esportivos para estudantes e
              instituições de ensino. Nosso site foi projetado com o propósito
              de proporcionar uma experiência única para a comunidade
              educacional, promovendo a competição saudável e o desenvolvimento
              pessoal de alunos de todas as idades.
            </p>
            <p>Nossos principais recursos incluem:</p>
            <ul>
              <li>
                Organização de Campeonatos Escolares: No LEC, oferecemos uma
                plataforma centralizada para a organização de campeonatos
                escolares de diversas modalidades esportivas, partidas de
                conhecimento, arte e muito mais. Escolas de toda Curitiba podem
                inscrever suas equipes e competir em torneios emocionantes.
              </li>
              <li>
                Cadastro de Alunos e Instituições: Alunos e instituições de
                ensino podem facilmente se cadastrar em nosso site. Os alunos
                podem criar seus perfis individuais, fornecendo informações
                relevantes sobre suas habilidades e interesses esportivos,
                enquanto as instituições de ensino podem se cadastrar para se
                conectar com outras escolas e promover competições locais e
                regionais.
              </li>
              <li>
                Participação em Campeonatos: Alunos podem se inscrever em
                campeonatos de sua escolha, formar equipes e competir contra
                outras instituições. Nossa plataforma simplifica o processo de
                inscrição e permite que os participantes se concentrem no que
                mais importa: competir e se superar.
              </li>
              <li>
                Criação de Campeonatos Personalizados: Para instituições que
                desejam criar seus próprios campeonatos e eventos exclusivos,
                oferecemos ferramentas de criação de campeonatos personalizados.
                Isso permite que as escolas organizem competições sob medida
                para suas necessidades e objetivos específicos.
              </li>
            </ul>
            <p>
              No LEC, acreditamos que a competição saudável e o espírito
              esportivo são fundamentais para o crescimento e desenvolvimento
              dos estudantes. Estamos comprometidos em fornecer uma plataforma
              segura e confiável para que escolas e alunos de todas as idades
              participem, criem laços e se destaquem em competições escolares.
              Junte-se a nós hoje e faça parte dessa emocionante jornada de
              aprendizado, amizade e conquistas!
            </p>
          </div>
        </div>
      </section>
    </main>
  </body>
</html>
