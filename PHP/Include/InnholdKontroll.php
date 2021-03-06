<?php
/*
Sist endret av Sindre 30.03.2017
Sist sett på av Erlend 30.03.2017
*/

include("mysqlcon.php");

function legg_til_side($tittel, $ingress, $tekst, $rekke, $side, $idmeny, $idsubmeny) {
    global $mysqli;
    $sql = "insert into innhold(tittel, ingress, tekst, rekke, side, idmeny, idsubmeny)
              values(?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('sssisii', $tittel, $ingress, $tekst, $rekke, $side, $idmeny, $idsubmeny);
    $stmt->execute();
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

    $sql = "DELETE FROM bilderinnhold WHERE _idinnhold = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $idinnhold);
    $stmt->execute();

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
        $navnet = $hvasomhelst;
        //Sjekker om verdien inneholder SUB
        if(strpos($id, 'SUB') !== false) {
            $nymenyid = substr($id,3);
            $sql = "SELECT meny_idmeny, idsubmeny FROM vikerfjell.submeny WHERE idsubmeny = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("s", $nymenyid);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            if($row) {
                $subID = $row['meny_idmeny'];
                $submenyid = $row['idsubmeny'];
            }
            //Legger til artikkel på submeny
            legg_til_side($_POST['overskrift'],$_POST['ingresso'],$_POST['innholdet'],$_POST['rekke'],$navnet,$subID, $submenyid);
            include 'KobleOgLagInnholdFiler.php';
        } else {
            //Legger til artikkel på hovedmeny
            $idsub = NULL;
            legg_til_side($_POST['overskrift'],$_POST['ingresso'],$_POST['innholdet'],$_POST['rekke'],$navnet,$_POST['menylistephp'], $idsub);
            include 'KobleOgLagInnholdFiler.php';
        }
        header("location: ../innhold.php?feilslett=Innhold er lagt til.");
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

function sjekk_antallartikkler($menyid){
    global $mysqli;
    $sql9 = "SELECT * FROM vikerfjell.innhold WHERE idmeny = ?";
    $stmt9 = $mysqli->prepare($sql9);
    $stmt9->bind_param("s", $menyid);
    $stmt9->execute();
    $result9 = $stmt9->get_result();
    $count = 0;
    while ($row9 = $result9->fetch_assoc()){
        $count++;
    }
    return $count;
}

//Sletting av innhold
if(isset($_POST['slettInnhold'])){
    $id = $_POST['menylistephp'];
    //KJØRER SPØRRING FOR Å FÅ UT MENYID TIL INNHOLDET
    $sql = "SELECT * FROM vikerfjell.innhold LEFT JOIN vikerfjell.submeny ON innhold.idmeny = submeny.meny_idmeny WHERE innhold.idinnhold = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $idSjekk = $row['idsubmeny'];

    if(empty($idSjekk) == false) {
        $iden = "S".$row['meny_idmeny'];
        $navnito = $row['side'];
    } else {
        $iden = $row['idmeny'];
        $navnito = $row['side'];
    }

    $idto = "";
    if(strpos($iden, "S") !== false) {
        $idto = substr($iden, 1);
    } else {
        $idto = $iden;
    }
    Slett_Innhold($id);
    unlink('../../../Vikerfjell/'.$navnito);
    //HER SETTER VI INN FUNKSJON
    include 'NyArtikkel.php';
    include 'createInnholdFile.php';
    $count = sjekk_antallartikkler($idto);

    if($count == 1){
        if(strpos($iden, "S") !== false) {
            koblemeny($idSjekk);
        } else {
            koblemeny($iden);
        }
    }else{
        if(strpos($iden, "S") !== false) {
            lagSide2($idSjekk);
        } else {
            lagSide2($iden);
        }
    }
    header("location: ../innhold.php?slettInn=Innholdet er slettet.");
}

//Funksjon for endring av innhold
function Endre_Innhold($tittel, $ingress, $text, $rekke, $idmeny, $idinnhold){
    global $mysqli;
    $sql = "UPDATE vikerfjell.innhold SET tittel=?,ingress=?,tekst=?,rekke=?,idmeny=? WHERE idinnhold =?;";
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
        $sql = "SELECT tittel, ingress, tekst, rekke, idmeny, submeny.idsubmeny FROM innhold, submeny
              WHERE innhold.idmeny = submeny.meny_idmeny AND submeny.idsubmeny = ? ;";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $nyid);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $sisteID = $row['idmeny'];
        Endre_Innhold($overskrift ,$ingress,$innhold,$rekke,$sisteID,$id);
        include 'GenererAlleHtmlSider.php';
        include 'NyArtikkel.php';
        lagSide3();

    } else {
        //Endrer hvis hovedmeny er valgt
        Endre_Innhold($overskrift ,$ingress,$innhold,$rekke,$idmeny,$id);
        include 'GenererAlleHtmlSider.php';
        include 'NyArtikkel.php';
        lagSide3();
    }

    header("location: ../innhold.php?feilslett=Innholdet er endret.");
}

function legg_til_link(string $url, string $tekst, string $idmeny, string $idsubmeny) {
    global $mysqli;
    $stmt = $mysqli->prepare(
        "INSERT INTO link(url, link_tekst, idmeny, idsubmeny)
              VALUES(?, ?, ?, ?)");

    $stmt->bind_param('ii', $idmeny, $idsubmeny);
    $stmt->execute();

}
?>
