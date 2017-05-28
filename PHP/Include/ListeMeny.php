<?php
/*
Sist endret av Erik 31.03.2017
Sist sett på av Sindre 24.03.2017
*/
include 'mysqlcon.php';

$sql = "SELECT * FROM vikerfjell.meny left join submeny on meny.idmeny = submeny.meny_idmeny ORDER BY rekke;";
$result = mysqli_query($mysqli, $sql);
$sessionRes = $mysqli->query($sql);
$nr = 0;
echo("<select autofocus class='listegammelMeny' id='listetest' name='menylistephp' size='12' onchange='changeMenyFunc()'>");

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    $id = "";
    while($row = mysqli_fetch_assoc($result)) {
        if($row["idmeny"] == $id){
            if ($row["meny_idmeny"] != null) {

                echo "<option value=". "SUB".$row["idsubmeny"] .">
    - Submenytekst: " . $row["sub_tekst"]."
    </option><br>";
                $nr++;
            }
        }else{

            echo "<option value=". $row["idmeny"] .">
    	Menytekst: " . $row["tekst"]."
    	</option><br>";
            if ($row["meny_idmeny"] != null) {
                echo "<option value=". "SUB".$row["idsubmeny"] .">
    		- Submenytekst: " . $row["sub_tekst"]."
   			 </option><br>";
            }
        }

        $id = $row["idmeny"];
    }
} else {
    echo "";
}
echo("</select>");
/*
while ($sessionRow = $sessionRes->fetch_assoc()) {
        $rekkemeny = $sessionRow['rekke'];
        $_SESSION['rekkemeny'] = $rekkemeny;

        
        echo "<input type='hidden' id='rekkemeny' value='".$rekkemeny."'/> \n";

        echo("\n"); 
        
}

*/


/*
$test1 = $row['idmeny'];
$test2 = $row['idsubmeny'];
$sqlPopulate = "SELECT side, rekke FROM vikerfjell.meny left join submeny on meny.idmeny = submeny.meny_idmenyWHERE idmeny = $test1 OR idsubmeny = $test2);";
$result = mysqli_query($mysqli, $sqlPopulate);
if(isset($result)) {
  echo("<h3> ". $sidemeny . "</h3>");
}

*/
mysqli_close($mysqli);

?>