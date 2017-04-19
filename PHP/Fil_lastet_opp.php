<?php


try {
    //Sjekk $_FILES[error] feilkodene
    if(!(isset($_FILES['upload']['error']))) {
        throw new RuntimeException('Noe gikk galt under overføring');
    }

    switch($_FILES['upload']['error']) {
        case UPLOAD_ERR_OK: break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException("Ingen fil ble sendt til server");
        case UPLOAD_ERR_FORM_SIZE || UPLOAD_ERR_INI_SIZE:
            throw new RuntimeException("Filen er for stor");
    }

    if($_FILES['upload']['size'] > 100000000000) {
        throw new RuntimeException("Filen er for stor");
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = array_search(
            $finfo->file($_FILES['upfile']['tmp_name']),
            array(
                'jpg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
                'tiff' => 'image/tiff',
                'bmp' => 'image/bmp',
            ),
            true
        )) {
        throw new RuntimeException('Invalid file format.');
    }

    $tmp_location = $_FILES['upload']['tmp_name'];
    $perm_name_hash = md5_file($tmp_location);
    $perm_name = sprintf('Bilder/%s.%s', $perm_name_hash, $ext);
    move_uploaded_file($tmp_location, $perm_name);
    echo("Fil ble lastet opp");




} catch (RuntimeException $e) {

}

//Sjekk UPLOAD_ERR_OK
//Sjekk NO_FILE
//Sjekk størrelse vs maks størrelse
//Sjekk størrelse MAX_FILE_SIZE
//Sjekk MIME type
//lag unikt navn fra binærdata

//var_dump($_POST);
var_dump($_FILES);

