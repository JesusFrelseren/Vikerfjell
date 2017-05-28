<?php
/* Sist endret av Alex 28.03.2017-->
<!--Sett over av Sindre 28.03.2017 */
include 'mysqlcon.php';

$sql = "SELECT * FROM vikerfjell.innhold;";
$result = mysqli_query($mysqli, $sql);

echo("<select class='endreInnhold' id='listeinnhold' name='menylistephp' size='12' onchange='changeFunc();'>");
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {

        echo "<option value=". $row["idinnhold"] .">
    	Tittel: " . $row["tittel"]."
    	</option><br>";
    }
} else {
    echo "0 results";
}
echo("</select>");



mysqli_close($mysqli);

?>
