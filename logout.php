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
        <?php
            //check if there was an error
            if(isset($_GET['error']))
                if($_GET['error'] == 'nosession'){
                    echo '<div class="centered" style="padding:0px 20px;">';
                    echo "<h3>Nessuna sessione valida attiva in questo momento.</h3>";
                }else{
        ?>
            <div class="centered" style="padding:0px 20px;">
                <h3>La sessione &egrave; scaduta. Ti invitiamo a effettuare nuovamente il login.</h3>
        <?php
            }
        ?>
            </div>
        <br>
        <div class="centered redirect-login" style="font-size:18px"> 
            <a href="login.php">Clicca qui.</a>
        </div>
    </div>
</body>
</html>