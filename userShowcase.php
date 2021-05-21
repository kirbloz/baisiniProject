<?php
@include('php/header.php');
if (!checkActive())
    header('location:login.php?error=nosession'); //session
@include('php/function.inc.php');
$utente = generateUserOBJ(session_id());
//var_dump($utente);

?>

<div class="wrapper user-area">
    <br>

    <div class='color-lightb user-nav '>
        <ul>
            <li><a href="areaUtente.php">Torna indietro</a></li>
            <li><a href="userfetch.php?select=tickets">Richiedi assistenza</a></li>
            <li><a href="userfetch.php?select=works">Area Interventi</a></li>
            <li><a href="userShowcase.php?redirect=changepwd">Cambia password</a></li>
            <li><a href="userShowcase.php?redirect=deleteaccount">Elimina il tuo account</a></li>
        </ul>
    </div>

    <div class="user-div">
        <?php
        echo "Benvenuto " . $utente->getUsername() . ".\r\nQueste sono le tue informazioni.\r\nUsa i collegamenti a lato per accedere ai vari servizi."
        ?>
    </div>

</div>

<div class="wrapper user-info">
    <?php
    //var_dump($_POST);
    if (isset($_GET) && isset($_GET['redirect'])) {

        if ($_GET['redirect'] == 'deleteaccount') {
            echo "<div class='centered' style='margin-top:10px;'>";
            echo "Sei sicuro di voler eliminare il tuo profilo?";
            echo "<form action='php/logout.inc.php' method='post'>";
            echo "<input class='btn btn-primary' id='confirm' name='submit' type='submit'  value='DELETE'/></form>";
            echo "</div>";
        } else if ($_GET['redirect'] == 'changepwd') {
            echo "<div class='wrapper login-box centered' style='margin-top:10px; transform: scale(1.15);'>";
            echo "<form action='php/logout.inc.php?isUser=true' method='post'>";
            echo "<input style='border:2px solid black; margin: 10px;' type='password' name='pwd' placeholder='Nuova password' required><br>";
            echo "<input style='border:2px solid black; margin: 10px;' type='password' name='repeat_pwd' placeholder='Ripeti password' required><br>";
            echo "<input class='button' id='confirm' name='submit' type='submit' value='CHANGE'/></form>";
            echo "</div>";

            if (isset($_GET['error']) && $_GET['error'] == 'invalidinput') {
                echo "<p class='centered error'> Inserisci valori validi. </p>";
            } else if (isset($_GET['error']) && $_GET['error'] == 'samepwd') {
                echo "<p class='centered error'> Inserisci una password diversa da quella attuale. </p>";
            } else if (isset($_GET['error']) && $_GET['error'] == 'nomatch') {
                echo "<p class='centered error'> Le password non corrispondono. </p>";
            }
        }
    } else if ($utente->setCustomer() === false) {

        /*echo "<table class='single'>";
        echo "<tr><td>Username</td><td>" . $utente->getUsername() . "</td></tr>
                    <tr><td>Email</td><td class='gray'>" . $utente->getEmail() . "</td></tr>";
        echo "</table>";*/
        if(isset($_GET['add'])){
            
            if(isset($_GET['error'])){
                if($_GET['error'] == 'none')
                    echo "<p class='centered alert alert-info'>Informazioni salvate corretamente. <b><a href='userShowcase.php'>Aggiorna qui la pagina</a></b></p>";
            }else if($_GET['add'] == 'customer'){
                require_once('user/userfun.inc.php');
                showCustomerForm($utente);
            }
        }else{
            echo '<div class="container">
                    <div class="row single centered">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-2">
                                        IdUser:
                                    </div>
                                    <div class="col-sm-6" style="text-align:left; margin:5px;">
                                        <input type="text" class="form-control" name="" placeholder="' .htmlentities($utente->getId()) .'" disabled> 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        Username:
                                    </div>
                                    <div class="col-sm-6" style="text-align:left; margin:5px;">
                                        <input type="text" class="form-control" name="" placeholder="' .htmlentities($utente->getUsername()) .'" disabled> 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        Email:
                                    </div>
                                    <div class="col-sm-6" style="text-align:left; margin:5px;">
                                        <input type="text" class="form-control" name="" placeholder="' .htmlentities($utente->getEmail()) .'" disabled> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
            echo "<p class='centered alert alert-info'>Sembra che tu non sia ancora registrato come cliente. Puoi farlo <a href='userShowcase.php?add=customer'><b>qui</b><a/>.</p>";
        }
    } else{
        //echo "ok show";
        //var_dump($_POST);
        if (isset($_POST)) {
            if (isset($_POST['submit']) && $_POST['submit'] == 'Salva') {
                if ($_POST['gender'] == "Uomo")
                    $_POST['gender'] = "M";
                else if ($_POST['gender'] == "Donna")
                    $_POST['gender'] = "F";
                else
                    $_POST['gender'] = "NB";
                //var_dump($_POST);
                $utente->update_Customer($_POST);
                $_POST=NULL;
            }
        }
        require_once('user/userfun.inc.php');
        fetchidUser($utente->getId());
    }

    //controllo POST se sono stato rimandato qui dopo aver usato la form in fetchIdUser per aggiornare i dati
    
    ?>
</div>
<div class="wrapper centered redirect-login">
    foot
</div>
<!--
                birth date cannot be null in database
                mettere un valore di default = NULL e cambiare database
    -->
<br>

</body>