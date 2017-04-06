<?php
/*
Sist endret av Erik 01.03.2017
Sist sett på av Sindre 02.03.2017
*/
include 'mysqlcon.php';

$sql = "SELECT idmeny, tekst FROM meny";
$result = mysqli_query($mysqli, $sql);
echo("<div class='leggetilNyMeny'>");
echo("<select class='nymeny' name='menyliste'>");
echo("<option value='nymenytype'>Ny hovedmeny</option>");
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {

    echo "<option class='listeklasse' value=". $row["idmeny"] .">
    " . $row["tekst"]. "
    </option><br>";

  }
} else {
  echo "0 results";
}
echo("</select>");
echo("</div>");
mysqli_close($mysqli);
?>
