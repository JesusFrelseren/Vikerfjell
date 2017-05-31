<!--
endret av Sindre 24.02.2017
Sist sett på av Erik 28.02.2017
Sist endret av Alex 23.05.2017
-->
<?php
//http://www.intechgrity.com/create-login-admin-logout-page-in-php-w/#
$username = $_POST["username"];

$msg = '';


if(isset($username)) {
  include 'mysqlcon.php';
  include 'konstant.php';

  $stmt = $mysqli->prepare("SELECT ePost,idbruker FROM bruker WHERE brukerNavn=?");
  $stmt->bind_param("s",$username);
  $stmt->execute();

  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

  $to = $row["ePost"];
  $idbruker = $row['idbruker'];
  $subject = "Glemt passord"; 

    $length = 10;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $message = "Ditt nye passord er: ";
    for ($i = 0; $i < $length; $i++) {
       $randord  .= $characters[rand(0, $charactersLength - 1)];
    }

$message .= $randord;



  




require '../mailer/PHPMailerAutoload.php';

      $mail = new PHPMailer;

      //$mail->SMTPDebug = 2;                               // Enable verbose debug output

      $mail->isSMTP();                                      // Set mailer to use SMTP
      $mail->Host = 'smtp.live.com';                        // Specify main and backup SMTP servers       smtp.gmail.com
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = 'gruppe5gruppe5@hotmail.com';                 // SMTP username
      $mail->Password = 'Gruppenr5';                         // SMTP password
      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = 587;                                    // TCP port som tilkobles   465

      $mail->setFrom('gruppe5gruppe5@hotmail.com', 'Mailer');
      $mail->addAddress($to, $to);


      $mail->isHTML(true);                                  // Setter epostformat til HTML

    

      $mail->Subject = 'Nytt passord';
      $mail->Body    = "$message";
      $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';



if(!$mail->send()) {
          header("location:../form.php?msg=brukernavnet eksisterer ikke");  
      } else {


$randord = sha1(constant("SALT").$randord);

			$stmt = $mysqli->prepare("UPDATE bruker SET passord =? WHERE idbruker=?");
     		$stmt->bind_param("ss",$randord,$idbruker);
      		$stmt->execute();
			

         header("location:../form.php?msg=nytt passord er sendt på mail");  
      }







  //$headers = 'From: Your name <info@address.com>' . "\r\n";
  
  //if(mail($to, $subject, $message, $headers)){
   
  //}else{
   // header("location:../form.php?id=noe gikk galt");
  //}
}
?>