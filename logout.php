<?php
@include('php/session.inc.php');
if (!isset($_GET['error'])) {
    if (checkActive()) {
        header("location:php/logout.inc.php?isUser=true");
    } else if (checkActiveSuper()) {
        header("location:php/logout.inc.php?isUser=false");
    } else {
        header("location:login.php");
    }
} else
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

        <?php
    //check if there was an error
    if ($_GET['error'] == 'nosession') {
        echo '<div class="centered" style="padding:0px 20px;">';
        echo "<h3>Nessuna sessione valida attiva in questo momento.</h3>";
    } else if ($_GET['error'] == 'noerror') {
        echo '<div class="centered" style="padding:0px 20px;">';
        echo "<h3>Sessione conclusa.</h3>";
    } else if ($_GET['error'] == 'deletedaccount') {
        echo '<div class="centered" style="padding:0px 20px;">';
        echo "<h3>Account eliminato.</h3>";
    } else if ($_GET['error'] == 'nodeletedaccount') {
        echo '<div class="centered" style="padding:0px 20px;">';
        echo "<h3>Non &egrave; stato possibile eliminare l'account.</h3>";
    } else if ($_GET['error'] == 'changedpwd') {
        echo '<div class="centered" style="padding:0px 20px;">';
        echo "<h3>Password cambiata e sessione conclusa. Rieffettua il login.</h3>";
    } else {
        ?>
            <div class="centered" style="padding:0px 20px;">
                <h3>La sessione &egrave; scaduta. Ti invitiamo a effettuare nuovamente il login.</h3>

            <?php
        }
            ?>

            </div>
            <br>
            <div class="centered redirect-login" style="font-size:18px">
                <!-- print redirect links -->
                <?php
                if (isset($_GET['isUser']) && $_GET['isUser'])
                    echo "<a href='login.php'>Clicca qui.</a>";
                else if (isset($_GET['isUser']) && !$_GET['isUser'])
                    echo "<a href='superlogin.php'>Clicca qui.</a>";
                else
                    echo "<a href='index.php'>Clicca qui.</a>";
                ?>

            </div>
    </div>
</body>

</html>