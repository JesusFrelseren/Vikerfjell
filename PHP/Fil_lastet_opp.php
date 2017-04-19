<?php
$tmp_location = $_FILES['upload']['tmp_name'];

//Sjekk $_FILES[error] feilkodene

//Sjekk UPLOAD_ERR_OK
//Sjekk NO_FILE
//Sjekk størrelse vs maks størrelse
//Sjekk størrelse MAX_FILE_SIZE
//Sjekk MIME type
//lag unikt navn fra binærdata

//var_dump($_POST);
var_dump($_FILES);
move_uploaded_file($tmp_location, 'Bilder/test.jpg');

