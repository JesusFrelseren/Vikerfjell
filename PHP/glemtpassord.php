<!--Sist endret av Sindre 16.02.2017-->
<!--Sett over av Erik 16.02.2017-->
<!DOCTYPE html>
<html>
<head>
	<meta charset="ns_4551-1-krutf-8">
	<title>Admin Vikerfjell - Glemt passord</title>
	<link href="CSS/form.css" rel="stylesheet">
</head>
<body>
	<img src="Bilder/logov2.png">
	<div id="login">
		<form action="Include/glemtpassordsend.php" id="form-login" method="post" name='form-login'>
			<p>Skriv inn brukernavn og send inn, innen kort tid sender vi deg en mail med instrukser til gjenoppretting av passord.</p><input autofocus="" name="username" placeholder="Brukernavn" title="Skriv inn ditt brukernavn" type="text"><br style="margin-bottom:12px;">
			<input name="send" type="submit" value="Send">
		</form>
	</div>
</body>
</html>