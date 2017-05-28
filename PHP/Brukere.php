<?php
/*
Laget av Erik 16.02.2017
Sist endret 12.03.2017
*/
include 'startSession.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vikerfjell Admin</title>
    <link href="CSS/style_admin.css" rel="stylesheet">
    <link href="CSS/menybar.css" rel="stylesheet">
    <link href="CSS/brukere.css" rel="stylesheet">
    <script defer src="JavaScript/JS.js">
    </script>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
</head><!--Rad 1: Overskift-header-->
<body>
<?php
include ("Include/backendmeny.php");
?>
</nav><!-- Hovedinnhold-->
<div class="container">
    <div class="listebruker" id="liste">
        <h3 style="margin: 5px">Liste over brukere</h3>
        <form action="slettbruker.php" method="post">
            <input onclick="return confirm('Sikker på at du vil slette valgt bruker?')" name="slett" type="submit" value="Slett bruker">
            <?php
            include 'Include/listebruker.php';
            ?>
            <h3 style="position: absolute; bottom: 10%; left:5.2%;"><?php $msg = isset($_GET['feilslett']) ? $_GET['feilslett'] : '';
                echo ($msg)
                ?></h3>
        </form>
    </div>
    <div class="listenybruker">
        <h3 style="margin: 5px;">Ny bruker</h3>
        <div id="login">
            <form action="nybruker.php" method="post">
                <p class="brukertekst">Brukernavn</p>
                <input placeholder="Brukernavn" autofocus="" name="username" title="Skriv inn ditt brukernavn" type="text"><br style="margin-bottom:12px;">
                <p class="brukertekst">Passord</p>
                <input placeholder="Passord" name="password" title="Skriv inn ditt passord" type="password"><br>
                <p class="brukertekst">E-Post</p>
                <input placeholder="E-Post" name="mail" title="Skriv inn din email" type="mail"> <input name="send" type="submit" value="Registrer">
                <h3><?php $msg = isset($_GET['msg']) ? $_GET['msg'] : '';
                    echo ($msg)
                    ?></h3>
            </form>
        </div>
    </div>
</div>
</body>
</html>
