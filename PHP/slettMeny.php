<?php
/*
Sist endret av Erik 30.03.2017
Sist sett på av Alex 30.03.2017
*/
include 'Include/mysqlcon.php';

//Henter menyen
$Menyelement = $_POST['menylistephp'];
//Sjekker om den finnes
if(isset($Menyelement) || $Menyelement=="") {
  //Sjekker om ID på menyen er 1 (Tenker å ikke slette hjem)
  if($Menyelement == 1) { 
    header("location: EndreMeny.php?feilslett=Du kan ikke slette denne menyen.");

    } else {
      //Substringer for å hente ren verdi (Vi har SUB foran alle submenyer)
      if(strpos($Menyelement, 'SUB') !== false) {
        //Substringer for å få ren ID
        $nymenyid = substr($Menyelement,3);
        //Select for å se om valgt meny har eksisterende innhold
        //DENNE FUNGERER IKKE ENDA
        $innholdSjekk = "SELECT * FROM submeny LEFT JOIN innhold ON submeny.meny_idmeny = innhold.idmeny WHERE submeny.idsubmeny = ? 
	                        AND idinnhold IS NOT NULL;";
        $innholdStmt = $mysqli->prepare($innholdSjekk);
        $innholdStmt->bind_param('i', intval($nymenyid));
        $innholdStmt->execute();
        $innholdStmt->store_result();
        if($innholdStmt->num_rows > 0) {
          header("location: EndreMeny.php?feilslett=Kan ikke slette en meny med eksisterende innhold.");
        } else {

        //Lager select for å finne sidenavn for filsletting
        $sqlSelect = "SELECT * FROM submeny WHERE idsubmeny = ?";
        $selectStmt = $mysqli->prepare($sqlSelect);
        $selectStmt->bind_param('i', intval($nymenyid));
        $selectStmt->execute();
        $selectResult = $selectStmt->get_result();
	      $selectRow = mysqli_fetch_assoc($selectResult);
        $selectID = $selectRow['sub_side'];
          //Trenger ikke substring om vi ikke skal ha ./ i filnavne i databasen - Må se
          $rest = substr($selectID, 2);
          //Må endres, kan ikke linke direkte  
          unlink("../../Vikerfjell/".$rest);      
        //Sletter fra submeny med idsubmeny som parameter
        
        $sql = "DELETE FROM submeny WHERE idsubmeny = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('i', intval($nymenyid));
        $stmt->execute();
        header("location:EndreMeny.php?feilslett=Menyen er slettet.");
        }
      }elseif(strpos($Menyelement, 'SUB') == false) {
         //Select for å se om valgt meny har eksisterende innhold
        $innholdSjekk = "SELECT * FROM meny LEFT JOIN innhold USING(idmeny) WHERE innhold.idmeny = ?;";
        $innholdStmt = $mysqli->prepare($innholdSjekk);
        $innholdStmt->bind_param('i', intval($Menyelement));
        $innholdStmt->execute();
        $innholdStmt->store_result();
       
        //Hvis valgt meny har innhold blir det vist en feilmelding
        if($innholdStmt->num_rows > 0) {
          header("location: EndreMeny.php?feilslett=Kan ikke slette en meny med eksisterende innhold.");
        } else {
        //Sletter hvis innhold ikke finnes
        //Sjekker om valgt hovedmeny har en submeny knyttet til seg
        $sjekkspørring = "SELECT * FROM meny WHERE   NOT EXISTS(SELECT  * FROM submeny WHERE submeny.meny_idmeny = ?);";
        $stmt = $mysqli->prepare($sjekkspørring);
        $stmt->bind_param('i', $Menyelement);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = mysqli_fetch_assoc($result);
        if(!$row) {
          header("location: EndreMeny.php?feilslett=Kan ikke slette en hovedmeny med submeny.");
        } else {  
          //Lager select for å finne sidenavn for filsletting
          $sqlSelect = "SELECT * FROM meny WHERE idmeny = ?";
          $selectStmt = $mysqli->prepare($sqlSelect);
          $selectStmt->bind_param('i', intval($Menyelement));
          $selectStmt->execute();
          $selectResult = $selectStmt->get_result();
          $selectRow = mysqli_fetch_assoc($selectResult);
          $selectID = $selectRow['side'];
          unlink("../../Vikerfjell/".$selectID); 
          //Sletter fra meny
          $sql = "DELETE FROM meny WHERE idmeny = ?";
          $stmt = $mysqli->prepare($sql);
          $stmt->bind_param('i', intval($Menyelement));
          $stmt->execute();
          header("location:EndreMeny.php?feilslett=Menyen er slettet.");
      
      } 
        }
       
        mysqli_close($mysqli);
      }
      }

}

?>