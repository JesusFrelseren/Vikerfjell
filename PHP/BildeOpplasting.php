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
    $perm_name = sprintf('Bilder/%s.%s', $perm_name_hash, $ext);
    move_uploaded_file($tmp_location, $perm_name);
    echo("Fil ble lastet opp");

    //Hent bildedimensjoner
    list($width_src, $height_src) = getimagesize($perm_name);

    //Lag filsti for thumbnail
    $perm_thumb_location = sprintf('Bilder/thumbs/%s.%s', $perm_name."_thumb", $ext);

    //Lag fullskalert bilde
    $image_src = imagecreatefromjpeg($perm_name);

    //Lag thumbnail med dimensjoner
    $image_thumb = imagecreatetruecolor($width_src / 3, 100);

    //Kopier til base
    imagecopyresampled($image_src, $image_thumb, 0, 0, 0, 0, $width_src / 4, 100,
        $width_src, $height_src);

    move_uploaded_file($tmp_location, $perm_thumb_location);

} catch (RuntimeException $e) {
    throw new RuntimeException($e->getMessage());
}

