<?php
$to      = 'vikerfjell@vikerfjell.no';
$subject = $_POST["Name"];
$mail = $_POST["Mail"];
$message = $_POST["Comment"];


if(empty($subject) || empty($mail) || empty($message)){
    // header('Location: ../../henvendelser.html');
        header("location: ../../PHP/henvendelser.php?feilslett=Fyll ut alle felt før du sender.");
    } else {
        mail($to, $subject, $message, "From: <" . $mail . ">" );
        //header('Location: ../../henvendelser.html');
        header("location: ../../PHP/henvendelser.php?feilslett=Meldingen er sendt.");
              
    }
?>