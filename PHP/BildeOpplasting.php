<?php

include('Include/mysqlcon.php');
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
            $finfo->file($_FILES['upload']['tmp_name']),
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
    $filinfo = pathinfo($_FILES['upload']['name'], PATHINFO_FILENAME);
    $perm_name = sprintf('Bilder/%s.%s', $filinfo, $ext);
    move_uploaded_file($tmp_location, $perm_name);
    //todo: Lag sjekk på om fil finnes
    //echo("Fil ble lastet opp\n");

    //Hent bildedimensjoner
    list($width_src, $height_src) = getimagesize($perm_name);
    $width_thumb = $width_src / 4;

    //Lag filsti for thumbnail
    $perm_thumb_location = sprintf('Bilder/thumbs/%s.%s', "thumb_".$filinfo, $ext);

    //Lag fullskalert bilde
    $image_src = imagecreatefromjpeg($perm_name);

    //Lag thumbnail med dimensjoner
    $image_thumb = imagecreatetruecolor($width_thumb, 100);

    //Resample image_thumb
    imagecopyresampled($image_thumb, $image_src, 0, 0, 0, 0, $width_src, 100,
        $width_src, $height_src);

    //Skriv $image_thumb til masselager med 50% kvalitet
    imagejpeg($image_thumb, $perm_thumb_location, 50);

    //Skriv metadata til databasen
    $tekst = $_POST['bildebeskrivelse'];
    $thumb = "thumb_".pathinfo($_FILES['upload']['name'], PATHINFO_BASENAME);
    $hvor = pathinfo($_FILES['upload']['name'], PATHINFO_BASENAME);
    $bredde = $width_src;
    $høyde = $height_src;
    $tooltip = "Fuck tooltips";
    $alt = "Bildet ble ikke funnet :´(";

    //Skriv meta til base
    global $mysqli;
    $stmt = $mysqli->prepare("
      INSERT INTO vikerfjell.bilder(hvor, tekst, thumb, bredde, hoyde, tooltip, alt)
      VALUES(?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param('sssiiss', $hvor, $tekst, $thumb, $bredde, $høyde, $tooltip, $alt);
    $stmt->execute();
    $mysqli->close();
} catch (RuntimeException $e) {
    throw new RuntimeException($e->getMessage());
}
