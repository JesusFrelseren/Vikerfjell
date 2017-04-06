<?php
/* Sist endret av Erik 28.03.2017-->
<!--Sett over av Alex 28.03.2017 */
include("mysqlcon.php");
$stmt = $mysqli->prepare("select * from vikerfjell.meny ORDER BY rekke");
mysqli_set_charset($mysqli, "UTF8");
$stmt->execute();
$result = $stmt->get_result();



while($row = $result->fetch_assoc()){

  $menyid = $row['idmeny'];
  $tekst = $row['tekst'];
  $side = $row['side'];

  $stmt = $mysqli->prepare("select meny_idmeny from submeny where meny_idmeny = $menyid");
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows == 0) {
    echo("<li><a href=$side>$tekst</a></li>");

  } else {

    $sub_stmt = $mysqli->prepare(
    "select * from submeny where meny_idmeny = " .$menyid
      );

    $sub_stmt->execute();
    $sub_result = $sub_stmt->get_result();

    $submenu_html = '';

    while($sub_row = $sub_result->fetch_assoc()) {

      $sub_tekst = $sub_row['sub_tekst'];
      $sub_side = $sub_row['sub_side'];
      $submenu_html .= "<a href=$sub_side>$sub_tekst</a>";

    }

    echo("<li class='dropdown'>
        <a href='#'' class='dropbtn'>$tekst</a>
        <div class='dropdown-content'>
          $submenu_html
        </div>
      </li>");
    $submenu_html = '';
    }

  }

  echo("
   <li class='icon'>
	<a href='javascript:void(0);' style='font-size:15px;' onclick='myFunction()'>☰</a>
   </li>

  </ul>
  </nav>
</header>
</div>");

?>
