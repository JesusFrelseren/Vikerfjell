<!--
endret av Sindre 24.02.2017
Sist sett på av Erik 28.02.2017
Sist endret av Sindre 25.04.2017
-->
<?php
//http://www.intechgrity.com/create-login-admin-logout-page-in-php-w/#
$username = $_POST["username"];
$mail = '';
$msg = '';


if(isset($username)) {
  include 'mysqlcon.php';

  $stmt = $mysqli->prepare("SELECT ePost,idbruker FROM bruker WHERE brukerNavn=?");
  $stmt->bind_param("s",$username);
  $stmt->execute();

  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

  $to = $row["ePost"];
  $idbruker = $row['idbruker'];
  $subject = "Glemt passord";




  // må endres til gunnar sin!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!11	
  $message = "https://home.hbv.no/139953/PHP/EnderPassordframail.php?id=$idbruker";
  // må endres til gunnar sin!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!11



  $headers = 'From: Your name <info@address.com>' . "\r\n";
  
  if(mail($to, $subject, $message, $headers)){
    header("location:../form.php?id=instrukser er send på mail");
  }else{
    header("location:../form.php?id=noe gikk galt");
  }
}
?>