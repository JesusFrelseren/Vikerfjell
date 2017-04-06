<?php
include 'mysqlcon.php';
$id = $_GET['id'];
$sql = "SELECT *
FROM meny inner join innhold on meny.idmeny = innhold.idmeny
WHERE meny.idmeny = $id";
$result = mysqli_query($mysqli, $sql);
$array = [];

echo("<select class='lenkerDropdown' id='lenkerdrop' name='lenkerdropdown'>");
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
