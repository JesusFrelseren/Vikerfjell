// Utviklet av Erlend. Sist endret 20.04.2017


<?php
//todo: Lag sjekk på om fil finnes
//todo: Sjekk for overskrivning av bilder
//todo: Utvid med tooltip
//todo: Utvid catch
//todo: Demonstrer bilder som allerede er linket
//todo: Lag støtte for andre bildeformater
//todo: Fiks visning av thumbnails på webside
//todo: Fiks firefox javascript
//todo: Fiks object not found i linkmodus


include('Include/InnholdKontroll.php');
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

    //Lag thumbnail filsti
    $perm_thumb_location = lag_thumbnail_filsti($filinfo, $ext);

    //Resample image resource med orginalversjon
    $image_thumb = resample($perm_name, $filinfo, $ext);

    //Skriv $image_thumb til masselager med 50% kvalitet
    imagejpeg($image_thumb, $perm_thumb_location, 50);

    //Skriv meta til base
    list($width_src, $height_src) = getimagesize($perm_name);
    skriv_bilder_til_base($_POST, $_FILES, $width_src, $height_src);
    header("location:form.php?msg=Feil brukernavn eller passord");


} catch (RuntimeException $e) {
    throw new RuntimeException($e->getMessage());
}


function lag_thumbnail_filsti($filinfo, $ext) {
    $perm_thumb_location = sprintf('Bilder/thumbs/%s.%s', "thumb_".$filinfo, $ext);
    return $perm_thumb_location;
}


function resample($perm_name, $filinfo, $ext) {
    list($width_src, $height_src) = getimagesize($perm_name);
    $width_thumb = $width_src / 4;

    //Lag filsti for thumbnail

    //Lag fullskalert bilde
    $image_src = imagecreatefromjpeg($perm_name);

    //Lag thumbnail med dimensjoner
    $image_thumb = imagecreatetruecolor($width_thumb, 100);

    imagecopyresampled($image_thumb, $image_src, 0, 0, 0, 0, $width_src, 100,
        $width_src, $height_src);

    return $image_thumb;
}
