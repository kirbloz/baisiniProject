<!DOCTYPE html>
<html lang="en">
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyLAN</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="wrapper login-box color-lightb">
        <br>
        <h1 class="centered"><a href="index.php">EASY LAN PORTAL</a></h1>
        <br>
        <form class="centered login-form" action="area_utente.php" method="post">
            <input type="text" name="email" placeholder="Nome utente" required>
            <br><br>
            <input type="password" name="pwd" placeholder="Password" required>
            <br><br>
            <input class="button" id="reset" type="reset" value="RIPULISCI"/>
			<input class="button" id="confirm" type="submit" value="CONFERMA"/>
        </form>
        <br><br>
        <div class="centered redirect-login"> 
            <a href="signuppage.php">Non sei registrato? Clicca qui.</a>
        </div>
    </div>
</body>
</html>

