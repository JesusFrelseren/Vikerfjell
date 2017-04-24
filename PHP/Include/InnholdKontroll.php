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
function skriv_bilder_til_base($POST, $FILES, $width_src, $height_src)  {
        global $mysqli;
    $tekst = $POST['bildebeskrivelse'];
    $thumb = "thumb_".pathinfo($FILES['upload']['name'], PATHINFO_BASENAME);
    $hvor = pathinfo($FILES['upload']['name'], PATHINFO_BASENAME);
    $bredde = $width_src;
    $høyde = $height_src;
    $tooltip = "Fuck tooltips";
    $alt = "Bildet ble ikke funnet :´(";
    $stmt = $mysqli->prepare("
      INSERT INTO vikerfjell.bilder(hvor, tekst, thumb, bredde, hoyde, tooltip, alt)
      VALUES(?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param('sssiiss', $hvor, $tekst, $thumb, $bredde, $høyde, $tooltip, $alt);
    $stmt->execute();    $mysqli->close();


}

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

//Slett innhold funksjon
function Slett_Innhold($idinnhold){
  global $mysqli;
  $sql = "DELETE FROM innhold WHERE idinnhold = ?";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param('i', $idinnhold);
  $stmt->execute();
}

// Sjekker om sidenavn finnes, hvis det gjør det blir det lagt til et tall og kjøres på nytt.
/*Endret av Alex 07.04.2017 */
function sjekk_navn($navn){
  global $mysqli;

  $hvasomhelst = $navn.".html";
  //Sjekker om side finnes fra før
  $stmt = $mysqli->prepare("SELECT * FROM vikerfjell.innhold WHERE side=?");
  $stmt->bind_param("s",$hvasomhelst);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

//Erik 21.04
//For å legge inn artikkel til submeny må vi teste value'n til menyen vi har lagt til for å se om det er en SUB eller ikke
//Hvis SIDE ikke finnes fra før
if(!$row){
  $subID = "";
  $id = $_POST['menylistephp'];
  //Sjekker om verdien inneholder SUB
  	if(strpos($id, 'SUB') !== false) { 
      $nymenyid = substr($id,3);
      $sql = "SELECT meny_idmeny FROM vikerfjell.submeny WHERE idsubmeny = ?";
      $stmt = $mysqli->prepare($sql);
      $stmt->bind_param("s", $nymenyid);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      if($row) {
        $subID = $row['meny_idmeny'];
      }
      //Legger til artikkel på submeny
      legg_til_side($_POST['overskrift'],$_POST['ingresso'],$_POST['innholdet'],$_POST['rekke'],$navn.".html",$subID);
      include 'KobleOgLagInnholdFiler.php';
    } else {
      //Legger til artikkel på hovedmeny
      legg_til_side($_POST['overskrift'],$_POST['ingresso'],$_POST['innholdet'],$_POST['rekke'],$navn.".html",$_POST['menylistephp']);
      include 'KobleOgLagInnholdFiler.php';
    }
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

//Funksjon for endring av innhold
function Endre_Innhold($tittel, $ingress, $text, $rekke, $idmeny, $idinnhold){
  global $mysqli;
  $sql = "UPDATE vikerfjell.innhold SET tittel=?,ingress=?,text=?,rekke=?,idmeny=? WHERE idinnhold =?;";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param('ssssss',$tittel,$ingress,$text,$rekke,$idmeny, $idinnhold);
  $stmt->execute();
  mysqli_close($mysqli);
}


  if(isset($_POST['endreInnhold'])){
    //Endret erik 21.04
    //Escaper verdiene brukeren skriver inn
    $overskrift = mysqli_real_escape_string($mysqli, $_POST["overskrift"]);
    $ingress = mysqli_real_escape_string($mysqli, $_POST["ingresso"]);
    $innhold = mysqli_real_escape_string($mysqli, $_POST["innholdet"]);
    $rekke = mysqli_real_escape_string($mysqli, $_POST["rekke"]);
    $idmeny = mysqli_real_escape_string($mysqli, $_POST["menylistephp"]);
    $id = mysqli_real_escape_string($mysqli, $_POST['id']);
    //Sjekker om artikkelen er koblet til en submeny
    if(strpos($idmeny, "SUB") !== false) {
      //Endrer hvis submeny er valgt
      $nyid = substr($idmeny, 3);
      $sql = "SELECT tittel, ingress, text, rekke, idmeny, submeny.idsubmeny FROM innhold, submeny 
              WHERE innhold.idmeny = submeny.meny_idmeny AND idsubmeny = ? ;";
      $stmt = $mysqli->prepare($sql);
      $stmt->bind_param("i", $nyid);
      $stmt->execute();
      $res = $stmt->get_result();
      $row = $res->fetch_assoc();
      $sisteID = $row['idmeny'];
      Endre_Innhold($overskrift ,$ingress,$innhold,$rekke,$sisteID,$id);
    } else {
      //Endrer hvis hovedmeny er valgt
      Endre_Innhold($overskrift ,$ingress,$innhold,$rekke,$idmeny,$id);
    }
    
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
