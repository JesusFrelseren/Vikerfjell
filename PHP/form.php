<!--Sist endret av Sindre 13.02.2017-->
<!--Sett over av Erik 13.02.2017-->
<!DOCTYPE html>
<html>
<head>
    <meta charset="ns_4551-1-krutf-8">
    <title>Admin Vikerfjell</title>
    <link href="CSS/form.css" rel="stylesheet">
</head>
<body>
<img src="Bilder/logov2.png">
<div id="login">
    <form action="login.php" id="form-login" method="post" name='form-login'>
        <input autofocus="" name="username" placeholder="Brukernavn" title="Skriv inn ditt brukernavn" type="text"><br style="margin-bottom:12px;">
        <input name="password" placeholder="Passord" title="Skriv inn ditt passord" type="password"> <input name="send" type="submit" value="Logg inn"> <a href="glemtpassord.php">Glemt passord?</a>
        <h3><?php $msg = isset($_GET['msg']) ? $_GET['msg'] : '';
            echo ($msg)?></h3>
    </form>
</div>
</body>
</html>
