<?php
/*
Sist endret av Erik 01.03.2017
Sist sett på av Sindre 02.03.2017
*/
include 'mysqlcon.php';
//Henter all informasjon om brukere
$sql = "SELECT idbruker, brukerNavn, ePost FROM vikerfjell.bruker";
$result = mysqli_query($mysqli, $sql);
echo("<select name='listephp' size='12'>");
if (mysqli_num_rows($result) > 0) {
    // utdata for hver rad
    while($row = mysqli_fetch_assoc($result)) {
        //Lager listen
        echo "<option value=". $row["idbruker"] .">
    " . $row["idbruker"]. "
    Brukernavn: " . $row["brukerNavn"].
            " - Mail:  " . $row["ePost"]. "
    </option><br>";

    }
} else {
    echo "0 results";
}
echo("</select>");



mysqli_close($mysqli);

?>
