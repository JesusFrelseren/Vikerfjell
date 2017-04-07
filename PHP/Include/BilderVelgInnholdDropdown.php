<?php
include 'mysqlcon.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $mysqli->prepare("SELECT *
            FROM meny inner join innhold on meny.idmeny = innhold.idmeny
            WHERE meny.idmeny = $id");
    $result = $stmt->get_result();
    $array = [];
}

echo("<select class='lenkerDropdown' id='lenkerdrop' name='lenkerdropdown'");

    // Utdata for hver rad
while($row = mysqli_fetch_assoc($result)) {
    $array[$row['idinnhold']] = $row['side'];
    echo "<option value=" . $row["idinnhold"] . ">
    Tittel: " . $row["tittel"] . "
    </option><br>";

}

echo("</select>");
mysqli_close($mysqli);

?>
