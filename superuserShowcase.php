<?php
        @include('php/header.php');
        if(!checkActiveSuper())
            header('location:superlogin.php?error=nosession'); //session
        @include('php/function.inc.php');
        $utente = generateSuperuserOBJ(session_id());
        //var_dump($utente);
        
?>	

<div class="wrapper user-area">
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
        /*
            if(isset($_GET) && isset($_GET['redirect'])){
                if($_GET['redirect'] == 'changepwd'){
                    echo "<div class='wrapper login-box centered' style='margin-top:10px; transform: scale(1.15);'>";
                    echo "<form action='php/logout.inc.php?isUser=true' method='post'>";
                    echo "<input style='border:2px solid black; margin: 10px;' type='password' name='pwd' placeholder='Nuova password' required><br>";
                    echo "<input style='border:2px solid black; margin: 10px;' type='password' name='repeat_pwd' placeholder='Ripeti password' required><br>";
                    echo "<input class='button' id='confirm' name='submit' type='submit' value='CHANGE'/></form>";
                    echo "</div>";

                    if(isset($_GET['error']) && $_GET['error'] == 'invalidinput'){
                        echo "<p class='centered error'> Inserisci valori validi. </p>";
                    }else if(isset($_GET['error']) && $_GET['error'] == 'samepwd'){
                        echo "<p class='centered error'> Inserisci una password diversa da quella attuale. </p>";
                    }else if(isset($_GET['error']) && $_GET['error'] == 'nomatch'){
                        echo "<p class='centered error'> Le password non corrispondono. </p>";
                    }
                }
            }else {
                echo "<h4>Nome</h4> <p> " . $utente->getFirstname(). "</p>";
                echo "<br>";
                echo "<h4>Cognome</h4> <p> " . $utente->getLastname(). "</p>";
                echo "<br>";
                echo "<h4>Data di nascita</h4> <p> " . $utente->getBirth(). "</p>";
                echo "<br>";
                if($utente->getGender() == "M")
                    $temp = "Uomo";
                else if ($utente->getGender() == "F")
                    $temp = "Donna";
                else
                    $temp = "Non specificato";
                echo "<h4>Genere</h4> <p> " . $temp . "</p>";
                echo "<br>";
                echo "<h4>Ufficio</h4> <p> " . $utente->getOffice(). "</p>";
                echo "<br>";
                
                echo "<h4>Supervisore</h4> <p> " . $utente->getSupervisorTuple()['lastname'] . " " . $utente->getSupervisorTuple()['firstname'] . "</p>";
            }
        */
        if(isset($_GET) && isset($_GET['redirect'])){
            if($_GET['redirect'] == 'changepwd'){
                echo "<div class='wrapper login-box centered' style='margin-top:10px; transform: scale(1.15);'>";
                echo "<form action='php/logout.inc.php?isUser=false' method='post'>";
                echo "<input style='border:2px solid black; margin: 10px;' type='password' name='pwd' placeholder='Nuova password' required><br>";
                echo "<input style='border:2px solid black; margin: 10px;' type='password' name='repeat_pwd' placeholder='Ripeti password' required><br>";
                echo "<input class='button' id='confirm' name='submit' type='submit' value='CHANGE'/></form>";
                echo "</div>";

                if(isset($_GET['error']) && $_GET['error'] == 'invalidinput'){
                    echo "<p class='centered error'> Inserisci valori validi. </p>";
                }else if(isset($_GET['error']) && $_GET['error'] == 'samepwd'){
                    echo "<p class='centered error'> Inserisci una password diversa da quella attuale. </p>";
                }else if(isset($_GET['error']) && $_GET['error'] == 'nomatch'){
                    echo "<p class='centered error'> Le password non corrispondono. </p>";
                }
            }
        }else if(isset($_GET['matricola']) && $_GET['matricola'] == 'self'){
            $_GET['matricola'] = $utente->getMatricola();
            @require('php/showDetails.inc.php');
        }
        
        
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