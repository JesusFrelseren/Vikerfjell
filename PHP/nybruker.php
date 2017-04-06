<?php
/* Sist endret av Erik 14.02.2017-->
<!--Sett over av Sindre 14.02.2017 */
  include 'Include/mysqlcon.php';
  //Lager variabler utifra tekst bruker har skrevet og salter og hasher passordet
  $username = mysqli_real_escape_string($mysqli, $_POST["username"]);
  $password = mysqli_real_escape_string($mysqli, $_POST["password"]);
  $mail = mysqli_real_escape_string($mysqli, $_POST["mail"]);
  $salt = "IT2_2017";
  $password = sha1($salt.$password);

  //Spørring for å se om brukernavn finnes
  $stmt = $mysqli->prepare("SELECT brukerNavn FROM vikerfjell.bruker WHERE brukerNavn=?");
  $stmt->bind_param("s",$username);
  $stmt->execute();

  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  //Om brukernavn ikke finnes, insert
if (!$row){
  $stmt = $mysqli->prepare("INSERT INTO bruker (brukerNavn, passord, ePost) VALUES (?, ?, ?)");
  $stmt->bind_param("sss",$username,$password, $mail);
  $stmt->execute();
  header('Location: Brukere.php');
  } else {
    header("location:Brukere.php?msg=Brukernavn finnes fra før.");
}







 ?>
