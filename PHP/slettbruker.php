<?php
/* Sist endret av Erik Hall 06.02.2017-->
<!--Sett over av Sindre 06.02.2017 */
include 'Include/mysqlcon.php';

//Henter brukere
$bruker = $_POST['listephp'];
//Ser om den finnes
if(isset($bruker) || $bruker=="") {
  //Ser om ID er 1 - Skal ikke kunne slette hovedbrukeren
  if($bruker == 1) { 
    header("location: brukere.php?feilslett=Du kan ikke slette denne brukeren.");
  } else {
    $sql = "DELETE FROM bruker WHERE idbruker = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', intval($bruker));
    $stmt->execute();

    header("location: brukere.php");
    exit();
    mysqli_close($mysqli);
}
}

?>
