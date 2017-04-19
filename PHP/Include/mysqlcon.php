<?php
/* Sist endret av Alex 28.03.2017-->
<!--Sett over av Sindre 28.03.2017 */

/*
  $mysqli = new mysqli('localhost', 'root', '', 'vikerfjell');

  if (mysqli_connect_error()) {
    die('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
  } else {
      echo("");
  }

*/
//////////////////////////////////////////////////////////////////////////////////////////////////

  $mysqli = new mysqli('158.36.139.21', 'brViker', 'pw_Viker', 'vikerfjell');

  if (mysqli_connect_error()) {
    die('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
  } else {
      echo("");
  }

?>
