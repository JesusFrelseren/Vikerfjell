<!--Sist endret av Alex 16.02.2017-->
<!--Sett over av Erlend 16.02.2017-->
<?php
include 'startSession.php';
?>

<!DOCTYPE html>
<html>
  <head>
  <meta charset="UTF-8">
  <title>Vikerfjell Admin</title>
  <link rel="stylesheet" href="CSS/style_admin.css">
  <link rel="stylesheet" href="CSS/menybar.css">
  <link rel="stylesheet" href="CSS/brukere.css">
  <script src="JavaScript/JS.js" defer></script>
  <script src="JavaScript/JS.js" defer></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="CSS/AdminEndre.css">
  </head>




 <body>
  <?php
    include 'Include/backendmeny.php';
  ?>
  <div id="wrapEndre">

  <div id="login">
      <form name='form-login' method="POST" action="endrePW.php">
      <H2>Endre passord</H2>
      <br/>
        <input type="password" name="oldpw" autofocus title="Skriv inn ditt brukernavn" placeholder="Gammelt passord">
        <br/>
        <input type="password" name="newpw" title="Skriv inn ditt brukernavn" placeholder="Nytt passord">
        <br/>
        <input type="password" name="confirmpw" title="Skriv inn ditt passord" placeholder="Gjenta Passord">
        <input type="submit" name="Endre" value="Endre passord">
        <h3><?php $msg = isset($_REQUEST['msg']) ? $_REQUEST['msg'] : '';
         echo ($msg)?></h3>
      </form>
  </div>

  </body>
</html>
