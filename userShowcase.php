<?php
@include('php/header.php');
if (!checkActive())
    header('location:login.php?error=nosession'); //session
@include('php/function.inc.php');
$utente = generateUserOBJ(session_id());
//var_dump($utente);

?>

<div class="wrapper user-area ">
    <div class='color-lightb user-nav '>
        <ul>
            <li><a href="areaUtente.php">Torna indietro</a></li>
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
            echo "<form action='php/logout.inc.php' method='post'>
            <input class='btn btn-primary' name='submit' type='submit'  value='DELETE'/></form>
            </div><br>";
        } else if ($_GET['redirect'] == 'changepwd') {
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
    } else if ($utente->setCustomer() === false) {

        if (isset($_GET['add'])) {
            if (isset($_GET['error'])) {
                if ($_GET['error'] == 'none')
                    echo "<p class='centered alert alert-info'>Informazioni salvate corretamente. <b><a href='userShowcase.php'>Aggiorna qui la pagina</a></b></p>";
            } else if ($_GET['add'] == 'customer') {
                require_once('user/userfun.inc.php');
                showCustomerForm($utente);
            }
        } else {
            echo '<div class="wrapper">
                    <div class="row single centered">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-2">
                                        IdUser:
                                    </div>
                                    <div class="col-sm-6" style="text-align:left; margin:5px;">
                                        <input type="text" class="form-control" name="" placeholder="' . $utente->getId() . '" disabled> 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        Username:
                                    </div>
                                    <div class="col-sm-6" style="text-align:left; margin:5px;">
                                        <input type="text" class="form-control" name="" placeholder="' . $utente->getUsername() . '" disabled> 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        Email:
                                    </div>
                                    <div class="col-sm-6" style="text-align:left; margin:5px;">
                                        <input type="text" class="form-control" name="" placeholder="' . $utente->getEmail() . '" disabled> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
            echo "<p class='centered alert alert-info'>Sembra che tu non sia ancora registrato come cliente. Puoi farlo <a class='alert-link' href='userShowcase.php?add=customer'>qui<a/>.</p>";
        }
    } else {

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
                $_POST = NULL;
            }
        }
        require_once('user/userfun.inc.php');
        fetchidUser($utente->getId());
    }

    ?>
</div>
</div>
</body>