
<?php
/*
Sist endret av Erik 31.03.2017
Sist sett på av Erlend 01.04.2017
*/
include 'mysqlcon.php';
//Sjekker om felt er tomt
if(!empty($_POST['namemenu'])) {
    $sjekkres = $_POST['sjekkres'];
    //Henter den gjemte variabelen for å se om det er submeny eller hovedmeny og utfører basert på den
    if($sjekkres == 2) {
        $menyNavn = mysqli_real_escape_string($mysqli, $_POST["namemenu"]);
        $rekke = mysqli_real_escape_string($mysqli, $_POST["rowmenu"]);
        $id = mysqli_real_escape_string($mysqli, $_POST["getID"]);
        //Sjekker om rekke er tall
        if(!is_numeric($rekke)) {
            header('Location: ../EndreMeny.php?feilendring=Rekke må være tall.');
        } else {
            $stmt = $mysqli->prepare('UPDATE vikerfjell.submeny SET submeny.sub_tekst = ?, submeny.sub_rekke = ? WHERE submeny.idsubmeny = ?');
            $stmt->bind_param("sii", $menyNavn, $rekke, $id);
            $stmt->execute();
            header("location: ../EndreMeny.php");
        }
    } elseif ($sjekkres == 1) {
        if(isset($_POST["endre"])) {
            $menyNavn = mysqli_real_escape_string($mysqli, $_POST["namemenu"]);
            $rekke = mysqli_real_escape_string($mysqli, $_POST["rowmenu"]);
            $id = mysqli_real_escape_string($mysqli, $_POST["getID"]);
            //Sjekker om rekke er tall
            if(!is_numeric($rekke)) {
                header('Location: ../EndreMeny.php?feilendring=Rekke må være tall.');
            } else {
                $stmt = $mysqli->prepare('UPDATE vikerfjell.meny SET meny.tekst = ?, meny.rekke = ? WHERE meny.idmeny = ?');
                $stmt->bind_param("sii", $menyNavn, $rekke, $id);
                $stmt->execute();
                header("location: ../EndreMeny.php");
            }
        } else {die();}
    }
}
?>
