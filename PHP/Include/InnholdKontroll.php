<?php
/*
Sist endret av Sindre 30.03.2017
Sist sett på av Erlend 30.03.2017
*/

include("mysqlcon.php");

function legg_til_side($tittel, $ingress, $tekst, $rekke, $side, $idmeny) {
    global $mysqli;
    $sql = "insert into innhold(tittel, ingress, text, rekke, side, idmeny)
              values(?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('sssisi', $tittel, $ingress, $tekst, $rekke, $side, $idmeny);
    $stmt->execute();
}

function rediger_side(string $tittel, string $ingress, string $tekst, $side, int $idinnhold) {
    global $mysqli;
    $sql = "
UPDATE innhold
SET ingress = $ingress
WHERE idinnhold = $idinnhold;

UPDATE innhold
SET tittel = $tittel
WHERE idinnhold = $idinnhold;

UPDATE innhold
SET text = $tekst
WHERE idinnhold = $idinnhold;

UPDATE innhold
SET side = $side
WHERE idinnhold = $idinnhold;";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('sssi', $tittel, $ingress, $tekst, $idinnhold);
    $stmt->execute();
}

// Sist endret av Sindre og Alex 29.03.2017

function Endre_Rekke($idmeny, $rekke){
global $mysqli;
$sql = "SELECT * FROM vikerfjell.innhold WHERE idmeny = ? and rekke >= ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ii',$idmeny,$rekke);
    $stmt->execute();
    $result = $stmt->get_result();


    while($row = $result->fetch_assoc()) {
      $sql = "UPDATE innhold set rekke = rekke +1 where idinnhold = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i',$row['idinnhold']);
    $stmt->execute();
    }
}

function Slett_Innhold($idinnhold){
  global $mysqli;
  $sql = "DELETE FROM innhold WHERE idinnhold = ?";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param('i', $idinnhold);
  $stmt->execute();
}

// Sjekker om sidenavn finnes, hvis det gjør det blir det lagt til et tall og kjøres på nytt.
function sjekk_navn($navn){
  global $mysqli;

  $hvasomhelst = $navn.".php";

  $stmt = $mysqli->prepare("SELECT * FROM vikerfjell.innhold WHERE side=?");
  $stmt->bind_param("s",$hvasomhelst);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

if(!$row){
  legg_til_side($_POST['overskrift'],$_POST['ingresso'],$_POST['innholdet'],$_POST['rekke'],$navn.".php",$_POST['menylistephp']);
  include("innholdinclude.php");
   header("location: ../innhold.php");
}else{
  $tall ="1";
  $side2 = $navn.$tall;
  sjekk_navn($side2);
}
}

// Kjører nytt innhold, med en sjekk på om sidenavn finnes.
if(isset($_POST['nyttInnhold'])){
  $side = $_POST['overskrift'];
  Endre_Rekke($_POST['menylistephp'],$_POST['rekke']);
  sjekk_navn($side);
}

//Sletting av innhold
if(isset($_POST['slettInnhold'])){
  Slett_Innhold($_POST['menylistephp']);
  header("location: ../innhold.php");
}

function Endre_Innhold($tittel, $ingress, $text, $rekke, $idmeny, $idinnhold){
global $mysqli;
$sql = "UPDATE vikerfjell.innhold SET tittel=?,ingress=?,text=?,rekke=?,idmeny=? WHERE idinnhold =?;";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('ssssss',$tittel,$ingress,$text,$rekke,$idmeny, $idinnhold);
$stmt->execute();
mysqli_close($mysqli);
}

if(isset($_POST['endreInnhold'])){
  Endre_Innhold($_POST['overskrift'],$_POST['ingresso'],$_POST['innholdet'],$_POST['rekke'],$_POST['menylistephp'],$_POST['id']);
  header("location: ../innhold.php");
}

function legg_til_link(string $url, string $tekst, string $idmeny, string $idsubmeny) {
    global $mysqli;
    $stmt = $mysqli->prepare(
            "INSERT INTO link(url, link_tekst, idmeny, idsubmeny)
              VALUES(?, ?, ?, ?)");

    $stmt->bind_param('ii', $idmeny, $idsubmeny);
    $stmt->execute();

}
