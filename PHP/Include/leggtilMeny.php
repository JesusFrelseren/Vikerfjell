<?php
/*
Laget av Erik 30.03.2017
Sist endret 07.04.2017
*/

function lagSide() {
			ob_start();
			include 'header.php';
			include 'meny.php';
			include 'footer.php';
			$includes = ob_get_clean();
			ob_end_clean();
			return $includes;
		}
include 'mysqlcon.php';
//Henter informasjon hvor vi ser på om valgt rekke finnes
$rekke = mysqli_real_escape_string($mysqli, $_POST["menurow"]);
$sql = "SELECT * FROM vikerfjell.meny WHERE rekke >= ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $rekke);
$stmt->execute();
$result = $stmt->get_result();
//Legger til +1 på alle rekker som er lik eller over rekke som er skrevet inn av bruker
while ($row = $result->fetch_assoc())
	{
	$sql = "UPDATE vikerfjell.meny set rekke = rekke +1 where idmeny = ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('i', $row['idmeny']);
	$stmt->execute();
	}
// Variabler som blir laget utifra brukertekst
$menynavn = mysqli_real_escape_string($mysqli, $_POST['menuname']);
$menyrekke = mysqli_real_escape_string($mysqli, $_POST["menurow"]);
$typemeny = $_POST['menyliste'];
//Sjekker om begge felt er fylt ut
if ($menynavn == '' || $menyrekke == '')
	{
	header('Location: ../EndreMeny.php?fylling=Må fylle ut alle felt.');
	}
	// Sjekker om rekke er tall
elseif (!is_numeric($menyrekke))
	{
	header('Location: ../EndreMeny.php?fylling=Rekke må være tall.');
	}
  else
	{
		//Sjekker om det er hovedmeny eller om brukeren prøver å legge til submeny
	if ($typemeny == 'nymenytype')
		{
		//Legger inn hovedmeny i databasen
		$sql = "SELECT * FROM vikerfjell.meny where side =?;";
		$sql2 = "INSERT INTO meny (tekst,side, rekke) VALUES (?, ?,?)";
		sjekktittel2($sql, $sql2, $menynavn, $menynavn, $menyrekke);
		header('Location: ../EndreMeny.php');
		
		//Lager ny fil til en ny hovedmeny
		$sideInsert = "../../".$menynavn.".html";
		$fh = fopen($sideInsert, 'w');
		$includes = lagSide();
		fwrite($fh, $includes);	
		//For å legge endre .html sider utifra nymeny
		//$sql3 = "SELECT * FROM vikerfjell.meny LEFT JOIN vikerfjell.innhold USING(idmeny);"
		//$result = mysqli_query($mysqli, $sql3);


		}
	  else
		{
			//Legger inn submeny i databasen
			$sql = "SELECT * FROM vikerfjell.submeny where sub_side =?;";
			$sql2 = "INSERT INTO submeny (sub_tekst,sub_side, sub_rekke , meny_idmeny) VALUES (?, ?, ?, ?)";
			sjekktittel($sql, $sql2, $menynavn, $menynavn, $menyrekke, $typemeny);
			header('Location: ../EndreMeny.php');
			
			//Lager ny fil til en ny submeny
			$sideInsert = "../../".$menynavn.".html";
			$fh = fopen($sideInsert, 'w');
			$includes = lagSide();
			fwrite($fh, $includes);
		}
	}
//Funksjon for select og insert for submeny
function sjekktittel($sql, $sql2, $nyttnavn, $menynavn, $menyrekke, $typemeny)
	{
	global $mysqli;
	$test = "./" . $nyttnavn . ".html";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("s", $test);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
	if (!$row)
		{
		$nyttnavn = "./" . $nyttnavn . ".html";
		$stmt = $mysqli->prepare($sql2);
		$stmt->bind_param("ssii", $menynavn, $nyttnavn, $menyrekke, $typemeny);
		$stmt->execute();
		}
	  else
		{
		$tall = "1";
		$nyttnavn = $nyttnavn . $tall;
		sjekktittel($sql, $sql2, $nyttnavn, $menynavn, $menyrekke, $typemeny);
		}
	}
//Funksjon for select og insert for hovedmeny
function sjekktittel2($sql, $sql2, $nyttnavn, $menynavn, $menyrekke)
	{
	global $mysqli;
	$test = $nyttnavn . ".html";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("s", $test);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
	if (!$row)
		{
		$stmt = $mysqli->prepare($sql2);
		$nyttnavn = $nyttnavn . ".html";
		$stmt->bind_param("ssi", $menynavn, $nyttnavn, $menyrekke);
		$stmt->execute();
		}
	  else
		{
		$tall = "1";
		$nyttnavn = $nyttnavn . $tall;
		sjekktittel2($sql, $sql2, $nyttnavn, $menynavn, $menyrekke);
		}
	}

?>