<?php
//Utviklet av Erlend


include('Include/mysqlcon.php');

if(isset($_POST['action_last_opp'])) {
    try {
        //Sjekk $_FILES[error] feilkodene
        if (!(isset($_FILES['upload']['error']))) {
            throw new RuntimeException('Noe gikk galt under overføring');
        }

        switch ($_FILES['upload']['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new RuntimeException("Ingen fil ble sendt til server");
        }


        $finfo = new finfo(FILEINFO_MIME_TYPE);
        if (false === $ext = array_search(
                $finfo->file($_FILES['upload']['tmp_name']),
                array(
                    'jpg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                ),
                true
            )
        ) {
            throw new RuntimeException('Invalid file format.');
        }
        $tmp_location = $_FILES['upload']['tmp_name'];
        $perm_name_hash = md5_file($tmp_location);
        $filinfo = pathinfo($_FILES['upload']['name'], PATHINFO_FILENAME);
        $perm_name = sprintf('Bilder/%s.%s', $filinfo, $ext);

        if (!(file_exists($perm_name))) {
            move_uploaded_file($tmp_location, $perm_name);
        } else {
            $kopi = 2;
            while (true) {
                if (file_exists($perm_name . $kopi)) {
                    $kopi++;
                } else {
                    move_uploaded_file($tmp_location, $perm_name . $kopi);
                    break;
                }
            }
        }


        //Hent bildedimensjoner for å definere thumbnail-dimensjoner
        list($width_src, $height_src) = getimagesize($perm_name);

        //Hvis bildet er landskap
        if ($width_src > $height_src) {
            $width_thumb = 150;
            $height_thumb = 100;
        //Hvis bildet er portrett
        } elseif($width_src < $height_src) {
            $width_thumb = 100;
            $height_thumb = 150;
        //Hvis bildet er kvadaratisk
        } else {
            $width_thumb = 100;
            $height_thumb = 100;

        }

        //Lag filsti for thumbnail
        $perm_thumb_location = sprintf('Bilder/thumbs/%s.%s', "thumb_" . $filinfo, $ext);

        //Lag fullskalert bilde
        $image_src = lagFullskalert($perm_name, $ext);


        //Lag thumbnail med dimensjoner
        $image_thumb = imagecreatetruecolor($width_thumb, $height_thumb);

        //Resample image_thumb
        imagecopyresampled($image_thumb, $image_src, 0, 0, 0, 0, $width_thumb, $height_thumb,
            $width_src, $height_src);

        //Skriv $image_thumb til masselager med 50% kvalitet
        createImage($ext, $image_thumb, $perm_thumb_location);


        //Skriv metadata til databasen
        $tekst = $_POST['bildebeskrivelse'];
        $thumb = "thumb_" . pathinfo($_FILES['upload']['name'], PATHINFO_BASENAME);
        $hvor = pathinfo($_FILES['upload']['name'], PATHINFO_BASENAME);
        $bredde = $width_src;
        $høyde = $height_src;
        $tooltip = "";
        $alt = "Bildet ble ikke funnet :´(";

        //Skriv meta til base
        global $mysqli;
        $stmt = $mysqli->prepare(
            "INSERT INTO vikerfjell.bilder(hvor, tekst, thumb, bredde, hoyde, tooltip, alt)
              VALUES(?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param('sssiiss', $hvor, $tekst, $thumb, $bredde, $høyde, $tooltip, $alt);
        $stmt->execute();
        $mysqli->close();
    } catch (RuntimeException $e) {
        throw new RuntimeException($e->getMessage());
    }

}

function createImage($ext, $image_thumb, $perm_thumb_location) {
    switch ($ext) {
        case 'jpg':
            imagejpeg($image_thumb, $perm_thumb_location, 100);
            break;
        case 'png':
            imagepng($image_thumb, $perm_thumb_location, 100);
            break;
        case 'gif':
            imagegif($image_thumb, $perm_thumb_location);
    }
}

function lagFullskalert($perm_name, $ext) {

    switch ($ext) {
        case 'jpg':
            return imagecreatefromjpeg($perm_name);
        case 'png':
            return imagecreatefrompng($perm_name);
        case 'gif':
            return imagecreatefromgif($perm_name);

    }
    echo("fail");
    return null;



}

