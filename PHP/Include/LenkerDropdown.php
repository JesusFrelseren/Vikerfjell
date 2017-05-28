<!--Sist endret av Alex 28.03.2017-->
<!--Sett over av Sindre 28.03.2017-->
<?php
include 'mysqlcon.php';

$sql = "SELECT * FROM vikerfjell.innhold;";
$result = mysqli_query($mysqli, $sql);
$array = [];

echo("<select class='lenkerDropdown' id='lenkerdrop' name='lenkerdropdown' onchange='fyllLink();'>");
if (mysqli_num_rows($result) > 0) {
    // Utdata for hver rad
    while($row = mysqli_fetch_assoc($result)) {
        $array[$row['idinnhold']] = $row['side'];
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
