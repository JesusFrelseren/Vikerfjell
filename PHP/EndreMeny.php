<?php
/*
Laget av Erik 01.03.2017
Sist endret 19.04.2017
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
	<link href="CSS/testEndreMeny.css" rel="stylesheet">
	<script defer src="JavaScript/JS.js">
	</script>
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
</head><!--Rad 1: Overskift-header-->
<body>
<?php
  include ('Include/mysqlcon.php');
$Menynavn = "";
$Rekke = "";

//Funksjon for spørring
function targetMeny($id, $sql) {
	global $mysqli;
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = mysqli_fetch_assoc($result);
	return $row;
}

//Ser om vi får id
if (isset($_GET['id'])){
	global $mysqli;
	$idvariabel = $_GET['id'];
	$Menynavn = '';
	$Rekke = '';
	$idmeny = '';
	$subid = '';
	$sjekkvariabel = 0;
	//Sjekker om det er en submeny eller hovedmeny
	if (strpos($idvariabel, 'SUB') !== false)  {
		$subid = substr($idvariabel, 3);
		$sql = "SELECT * FROM vikerfjell.submeny WHERE idsubmeny = ?;";
		$row = targetMeny($subid, $sql);
		$Menynavn = $row['sub_tekst'];
		$Rekke = $row['sub_rekke'];
		$idmeny = $row['idsubmeny'];
		$row = targetMeny($subid, $sql);
		$sjekkvariabel = 2;
	} else {
		$sql = "SELECT * FROM vikerfjell.meny WHERE idmeny = ?;";
		$row = targetMeny($idvariabel, $sql);
		$Menynavn = $row['tekst'];
		$Rekke = $row['rekke'];
		$idmeny = $row['idmeny'];	
		$sjekkvariabel = 1;
	}
	mysqli_close($mysqli);
}
?>

	<?php
		include ("Include/backendmeny.php");
	?>
	</nav><!-- Hovedinnhold-->
	<div class="container">
</nav><!-- Hovedinnhold-->
	<!-- Menyregistrering -->
	<div class="menyreg">
			<h3 style="margin: 5px;">Nytt meny element</h3>
			<div id="login">
				<form action="Include/leggtilMeny.php" method="post">
				<p class="brukertekst">Type meny</p>
						<?php 
							include 'Include/listeNyMeny.php';
						?>

					<p class="brukertekst">Menynavn</p>
						<input placeholder="Menynavn" autofocus="" name="menuname" title="Skriv inn menynavn" type="text"><br style="margin-bottom:12px;">
					<p class="brukertekst">Rekke</p>
						<input placeholder="Rekke" name="menurow" title="Skriv inn menyrekke" type="number" min="1">

						<div class="regmeny">
							<input class="listemenyer" name="send" type="submit" value="Registrer meny">
						</div>
						
					<h3 style="position: absolute; bottom: 15%; left:35.2%;"><?php $msg = isset($_GET['fylling']) ? $_GET['fylling'] : '';
				        echo ($msg)
				      ?></h3>
				</form>
			</div>
		</div>

		<!-- Lister opp meny med mulighet for sletting -->
		<div class="menyliste" id="liste">
			<h3 style="margin: 5px">Menyliste</h3>
			<form action="slettMeny.php" method="post">	
				

				<input onclick="return confirm('Sikker på at du vil slette menyen?')" class="slettmenycss" name="slett" type="submit" value="Slett meny"> 
				
				<?php
				  include 'Include/ListeMeny.php';
				?>
				<h3 style="position: absolute; bottom: 10%; left:5.2%;"><?php $msg = isset($_GET['feilslett']) ? $_GET['feilslett'] : '';
				        echo ($msg)
				?></h3>
			</form>

			<!-- Form for å endre valgt meny -->
			<form action="Include/endresideinclude.php" method="post">
				<div id="endremeny">	
					<p class="brukertekst"> Menynavn </p>				
					<input value="<?php echo($Menynavn) ?>" id='idtest' class="meny1" placeholder="Menynavn" autofocus name="namemenu" title="Skriv inn menynavn" type="text">
						
					<br style="margin-bottom:12px;">
					<p class="brukertekst"> Rekke </p>
					<input value="<?php echo($Rekke) ?>" id='idrowmenu' class="meny3" placeholder="Rekke" autofocus="" name="rowmenu" title="Skriv inn meny rekke" type="number">
						
					<br style="margin-bottom:12px;">
					<input onclick="return confirm('Sikker på at du vil endre menyen?')" class="endremenycss" name="endre" type="submit" value="Endre meny"> 
					<h3 style="position: absolute; bottom: 30%; left:2%;"><?php $msg = isset($_GET['feilendring']) ? $_GET['feilendring'] : '';
				        echo ($msg)
					?></h3>
					<?php 
						include 'Include/endresideinclude.php';
					?>
				</div>
<!-- JavaScript som setter plassering tilbake på gammel valgt meny fra listen -->
<script type="text/javascript"> 
	var idmeny = "<?php echo($idmeny); ?>";
	var idsubmeny = "<?php echo($subid); ?>";
	var sjekk = "<?php echo($sjekkvariabel); ?>";
	if(sjekk == 1) {
		document.getElementById('listetest').value = idmeny;
	} else {
		document.getElementById('listetest').value = 'SUB'+idsubmeny;
	}
</script>
<!-- Gjemte variabler for som blir hentet i endresideinclude.php for sjekking -->
		<input name="sjekkres" type="hidden" value="<?php echo($sjekkvariabel) ?>">
		<input name="getID" type="hidden" value="<?php echo($idmeny) ?>">
		</form>

		</div>
	</div>
</body>
</html>