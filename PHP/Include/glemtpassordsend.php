<!--
Sist endret av Sindre 24.02.2017
Sist sett på av Erik 28.02.2017
-->
<?php
//http://www.intechgrity.com/create-login-admin-logout-page-in-php-w/#
$username = $_POST["username"];
$mail = '';
$msg = '';


if(isset($username)) {
  include 'mysqlcon.php';

  $stmt = $mysqli->prepare("SELECT ePost FROM bruker WHERE brukerNavn=?");
  $stmt->bind_param("s",$username);
  $stmt->execute();

  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

  $to = $row["ePost"];
  $subject = "Glemt passord";

  $message = "Please use this password to login";
  $headers = 'From: Your name <info@address.com>' . "\r\n";
  if(mail($to, $subject, $message, $headers)){
    echo "Your Password has been sent to your email id";
  }else{
    echo "Failed to Recover your password, try again";
  }
}
?>
