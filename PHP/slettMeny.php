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
        $nymenyid = substr($Menyelement,3);
        $sql = "DELETE FROM submeny WHERE idsubmeny = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('i', intval($nymenyid));
        $stmt->execute();
         header("location:EndreMeny.php");
      }elseif(strpos($Menyelement, 'SUB') == false) {
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
          $sql = "DELETE FROM meny WHERE idmeny = ?";
          $stmt = $mysqli->prepare($sql);
          $stmt->bind_param('i', intval($Menyelement));
          $stmt->execute();
          header("location:EndreMeny.php");
      
      } 
       
        mysqli_close($mysqli);
      }
      }
}
    

?>