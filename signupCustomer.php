<?php
    @include_once('session.inc.php');
    @include_once('php/session.inc.php');
    @include_once('../php/session.inc.php');
    @session_start();
    if(!checkActive())
        header("location:php/logout.inc.php"); //session
    @include('php/function.inc.php');
    $utente = generateUserOBJ(session_id()); 
?>	

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

        <form class="centered login-form" action="php/signupCustomer.inc.php" method="post">
            <input type="text" name="firstname" placeholder="Nome" required>
            <br><br>
            <input type="text" name="lastname" placeholder="Cognome" required>
            <br><br>
            
            <label for="male" class="radio">
                <input type="radio" id="male" name="gender" value="M" class="radio__input">
                <div class="radio__radio"></div>
                Uomo
            </label>
            <label for="female" class="radio">
                <input type="radio" id="female" name="gender" value="F" class="radio__input">
                <div class="radio__radio"></div>
                Donna
            </label>
            <label for="other" class="radio">
                <input type="radio" id="other" name="gender" value="NB" class="radio__input">
                <div class="radio__radio"></div>
                Non Specificato
            </label>
            <br><br>

            <input type="text" name="address" placeholder="Indirizzo" >
            <br><br>
            <input type="text" name="city" placeholder="Citt&agrave;" >
            <br><br>
            <input type="text" name="postal_code" placeholder="CAP" >
            <br><br>
            <input style="color:#757575;" type="date" name="birth_date" placeholder="Data di nascita" >
            <br><br>
            <input class="button" id="reset" type="reset" value="RIPULISCI"/>
			<input class="button" id="confirm" name="submit" type="submit" value="CONFERMA"/>
        </form><br><br>

        <?php
            if(isset($_GET['error'])){
                //check if there was an error
                if($_GET['error'] == 'invalidname'){
                    echo "<p class='centered error'> Indirizzo email non valido. </p>";
                }else if($_GET['error'] == 'customeralreadyexists'){
                    echo "<p class='centered error'> Questo utente esiste gi&agrave;. </p>";
                }else if($_GET['error'] == 'queryfailed'){
                    echo "<p class='centered error'> Qualcosa &egrave; andato storto. </p>";
                }else if($_GET['error'] == 'none' && isset($_GET['firstname']) && isset($_GET['lastname'])){
                    echo "<p style='font-weight:bold; color:#208F82; width:60%;' class='centered'> Il cliente " . $_GET['firstname'] . " ". $_GET['lastname'] . " &egrave; stato registrato con successo. Verrai inviato alla tua area utente. </p>";
                    header('Refresh: 5; URL=areaUtente.php');
                }
                echo "<br><br>";
            }

        ?>
        
        <div class="centered redirect-login"> 
            <a href="userShowcase.php">Torna indietro.</a>
        </div>
    </div>

</body>
</html>
