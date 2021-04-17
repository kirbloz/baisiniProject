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
            <input type="password" name="repeat_pwd" placeholder="Ripeti password" required>
            <br><br>
            <input class="button" id="reset" type="reset" value="RIPULISCI"/>
			<input class="button" id="confirm" name="submit" type="submit" value="CONFERMA"/>
        </form><br><br>

        <?php
            if(isset($_GET['error'])){
                //check if there was an error
                if($_GET['error'] == 'emptyinput'){
                    echo "<p class='centered error'> Compila tutti i campi. </p>";
                }else if($_GET['error'] == 'invalidemail'){
                    echo "<p class='centered error'> Indirizzo email non valido. </p>";
                }else if($_GET['error'] == 'invalidusername'){
                    echo "<p class='centered error'> Username non valido. </p>";
                }else if($_GET['error'] == 'invalidpassword'){
                    echo "<p class='centered error'> Password non valida. </p>";
                }else if($_GET['error'] == 'pwdsnotmatching'){
                    echo "<p class='centered error'> Le password non corrispondono. </p>";
                }else if($_GET['error'] == 'useralreadyexists'){
                    echo "<p class='centered error'> Questo utente esiste gi&agrave;. </p>";
                }else if($_GET['error'] == 'queryfailed'){
                    echo "<p class='centered error'> Qualcosa &egrave; andato storto. </p>";
                }else if($_GET['error'] == 'none'){
                    echo "<p style='font-weight:bold; color:#208F82; width:60%;' class='centered'> L'utente " . $_GET['username'] . " &egrave; stato registrato con successo. Verrai mandato alla tua Area utente. </p>";
                    header('Refresh: 5; URL=../areaUtente.php');
                }
                echo "<br><br>";
            }

        ?>
        
        <div class="centered redirect-login"> 
            <a href="loginpage.php">Gi&agrave; registrato? Clicca qui.</a>
        </div>
    </div>

</body>
</html>
