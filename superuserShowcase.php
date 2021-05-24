<?php
@include('php/header.php');
if (!checkActiveSuper())
    header('location:superlogin.php?error=nosession'); //session
@include('php/function.inc.php');
$utente = generateSuperuserOBJ(session_id());
//var_dump($utente);
?>

<div class="wrapper user-area row">
    <br>

    <div class='color-lightb user-nav'>
        <ul>
            <li><a href="areaSuperutente.php">Torna indietro</a></li>
            <li><a href="superuserShowcase.php?redirect=changepwd">Cambia password</a></li>
            <li> </li>
        </ul>
    </div>

    <div class="user-div">

        <?php
        echo "Benvenuto " . $utente->getLastname() . ".\r\nQueste sono le tue informazioni.\r\nUsa i collegamenti a lato per accedere ai vari servizi."
        ?>

    </div>

</div>

<div class="wrapper user-info">

    <?php
    if (isset($_GET) && isset($_GET['redirect'])) {
        if ($_GET['redirect'] == 'changepwd') {
            echo "</div><div class='centered mb-3'>
                    <div class='form-group'>
                        <form action='php/logout.inc.php?isUser=true' method='post'>
                            <div class='col-sm-6 m-auto'>
                                <input class='form-control' type='password' name='pwd' placeholder='Nuova password' required><br>
                            </div>
                            <div class='col-sm-6 m-auto'>
                                <input class='form-control' type='password' name='repeat_pwd' placeholder='Ripeti password' required><br>
                            </div>
                            <input class='btn btn-primary' name='submit' type='submit' value='Salva'/>
                        </form>
                    </div>
                </div><br>";

            if (isset($_GET['error']) && $_GET['error'] == 'invalidinput') {
                echo "<p class='centered error'> Inserisci valori validi. </p>";
            } else if (isset($_GET['error']) && $_GET['error'] == 'samepwd') {
                echo "<p class='centered error'> Inserisci una password diversa da quella attuale. </p>";
            } else if (isset($_GET['error']) && $_GET['error'] == 'nomatch') {
                echo "<p class='centered error'> Le password non corrispondono. </p>";
            }
        }
    } else if (isset($_GET['matricola']) && $_GET['matricola'] == 'self') {
        $_GET['matricola'] = $utente->getMatricola();
        $_GET['self'] = true;
        $_GET['superuser'] = true;
        @require('common/showDetails.inc.php');
    }
    ?>
</div>
<br>
</body>

</html>