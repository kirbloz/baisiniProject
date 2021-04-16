
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

        <form class="centered login-form" action="php/signup.inc.php" method="post">
            <input type="text" name="username" placeholder="Nome utente" >
            <br><br>
            <input type="email" name="email_address" placeholder="Indirizzo mail" required>
            <br><br>
            <input type="password" name="pwd" placeholder="Password" required>
            <br><br>
            <input type="text" name="id_customer" placeholder="ID Cliente" required>
            <br><br>
            <input class="button" id="reset" type="reset" value="RIPULISCI"/>
			<input class="button" id="confirm" name="submit" type="submit" value="CONFERMA"/>
        </form>

        <br><br>
        <div class="centered redirect-login"> 
            <a href="loginpage.php">Gi&agrave; registrato? Clicca qui.</a>
            <!-- look at timestamp 24.29 for login page -->
        </div>
    </div>

</body>
</html>