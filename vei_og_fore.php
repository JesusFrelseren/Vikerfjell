<!--
Sist endret av Sindre 06.04.2017
Sett på av Erik 03.03.2017
-->

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vikerfjell</title>
  <link type="text/css" href="PHP/CSS/frontend_header.css?v=12345" rel="stylesheet">
  <link type="text/css" href="PHP/CSS/frontend_slider.css?v=12345" rel="stylesheet">
  <link type="text/css" href="PHP/CSS/frontend_mediaquerys.css?v=12345" rel="stylesheet">
  <link type="text/css" href="PHP/CSS/frontend_footer_new.css?v=12345" rel="stylesheet">
  <link type="text/css" href="PHP/CSS/menybar.css?v=12345" rel="stylesheet">
  <link type="text/css" href="PHP/CSS/Oversikt.css" rel="stylesheet">
  <script src="PHP/JavaScript/JS.js?v=12345" type="text/javascript" defer></script>
</head>
<body>
  <?php
  include("PHP/Include/header.php");
  include("PHP/Include/meny.php");
  ?>
  <!--Sindre 05.04.2017-->
  <div class="content100Prosent">
		<h1>Vei og føre</h1>
    <?php
    include('/PHP/Include/Oversiktsporring.php');
    ?>	
	</div>
  <?php
 	 include("PHP/Include/footer.php");
  ?>
</body>
</html>
