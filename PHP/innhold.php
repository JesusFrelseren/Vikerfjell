<!--Sist endret av Sindre 02.04.2017-->
<!--Sett over av Alex 02.04.2017-->
<?php
include 'startSession.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Vikerfjell Admin</title>
	<link href="CSS/style_admin.css" rel="stylesheet">
	<link href="CSS/menybar.css" rel="stylesheet">
	<link href="CSS/style_innhold.css" rel="stylesheet">
	<script defer src="JavaScript/JS.js">
	</script>
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
</head>
<!--Rad 1: Overskift-header-->
<body>
<?php

function targetMeny($id, $sql) {
	global $mysqli;
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = mysqli_fetch_assoc($result);
	return $row;
}
  include ("Include/backendmeny.php");
  include ('Include/mysqlcon.php');
$overskrift = "";
$ingress = "";
$text = "";
$rekke = "";
$idmeny = "";
$subid = "";

if (isset($_GET['id'])){
	global $mysqli;
	$idvariabel = $_GET['id'];
	$sql = "SELECT * FROM  innhold
					LEFT JOIN submeny
					ON submeny.meny_idmeny = innhold.idmeny
					WHERE idinnhold = ? AND idsubmeny IS NOT NULL;";
	$row = targetMeny($idvariabel, $sql);
	if($row == true) {
		$subID = $row['idsubmeny'];
		$sql = "SELECT tittel, ingress, text, rekke, idmeny, submeny.idsubmeny FROM innhold, submeny
						WHERE innhold.idmeny = submeny.meny_idmeny AND idsubmeny = ?;";
		$sql2 = "SELECT * FROM vikerfjell.innhold WHERE idinnhold = ?;";
		$row = targetMeny($subID, $sql);
		$row2 = targetMeny($idvariabel,$sql2);
		$overskrift = $row2['tittel'];
		$ingress = $row2['ingress'];
		$text = $row2['text'];
		$rekke = $row2['rekke'];
		$subid = $row['idsubmeny'];
		$sjekkvariabel = 2;
	} else {
		$sql = "SELECT * FROM vikerfjell.innhold WHERE idinnhold =?;";
		$row = targetMeny($idvariabel, $sql);

		$overskrift = $row['tittel'];
		$ingress = $row['ingress'];
		$text = $row['text'];
		$rekke = $row['rekke'];
		$idmeny = $row['idmeny'];
		$sjekkvariabel = 1;

}
}

?>
<!-- Hovedinnhold-->
	<div class="container">
		<div class="container">
			<div class="menyliste" id="innhold">
				<h3 style="margin: 10px 5px 10px 5px">Nytt innhold</h3>
				<form action="Include/InnholdKontroll.php" method="post" id="innholdform">
					<b style="margin-left:2%">Valg av plassering:</b>
					<?php
					  include ("Include/ListeInnholdPlassering.php");
					?>
					<b style="margin-left:2%">Rekkefølge: </b><input name="rekke" type="number" min="1" value="<?php echo($rekke) ?>">
					<input name="overskrift" value="<?php echo($overskrift) ?>" placeholder="Overskrift" title="Skriv inn overskrift på innhold" type="text"><br style="margin-bottom:12px;">
          <textarea class="ingress" form ="innholdform" placeholder="Ingress" name="ingresso" id="inng" cols="45" wrap="soft"><?php echo($ingress) ?></textarea><br style="margin-bottom:12px;">
          <textarea class="innhold" form ="innholdform" placeholder="Tekst (Innhold)" name="innholdet" id="innh" cols="45" wrap="soft"><?php echo($text) ?></textarea>
          <input name="nyttInnhold" type="submit" value="Lag nytt innhold">
					<input name="endreInnhold" type="submit" value="Oppdater innhold">
					<input name="id" type="hidden" value="<?php echo($_GET['id']) ?>">

					<h3 style="position: absolute; bottom: 10%; left:5.2%;"><?php $msg = isset($_GET['feilslett']) ? $_GET['feilslett'] : '';
					                        echo ($msg)
					                      ?></h3>
				</form>


			</div>
			<div class="menyreg" id="endre">
				<h3 style="margin: 10px;">Endre/slett innhold</h3>
        <form action="Include/InnholdKontroll.php" method="post" id="endreinnholdform">
        <?php
        include 'Include/ListeInnhold.php';
        ?>
        <div class="containerknapper">
          <input name="slettInnhold" type="submit" value="Slett innhold" onclick="return confirm('Du sletter nå et innhold på nettsiden. Vil du fortsatt slette siden?')">
        </div>
      </form>
        <!--
        <div id="login">
					<form action="" method="post">
						<p class="brukertekst">Menynavn</p><input autofocus="" name="menuname" placeholder="Menynavn" title="Skriv inn menynavn" type="text"><br style="margin-bottom:12px;">
						<p class="brukertekst">Side</p><input name="menupage" placeholder="Side" title="Skriv inn menyside" type="text"><br>
						<p class="brukertekst">Rekke</p><input name="menurow" placeholder="Rekke" title="Skriv inn menyrekke" type="text"> <input name="send" type="submit" value="Registrer meny">
						<h3><?php $msg = isset($_GET['msg']) ? $_GET['msg'] : '';
						                                  echo ($msg)
						                        ?></h3>
					</form>
				</div>
      -->
			</div>
<p style="bold"> </p>
			<div class="linkreg" id="style">
				<h3 style="margin: 10px">Formatering</h3>
				<div id="formateringstyle">
					<p style = "margin-right: 6px; margin-top: 0px; margin-bottom: 7px;">(Link til eget innhold) Intern link:</p>
					<?php
	        include 'Include/lenkerDropdown.php';
	        ?>
					<input  style="width:72%;" id="url_input" name="endreInnhold" type="text" placeholder="Legg inn link" size="40">
					<input   style="margin-top:9px; margin-left:2px;" type="submit" value="Legg til lenke" onclick="formatTextLink();" />
				</div>
				<div id="knappestyle">
					<input id="" type="submit" value="Bold" onClick="formatText ('bold');" />
					<input id="" type="submit" value="Italic" onClick="formatText ('italic');" />
                    <input id="" type="submit" value="Underline" onClick="formatText ('underline');" />
                </div>
			</div>
				<!-- <div id="knappestyle">
					<input id="" type="submit" value="Bold" onClick="formatText ('p style='bold;'');" />
					<input id="" type="submit" value="Italic" onClick="formatText ('em');" />
				</div>
				-->
			</div>
		</div>
	</div>
<script type="text/javascript">
	var idmeny = "<?php echo($idmeny); ?>"
	<?php $idyolo = "";
	if(isset($_GET['id'])){
		$idyolo = $_GET['id'];};?>
		var id = "<?php echo($idyolo); ?>";
		var sjekk = "<?php echo($sjekkvariabel); ?>";
		var idsubmeny = "<?php echo($subid); ?>";
	if(sjekk == 1) {
		document.getElementById('listetest').value = idmeny;
	} else {
		document.getElementById('listetest').value = 'SUB'+idsubmeny;
	}
	//ID på selve artikkelen - Hva brukes denne til?
	document.getElementById('listeinnhold').value = id;

	 function fyllLink() {
	    var selectBox = document.getElementById("lenkerdrop").selectedIndex;
	    //var selectedValue = selectBox.options[selectBox.selectedIndex].value;
	    var js_array = [<?php echo '"'.implode('","',  $array).'"' ?>];
	    document.getElementById('url_input').value = js_array[selectBox];
	}


</script>

 <!--
 <div id="linkreg">
                <h3>Formatering</h3>
                    <div id="input_container">
                        <input id="url_input" name="endreInnhold" type="text" placeholder="Legg inn link" size="40">
                        <input type="submit" value="Lagre" id="innhold" onclick="formatTextLink();" />
												<input type="button" value="Bold" onClick="formatText ('b');" />
												<input type="button" value="Italic" onClick="formatText ('i');" />
												<input type="button" value="Underline" onClick="formatText ('u')" />

                    </div>
            </div>
						-->
</body>
</html>
