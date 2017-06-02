<?php
/* laget av Alex og Erik*/
include 'mysqlcon.php';
//LEGGE TIL GENERERING AV SUBMENYER
$stmt33 = $mysqli->prepare("SELECT * FROM meny LEFT JOIN submeny ON meny.idmeny = submeny.meny_idmeny ORDER BY idmeny;");
mysqli_set_charset($mysqli, "UTF8");
$stmt33->execute();
$result33 = $stmt33->get_result();
include ("createInnholdFile.php");
$menyid;
$array = [];
$int = 0;

while ($row33 = $result33->fetch_assoc()){
    $menyid = $row33['idmeny'];
    if($menyid != 1) {


        $stmt3 = $mysqli->prepare("SELECT * FROM vikerfjell.innhold where idmeny = ?");
        mysqli_set_charset($mysqli, "UTF8");
        $stmt3->bind_param("i", $menyid);
        $stmt3->execute();
        $result3 = $stmt3->get_result();
        $count = 0;
        while ($row3 = $result3->fetch_assoc()){
            $idinnhol = $row3['idinnhold'];
            $sideInsert = "../../".$row3['side'];
            $fh = fopen($sideInsert, 'w', 'w');
            $stringen = lagBestemtSide($idinnhol);
            $array[$int] = $stringen;
            $int++;
            fwrite($fh, $stringen);
            $count++;

        }
        if ($count = 1){
            koblemeny($menyid);
        }
    } else {
        //Fikse for hovedside
    }
    // lager oversikt til innhold
    //	include("NyArtikkel.php");
    //	lagSide2($row3['idmeny']);

}



?>
