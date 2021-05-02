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
        <form class="centered login-form" action="php/superlogin.inc.php" method="post">
            <input type="text" name="username" placeholder="Matricola" required>
            <br><br>
            <input type="password" name="pwd" placeholder="Password" required>
            <br><br>
            <input class="button" id="reset" type="reset" value="RIPULISCI"/>
			<input class="button" id="confirm" name="submit" type="submit"  value="CONFERMA"/>
        </form><br><br>

        <?php

            if(isset($_GET['error'])){
                //check if there was an error
                if($_GET['error'] == 'emptyinput'){
                    echo "<p class='centered error'> Compila tutti i campi. </p>";
                }else if($_GET['error'] == 'nouser'){
                    echo "<p class='centered error'> Questo utente non esiste. </p>";
                }else if($_GET['error'] == 'wrongpassword'){
                    echo "<p class='centered error'> La password che hai inserito &egrave; errata. </p>";
                }else if($_GET['error'] == 'queryfailed'){
                    echo "<p class='centered error'> Qualcosa &egrave; andato storto [QUERY]. </p>";
                }else if($_GET['error'] == 'sessionfailed'){
                    echo "<p class='centered error'> Qualcosa &egrave; andato storto [SESSION]. </p>";
                }else if($_GET['error'] == 'nosession'){
                    echo "<p class='centered error'> Sessione scaduta o non esistente. Effettua nuovamente il login. </p>";
                }else if($_GET['error'] == 'none' && isset($_GET['username'])){
                    echo "<p style='font-weight:bold; color:#208F82; width:60%;' class='centered'> Benvenuto " . $_GET['username'] . ". Verrai inviato alla tua area personale. </p>";
                    header('Refresh: 5; URL=areaUtente.php');
                }
                    echo "<br>";
            }

        ?>

        <div class="centered redirect-login"> 
            <a href="supersignup.php">Non sei registrato? Clicca qui.</a><br>
            <a href="superlogin.php">Non sei parte del nostro personale? Clicca qui.</a>
        </div>
    </div>
</body>
</html>